<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\QuoteController;
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

Route::middleware('auth:sanctum')->group(function () {
	Route::post('/movie', [MovieController::class, 'store']);
    Route::put('/movie/{id}', [MovieController::class, 'update']);
    Route::delete('/movie/{id}', [MovieController::class, 'destroy']);

    Route::post('/quote', [QuoteController::class, 'store']);
    Route::put('/quote/{id}', [QuoteController::class, 'update']);
    Route::delete('/quote/{id}', [QuoteController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/all-movies', [MovieController::class, 'getOnlyMovies']);
Route::get('/movies', [MovieController::class, 'getAllMoviesWithQuotes']);
Route::get('/movie/{movie}', [MovieController::class, 'getSpecificMovie']);
Route::get('/movies/{id}', [MovieController::class, 'getMovieWithQuotes']);

Route::get('/quotes', [QuoteController::class, 'getQuotesWithMovie']);
Route::get('/quote/{id}', [QuoteController::class, 'getSpecificQuote']);
Route::get('/quotes-movies', [QuoteController::class, 'getQuotesAndMovies']);







