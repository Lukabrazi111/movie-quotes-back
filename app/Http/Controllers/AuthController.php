<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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

    public function verifyUser(Request $request): \Illuminate\Http\JsonResponse
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'status' => false,
                'message' => 'Link expired',
            ], 410);
        }

        $user = User::findOrFail($request->user);

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'User already verified',
            ], 409);
        }

        $user->markEmailAsVerified();

        return response()->json([
            'message' => 'User successfully verified'
        ]);
    }

    public function resendLink($id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => false,
                'message' => 'User already verified',
            ], 409);
        }

        $this->sendEmailWithUrl($user);

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
