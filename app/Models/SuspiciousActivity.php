<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SuspiciousActivity extends Model
{
    protected $table = 'suspicious_activities';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'username_or_email',
        'ip_address',
        'activity_type',
        'details',
        'alert_sent',
        'alerted_at',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'alerted_at' => 'datetime',
        'alert_sent' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Log suspicious activity
     */
    public static function logActivity($activityType, $usernameOrEmail, $ipAddress, $details = null, $userId = null)
    {
        return self::create([
            'user_id' => $userId,
            'username_or_email' => $usernameOrEmail,
            'ip_address' => $ipAddress,
            'activity_type' => $activityType,
            'details' => json_encode($details),
            'created_at' => now()
        ]);
    }
}
