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

    private function saveToken($user): string
    {
        $email = $user->email;

        $tokenExists = $this->isEmailExists($email);

        if ($tokenExists) {
            ResetPassword::whereEmail($user->email)->delete();
        }

        $token = Str::random(30);

        ResetPassword::create([
            'token' => $token,
            'email' => $email,
            'created_at' => now(),
        ]);

        return $token;
    }

    private function isEmailExists(string $email): bool
    {
        return ResetPassword::whereEmail($email)->exists();
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
        $token = $request->token ?? '';

        if (!$this->isTokenExists($token)) {
            throw new \Exception('You can\'t reset your password', 400);
        }

        if (Hash::check($validated['password'], $user->password)) {
            throw new \Exception('This is your old password, enter new password', 422);
        }

        $this->deleteByToken($token);

        $user->update(['password' => bcrypt($validated['password'])]);

        return $user;
    }

    private function isTokenExists(string $token): bool
    {
        return ResetPassword::whereToken($token)->exists();
    }

    private function deleteByToken(string $token)
    {
        return ResetPassword::whereToken($token)->delete();
    }
}
