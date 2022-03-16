<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->middleware(['auth', 'auth:sanctum'])->group(function () {
	Route::get('/movies', [MovieController::class, 'index'])->name('admin.show');
	Route::get('/add-movie', [MovieController::class, 'addMovie'])->name('admin.add-movie');
	Route::post('/add-movie', [MovieController::class, 'store'])->name('admin.store');
	Route::get('/{id}/edit-movie', [MovieController::class, 'show'])->name('admin.edit');
	Route::put('/{id}', [MovieController::class, 'update'])->name('admin.update');
	Route::get('/{id}', [MovieController::class, 'destroy'])->name('admin.destroy');
	Route::get('panel/quotes', [QuoteController::class, 'index'])->name('admin.quotes');
	Route::get('panel/quotes/{id}/edit-quotes', [QuoteController::class, 'show'])->name('admin.edit-quotes');
	Route::put('panel/quotes/{id}', [QuoteController::class, 'update'])->name('admin.update-quotes');
	Route::get('panel/quotes/{id}', [QuoteController::class, 'destroy'])->name('admin.delete-quotes');
	Route::get('panel/add-quotes', [QuoteController::class, 'addQuote'])->name('admin.add-quotes');
	Route::post('panel/add-quotes', [QuoteController::class, 'store'])->name('admin.store-quotes');
});

Route::get('/login', [AuthController::class, 'index'])->name('user.index');
Route::post('/login-user', [AuthController::class, 'store'])->middleware('guest')->name('user.login');
Route::get('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('user.logout');

Route::post('/{language}', [LanguageController::class, 'index'])->name('lang');
