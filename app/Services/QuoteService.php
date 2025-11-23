<?php

namespace App\Services;

use App\Http\Requests\QuoteRequest;
use App\Models\Movie;
use App\Models\Quote;
use Spatie\QueryBuilder\QueryBuilder;

class QuoteService
{
    public function getQuotes()
    {
        $quotesQuery = QueryBuilder::for(Quote::class)
            ->with(['movie', 'user'])
            ->withCount(['comments', 'likes'])
            ->allowedFilters(['description', 'movie.title']);

        return $quotesQuery->get();
    }

    public function createQuote(Movie $movie, QuoteRequest $request, array $data): Quote
    {
        $quote = $movie->quotes()->create($data);

        if ($request->has('image')) {
            $file = $request->file('image');
            $quote->addMedia($file)->toMediaCollection('quote/image');
        }

        return $quote;
    }
}
