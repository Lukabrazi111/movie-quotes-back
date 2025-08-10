<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\UserVerificationMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use phpDocumentor\Reflection\Types\Boolean;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);

        $this->sendEmailWithUrl($user);

        return response()->json([
            'user' => $user,
            'message' => 'We\'ve sent a verification link to your email',
        ]);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $fieldType = $this->getCredentialFieldType($validated['email']);

        $user = $this->getUserByType($fieldType, $validated['email']);

        // TODO: need to check if user is verified

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function verifyUser(Request $request): \Illuminate\Http\JsonResponse
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'status' => false,
                'message' => 'Link expired',
            ], 410);
        }

        $user = User::findOrFail($request->user);

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'User already verified',
            ], 409);
        }

        $user->markEmailAsVerified();

        return response()->json([
            'message' => 'User successfully verified'
        ]);
    }

    public function resendLink($id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => false,
                'message' => 'User already verified',
            ], 409);
        }

        $this->sendEmailWithUrl($user);

        return response()->json([
            'status' => true,
            'message' => 'We\'ve sent a verification link to your email',
        ]);
    }

    private function sendEmailWithUrl($user): void
    {
        $tempUrl = $this->createTempUrl($user);

        Mail::to($user)->send(new UserVerificationMail($user->username, $tempUrl));
    }

    private function createTempUrl(object $user): string
    {
        $tempUrl = $this->generateTempUrl($user->id);

        /**
         * TODO: update readme.md file with this info
         * so that user will add this info to .env file
         */
        $backUrl = config('app.url') . '/api';
        $frontUrl = config('app.frontend_url');

        return str_replace($backUrl, $frontUrl, $tempUrl);
    }

    private function generateTempUrl(string $id): string
    {
        return URL::temporarySignedRoute('verify-user', now()->addMinutes(15), ['user' => $id]);
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

        if(!is_null($user)) {
            return $user;
        }

        return false;
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out',
        ]);
    }
}
