<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Auth
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

// Email verification
Route::get('/verify', [AuthController::class, 'verifyUser'])->name('verify-user');
Route::post('/resend-link/{id}', [AuthController::class, 'resendEmailVerificationLink'])->name('auth.resend-link');

// Password reset
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetPassword'])->name('send-reset-password');
Route::post('/reset-password/{token}', [ResetPasswordController::class, 'resetPassword'])->name('reset-password');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'checkToken'])->name('reset-password.check-token');
// User
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::put('/profile', [UserController::class, 'update'])->name('user.update');

    // Movies
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
});
