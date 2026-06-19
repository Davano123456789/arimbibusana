<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Find existing user by google_id
            $user = User::where('google_id', $googleUser->id)->first();

            // Determine the safe redirect URL (avoid redirecting back to login/register)
            $intendedUrl = session()->pull('url.intended', '/');
            if (in_array(parse_url($intendedUrl, PHP_URL_PATH), ['/login', '/register', '/auth/google', '/auth/google/callback'])) {
                $intendedUrl = '/';
            }

            if ($user) {
                Auth::login($user);
                request()->session()->regenerate();
                
                if ($user->role === 'admin') {
                    return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali, Admin!');
                }
                return redirect($intendedUrl)->with('success', 'Berhasil masuk dengan Google!');
            }

            // Find existing user by email (if they registered manually before)
            $userByEmail = User::where('email', $googleUser->email)->first();

            if ($userByEmail) {
                // Link Google ID to existing account
                $userByEmail->update([
                    'google_id' => $googleUser->id,
                ]);

                Auth::login($userByEmail);
                request()->session()->regenerate();

                if ($userByEmail->role === 'admin') {
                    return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali, Admin!');
                }
                return redirect($intendedUrl)->with('success', 'Berhasil masuk dan menautkan akun Google Anda!');
            }

            // Create a new user
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => null, // Password is null since they login via Google
                'role' => 'client',
                'email_verified_at' => now(), // Auto-verify Google email addresses
            ]);

            Auth::login($newUser);
            request()->session()->regenerate();

            return redirect($intendedUrl)->with('success', 'Registrasi dan login dengan Google berhasil!');

        } catch (Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat masuk menggunakan Google. Silakan coba lagi.');
        }
    }
}
