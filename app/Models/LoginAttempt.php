<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $table = 'login_attempts';

    protected $fillable = [
        'username_or_email',
        'ip_address',
        'user_agent',
        'successful',
        'reason',
        'attempted_at'
    ];

    protected $casts = [
        'attempted_at' => 'datetime',
        'successful' => 'boolean'
    ];

    /**
     * Get failed login attempts for a username in the last period
     */
    public static function getFailedAttempts($usernameOrEmail, $minutes = 15)
    {
        return self::where('username_or_email', $usernameOrEmail)
            ->where('successful', false)
            ->where('attempted_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    /**
     * Get failed login attempts from an IP address
     */
    public static function getFailedAttemptsFromIp($ipAddress, $minutes = 15)
    {
        return self::where('ip_address', $ipAddress)
            ->where('successful', false)
            ->where('attempted_at', '>=', now()->subMinutes($minutes))
            ->count();
    }
}
