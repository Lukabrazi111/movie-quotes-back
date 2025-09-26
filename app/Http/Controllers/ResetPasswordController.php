<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Traits\TemporaryEmail;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use TemporaryEmail;

    public function sendResetPassword(SendResetPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $user = User::whereEmail($validated['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $this->sendEmailWithUrl('auth.reset-password', $user, ResetPasswordMail::class);

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
            ], 404);
        }

        if (Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'This is your old password, enter new password',
            ], 422);
        }

        $user->update(['password' => $validated['password']]);

        return response()->json([
            'message' => 'Your password changed successfully',
        ]);
    }
}
