<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\models\User; // FIX: huruf M besar

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user berdasarkan google_id
            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Google belum terdaftar.',
                ]);
            }

            if (!$user->is_active || !$user->is_verified) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun tidak aktif atau belum diverifikasi.',
                ]);
            }

            Auth::login($user, true);
            return redirect()->intended('/');
        } catch (\Exception $e) {
            // Optional: log error
            Log::error('Google Login Error: ' . $e->getMessage());

            return redirect()->route('login')->withErrors([
                'email' => 'Gagal login dengan Google. Silakan coba lagi.',
            ]);
        }
    }
}
