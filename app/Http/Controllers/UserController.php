<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(UpdateProfileRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $user = auth()->user();

        if($request->has('username')) {
            $user->username = $validated['username'];
        }

        if($request->has('password')) {
            $user->password = bcrypt($validated['password']);
        }

        if($request->has('image')) {
            $image = $request->file('image');
            // upload file...
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
        ]);
    }
}
