<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isThumbnailExists = !is_null($this->thumbnail) && $this->thumbnail !== '';

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'director' => $this->director,
            'release_year' => $this->release_year,
            'thumbnail' => $this->when($isThumbnailExists, $this->thumbnail),
            'quotes_count' => $this->quotes_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
