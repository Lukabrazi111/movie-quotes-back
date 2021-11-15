<?php

use App\Http\Controllers\AdminController;
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

Route::get('/', [PostsController::class, 'index']);

Route::get('/posts/{movie:id}', [PostsController::class, 'show'])->name('post.show');

// Admin route
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/panel', [AdminController::class, 'index'])->name('admin.show');

    Route::get('/panel/add', [AdminController::class, 'addMovie'])->name('admin.add-movie');
    Route::post('/panel/add', [AdminController::class, 'store'])->name('admin.store');

    Route::get('/panel/{id}/edit', [AdminController::class, 'show'])->name('admin.edit');
    Route::put('/panel/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/panel/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

// User login route
Route::get('/login', [UserAuthController::class, 'index'])->name('user.index');
Route::post('/login-user', [UserAuthController::class, 'store'])->middleware('guest')->name('user.login');
Route::get('/logout', [UserAuthController::class, 'destroy'])->middleware('auth')->name('user.logout');

// Page not found route
Route::fallback(function () {
    abort(404);
});
