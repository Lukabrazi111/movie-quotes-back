<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class PostsController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('posts.index', ['movies' => $movies->random()]);
    }

    public function show(Movie $movie)
    {
        return view('posts.show', [
            'quotes' => $movie->quotes,
            'movie' => $movie,
        ]);
    }
}
