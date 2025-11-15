<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PurchasedCourseResource extends JsonResource
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
            'rate' => $this->rate,
            'duration' => $this->duration,
            'sessions' => $this->sessions == null ? [] : PurchasedCourseSessionResource::collection($this->sessions)->toArray($request),
            'attaches' => $this->attaches == null ? [] : PublicAttachResource::collection($this->attaches)->toArray($request),
            'lessons' =>  $this->lessons == null ? [] : PublicLessonResource::collection($this->lessons)->toArray($request),
            'tags' => $this->tags == null ? [] : $this->tags->map(function($tag) { return $tag->value; })->toArray(),
            'seo_tags' => $this->tags == null ? [] : SeoTagResource::collection($this->seo_tags)->toArray($request)
        ];
    }
}
