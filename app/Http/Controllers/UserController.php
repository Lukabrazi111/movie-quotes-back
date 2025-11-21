<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserController extends Controller
{
    public function update(UpdateProfileRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $user = auth()->user();

        if ($request->has('username')) {
            $user->username = $validated['username'];
        }

        if ($request->has('password')) {
            $user->password = bcrypt($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            uploadImage($user, $request->file('avatar'), 'avatar');
        }

        $user->save();

        return response()->json([
            'user' => new UserResource($user),
            'message' => 'Profile updated successfully',
            'success' => true,
        ]);
    }
}
