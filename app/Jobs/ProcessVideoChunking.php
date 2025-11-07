<?php

namespace App\Jobs;

use App\Models\CourseSession;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;

class ProcessVideoChunking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $videoPath;
    public $sessionId;
    public $chunkDuration;

    /**
     * Create a new job instance.
     */
    public function __construct($videoPath, $sessionId)
    {
        $this->videoPath = $videoPath;
        $this->sessionId = $sessionId;
        $this->chunkDuration = config('video.chunk_duration', 10);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $storageDisk = config('video.storage_disk', 'local');
            $outputDirectory = 'video_chunks/' . $this->sessionId;
            
            // Create output directory if it doesn't exist
            Storage::disk($storageDisk)->makeDirectory($outputDirectory);
//	    $media = FFMpeg::fromDisk($storageDisk)->open(storage_path('app/public/session_raw_videos/' . $this->videoPath));
	    $media = FFMpeg::fromDisk($storageDisk)->open('session_raw_videos/' . $this->videoPath);
            // Create HLS export with multiple bitrates
            $export = $media
                ->exportForHLS()
                ->toDisk($storageDisk)
                ->setSegmentLength($this->chunkDuration)
                ->setKeyFrameInterval(48);
            $resolutions = config('video.resolutions', []);
            $availableResolutions = [];

foreach ($resolutions as $resolutionName => $resolutionConfig) {
                list($width, $height) = explode('x', $resolutionConfig['resolution']);
                
                // Create format with proper parameters
                $format = $this->createVideoFormat($resolutionConfig);
                
                $export->addFormat($format, function (HLSVideoFilters $filters) use ($width, $height) {
                    $filters->resize($width, $height);
                });

                $availableResolutions[] = $resolutionName;
            }

            // Save the master playlist and all segments
            $masterPlaylistPath = "{$outputDirectory}/master.m3u8";
            $export->save($masterPlaylistPath);

	    $media = FFMpeg::fromDisk($storageDisk)->open('session_raw_videos/' . $this->videoPath);
            $duration = $media->getDurationInSeconds();

            // Update video record with playlist info
            $this->updateVideoWithPlaylistInfo($masterPlaylistPath, $availableResolutions, $duration);

	    TransferToFTP::dispatch($this->videoId, $outputPath)
                ->onQueue('ftp-transfer')
                ->delay(now()->addSeconds(10)); // 10 ثانیه تاخیر برای اطمینان
            
            Log::info("HLS video processing completed for video ID: {$this->sessionId}");
            
        } catch (\Exception $e) {
            Log::error("Video chunking failed for video ID: {$this->sessionId}. Error: " . $e->getMessage());
            $this->markVideoAsFailed();
            throw $e;
        }
    }

private function createVideoFormat($resolutionConfig)
    {
        // Create X264 format with proper codec names
        $format = new X264('aac', 'libx264'); // Audio codec, Video codec
        
        // Set the video bitrate (convert '400k' to 400)
        $videoBitrate = intval(str_replace('k', '', $resolutionConfig['video_bitrate']));
        $format->setKiloBitrate($videoBitrate);
        
        // Set audio bitrate
        $audioBitrate = intval(str_replace('k', '', $resolutionConfig['audio_bitrate']));
        $format->setAudioKiloBitrate($audioBitrate);
        
        // Additional quality settings for better output
        $format->setAdditionalParameters([
            '-preset', 'fast',
            '-crf', '23',
            '-movflags', '+faststart',
            '-profile:v', 'main',
            '-level', '3.1',
        ]);
        
        return $format;
    }
    
    private function updateVideoWithPlaylistInfo($masterPlaylistPath, $availableResolutions, $duration)
    {
        CourseSession::whereId($this->sessionId)->update([
            'master_playlist_path' => $masterPlaylistPath,
            'available_resolutions' => $availableResolutions,
            'processing_status' => 'completed',
            'chunked_at' => Carbon::now(),
            'duration' => $duration
        ]);
    }

    private function markVideoAsFailed()
    {
        CourseSession::whereId($this->sessionId)->update([
            'processing_status' => 'failed'
        ]);
    }
}
