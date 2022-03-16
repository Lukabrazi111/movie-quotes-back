<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Movie;

class MovieController extends Controller
{
    public function getSpecificMovie($id) {
        return Movie::where('id', $id)->get();
    }

	public function getOnlyMovies(Movie $movie)
	{
		return $movie->all();
	}

	public function getAllMoviesWithQuotes(Movie $movie)
	{
		return $movie->with('quotes')->get();
	}

	public function getMovieWithQuotes($id)
	{
		return Movie::where('id', $id)->with('quotes')->get();
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

	public function update(AdminUpdateRequest $request, $id)
	{
		Movie::find($id)->update(['name' => ['en' => $request->input('enMovie'), 'ka' => $request->input('kaMovie')]], $id);

		return response()->json([
			'name' => ['en' => $request->input('enMovie'), 'ka' => $request->input('kaMovie')],
		]);
	}

	public function destroy($id)
	{
		Movie::destroy($id);

		return response()->json([
			'movie_id' => $id,
			'message'  => 'Movie removed!',
		]);
	}
}
