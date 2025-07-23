<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password_hash', 'google_id', 'google_email', 'google_name', 'role', 'id_sekolah', 'is_active', 'is_verified', 'verification_token', 'verification_expires', 'refresh_token', 'refresh_token_expires', 'last_login',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password_hash', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verification_expires' => 'datetime',
        'refresh_token_expires' => 'datetime',
        'last_login' => 'datetime',
    ];
}
