<?php

use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Quote;
use App\Models\Movie;

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
	return $movie->all();
});
