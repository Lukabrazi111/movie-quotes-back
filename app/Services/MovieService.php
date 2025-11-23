<?php

namespace App\Services;

use App\Http\Requests\MovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Genre;
use App\Models\Movie;
use Spatie\QueryBuilder\QueryBuilder;

class MovieService
{
    public function getUserMovies(): array
    {
        $userId = auth()->id();

        $moviesQuery = QueryBuilder::for(Movie::class)
            ->where('user_id', $userId)
            ->allowedFilters(['title', 'release_year'])
            ->withCount('quotes');


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
            $movie->addMedia($file)->toMediaCollection('movie/thumbnail');
        }

        return $movie;
    }

    public function updateMovie(UpdateMovieRequest $request, array $validated, string $id): Movie
    {
        $movie = Movie::find($id);

        if (is_null($movie)) {
            throw new \Exception('Movie not found', 404);
        }

        if ($request->hasFile('thumbnail')) {
            uploadImage($movie, $request->file('thumbnail'), 'movie/thumbnail');
        }

        $genreIds = Genre::whereIn('name', $validated['genres'])->pluck('id')->toArray();

        $movie->genres()->syncWithoutDetaching($genreIds);

        $movie->update($validated);

        $movie->load(['genres', 'quotes']);

        return $movie;
    }
}
