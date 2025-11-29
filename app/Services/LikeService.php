<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Quote;

class LikeService
{
    public function toggleLike(Quote $quote, array $data)
    {
        $existingLike = $quote->likes()
            ->where('user_id', $data['user_id'])
            ->first();

        if ($existingLike && $existingLike->like === $data['like']) {
            $existingLike->delete();
            return null;
        }

        return Like::updateOrCreate(
            [
                'quote_id' => $quote->id,
                'user_id' => $data['user_id']
            ],
            ['like' => $data['like']]
        );
    }
}
