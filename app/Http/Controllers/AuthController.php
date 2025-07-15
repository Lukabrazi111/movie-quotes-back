<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        // TODO: need to send temporary link for verification user

        return response()->json([
            'user' => $user,
            'message' => 'User successfully registered',
        ]);
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
    public function getCredentialFieldType(string $field)
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
