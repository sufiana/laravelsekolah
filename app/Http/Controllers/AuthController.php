<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rules\ValidateCaptcha;
use App\Services\BruteForceProtectionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    protected $bruteForceService;

    public function __construct(BruteForceProtectionService $bruteForceService)
    {
        $this->bruteForceService = $bruteForceService;
    }

    public function showLoginForm()
    {
        // Generate CAPTCHA for session
        $captcha = null;
        if (session()->has('show_captcha')) {
            $captcha = ValidateCaptcha::generateCaptcha();
        }

        return view('auth.login', ['captcha' => $captcha]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'role' => 2, // or whatever default role you want to assign
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $usernameOrEmail = $request->input('username') ?? $request->input('email');
        $password = $request->input('password');
        $ipAddress = $this->bruteForceService->getClientIp();

        // Check if account is locked
        if ($this->bruteForceService->isAccountLocked($usernameOrEmail)) {
            $remainingSeconds = $this->bruteForceService->getLockoutTimeRemaining($usernameOrEmail);
            $remainingMinutes = ceil($remainingSeconds / 60);

            $this->bruteForceService->recordAttempt($usernameOrEmail, false, 'account_locked', $ipAddress);

            return redirect()->back()->withErrors([
                'username' => "Akun Anda terkunci sementara karena terlalu banyak percobaan login gagal. Silakan coba lagi dalam $remainingMinutes menit.",
            ])->withInput($request->except('password'));
        }

        // Check if CAPTCHA is required
        if ($this->bruteForceService->requiresCaptchaValidation($usernameOrEmail)) {
            session(['show_captcha' => true]);

            $validationRules = [
                'username' => 'required|string',
                'password' => 'required|string',
                'captcha_answer' => [new ValidateCaptcha()],
            ];

            $customMessages = [
                'captcha_answer.validate_captcha' => 'Jawaban CAPTCHA tidak benar.'
            ];

            $request->validate($validationRules, $customMessages);
        }

        // Attempt authentication
        $credentials = [
            'username' => $usernameOrEmail,
            'password' => $password
        ];

        // Try with username first
        if (Auth::attempt($credentials)) {
            $this->bruteForceService->recordAttempt($usernameOrEmail, true, null, $ipAddress);

            session()->forget(['show_captcha', 'captcha_answer', 'captcha_expires']);

            return redirect()->intended('dashboard');
        }

        // Try with email
        $credentials = [
            'email' => $usernameOrEmail,
            'password' => $password
        ];

        if (Auth::attempt($credentials)) {
            $this->bruteForceService->recordAttempt($usernameOrEmail, true, null, $ipAddress);

            session()->forget(['show_captcha', 'captcha_answer', 'captcha_expires']);

            return redirect()->intended('dashboard');
        }

        // Record failed attempt
        $this->bruteForceService->recordAttempt($usernameOrEmail, false, 'invalid_credentials', $ipAddress);

        // Check if should show CAPTCHA
        if ($this->bruteForceService->shouldShowCaptcha($usernameOrEmail, $ipAddress)) {
            session(['show_captcha' => true]);
        }

        return redirect()->back()->withErrors([
            'username' => 'Username/Email atau password tidak sesuai.',
        ])->withInput($request->except('password'));
    }

    /**
     * Get login attempt status via AJAX
     */
    public function getLoginStatus(Request $request)
    {
        $usernameOrEmail = $request->input('username_or_email');

        if (!$usernameOrEmail) {
            return response()->json(['error' => 'Username atau email diperlukan'], 400);
        }

        $stats = $this->bruteForceService->getStatistics($usernameOrEmail);

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Generate CAPTCHA via AJAX
     */
    public function generateCaptcha()
    {
        session(['show_captcha' => true]);
        $captcha = ValidateCaptcha::generateCaptcha();

        return response()->json([
            'success' => true,
            'captcha' => $captcha
        ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->getId())->orWhere('email', $googleUser->getEmail())->first();

            if ($user) {
                $ipAddress = $this->bruteForceService->getClientIp();
                $this->bruteForceService->recordAttempt($user->email, true, 'google_oauth', $ipAddress);

                Auth::login($user);
                return redirect()->intended('dashboard');
            } else {
                return redirect()->route('login')->withErrors(['msg' => 'Anda belum terdaftar.']);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Terjadi kesalahan saat login dengan Google.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
