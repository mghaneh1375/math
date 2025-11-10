<?php

namespace App\Jobs;

use App\Models\CourseSession;
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

    public $sessionId;
    public $localPath;

    public function __construct($sessionId, $localPath)
    {
        $this->sessionId = $sessionId;
        $this->localPath = $localPath;
    }

    public function handle()
    {
        try {
            Log::info("Starting FTP transfer for session ID: {$this->sessionId}");
            $localDisk = config('video.storage_disk', 'local');

            // Check if local directory exists
            if (!Storage::disk($localDisk)->exists($this->localPath)) {
                throw new \Exception("Local directory not found: {$this->localPath}");
            }

            // Get all files in the HLS directory
            $files = Storage::disk($localDisk)->allFiles($this->localPath);
            $transferredFiles = [];

            foreach ($files as $file) {
                $remotePath = $file;
                // Read file content
                $content = Storage::disk($localDisk)->get($file);
                // Upload to FTP
                Storage::disk('ftp')->put($remotePath, $content);
                $transferredFiles[] = $file;
                Log::info("Transferred: {$file}");
            }

            // Update database with FTP paths
            $this->updateVideoWithFTPInfo();
            Storage::disk($localDisk)->deleteDirectory($this->localPath);
            Log::info("FTP transfer completed for session ID: {$this->sessionId}. Files transferred: " . count($files));
        } catch (\Exception $e) {
            Log::error("FTP transfer failed for session ID: {$this->sessionId}. Error: " . $e->getMessage());
            $this->failed($e);
        }
    }

    private function updateVideoWithFTPInfo()
    {
        CourseSession::whereId($this->sessionId)->update([
            'transfer_status' => 'completed',
            'transferred_at' => now(),
        ]);
    }

    public function failed(\Throwable $exception)
    {
        Log::error("FTP transfer job failed for video ID: {$this->sessionId}. Error: " . $exception->getMessage());
        // Update status to failed
        CourseSession::whereId($this->sessionId)->update([
            'transfer_status' => 'failed',
            'transfer_error_message' => $exception->getMessage()
        ]);
    }
}
