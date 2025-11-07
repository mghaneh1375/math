<?php
// app/Jobs/TransferToFTP.php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TransferToFTP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $videoId;
    public $localPath;

    public function __construct($videoId, $localPath)
    {
        $this->videoId = $videoId;
        $this->localPath = $localPath;
    }

    public function handle()
    {
        try {
            Log::info("Starting FTP transfer for video ID: {$this->videoId}");

            $localDisk = config('video.storage_disk', 'public');
            $localDirectory = "hls_videos/{$this->videoId}";
            $remoteDirectory = "videos/{$this->videoId}";

            // Check if local directory exists
            if (!Storage::disk($localDisk)->exists($localDirectory)) {
                throw new \Exception("Local directory not found: {$localDirectory}");
            }

            // Create remote directory if not exists
            if (!Storage::disk('ftp')->exists($remoteDirectory)) {
                Storage::disk('ftp')->makeDirectory($remoteDirectory);
            }

            // Get all files in the HLS directory
            $files = Storage::disk($localDisk)->allFiles($localDirectory);

            $transferredFiles = [];

            foreach ($files as $file) {
                $remotePath = $file; // یا اگر مسیر متفاوتی می‌خواید: str_replace($localDirectory, $remoteDirectory, $file)
                
                // Read file content
                $content = Storage::disk($localDisk)->get($file);
                
                // Upload to FTP
                Storage::disk('ftp')->put($remotePath, $content);
                
                $transferredFiles[] = $file;
                
                Log::info("Transferred: {$file}");
            }

            // Update database with FTP paths
            $this->updateVideoWithFTPInfo($remoteDirectory, $files);

            // Optional: Delete local files after transfer
            // Storage::disk($localDisk)->deleteDirectory($localDirectory);

            Log::info("FTP transfer completed for video ID: {$this->videoId}. Files transferred: " . count($files));

        } catch (\Exception $e) {
            Log::error("FTP transfer failed for video ID: {$this->videoId}. Error: " . $e->getMessage());
            $this->failed($e);
        }
    }

    private function updateVideoWithFTPInfo($remoteDirectory, $files)
    {
        // اگر مدل Video دارید
        \App\Models\Video::where('id', $this->videoId)->update([
            'ftp_path' => $remoteDirectory,
            'files_transferred' => count($files),
            'transferred_at' => now(),
        ]);

        // یا اگر با session کار می‌کنید
        // \App\Models\CourseSession::where('id', $this->videoId)->update([...]);
    }

    public function failed(\Throwable $exception)
    {
        Log::error("FTP transfer job failed for video ID: {$this->videoId}. Error: " . $exception->getMessage());

        // Update status to failed
        \App\Models\Video::where('id', $this->videoId)->update([
            'transfer_status' => 'failed',
            'error_message' => $exception->getMessage()
        ]);
    }
}
