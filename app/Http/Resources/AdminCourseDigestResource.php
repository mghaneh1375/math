<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminCourseDigestResource extends JsonResource
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
            'price' => $this->price,
            'priority' => $this->priority,
            'rate' => $this->rate,
            'duration' => $this->duration,
            'visibility' => $this->visibility,
            'buyers_count' => $this->purchases_count,
            'sessions_count' => $this->sessions_count,
            'attaches_count' => $this->attaches_count,
            'created_at' => Controller::MiladyToShamsi4(strtotime($this->created_at)),
            'updated_at' => Controller::MiladyToShamsi4(strtotime($this->updated_at)),
        ];
    }
}
