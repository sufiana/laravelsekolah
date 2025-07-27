<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // pastikan view login ada
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }

        if (!$user->is_active || !$user->is_verified) {
            return back()->withErrors([
                'email' => 'Akun belum aktif atau belum diverifikasi.',
            ]);
        }

        Auth::login($user, $request->remember);
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
