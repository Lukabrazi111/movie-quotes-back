<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetPasswordRequest;
use App\Services\ResetPasswordService;

class ResetPasswordController extends Controller
{
    public function __construct(private readonly ResetPasswordService $resetPasswordService)
    {
    }

    public function sendResetPassword(SendResetPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        try {
            $user = $this->resetPasswordService->sendEmail($validated['email']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

        return response()->json([
            'user' => $user->only('username', 'email'),
            'message' => 'We\'ve sent a reset password link to your email',
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        try {
            $user = $this->resetPasswordService->resetPassword($request, $validated);
        } catch (\Exception $exception) {
            $code = (int)$exception->getCode();
            return match ($code) {
                410, 404, 422 => response()->json(['message' => $exception->getMessage()], $exception->getCode()),
            };
        }

        return response()->json([
            'user' => $user->only('username', 'password'),
            'message' => 'Your password changed successfully',
        ]);
    }
}
