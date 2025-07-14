<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $fillable = [
        'id_program',
        'kode',
        'nama',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];

    public function programlist(){
        return $this->belongsTo(Program::class,'id_program','id');
    }

    public function getFullNameAttribute()
    {
        return $this->kode . ' - ' . $this->nama;
    }
}
