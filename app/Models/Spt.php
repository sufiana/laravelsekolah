<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\nppd;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\Pegawai;
use App\Models\PejabatTtd;
use App\Models\Beban;

class Spt extends Model
{
    protected $table = 'spt';
    protected $fillable = [
        'no_urut',
        'no_spt',
        'dasar',
        'program',
        'kegiatan',
        'subkegiatan',
        'mata_anggaran',
        'pegawai_ke1',
        'pegawai',
        'untuk',
        'tanggal_berangkat',
        'tanggal_kembali',
        'lama',
        'tgl_spt',
        'pejabat_pemberi_perintah',
        'status',
        'alasan_penolakan',
        'instansi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at',
        'status_spt',
        'tanggal_status_spt',
        'user_status_spt',
        'user_reset_status',
        'tanggal_reset_status',
        'detail_pegawai_1',
        'detail_pegawai_lain',
        'kode_spt'

    ];

    public function setCatAttribute($value)
    {
        $this->attributes['pegawai'] = json_encode($value);
    }

    public function getCatAttribute($value)
    {
        return $this->attributes['pegawai'] = json_decode($value);
    }

    public function programlist(){
        return $this->belongsTo(Program::class,'program','id');
    }

    public function kegiatanlist(){
        return $this->belongsTo(Kegiatan::class,'kegiatan','id');
    }

    public function subkegiatanlist(){
        return $this->belongsTo(SubKegiatan::class,'subkegiatan','id');
    }

    public function bebanlist(){
        return $this->belongsTo(Beban::class,'mata_anggaran','id');
    }

    public function pejabatlist(){
        return $this->belongsTo(Pegawai::class,'pejabat_pemberi_perintah','id');
    }

    public function pejabatttdlist(){
        return $this->belongsTo(PejabatTtd::class,'pejabat_pemberi_perintah','id');
    }

    static function namaBulan($id)
    {
        $hari=substr($id,8,2);
        $thn=substr($id,0,4);
        $id=substr($id,5,2);

        $daftar=array('01'=>$hari.' Januari '.$thn ,'02'=>$hari.' Februari '.$thn,'03'=>$hari.' Maret '.$thn,'04'=>$hari.' April '.$thn,'05'=>$hari.' Mei '.$thn,'06'=>$hari.' Juni '.$thn,'07'=>$hari.' Juli '.$thn,'08'=>$hari.' Agustus '.$thn, '09'=>$hari.' September '.$thn, '10'=>$hari.' Oktober '.$thn,'11'=>$hari.' November '.$thn, '12'=>$hari.' Desember '.$thn);

        return $daftar[$id];
    }
//    public function getFacingsAttribute()
//    {
//        return explode(',', $this->pegawai);
//    }

}
