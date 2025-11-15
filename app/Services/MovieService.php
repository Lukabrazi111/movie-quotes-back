<?php

namespace App\Services;

use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use Spatie\QueryBuilder\QueryBuilder;

class MovieService
{
    public function getUserMovies(): array
    {
        $userId = auth()->id();

        $moviesQuery = QueryBuilder::for(Movie::class)
            ->allowedIncludes(['quotes'])
            ->withCount('quotes')
            ->where('user_id', $userId)
            ->allowedFilters(['title', 'release_year']);

        $moviesCount = Movie::where('user_id', $userId)->count();

        return [
            $moviesQuery->get(),
            $moviesCount,
        ];
    }

    public function createMovie(array $data, MovieRequest $request): Movie
    {
        $movie = Movie::create($data);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $movie->addMedia($file)->toMediaCollection('movies/thumbnail');
        }

        return $movie;
    }
}
