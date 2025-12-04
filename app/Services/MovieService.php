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
            ->allowedFilters(['title'])
            ->withCount(['quotes']);

        $moviesCount = $moviesQuery->count();

        return [
            $moviesQuery->paginate(10),
            $moviesCount,
        ];
    }

    public function createMovie(array $data, MovieRequest $request): Movie
    {
        $genres = $data['genres'] ?? [];
        unset($data['genres']);

        $movie = Movie::create($data);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $movie->addMedia($file)->toMediaCollection('movie/thumbnail');
        }

        if (!empty($genres)) {
            $genreIds = Genre::whereIn('name', $genres)->pluck('id')->toArray();
            $movie->genres()->attach($genreIds);
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

        if (isset($validated['genres']) && !empty($validated['genres'])) {
            $genreIds = Genre::whereIn('name', $validated['genres'])->pluck('id')->toArray();
            $movie->genres()->sync($genreIds);
        }

        $movie->update($validated);

        $movie->load(['genres', 'quotes']);

        return $movie;
    }
}
