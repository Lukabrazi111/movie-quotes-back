<?php

use App\Http\Controllers\AdminMovieController;
use App\Http\Controllers\AdminQuoteController;
use App\Http\Controllers\UserAuthController;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get('/quotes', function (Quote $quote) {
	return $quote->with('movie')->get()->random(1)[0];
});

Route::get('/posts/{movie}', function ($id) {
	return Movie::where('id', $id)->with('quotes')->get();
});

Route::post('/login-user', [UserAuthController::class, 'store']);

Route::get('/movies', function (Movie $movie) {
	return $movie->with('quotes')->get();
});

Route::get('/quotes-movies', function (Quote $quote) {
	return $quote->with('movie')->get();
});

Route::post('/add-movie', [AdminMovieController::class, 'store']);

Route::get('/all-movies', function (Movie $movie) {
	return $movie->all();
});

Route::post('/add-quote', [AdminQuoteController::class, 'store']);

Route::get('/show-quote/{quote}', function($id) {
    return Quote::where('id', $id)->get();
});

Route::put('/edit-quote/{id}', [AdminQuoteController::class, 'update']);

Route::get('/remove-quote/{id}', [AdminQuoteController::class, 'destroy']);

Route::get('/show-movie/{movie}', function($id) {
    return Movie::where('id', $id)->get();
});

Route::put('/edit-movie/{id}', [AdminMovieController::class, 'update']);

Route::get('/remove-movie/{id}', [AdminMovieController::class, 'destroy']);
