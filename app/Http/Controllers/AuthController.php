<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        try {
            $user = $this->authService->storeUser($validated);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 422);
        }

        return response()->json([
            'user' => $user,
            'message' => 'We\'ve sent a verification link to your email',
        ]);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        try {
            $token = $this->authService->createToken($validated);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }

        return response()->json([
            'token' => $token,
        ]);
    }

    public function sendResetPassword(SendResetPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $user = User::whereEmail($validated['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $this->authService->sendEmailWithUrl('auth.reset-password', $user, ResetPasswordMail::class);

        return response()->json([
            'message' => 'We\'ve sent a reset password link to your email',
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => 'Reset password link expired',
            ], 410);
        }

        $validated = $request->validated();

        $user = User::find($request->user);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ]);
        }

        if (Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'This is your old password, enter new password',
            ]);
        }

        $user->update(['password' => $validated['password']]);

        return response()->json([
            'message' => 'Your password changed successfully',
        ]);
    }

    public function verifyUser(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->authService->verifyUser($request);
        } catch (\Exception $exception) {
            if ($exception->getCode() === 410) {
                return response()->json(['message' => $exception->getMessage()], 410);
            }
            return response()->json(['message' => $exception->getMessage()], 409);
        }

        return response()->json([
            'message' => 'User successfully verified'
        ]);
    }

    public function resendEmailVerificationLink($id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->authService->resendUserLink($id);
        } catch (\Exception $exception) {
            if ($exception->getCode() === 404) {
                return response()->json(['message' => $exception->getMessage()], 404);
            }
            return response()->json(['message' => $exception->getMessage()], 409);
        }

        return response()->json([
            'status' => true,
            'message' => 'We\'ve sent a verification link to your email',
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out',
        ]);
    }
}
