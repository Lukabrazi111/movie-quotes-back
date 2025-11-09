<?php

namespace App\Services;

use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

        $url = $this->changeUrl($token);

        Mail::to($user)->send(new ResetPasswordMail($user->username, $url));

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

        // TODO: maybe we can create relationship between user and reset password model
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

    private function changeUrl(string $token): string
    {
        $url = route('reset-password.check-token', $token);
        $backUrl = config('app.url') . '/api';
        $frontUrl = config('app.frontend_url');

        return str_replace($backUrl, $frontUrl, $url);
    }

    public function resetPassword(ResetPasswordRequest $request, array $validated): User|JsonResponse
    {
        $token = $request->token ?? '';

        if (!$this->getToken($token)) {
            throw new \Exception('You can\'t reset your password', 400);
        }

        $email = $this->getToken($token)->email;

        $user = User::whereEmail($email)->first();

        if (Hash::check($validated['password'], $user->password)) {
            throw new \Exception('This is your old password, enter new password', 422);
        }

        $this->deleteResetPasswordToken($token);

        $user->update(['password' => bcrypt($validated['password'])]);

        return $user;
    }

    private function getToken(string $token)
    {
        return ResetPassword::whereToken($token)->first();
    }

    private function deleteResetPasswordToken(string $token): bool
    {
        return ResetPassword::whereToken($token)->delete();
    }

    public function getUserEmail(string $token)
    {
        $resetPasswordData = $this->getToken($token);

        if (!$resetPasswordData) {
            throw new \Exception('Invalid or expired token', 404);
        }

        return $resetPasswordData->email;
    }
}
