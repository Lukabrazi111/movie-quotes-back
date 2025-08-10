<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;

class UserController extends Controller
{
    // update user profile
    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();


    }
}
