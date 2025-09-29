<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

// Email verification
Route::get('/verify', [AuthController::class, 'verifyUser'])->name('verify-user');
Route::post('/resend-link/{id}', [AuthController::class, 'resendEmailVerificationLink'])->name('auth.resend-link');

// Password reset
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetPassword'])->name('send-reset-password');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset-password');
// User
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/profile', [UserController::class, 'update'])->name('user.update');
});
