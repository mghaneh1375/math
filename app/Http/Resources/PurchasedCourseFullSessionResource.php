<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PurchasedCourseFullSessionResource extends JsonResource
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
            'file' => $this->video,
            'chapter' => $this->chapter,
            'duration' => sprintf('%02d:%02d', floor($this->duration / 60) % 60, $this->duration % 60) . ' دقیقه ',
            'attaches' => $this->attaches == null ? [] : PublicAttachResource::collection($this->attaches),
            'preview_link' => ($this->file != null && str_starts_with($this->file, 'http') ? $this->file : $this->processing_status == 'completed' && $this->transfer_status == 'completed') ? 'https://statics.riazizoom.ir/videos/' . $this->master_playlist_path : Storage::url($this->file),
        ];
    }
}
