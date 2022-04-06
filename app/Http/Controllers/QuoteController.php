<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminQuoteStoreRequest;
use App\Http\Requests\AdminUpdateQuoteRequest;
use App\Models\Quote;

class QuoteController extends Controller
{
	public function getSpecificQuote($id)
	{
		return Quote::where('id', $id)->get();
	}

	public function getQuotesAndMovies(Quote $quote)
	{
		return $quote->with('movie')->orderBy('id', 'desc')->get();
	}

	public function getQuotesWithMovie(Quote $quote)
	{
		return $quote->with('movie')->get()->random(1)[0];
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(AdminQuoteStoreRequest $request)
	{
		$request->validated();

		$image = $request->file('quoteImg');

		if ($request->has('quoteImg'))
		{
			$fileName = mt_rand() . '.' . $image->getClientOriginalExtension();
			$image->move(public_path('img'), $fileName);

			Quote::create(['quote' => [
				'en' => $request->input('enQuote'),
				'ka' => $request->input('kaQuote'),
			], 'thumbnail' => $fileName, 'movie_id' => $request->input('movieId')]);

			return response()->json(['quote' => [
				'en' => $request->input('enQuote'),
				'ka' => $request->input('kaQuote'),
			], 'thumbnail' => $fileName, 'movie_id' => $request->input('movieId')]);
		}

		return response()->json([
			'message' => 'Can NOT upload image!',
		], 422);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id
	 */
	public function update(AdminUpdateQuoteRequest $request, $id)
	{
		$quote = Quote::find($id);

		$image = $request->file('quoteImg');

		$fileName = mt_rand() . '.' . $image->getClientOriginalExtension();
		$image->move(public_path('img'), $fileName);

		$quote->update([
			'quote'     => ['en' => $request->input('enQuote'), 'ka' => $request->input('kaQuote')],
			'thumbnail' => $fileName,
			'movie_id'  => $request->input('movieId'),
		]);

		return response()->json([
			'quote'     => ['en' => $request->input('enQuote'), 'ka' => $request->input('kaQuote')],
			'thumbnail' => $fileName,
			'movie_id'  => $request->input('movieId'),
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 */
	public function destroy($id)
	{
		Quote::destroy($id);

		return response()->json([
			'message' => 'Quote removed!',
		], 200);
	}
}
