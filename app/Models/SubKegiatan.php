<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Program;
use App\Models\Kegiatan;

class SubKegiatan extends Model
{
    protected $table = 'sub_kegiatan';
    protected $fillable = [
        'id_program',
        'id_kegiatan',
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

    public function kegiatanlist(){
        return $this->belongsTo(Kegiatan::class,'id_kegiatan','id');
    }
}
