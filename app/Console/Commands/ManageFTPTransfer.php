<?php
// app/Console/Commands/ManageFTPTransfer.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ManageFTPTransfer extends Command
{
    protected $signature = 'ftp:transfer {videoId?} {--retry} {--list}';
    protected $description = 'Manage FTP transfers for videos';

    public function handle()
    {
        if ($this->option('list')) {
            return $this->listLocalFiles();
        }

        if ($this->option('retry')) {
            return $this->retryFailedTransfers();
        }

        $videoId = $this->argument('videoId');
        if ($videoId) {
            return $this->transferSingleVideo($videoId);
        }

        $this->info("Usage:");
        $this->info("php artisan ftp:transfer {videoId} - Transfer specific video");
        $this->info("php artisan ftp:transfer --retry - Retry failed transfers");
        $this->info("php artisan ftp:transfer --list - List local files");
    }

    private function transferSingleVideo($videoId)
    {
        $this->info("Transferring video {$videoId} to FTP...");
        
        \App\Jobs\TransferToFTP::dispatch($videoId, "hls_videos/{$videoId}")
            ->onQueue('ftp-transfer');
            
        $this->info("Transfer queued for video {$videoId}");
    }

    private function retryFailedTransfers()
    {
        $failedVideos = \App\Models\Video::where('transfer_status', 'failed')->get();
        
        foreach ($failedVideos as $video) {
            $this->transferSingleVideo($video->id);
        }
        
        $this->info("Retried {$failedVideos->count()} failed transfers");
    }

    private function listLocalFiles()
    {
        $localDisk = config('video.storage_disk', 'public');
        $directories = Storage::disk($localDisk)->directories('hls_videos');
        
        $this->info("Local HLS directories:");
        foreach ($directories as $dir) {
            $files = Storage::disk($localDisk)->files($dir);
            $this->info("- {$dir} (" . count($files) . " files)");
        }
    }
}
