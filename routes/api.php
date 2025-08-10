<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/verify', [AuthController::class, 'verifyUser'])->name('verify-user');
Route::post('/resend-link/{id}', [AuthController::class, 'resendLink'])->name('auth.resend-link');

// User
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('user.update-profile');
    Route::post('/logout', [AuthController::class, 'logout']);
});
