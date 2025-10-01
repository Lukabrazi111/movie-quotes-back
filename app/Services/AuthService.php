<?php

namespace App\Services;

use App\Mail\UserVerificationMail;
use App\Models\User;
use App\Traits\TemporaryEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use TemporaryEmail;

    public function storeUser(array $userData): User
    {
        $user = User::create($userData);

        $this->sendEmailWithUrl('verify-user', $user, UserVerificationMail::class);

        return $user;
    }

    public function createToken(array $data): array
    {
        $fieldType = $this->getCredentialFieldType($data['email']);

        $user = $this->getUserByType($fieldType, $data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new \Exception('Invalid credentials', 401);
        }

        if (!$user->hasVerifiedEmail()) {
            throw new \Exception('Your email address is not verified', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
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
}
