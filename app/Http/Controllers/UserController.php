<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserController extends Controller
{
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
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
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }
}
