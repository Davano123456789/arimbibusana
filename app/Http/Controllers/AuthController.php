<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Placeholder for login logic
    }

    public function register(Request $request)
    {
        // Placeholder for register logic
    }

    public function logout()
    {
        // Placeholder for logout logic
    }
}
