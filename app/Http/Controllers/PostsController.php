<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Support\Facades\App;

class PostsController extends Controller
{
	public function index()
	{
		App::setLocale(session('language', 'ka'));

		$quotes = Quote::all()->random(1)[0];

		return view('posts.index', ['quotes' => $quotes]);
	}

	public function show(Movie $movie)
	{
		return view('posts.show', [
			'quotes' => $movie->quotes,
			'movie'  => $movie,
		]);
	}
}
