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

        $this->saveToken($user);

        $tempUrl = $this->createTempUrl($user->id);

        Mail::to($user)->send(new ResetPasswordMail($user->username, $tempUrl));

        return $user;
    }

    private function saveToken($user): string
    {
        $email = $user->email;

        $emailExists = $this->isEmailExists($email);

        if ($emailExists) {
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

    private function createTempUrl(int $userId): string
    {
        $tempUrl = URL::temporarySignedRoute('reset-password', now()->addMinutes(15), ['user' => $userId]);
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

        $resetToken = $this->getTokenByEmail($user->email);

        if (!$resetToken) {
            throw new \Exception('You can\'t reset your password', 400);
        }

        if (Hash::check($validated['password'], $user->password)) {
            throw new \Exception('This is your old password, enter new password', 422);
        }

        $this->deleteTokenByEmail($user->email);

        $user->update(['password' => bcrypt($validated['password'])]);

        return $user;
    }

    private function getTokenByEmail(string $email): bool
    {
        return ResetPassword::whereEmail($email)->exists();
    }

    private function deleteTokenByEmail(string $email)
    {
        return ResetPassword::whereEmail($email)->delete();
    }
}
