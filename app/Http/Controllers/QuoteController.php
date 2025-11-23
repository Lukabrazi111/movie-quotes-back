<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use App\Http\Resources\QuoteCollectionResource;
use App\Http\Resources\QuoteResource;
use App\Models\Movie;
use App\Models\Quote;
use App\Services\QuoteService;

class QuoteController extends Controller
{
    public function __construct(private readonly QuoteService $quoteService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = $this->quoteService->getQuotes();

        return response()->json([
            'quotes' => QuoteCollectionResource::collection($quotes),
            'success' => true,
        ]);
    }

    public function show(Quote $quote)
    {
        $quote->load(['user', 'movie', 'comments', 'likes']);

        return response()->json([
            'quote' => new QuoteResource($quote),
            'success' => true,
        ]);
    }

    public function store(QuoteRequest $request, Movie $movie)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        try {
            $quote = $this->quoteService->createQuote($movie, $request, $validated);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'quote' => new QuoteResource($quote),
            'message' => 'Quote created successfully',
            'success' => true,
        ]);
    }
}
