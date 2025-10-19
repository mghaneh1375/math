<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'img' => Storage::url($this->img),
            'price' => number_format($this->price, 0) . ' تومان',
            'rate' => $this->rate,
            'duration' => $this->duration,
            'sessions_count' => $this->sessions_count
        ];
    }

    
}
