<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursePublicResource extends JsonResource
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
            'img' => $this->img,
            'price' => $this->price,
            'rate' => $this->rate,
            'duration' => $this->duration,
            'sessions_count' => $this->sessions_count,
            'attaches_count' => $this->attaches_count,
        ];
    }

    
}
