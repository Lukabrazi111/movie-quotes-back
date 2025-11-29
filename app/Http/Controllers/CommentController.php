<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Quote $quote)
    {
        $comments = $quote->comments;

        return response()->json([
            'comments' => CommentResource::collection($comments),
            'success' => true,
        ]);
    }

    public function store(CommentRequest $request, Quote $quote)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['quote_id'] = $quote->id;

        try {
            $comment = $quote->comments()->create($validated);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'comment' => new CommentResource($comment),
            'message' => 'Comment created successfully',
            'success' => true,
        ]);
    }

    public function destroy(Quote $quote, Comment $comment) {

    }
}
