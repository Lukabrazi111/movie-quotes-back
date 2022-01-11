<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function store(UserAuthRequest $request)
    {
        $request->validated();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('index');
        }

        return back()->with('success', 'Incorrect email or password!');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->route('index');
    }
}
