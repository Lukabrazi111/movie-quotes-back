<?php

namespace App\Services;

use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService
{
    public function sendEmail(string $email): User|\Illuminate\Http\JsonResponse
    {
        $user = User::whereEmail($email)->first();

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        $user->sendEmailWithUrl('auth.reset-password', $user, ResetPasswordMail::class);

        return $user;
    }

    public function resetPassword(ResetPasswordRequest $request, array $validated): User|JsonResponse
    {
        if (!$request->hasValidSignature()) {
            throw new \Exception('Reset password link expired', 410);
        }

        $user = User::find($request->user);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        if (Hash::check($validated['password'], $user->password)) {
            throw new \Exception('This is your old password, enter new password', 422);
        }

        $user->update(['password' => bcrypt($validated['password'])]);

        return $user;
    }
}
