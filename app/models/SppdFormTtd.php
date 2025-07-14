<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sppd;
use App\Models\Spt;


class SppdFormTtd extends Model
{
    protected $table = 'sppd_formttd';
    protected $fillable = [
        'id_sppd',
        'id_spt',
        'tiba_di',
        'tanggal_tiba',
        'berangkat_dari',
        'tujuan',
        'tanggal_berangkat',
        'status',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];

    public function listsppd(){
        return $this->belongsTo(Sppd::class,'id_sppd','id');
    }

    public function listspt(){
        return $this->belongsTo(Spt::class,'id_spt','id');
    }
}
