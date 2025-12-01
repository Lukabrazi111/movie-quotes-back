<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
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
            'user_id' => $this->user_id,
            'movie_id' => $this->movie_id,
            'description' => $this->description,
            'image' => $this->image,
            'user' => new UserResource($this->whenLoaded('user')),
            'movie' => new MovieResource($this->whenLoaded('movie')),
            'comments' => $this->whenLoaded('comments', fn() => CommentResource::collection($this->comments)),
            'likes' => $this->whenLoaded('likes'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
