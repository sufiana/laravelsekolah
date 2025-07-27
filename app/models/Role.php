<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'role';
    protected $fillable = [
        'name',
        'deskripsi',
        'butuh_sekolah'
    ];

    public $timestamps = false; // <-- tambahkan ini jika tabel tidak punya created_at/updated_at


}
