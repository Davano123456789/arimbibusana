<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('public.auth.login');
    }

    public function showRegister()
    {
        return view('public.auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            // Block login if email not verified
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('verification.notice')
                    ->with('warning', 'Email kamu belum diverifikasi. Silakan cek inbox emailmu.');
            }

            // Redirect based on role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali, Admin!');
            }

            return redirect()->intended('/')->with('success', 'Berhasil masuk! Selamat berbelanja.');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'client',
        ]);

        // Send verification email
        $user->sendEmailVerificationNotification();

        // Login temporarily so verification routes work
        Auth::login($user);

        return redirect()->route('verification.notice')
            ->with('success', 'Registrasi berhasil! Kami sudah mengirim email verifikasi ke ' . $user->email . '. Silakan cek inbox kamu.');
    }

    public function verificationNotice()
    {
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return redirect('/');
        }
        return view('public.auth.verify-email');
    }

    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Email verifikasi berhasil dikirim ulang. Silakan cek inbox kamu.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil keluar. Sampai jumpa lagi!');
    }
}
