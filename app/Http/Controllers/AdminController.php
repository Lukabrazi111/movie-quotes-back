<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Movie;
use App\Models\Quote;

class AdminController extends Controller
{
	public function index()
	{
		$quotes = Quote::all();
		$movie = Movie::all();

		return view('admin-panel.index', ['quotes' => $quotes, 'movies' => json_decode($movie)]);
	}

	public function addMovie()
	{
		return view('admin-panel.add-movie');
	}

	public function store(AdminStoreRequest $request)
	{
		$request->validated();

		Movie::create(['name' => [
			'en' => $request->input('movie-name'),
			'ka' => $request->input('movie-name-geo'),
		]]);

//		Quote::create(['quote' => [
//			'en' => $request->input('quote'),
//			'ka' => $request->input('quote-geo'),
//		],
//			'movie_id' => $movie->id, ]);

		return redirect()->route('admin.show')->with('success', 'Movie Added!');
	}

	// Edit
	public function show($id)
	{
		$movies = Movie::find($id);

		return view('admin-panel.edit', ['movies' => json_decode($movies)]);
	}

	public function update(AdminUpdateRequest $request, $id)
	{
		$request->validated();

		$movie = Movie::find($id);

		$movie->update([
			'name' => ['en' => $request->input('name'), 'ka' => $request->input('nameGeo')],
		]);

		return redirect()->route('admin.show')->with('success', 'Movie Updated!');
	}

	public function destroy($id)
	{
		$movie = Movie::find($id);

		$movie->delete();

		return redirect()->route('admin.show')->with('success', 'Movie Removed!');
	}
}
