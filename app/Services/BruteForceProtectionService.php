<?php

namespace App\Services;

use App\models\LoginAttempt;
use App\models\SuspiciousActivity;
use App\User;
use Carbon\Carbon;

class BruteForceProtectionService
{
    // Konfigurasi
    const MAX_ATTEMPTS = 5; // Maksimal attempt sebelum lockout
    const LOCKOUT_DURATION = 30; // Menit
    const ATTEMPT_WINDOW = 15; // Menit untuk penghitungan attempt
    const IP_MAX_ATTEMPTS = 20; // Maksimal attempt dari IP yang sama
    const ALERT_THRESHOLD = 3; // Mulai alert setelah N attempt

    /**
     * Record login attempt
     */
    public function recordAttempt($usernameOrEmail, $successful = false, $reason = null, $ipAddress = null, $userAgent = null)
    {
        $ipAddress = $ipAddress ?? $this->getClientIp();

        LoginAttempt::create([
            'username_or_email' => $usernameOrEmail,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'successful' => $successful,
            'reason' => $reason,
            'attempted_at' => now()
        ]);

        // Jika berhasil, reset attempt counter
        if ($successful) {
            $this->resetLoginAttempts($usernameOrEmail);
        } else {
            // Increment failed attempts
            $this->incrementFailedAttempts($usernameOrEmail, $ipAddress);
        }
    }

    /**
     * Check if account is locked
     */
    public function isAccountLocked($usernameOrEmail)
    {
        $user = User::where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();

        if (!$user) {
            return false;
        }

        if ($user->locked_until && $user->locked_until > now()) {
            return true;
        }

        // Jika lockout sudah expired, reset
        if ($user->locked_until && $user->locked_until <= now()) {
            $user->update([
                'login_attempts' => 0,
                'locked_until' => null
            ]);
        }

        return false;
    }

    /**
     * Get remaining time for account lockout
     */
    public function getLockoutTimeRemaining($usernameOrEmail)
    {
        $user = User::where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();

        if (!$user || !$user->locked_until) {
            return null;
        }

        $remaining = $user->locked_until->diffInSeconds(now());
        return max(0, $remaining);
    }

    /**
     * Check if CAPTCHA should be shown
     */
    public function shouldShowCaptcha($usernameOrEmail, $ipAddress = null)
    {
        $ipAddress = $ipAddress ?? $this->getClientIp();

        $failedAttempts = LoginAttempt::getFailedAttempts($usernameOrEmail, self::ATTEMPT_WINDOW);
        $failedAttemptsFromIp = LoginAttempt::getFailedAttemptsFromIp($ipAddress, self::ATTEMPT_WINDOW);

        return $failedAttempts >= self::ALERT_THRESHOLD || $failedAttemptsFromIp >= (self::IP_MAX_ATTEMPTS / 2);
    }

    /**
     * Check if too many attempts from this IP
     */
    public function isTooManyAttemptsFromIp($ipAddress = null)
    {
        $ipAddress = $ipAddress ?? $this->getClientIp();

        $failedAttempts = LoginAttempt::getFailedAttemptsFromIp($ipAddress, self::ATTEMPT_WINDOW);

        return $failedAttempts > self::IP_MAX_ATTEMPTS;
    }

    /**
     * Verify CAPTCHA is required and validate
     */
    public function requiresCaptchaValidation($usernameOrEmail, $ipAddress = null)
    {
        $ipAddress = $ipAddress ?? $this->getClientIp();

        $failedAttempts = LoginAttempt::getFailedAttempts($usernameOrEmail, self::ATTEMPT_WINDOW);

        return $failedAttempts >= self::ALERT_THRESHOLD;
    }

    /**
     * Increment failed login attempts
     */
    protected function incrementFailedAttempts($usernameOrEmail, $ipAddress)
    {
        $user = User::where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();

        if (!$user) {
            return;
        }

        // Count failed attempts
        $failedAttempts = LoginAttempt::getFailedAttempts($usernameOrEmail, self::ATTEMPT_WINDOW);

        $user->update([
            'login_attempts' => $failedAttempts,
            'last_login_attempt' => now()
        ]);

        // Check if should lock account
        if ($failedAttempts >= self::MAX_ATTEMPTS && !$user->locked_until) {
            $user->update([
                'locked_until' => now()->addMinutes(self::LOCKOUT_DURATION)
            ]);

            // Log suspicious activity
            SuspiciousActivity::logActivity(
                'account_locked',
                $usernameOrEmail,
                $ipAddress,
                [
                    'failed_attempts' => $failedAttempts,
                    'lockout_until' => now()->addMinutes(self::LOCKOUT_DURATION)->toDateTimeString()
                ],
                $user->id
            );
        }

        // Alert if exceeds threshold
        if ($failedAttempts >= self::ALERT_THRESHOLD) {
            $this->logSuspiciousActivity(
                'multiple_failures',
                $user->id,
                $usernameOrEmail,
                $ipAddress,
                ['failed_attempts' => $failedAttempts]
            );
        }
    }

    /**
     * Reset login attempts
     */
    protected function resetLoginAttempts($usernameOrEmail)
    {
        $user = User::where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();

        if ($user) {
            $user->update([
                'login_attempts' => 0,
                'last_login_attempt' => now(),
                'locked_until' => null
            ]);
        }
    }

    /**
     * Log suspicious activity
     */
    protected function logSuspiciousActivity($type, $userId, $usernameOrEmail, $ipAddress, $details = [])
    {
        SuspiciousActivity::logActivity(
            $type,
            $usernameOrEmail,
            $ipAddress,
            $details,
            $userId
        );
    }

    /**
     * Get client IP address
     */
    public function getClientIp()
    {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Get recent login attempts
     */
    public function getRecentAttempts($usernameOrEmail, $limit = 10)
    {
        return LoginAttempt::where('username_or_email', $usernameOrEmail)
            ->latest('attempted_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Get statistics
     */
    public function getStatistics($usernameOrEmail)
    {
        $failedAttempts = LoginAttempt::getFailedAttempts($usernameOrEmail, self::ATTEMPT_WINDOW);
        $user = User::where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();

        return [
            'failed_attempts' => $failedAttempts,
            'is_locked' => $this->isAccountLocked($usernameOrEmail),
            'lock_remaining_seconds' => $this->getLockoutTimeRemaining($usernameOrEmail),
            'needs_captcha' => $this->shouldShowCaptcha($usernameOrEmail),
            'last_attempt' => $user?->last_login_attempt,
        ];
    }
}
