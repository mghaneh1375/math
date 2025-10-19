<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PublicDetailedCourseResource extends JsonResource
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
            'description' => $this->description,
            'img' => Storage::url($this->img),
            'price' => number_format($this->price, 0) . ' تومان',
            'rate' => $this->rate,
            'duration' => $this->duration,
            'sessions' => PublicCourseSessionResource::collection($this->sessions)->toArray($request),
            'lessons' =>  $this->lessons == null ? [] : PublicLessonResource::collection($this->lessons)->toArray($request),
            'tags' => $this->tags == null ? [] : $this->tags->map(function($tag) { return $tag->value; })->toArray(),
            'seo_tags' => $this->tags == null ? [] : SeoTagResource::collection($this->seo_tags)->toArray($request),
            'attaches_count' => $this->attaches_count == null ? 0 : $this->attaches_count,
        ];
    }
}
