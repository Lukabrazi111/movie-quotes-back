<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // update user profile
    public function update(UpdateProfileRequest $request)
    {
        $validated = $request->validated();

        auth()->user()->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
        ]);
    }
}
