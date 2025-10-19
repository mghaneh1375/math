<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicCourseSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'chapter' => $this->chapter,
            'duration' => sprintf('%02d:%02d', floor($this->duration / 60) % 60, $this->duration % 60) . ' دقیقه ',
        ];
    }
}
