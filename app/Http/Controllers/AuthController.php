<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function login(UserAuthRequest $request)
	{
		$request->validated();

		$credentials = $request->only('email', 'password');

		if (Auth::attempt($credentials))
		{
			$user = User::where('email', $request['email'])->firstOrFail();

			$token = $user->createToken('token')->plainTextToken;

			return response()->json([
				'access_token' => $token,
			], 201);
		}

		return response()->json([
			'message' => 'Invalid email or password',
		]);
	}

	public function logout()
	{
		return response()->json([
			'message' => 'Logged out',
		]);
	}
}
