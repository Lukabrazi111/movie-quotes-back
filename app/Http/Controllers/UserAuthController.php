<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    // User login
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/');
        }

        return back()->with('success', 'Incorrect email or password!');
    }

    // User logout
    public function destroy()
    {
        auth()->logout();

        return redirect('/');
    }
}
