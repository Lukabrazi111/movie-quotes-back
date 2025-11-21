<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

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
            ['token' => $token, 'user' => $user] = $this->authService->createToken($validated);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function verifyUser(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->authService->verifyUser($request);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

        return response()->json([
            'message' => 'User successfully verified',
            'success' => true,
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
            'message' => 'We\'ve sent a verification link to your email',
            'success' => true,
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'User logged out',
            'success' => true,
        ]);
    }
}
