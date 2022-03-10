<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Movie;
use App\Models\Quote;

class AdminMovieController extends Controller
{
	public function index()
	{
		$quotes = Quote::all();
		$movies = Movie::all();

		return view('admin-panel.index-movie', ['quotes' => $quotes, 'movies' => $movies]);
	}

	public function addMovie()
	{
		return view('admin-panel.add-movie');
	}

	public function store(AdminStoreRequest $request)
	{
		$request->validated();

		Movie::create(['name' => [
			'en' => $request->input('enName'),
			'ka' => $request->input('kaName'),
		]]);

		return response()->json([
			'en' => $request->input('enName'),
			'ka' => $request->input('kaName'),
		], 201);
	}

	public function show($id)
	{
		$movies = Movie::find($id);

		return view('admin-panel.edit-movie', ['movies' => $movies]);
	}

	public function update(AdminUpdateRequest $request, $id)
	{
		$movie = Movie::find($id);

		$movie->update([
			'name' => ['en' => $request->input('enMovie'), 'ka' => $request->input('kaMovie')],
		]);

		return response()->json([
			'name' => ['en' => $request->input('enMovie'), 'ka' => $request->input('kaMovie')],
		]);
	}

	public function destroy($id)
	{
		$movie = Movie::find($id);

		$movie->delete();

		return response()->json([
			'movie_id' => $movie->id,
			'message'  => 'Movie removed!',
		]);
	}
}
