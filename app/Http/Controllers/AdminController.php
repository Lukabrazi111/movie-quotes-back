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

		return view('admin-panel.index', ['quotes' => $quotes]);
	}

	public function addMovie()
	{
		return view('admin-panel.add-movie');
	}

	public function store(AdminStoreRequest $request)
	{
		$request->validated();

		$movie = Movie::create(['name' => [
			'en' => $request->input('movie-name'),
			'ka' => $request->input('movie-name-geo'),
		]]);

		Quote::create(['quote' => [
			'en' => $request->input('quote'),
			'ka' => $request->input('quote-geo'),
		],
			'movie_id' => $movie->id, ]);

		return redirect()->route('admin.show')->with('success', 'Movie Added!');
	}

	public function show($id)
	{
		$quotes = Quote::find($id);

		return view('admin-panel.edit', ['quotes' => $quotes]);
	}

	public function update(AdminUpdateRequest $request, $id)
	{
		$request->validated();

		$quote = Quote::find($id);

		$quote->movie->name = $request->input('name');
		$quote->quote = $request->input('textarea');
		$quote->save();

		return redirect()->route('admin.show')->with('success', 'Movie Updated!');
	}

	public function destroy($id)
	{
		$quote = Quote::find($id);

		$quote->delete();

		return redirect()->route('admin.show')->with('success', 'Movie Removed!');
	}
}
