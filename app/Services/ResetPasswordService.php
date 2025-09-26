<?php

namespace App\Services;

use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ResetPasswordService
{
    public function sendEmail(string $email): User
    {
        $user = User::whereEmail($email)->first();

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        $token = $this->saveToken($user);
        $tempUrl = $this->createTempUrl($user->id, $token);

        Mail::to($user)->send(new ResetPasswordMail($user->username, $tempUrl));

        return $user;
    }

    private function createTempUrl(int $userId, string $token): string
    {
        $tempUrl = URL::temporarySignedRoute('auth.reset-password', now()->addMinutes(10), ['user' => $userId, 'token' => $token]);
        $backUrl = config('app.url') . '/api';
        $frontUrl = config('app.frontend_url');
        return str_replace($backUrl, $frontUrl, $tempUrl);
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

    private function saveToken($user): string
    {
        $email = $user->email;

        $exists = ResetPassword::whereEmail($user->email)->first();

        // TODO: maybe need to check if exists delete previous and add new one
        // after that delete token from database if user already did the action
        if($exists) {
            throw new \Exception('We already sent reset password email', 403);
        }

        $token = Str::random(60);

        ResetPassword::create([
            'token' => $token,
            'email' => $email,
            'created_at' => now(),
        ]);

        return $token;
    }
}
