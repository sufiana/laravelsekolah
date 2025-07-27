<?php
namespace App\models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\models\Role;


class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users_new';

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'google_id',
        'google_email',
        'google_name',
        'role',
        'id_sekolah',
        'is_active',
        'is_verified',
        'verification_token',
        'verification_expires',
        'refresh_token',
        'refresh_token_expires',
        'last_login',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
        'refresh_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Optional: generate hashed password setter
    public function setPasswordHashAttribute($value)
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }

    /*
    public function isDeveloper()
    {
        return $this->role === 1;
    }

    public function isSekolah()
    {
        return $this->role === 2;
    }

    public function isTataUsaha()
    {
        return $this->role === 3;
    }

    public function isCabangDinas()
    {
        return $this->role === 4;
    }

    public function isKepalaDinas()
    {
        return $this->role === 5;
    }

    public function isPengawasSekolah()
    {
        return $this->role === 6;
    }

    public function isSuperadmin()
    {
        return $this->role === 7;
    }

    public function isVerifikator()
    {
        return $this->role === 8;
    }
*/
    public function rolenya()
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }

}
