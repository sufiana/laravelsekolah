<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RefBebanJenis extends Model
{
    protected $table = 'ref_beban_jenis';
    protected $fillable = [
        'nama'
    ];
}
