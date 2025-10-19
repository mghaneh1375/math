<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdminCourseSessionDigestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'duration' => sprintf('%02d:%02d', floor($this->duration / 60) % 60, $this->duration % 60) . 'دقیقه ',
            'chapter' => $this->chapter,
            'chunked_at' => $this->chunked_at,
            'attaches_count' => $this->attaches_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'visibility' => $this->visibility,
            'is_file_uploaded' => $this->file != null,
            'preview_link' => ($this->file != null && str_starts_with($this->file, 'http') ? $this->file : $this->chunked_at != null) ? env('VIDEO_SERVER_ADDR') . $this->file : Storage::url($this->file)
        ];
    }
}
