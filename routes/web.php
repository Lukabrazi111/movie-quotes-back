<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostsController;
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
Route::prefix('admin')->group(function () {
    Route::get('/panel', [AdminController::class, 'index'])->name('admin.show');
    Route::get('/panel/{id}/edit', [AdminController::class, 'show'])->name('admin.edit');
    Route::put('/panel/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/panel/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});
