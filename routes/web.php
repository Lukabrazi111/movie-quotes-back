<?php

use App\Http\Controllers\AdminMovieController;
use App\Http\Controllers\AdminQuoteController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserAuthController;
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

Route::get('/', [PostsController::class, 'index'])->name('index');

Route::get('/posts/{movie}', [PostsController::class, 'show'])->name('post.show');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/movies', [AdminMovieController::class, 'index'])->name('admin.show');
    Route::get('/add-movie', [AdminMovieController::class, 'addMovie'])->name('admin.add-movie');
    Route::post('/add-movie', [AdminMovieController::class, 'store'])->name('admin.store');
    Route::get('/{id}/edit-movie', [AdminMovieController::class, 'show'])->name('admin.edit');
    Route::put('/{id}', [AdminMovieController::class, 'update'])->name('admin.update');
	Route::get('/{id}', [AdminMovieController::class, 'destroy'])->name('admin.destroy');

    Route::get('panel/quotes', [AdminQuoteController::class, 'index'])->name('admin.quotes');
    Route::get('panel/quotes/{id}/edit-quotes', [AdminQuoteController::class, 'show'])->name('admin.edit-quotes');
    Route::put('panel/quotes/{id}', [AdminQuoteController::class, 'update'])->name('admin.update-quotes');
    Route::get('panel/quotes/{id}', [AdminQuoteController::class, 'destroy'])->name('admin.delete-quotes');

    Route::get('panel/add-quotes', [AdminQuoteController::class, 'addQuote'])->name('admin.add-quotes');
    Route::post('panel/add-quotes', [AdminQuoteController::class, 'store'])->name('admin.store-quotes');

});

Route::get('/login', [UserAuthController::class, 'index'])->name('user.index');
Route::post('/login-user', [UserAuthController::class, 'store'])->middleware('guest')->name('user.login');
Route::get('/logout', [UserAuthController::class, 'destroy'])->middleware('auth')->name('user.logout');

Route::post('/{language}', [LanguageController::class, 'index'])->name('lang');
