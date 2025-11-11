<?php

namespace App\Services;

use App\Http\Requests\MovieRequest;
use App\Models\Movie;

class MovieService
{

    public function createMovie(array $data, MovieRequest $request)
    {
        $movie = Movie::create($data);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $movie->addMedia($file)->toMediaCollection('movies/thumbnail');
        }

        return $movie;
    }
}
