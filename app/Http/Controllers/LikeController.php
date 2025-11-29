<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Quote;
use App\Services\LikeService;

class LikeController extends Controller
{

    public function __construct(private readonly LikeService $likeService)
    {
    }

    public function store(LikeRequest $request, Quote $quote)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['quote_id'] = $quote->id;

        try {
            $like = $this->likeService->toggleLike($quote, $validated);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        if ($like) {
            return response()->json([
                'like' => new LikeResource($like),
                'message' => 'Like updated successfully',
                'success' => true,
            ]);
        }

        return response()->json([
            'message' => 'Like removed successfully',
            'success' => true,
        ]);
    }
}
