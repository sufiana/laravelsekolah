<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IconGrid;

class Parameter extends Model
{
    //
    protected $table = 'parameter_kebersihan';
    protected $fillable = [
        'id_ruang',
        'parameter',
        'deskripsi',
        'user_created',
        'time_created',
        'user_update',
        'time_update'
    ];

    public function ruanglist(){
        return $this->belongsTo(IconGrid::class,'id_ruang','id');
    }

}
