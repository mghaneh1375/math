<?php

namespace App\Listeners;

use App\Events\VideoUploaded;
use App\Jobs\ProcessVideoChunking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ProcessUploadedVideo implements ShouldQueue
{
     /**
     * The name of the queue the job should be sent to.
     *
     * @var string
     */
    public $queue = 'video-processing';
    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 5;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VideoUploaded $event): void
    {
        Log::info("Starting video processing for video ID: {$event->sessionId}");
        ProcessVideoChunking::dispatch(
            $event->videoPath,
            $event->sessionId
        )->onQueue('video-processing');

        Log::info("Video processing job dispatched for video ID: {$event->sessionId}");   
    }
}
