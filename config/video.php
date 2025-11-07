<?php

return [
    'chunk_duration' => env('VIDEO_CHUNK_DURATION', 10), // in seconds (10 minutes default)
    'storage_disk' => env('VIDEO_STORAGE_DISK', 'public'),
    'chunk_format' => env('VIDEO_CHUNK_FORMAT', 'mp4'),
    'max_upload_size' => env('VIDEO_MAX_UPLOAD_SIZE', 102400), // in KB (100MB default)
    'allowed_mimes' => explode(',', env('VIDEO_ALLOWED_MIMES', 'mp4,avi,mov,wmv,mkv')),
    
    // FFmpeg settings
    'ffmpeg' => [
        'timeout' => env('FFMPEG_TIMEOUT', 3600),
        'threads' => env('FFMPEG_THREADS', 12),
    ],
  'resolutions' => [
        '480p' => [
            'resolution' => env('VIDEO_RESOLUTION_480P', '854x480'),
            'video_bitrate' => env('VIDEO_BITRATE_480P', 800),
            'audio_bitrate' => env('VIDEO_AUDIO_BITRATE', 128),
        ],
        '720p' => [
            'resolution' => env('VIDEO_RESOLUTION_720P', '1280x720'),
            'video_bitrate' => env('VIDEO_BITRATE_720P', 1200),
            'audio_bitrate' => env('VIDEO_AUDIO_BITRATE', 128),
        ]
    ],
];
