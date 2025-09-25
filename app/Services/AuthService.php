<?php

namespace App\Services;

use App\Mail\UserVerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthService
{
    public function storeUser(array $userData): User
    {
        $user = User::create($userData);

        $this->sendEmailWithUrl('verify-user', $user, UserVerificationMail::class);

        return $user;
    }

    public function createToken(array $data): string
    {
        $fieldType = $this->getCredentialFieldType($data['email']);

        $user = $this->getUserByType($fieldType, $data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new \Exception('Invalid credentials', 401);
        }

        if (!$user->hasVerifiedEmail()) {
            throw new \Exception('Your email address is not verified', 401);
        }

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function verifyUser(Request $request): void
    {
        if (!$request->hasValidSignature()) {
            throw new \Exception('Verification link expired', 410);
        }

        $user = User::findOrFail($request->user);

        if ($user->hasVerifiedEmail()) {
            throw new \Exception('User already verified', 409);
        }

        $user->markEmailAsVerified();
    }

    public function resendUserLink($id): void
    {
        $user = User::find($id);

        if (is_null($user)) {
            throw new \Exception('User not found', 404);
        }

        if ($user->hasVerifiedEmail()) {
            throw new \Exception('User already verified', 409);
        }

        $this->sendEmailWithUrl('verify-user', $user, UserVerificationMail::class);
    }

    public function sendEmailWithUrl(string $routeName, object $user, $class): void
    {
        $tempUrl = $this->createTempUrl($routeName, $user);

        Mail::to($user)->send(new $class($user->username, $tempUrl));
    }

    private function createTempUrl(string $routeName, object $user): string
    {
        $tempUrl = URL::temporarySignedRoute($routeName, now()->addMinutes(10), ['user' => $user->id]);

        /**
         * TODO: update readme.md file with this info
         * so that user will add this info to .env file
         */
        $backUrl = config('app.url') . '/api';
        $frontUrl = config('app.frontend_url');

        return str_replace($backUrl, $frontUrl, $tempUrl);
    }

    /**
     * Get credential field with type
     * @param string $field
     * @return string
     */
    private function getCredentialFieldType(string $field): string
    {
        return filter_var($field, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * Get user by specific field type
     * @param string $field
     * @param string $value
     * @return User|false
     */
    private function getUserByType(string $field, string $value): User|false
    {
        $user = User::where($field, $value)->first();

        if (!is_null($user)) {
            return $user;
        }

        return false;
    }
}
