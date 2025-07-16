<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\UserVerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        $tempUrl = $this->changeTempUrl($user);

        Mail::to($user)->send(new UserVerificationMail($user->name, $tempUrl));

        return response()->json([
            'user' => $user,
            'message' => 'We\'ve sent a verification link to your email',
        ]);
    }

    public function verifyUser(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
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

    private function changeTempUrl(object $user)
    {
        $tempUrl = $this->generateTempUrl($user->id);

        $backUrl = config('app.url') . '/api';
        $frontUrl = config('app.frontend_url');

        return str_replace($backUrl, $frontUrl, $tempUrl);
    }

    private function generateTempUrl(string $id)
    {
        return URL::temporarySignedRoute('verify-user', now()->addMinutes(15), ['user' => $id]);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $fieldType = $this->getCredentialFieldType($validated['email']);

        $user = $this->getUserByType($fieldType, $validated['email']);

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

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'User logged out',
        ]);
    }

    /**
     * Get credential field with type
     * @param string $field
     * @return string
     */
    private function getCredentialFieldType(string $field)
    {
        return filter_var($field, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    }

    /**
     * Get user by specific field type
     * @param string $field
     * @param string $value
     * @return User
     */
    private function getUserByType(string $field, string $value)
    {
        return User::where($field, $value)->first();
    }
}
