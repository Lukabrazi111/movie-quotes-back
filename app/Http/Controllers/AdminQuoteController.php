<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminQuoteStoreRequest;
use App\Http\Requests\AdminUpdateQuoteRequest;
use App\Models\Movie;
use App\Models\Quote;

class AdminQuoteController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$quotes = Quote::all();

		return view('admin-panel.index-quote', ['quotes' => json_decode($quotes)]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function addQuote()
	{
		$movies = Movie::all();

		return view('admin-panel.add-quote', ['movies' => $movies]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(AdminQuoteStoreRequest $request)
	{
		$request->validated();

		Quote::create(['quote' => [
			'en' => $request->input('quote-name'),
			'ka' => $request->input('quote-name-geo'),
		], 'movie_id' => $request->input('movie_name')]);

		return redirect()->route('admin.quotes')->with('success', 'Quote Added!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 */
	public function show($id)
	{
		$quotes = Quote::find($id);
		$movies = Movie::all();

		return view('admin-panel.edit-quote', [
			'quotes' => json_decode($quotes),
			'movies' => $movies,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id
	 */
	public function update(AdminUpdateQuoteRequest $request, $id)
	{
		$request->validated();

		$quote = Quote::find($id);

		$quote->update([
			'quote'    => ['en' => $request->input('quote'), 'ka' => $request->input('quoteGeo')],
			'movie_id' => $request->input('movie_name'),
		]);

		return redirect()->route('admin.quotes')->with('success', 'Quote Updated!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 */
	public function destroy($id)
	{
		$quote = Quote::find($id);

		$quote->delete();

		return redirect()->route('admin.quotes')->with('success', 'Quote Removed!');
	}
}
