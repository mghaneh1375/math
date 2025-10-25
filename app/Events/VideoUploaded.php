<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoUploaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sessionId;
    public $videoPath;

    /**
     * Create a new event instance.
     */
    public function __construct($sessionId, $videoPath)
    {
        $this->sessionId = $sessionId;
        $this->videoPath = $videoPath;
    }
}
