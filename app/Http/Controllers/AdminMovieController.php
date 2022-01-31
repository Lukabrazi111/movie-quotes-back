<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Support\Facades\App;

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
		Movie::create(['name' => [
			'en' => $request->input('movie-name'),
			'ka' => $request->input('movie-name-geo'),
		]]);

		return redirect()->route('admin.show')->with('success', 'Movie Added!');
	}

	public function show($id)
	{
		$movies = Movie::find($id);

		return view('admin-panel.edit-movie', ['movies' => json_decode($movies)]);
	}

	public function update(AdminUpdateRequest $request, $id)
	{
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
