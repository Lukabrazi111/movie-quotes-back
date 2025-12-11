<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteCollectionResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
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
            'movie' => $this->whenLoaded('movie', fn() => [
                'title' => $this->movie->title,
                'release_year' => $this->movie->release_year,
            ]),
            'comments' => $this->whenLoaded('comments', fn() => CommentResource::collection($this->comments)),
            'likes' => $this->whenLoaded('likes', fn() => LikeResource::collection($this->likes)),
            'comments_count' => $this->whenCounted('comments'),
            'likes_count' => $this->whenCounted('likes'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
