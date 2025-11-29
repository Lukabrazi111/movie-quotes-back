<?php

namespace App\Services;

use App\Http\Requests\QuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\Movie;
use App\Models\Quote;
use Spatie\QueryBuilder\QueryBuilder;

class QuoteService
{
    public function getQuotes()
    {
        $quotesQuery = QueryBuilder::for(Quote::class)
            ->with(['movie', 'user', 'comments'])
            ->withCount(['comments', 'likes'])
            ->allowedFilters(['description', 'movie.title']);

        return $quotesQuery->get();
    }

    public function createQuote(Movie $movie, QuoteRequest $request, array $data): Quote
    {
        $quote = $movie->quotes()->create($data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            uploadImage($quote, $file, 'quote/image');
        }

        return $quote;
    }

    public function updateQuote(Quote $quote, UpdateQuoteRequest $request, array $data): Quote
    {
        $quote->update($data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            uploadImage($quote, $file, 'quote/image');
        }

        return $quote;
    }
}
