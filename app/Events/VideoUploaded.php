<?php

namespace App\Events;

use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoUploaded implements ShouldDispatchAfterCommit
{
    use Dispatchable, SerializesModels;

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
