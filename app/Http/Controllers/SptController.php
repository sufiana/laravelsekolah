<?php

namespace App\Http\Controllers;

use App\models\Kegiatan;
use App\models\Program;
use App\models\RefGolongan;
use App\models\RefJabatan;
use App\models\SptAnggota;
use App\models\SubKegiatan;
use App\models\UnitKerja;
use Illuminate\Http\Request;
use App\models\Spt;
use App\models\nppd;
use App\models\Pegawai;
use App\models\JenisKegiatan;
use App\models\Jabatan;
use App\models\Golongan;
use App\models\Kecamatan;
use App\models\Kelurahan;
use App\models\PejabatTtd;
use App\models\RefJabatanTtd;
use App\models\Beban;
use App\models\SptDasar;
use App\models\Sppd;
use App\models\SppdFormTtd;
use App\models\Provinsi;
use App\models\JenisAngkutan;
use App\models\JenisTransportasi;
use App\models\FormatSurat;
use App\models\Lokasi;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Auth;
Use Carbon\Carbon;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;
Use Alert;
use Carbon\CarbonPeriod;


class SptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=Spt::all();
        return view('spt/index', [
            'model'    => $model
        ]);
    }

    public function indexsptditerima()
    {
        $model=Spt::all();
        return view('spt/diterima', [
            'model'    => $model
        ]);
    }

    public function getsptditerima(){
        $model=Spt::where('status',1)->orderBy('id', 'DESC')->get();
        return Datatables::of($model)
            ->editColumn('subkegiatan',function ($data){
                return !$data->subkegiatanlist || !$data->subkegiatan ?  ' - ' : $data->subkegiatanlist["kode"].' - '.$data->subkegiatanlist["nama"] ;
            })
            ->editColumn('tanggal_berangkat',function ($data){
                $a=date('d-M-Y', strtotime($data->tanggal_berangkat));
                $b=date('d-M-Y', strtotime($data->tanggal_kembali));
                return $a.' s/d '.$b;
            })
            ->editColumn('pegawai',function ($data){
                $categoryIdString = $data->pegawai;
                $categoryIds = explode(',', $categoryIdString);
                //$cetak=array();
                if(!$categoryIds || $categoryIdString == NULL )
                {
                    $articles = Pegawai::select("*")
                        ->where('id','=','0')
                        ->get();
                    $cetak='-';
                }
                else
                {
                    $articles = Pegawai::select("*")
                        ->whereIn('id', $categoryIds)
                        ->orderByRaw('FIELD(id, '.implode(", " , $categoryIds).')')
                        ->get();
                    if(sizeof($articles) >0)
                    {
                        foreach($articles as $article => $pegawai)
                        {
                            if($article.$pegawai->id==$article.$data->pegawai_ke1 || $article==0)
                                //$cetak[]=$article.':'.$pegawai .'';
                                $cetak[]='<span class="badge badge-primary"><i class="fa fa-star"></i> '.$pegawai->nip.' - '.$pegawai->nama_pegawai.'</span>';
                            else
                                //$cetak[]=$article.':'.$pegawai .'';
                                $cetak[]='<span class="badge badge-success">'.$pegawai->nip.' - '.$pegawai->nama_pegawai.'</span>';
                        }
                    }
                    else
                    {
                        $cetak='-';
                    }
                }
                return $cetak;
            })

            ->addColumn('action', function ($model){
                $button = "
                    <div class='btn-group-horizontal'>
                        <a href='#' class='table-link yellow' data-id='" . $model->id . "' data-nama='" . $model->no_spt . "' id='resetbtn' >
                            <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-undo fa-stack-1x fa-inverse'></i></span>
                        </a>
                ";

                $button = $button . "</div>";
                return $button;
            })
            ->escapeColumns('status')

            ->make(true);
    }

    public function indexsptditolak()
    {
        $model=Spt::all();
        return view('spt/ditolak', [
            'model'    => $model
        ]);
    }

    public function getsptditolak(){
        $model=Spt::where('status',0)->orderBy('id', 'DESC')->get();
        return Datatables::of($model)
            ->editColumn('subkegiatan',function ($data){
                return !$data->subkegiatanlist || !$data->subkegiatan ?  ' - ' : $data->subkegiatanlist["kode"].' - '.$data->subkegiatanlist["nama"] ;
            })
            ->editColumn('tanggal_berangkat',function ($data){
                $a=date('d-M-Y', strtotime($data->tanggal_berangkat));
                $b=date('d-M-Y', strtotime($data->tanggal_kembali));
                return $a.' s/d '.$b;
            })
            ->editColumn('pegawai',function ($data){
                $categoryIdString = $data->pegawai;
                $categoryIds = explode(',', $categoryIdString);
                //$cetak=array();
                if(!$categoryIds || $categoryIdString == NULL )
                {
                    $articles = Pegawai::select("*")
                        ->where('id','=','0')
                        ->get();
                    $cetak='-';
                }
                else
                {
                    $articles = Pegawai::select("*")
                        ->whereIn('id', $categoryIds)
                        ->orderByRaw('FIELD(id, '.implode(", " , $categoryIds).')')
                        ->get();
                    if(sizeof($articles) >0)
                    {
                        foreach($articles as $article => $pegawai)
                        {
                            if($article.$pegawai->id==$article.$data->pegawai_ke1 || $article==0)
                                //$cetak[]=$article.':'.$pegawai .'';
                                $cetak[]='<span class="badge badge-primary"><i class="fa fa-star"></i> '.$pegawai->nip.' - '.$pegawai->nama_pegawai.'</span>';
                            else
                                //$cetak[]=$article.':'.$pegawai .'';
                                $cetak[]='<span class="badge badge-success">'.$pegawai->nip.' - '.$pegawai->nama_pegawai.'</span>';
                        }
                    }
                    else
                    {
                        $cetak='-';
                    }
                }
                return $cetak;
            })

            ->addColumn('action', function ($model){
                /*$button = "
                    <div class='btn-group-horizontal'>
                        <a href='#' class='table-link yellow' data-id='" . $model->id . "' data-nama='" . $model->no_spt . "' id='resetbtn' >
                            <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-undo fa-stack-1x fa-inverse'></i></span>
                        </a>
                ";*/
                $button = "
                    <div class='btn-group-horizontal'>
                    <a href='" . route("spt.edit", $model->id) . "'  id='edit'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-pencil fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='" . route("spt.cetak", $model->id) . "'  class='table-link turquise' id='cetak'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-print fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->no_spt . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                $button = $button . "</div>";
                return $button;
            })
            ->escapeColumns('status')
            ->make(true);
    }

    public function getData(){
        $model=Spt::orderBy('id', 'DESC','status','ASC')->get();
        return Datatables::of($model)
            ->editColumn('kode_spt',function ($data){
                $pegawaipost                = $data->pegawai;
                $pegawaiarray               = explode(',', $pegawaipost);
                $tgla                       = $data->tanggal_berangkat;
                $tglb                       = $data->tanggal_kembali;

                $sql                        =DB::table('spt_anggota as sa')
                    ->select('sa.*')
                    ->whereIn('sa.id_pegawai', $pegawaiarray)
                    ->where(function ($query) use ($tgla, $tglb) {
                        $query->whereBetween('sa.tanggal_berangkat',array($tgla, $tglb));
                        $query->orwhereBetween('sa.tanggal_kembali',array($tgla, $tglb));
                    })
                    ->where('sa.id_spt','<>',$data->id)
                    ->get();
                $i=count($sql);
                if(count($sql) >0)
                    $a=$data->kode_spt . " <a href='#' data-toggle='modal' data-target='#cekjadwalspt' data-id='" . $data->id . "' data-nama='" . $data->kode_spt . "' data-tanggala='" . $data->tanggal_berangkat. "' data-tanggalb='" . $data->tanggal_kembali. "' data-pegawai='" . $data->pegawai . "' style='color: red' title={$i}><i class='fa  fa-exclamation-triangle'></i> </a>";
                else
                    $a=$data->kode_spt;

                return $a;
            })

            ->editColumn('no_spt',function ($data){
                if($data->no_spt==NULL)
                    $a="<a href='#'  id='setnospt' data-toggle='modal' data-target='#setnosptModal' data-id='" . $data->id . "' data-nama='" . $data->kode_spt . "' data-laman='" . 'spt' . "'>No.SPT Belum diisi</a>";
                else
                    $a=$data->no_spt;
                return $a;
            })
            ->editColumn('lama',function ($data){
                return $data->lama.' Hari';
            })
            ->editColumn('subkegiatan',function ($data){
                return !$data->subkegiatanlist || !$data->subkegiatan ?  ' - ' : $data->subkegiatanlist["kode"].' - '.$data->subkegiatanlist["nama"] ;
            })
            ->editColumn('tanggal_berangkat',function ($data){
                $a=date('d-M-Y', strtotime($data->tanggal_berangkat));
                $b=date('d-M-Y', strtotime($data->tanggal_kembali));
                return $a.' s/d '.$b;
            })
            ->editColumn('pegawai',function ($data){
                $categoryIdString = $data->pegawai;
                $categoryIds = explode(',', $categoryIdString);
                //$cetak=array();
                if(!$categoryIds || $categoryIdString == NULL )
                {
                    $articles = Pegawai::select("*")
                        ->where('id','=','0')
                        ->get();
                    $cetak='-';
                }
                else
                {
                    $articles = Pegawai::select("*")
                        ->whereIn('id', $categoryIds)
                        ->orderByRaw('FIELD(id, '.implode(", " , $categoryIds).')')
                        ->get();
                    if(sizeof($articles) >0)
                    {
                        foreach($articles as $article => $pegawai)
                        {
                            if($article.$pegawai->id==$article.$data->pegawai_ke1 || $article==0)
                                //$cetak[]=$article.':'.$pegawai .'';
                                $cetak[]='<span class="badge badge-primary"><i class="fa fa-star"></i> '.$pegawai->nip.' - '.$pegawai->nama_pegawai.'</span>';
                            else
                                //$cetak[]=$article.':'.$pegawai .'';
                                $cetak[]='<span class="badge badge-success">'.$pegawai->nip.' - '.$pegawai->nama_pegawai.'</span>';
                        }
                    }
                    else
                    {
                        $cetak='-';
                    }
                }
                return $cetak;
            })
            ->addColumn('action', function ($model){
                $ceksppd=Sppd::where('id_spt',$model->id)->first();
                if(!$ceksppd) {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a href='" . route("spt.edit", $model->id) . "'  id='edit'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-pencil fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='" . route("spt.cetak", $model->id) . "'  class='table-link turquise' id='cetak'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-print fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='" . route("spt.createSppd", $model->id) . "' title='Create SPPD' id='sppd' class='table-link yellow'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-sign-in fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->no_spt . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                }
                else $button = "
                    <div class='btn-group-horizontal'>
                    <a href='" . route("spt.edit", $model->id) . "'  id='edit'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-pencil fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='" . route("spt.cetak", $model->id) . "'  class='table-link turquise' id='cetak'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-print fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->no_spt . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                $button = $button . "</div>";
                return $button;
            })
            ->escapeColumns('status')
            ->make(true);
    }

    public function createSppd($id)
    {
        $model                  = Spt::find($id);
        $sppd                   = Sppd::where('id_spt',$id)->first();
//        if($sppd)
//            $idsppd             = $sppd->id;
//        else
//            $idsppd             = Null;
        $provinsi               = Provinsi::all();
        $angkutan               = JenisAngkutan::all();
        $transport              = JenisTransportasi::all();
        $anggaran               = Beban::all();
        $kecamatands            = Kecamatan::where('id_kabupatenkota',1212)->get();
        $kelurahands            = Kelurahan::where('kab',1212)->get();
        $lokasi                 = Lokasi::all();
        $lokasidalam            = Lokasi::where('kab',12)->get();
        $unitkerja              = UnitKerja::find(1);

        $cekformtujuan          = DB::table('sppd_formttd as a')
            ->select('*')
            ->where('id_spt',$id)
            ->get();

        $max                    = DB::table('spt as a')
            ->select(DB::Raw("max(a.kode_spt) AS kode"))
            ->first();
        if($model->kode_spt >=1) {
            $kode=$model->kode_spt;
        }
        else {
            if(!$max)
                $kode   = 1;
            else
                $kode   = $max->kode+1;
        }
        if($model->program && $model->programlist )
            $program= $model->programlist["kode"].' - '.$model->programlist["nama"] ;
        else
            $program='-';

        if($model->kegiatan && $model->kegiatanlist )
            $kegiatan= $model->kegiatanlist["kode"].' - '.$model->kegiatanlist["nama"] ;
        else
            $kegiatan='-';

        if($model->subkegiatan && $model->subkegiatanlist )
            $subkegiatan= $model->subkegiatanlist["kode"].' - '.$model->subkegiatanlist["nama"] ;
        else
            $subkegiatan='-';

        if($model->mata_anggaran && $model->bebanlist ) {
            $beban = $model->bebanlist["kode"] . ' - ' . $model->bebanlist["nama"];
            $tahun = $model->bebanlist["tahun"];
        }
        else {
            $beban = '-';
            $tahun = '-';
        }

        $categoryIdString = $model->pegawai;
        $categoryIds = explode(',', $categoryIdString);
        if ($categoryIdString <> NULL) {
            $articles = Pegawai::select("*")
                ->whereIn('id', $categoryIds)
                ->orderByRaw('FIELD(id, ' . implode(", ", $categoryIds) . ')')
                ->get();
        } else {
            $articles = Pegawai::select("*")
                ->where('id', '=', '0')
                ->get();
        }

        $lama=$model->lama;
        $daterange              = CarbonPeriod::create($model->tanggal_berangkat,$model->tanggal_kembali);

        if(!$sppd) {
            return view('sppd.createsppd', compact(
                'model',
                'sppd',
//                'idsppd',
                'provinsi',
                'lokasi',
                'lokasidalam',
                'angkutan',
                'transport',
                'anggaran',
                'kecamatands',
                'kelurahands',
                'cekformtujuan',
                'max',
                'kode',
                'program',
                'kegiatan',
                'beban',
                'tahun',
                'categoryIdString',
                'categoryIds',
                'articles',
                'lama',
                'subkegiatan',
                'unitkerja',
                'daterange'
            ));
        }
        else {
//            return view('sppd.editsppd', compact(
//                'model',
//                'sppd',
////                'idsppd',
//                'provinsi',
//                'lokasi',
//                'lokasidalam',
//                'angkutan',
//                'transport',
//                'anggaran',
//                'kecamatands',
//                'kelurahands',
//                'cekformtujuan',
//                'max',
//                'kode',
//                'program',
//                'kegiatan',
//                'beban',
//                'tahun',
//                'categoryIdString',
//                'categoryIds',
//                'articles',
//                'lama',
//                'subkegiatan',
//                'unitkerja',
//                'daterange'
//            ));
            return redirect()->route('sppd.edit',$sppd->id);
        }


    }

    public function create()
    {
        $pegawai                = Pegawai::all();
        $pejabat                = Pegawai::all();
        $program                = Program::all();
        $kegiatan               = Kegiatan::all();
        $subkegiatan            = SubKegiatan::all();
        $mataanggaran           = Beban::all();

        $pejabatttd             = DB::table('pejabat_ttd as ptd')
                                    ->select('ptd.*', 'mp.nip', 'mp.nama_pegawai', 'rj.nama as jabatan_ttd',
                                        DB::Raw("CONCAT(rj.nama, ' (', mp.nip, ' - ', mp.nama_pegawai, ' )' ) AS detail"))
                                    ->join('master_pegawai as mp', 'ptd.id_pegawai', '=', 'mp.id')
                                    ->join('ref_jabatan_ttd as rj', 'ptd.id_jabatan_ttd', '=', 'rj.id')
                                    ->get();
        $kop                    = UnitKerja::findOrFail(1);

        $max                    = DB::table('spt as a')
                                    ->select(DB::Raw("max(a.kode_spt) AS kode"))
                                    ->first();

        if(!$max)
            $kode   = 1;
        else
            $kode   = $max->kode+1;


        return view('spt.create', compact(
            'pegawai',
            'pejabat',
            'program',
            'kegiatan',
            'subkegiatan',
            'mataanggaran',
            'pejabatttd',
            'kop',
            'max',
            'kode'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required'      => 'Kolom :attribute Wajib diisi',
            //'nospt.unique'  => 'No. SPT Tersebut Sudah digunakan sebelumnya',
            'kodespt.unique'  => 'Kode SPT Tersebut Sudah digunakan sebelumnya',

        ];
        $validator = Validator::make($request->all(), [
            //'nospt'                     => 'unique:spt,no_spt',
            'kodespt'                   => 'required|unique:spt,kode_spt',
            'tgl_spt'                   => 'required',
            'program'                   => 'required',
            'kegiatan'                  => 'required',
            'subkegiatan'               => 'required',
            'mata_anggaran'             => 'required',
            //'pejabat_pemberi_perintah'  => 'required',
            'inputCount'                => 'required',
            'pegawai_ke1'               => 'required',
            'pegawai'                   => 'required',
            'untuk'                     => 'required',
            'tanggal_berangkat'         => 'required',
            'tanggal_kembali'           => 'required',
            'lama'                      => 'required',
        ], $messages);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()->all()
            ]);
        }

        else {
            $pegawai                    = $request->pegawai_ke1 . ',' . implode(",", $request->pegawai);
            $post                       = new Spt();
            $post->no_spt               = $request->nospt;
            $post->no_urut              = $request->no_urut;
            $post->tgl_spt              = date('Y-m-d', strtotime($request->tgl_spt));
            $post->pegawai              = $pegawai;
            $post->pegawai_ke1          = $request->pegawai_ke1;
            $post->program              = $request->program;
            $post->kegiatan             = $request->kegiatan;
            $post->subkegiatan          = $request->subkegiatan;
            $post->mata_anggaran        = $request->mata_anggaran;
            $post->untuk                = $request->untuk;
            $post->tanggal_berangkat    = date('Y-m-d', strtotime($request->tanggal_berangkat));
            $post->tanggal_kembali      = date('Y-m-d', strtotime($request->tanggal_kembali));
            $post->lama                 = $request->lama;
            //$post->pejabat_pemberi_perintah = $request->pejabat_pemberi_perintah;
            $post->user_created         = NULL;
            $post->status               = 0;
            $post->kode_spt             = $request->kodespt;

            //save SPT Dasar
            for ($i = 1; $i <= $request->inputCount; $i++) {
                $dasararray[]           = '<li>' . $request->dasar[$i] . '</li>';
                $dasar                  = new SptDasar;
                $dasar->nomor_spt       = $post->no_spt;
                $dasar->kode_spt        = $post->kode_spt;
                $dasar->jumlah          = $request->inputCount;
                $dasar->nomor_urut      = $i;
                $dasar->dasar           = $request->dasar[$i];
                $dasar->save();
            }
            $post->dasar                = '<ol>' . implode(';', $dasararray) . '</ol>';

            $simpan = $post->save();
            if ($simpan) {

                //save SPT anggota
                $categoryIdString           = $post->pegawai;
                $categoryIds                = explode(',', $categoryIdString);
                foreach ($categoryIds as $x => $spt) {
                    //dropdown jabatan dari tabel ref_golongan
                    //field di master pegawai = golongan
                    $masterpegawai          = Pegawai::find($spt);
                    $anggota                = new SptAnggota();
                    $anggota->id_spt        = $post->id;
                    $anggota->no_spt        = $post->no_spt;
                    $anggota->kode_spt      = $post->kode_spt;
                    $anggota->id_pegawai    = $spt;
                    $anggota->urutan        = $x;
                    $anggota->jabatan_pegawai       = $masterpegawai->id_jabatan;
                    $anggota->golongan_pegawai      = $masterpegawai->golongan;
                    $anggota->tanggal_berangkat = $post->tanggal_berangkat;
                    $anggota->tanggal_kembali = $post->tanggal_kembali;
                    $anggota->lama = $post->lama;
                    $anggota->save();
                }
                //fungsi update SPTDASAr untuk menyimpan ID SPT
                SptDasar::where('nomor_spt', $post->no_spt)
                    ->update(['id_spt' => $post->id]);

                Session::flash('berhasil', 'Data SPT Berhasil di tambah');
                if($request->print==1)
                    return redirect()->route('spt.cetak',$post->id);

                else
                    return redirect()->route('spt.index');
            }
            else
                return back()->withErrors(['Gagal' => ['Data SPT Gagal di tambah']]);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model=Spt::findOrFail($id);
        $kop                = UnitKerja::findOrFail(1);
        $program            = $model->program && $model->programlist ? $model->programlist["tahun"] : ' - ' ;
        $programkegiatan    = $model->kegiatan && $model->kegiatanlist ? $model->kegiatanlist["kode"].' '.$model->kegiatanlist["nama"] : ' - ' ;
        $programsubkegiatan = $model->subkegiatan && $model->subkegiatanlist ? $model->subkegiatanlist["kode"].' '.$model->subkegiatanlist["nama"] : ' - ' ;
        $ttd                = PejabatTtd::find($model->pejabat_pemberi_perintah);
        if($model->pejabat_pemberi_perintah <> NULL)
        {
            $pejabatttd             = DB::table('pejabat_ttd as ptd')
                ->select('ptd.*', 'mp.nip', 'mp.nama_pegawai', 'rj.nama as jabatan_ttd',
                    DB::Raw("CONCAT(rj.nama, ' (', mp.nip, ' - ', mp.nama_pegawai, ' )' ) AS detail"))
                ->join('master_pegawai as mp', 'ptd.id_pegawai', '=', 'mp.id')
                ->join('ref_jabatan_ttd as rj', 'ptd.id_jabatan_ttd', '=', 'rj.id')
                ->where('ptd.id', '=', $model->pejabat_pemberi_perintah)
                ->get();
            if(sizeof($pejabatttd) >0)
            {
                foreach($pejabatttd as $pej)
                {
                    $pejabatttd=$pej->detail;
                }
            }

            else
                $pejabatttd='-';
        }
        else
        {
            $pejabatttd= '-';
        }

        return view('spt.detail',compact('model','kop','program','programkegiatan','programsubkegiatan','pejabatttd','ttd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model                  = Spt::find($id);
        $pegawai                = Pegawai::all();
        $pejabat                = Pegawai::all();
        $program                = Program::all();
        $kegiatan               = Kegiatan::all();
        $ambilkegiatan          = Kegiatan::find($model->kegiatan);
        $ambilsubkegiatan       = SubKegiatan::find($model->subkegiatan);
        $ambilanggaran          = Beban::find($model->mata_anggaran);
        $subkegiatan            = SubKegiatan::all();
        $kop                    = UnitKerja::findOrFail(1);
        $mataanggaran           = Beban::all();
        $sptdasar               = SptDasar::where('id_spt',$id)->first();
        $dasarsptarray          = SptDasar::where('id_spt',$id)->get();

        $pejabatttd             = DB::table('pejabat_ttd as ptd')
            ->select('ptd.*', 'mp.nip', 'mp.nama_pegawai', 'rj.nama as jabatan_ttd',
                DB::Raw("CONCAT(rj.nama, ' (', mp.nip, ' - ', mp.nama_pegawai, ' )' ) AS detail"))
            ->join('master_pegawai as mp', 'ptd.id_pegawai', '=', 'mp.id')
            ->join('ref_jabatan_ttd as rj', 'ptd.id_jabatan_ttd', '=', 'rj.id')
            ->get();

        $max                    = DB::table('spt as a')
            ->select(DB::Raw("max(a.kode_spt) AS kode"))
            ->first();

        if($model->kode_spt == NULL) {
            if (!$max)
                $kode = 1;
            else
                $kode = $max->kode + 1;
        }
        else {
            $kode = $model->kode_spt;
        }

        return view('spt.edit', compact(
            'model',
            'pegawai',
            'pejabat',
            'program',
            'kegiatan',
            'subkegiatan',
            'kop',
            'mataanggaran',
            'sptdasar',
            'dasarsptarray',
            'pejabatttd',
            'ambilkegiatan',
            'ambilsubkegiatan',
            'ambilanggaran',
            'max',
            'kode'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $messages = [
            'required'                  => 'Kolom :attribute Wajib diisi',
            //'nospt.unique'              => 'No. SPT Tersebut Sudah digunakan sebelumnya',
            'kodespt.unique'            => 'Kode. SPT Tersebut Sudah digunakan sebelumnya',

        ];
        $validator = Validator::make($request->all(), [
            // 'nospt'                     =>'required|unique:spt,no_spt,'.$request->id,
            'kodespt'                   =>'required|unique:spt,kode_spt,'.$request->id,
            'tgl_spt'                   =>'required',
            'program'                   =>'required',
            'kegiatan'                  =>'required',
            'subkegiatan'               =>'required',
            'inputCount'                => 'required',
            'pegawai_ke1'               => 'required',
            'pegawai'                   => 'required',
            'untuk'                     =>'required',
            'tanggal_berangkat'         =>'required',
            'tanggal_kembali'           =>'required',
            'lama'                      =>'required',
        ],$messages);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()->all()
            ]);
        }

        else {
            $pegawai                    = $request->pegawai_ke1 . ',' . implode(",", $request->pegawai);
            $post                       = Spt::where('id', $request->id)->first();
            $post->no_spt               = $request->nospt;
            $post->no_urut              = $request->no_urut;
            $post->tgl_spt              = date('Y-m-d', strtotime($request->tgl_spt));
//        $post->dasar                                = $request->dasar;
            $post->pegawai              = $pegawai;
            $post->pegawai_ke1          = $request->pegawai_ke1;
            $post->program              = $request->program;
            $post->kegiatan             = $request->kegiatan;
            $post->subkegiatan          = $request->subkegiatan;
            $post->mata_anggaran        = $request->mata_anggaran;
            $post->untuk                = $request->untuk;
            $post->tanggal_berangkat    = date('Y-m-d', strtotime($request->tanggal_berangkat));
            $post->tanggal_kembali      = date('Y-m-d', strtotime($request->tanggal_kembali));
            $post->lama                 = $request->lama;
            $post->pejabat_pemberi_perintah = $request->pejabat_pemberi_perintah;
            $post->user_created         = NULL;
            $post->status               = 0;
            //$post->created_at
            //$post->user_update
            //$post->updated_at

            //hapus SPT Dasar
            SptDasar::where('id_spt', $request->id)
                ->delete();
            SptAnggota::where('id_spt', $request->id)
                ->delete();

            //save ulang SPTDasar
            for ($i = 1; $i <= $request->inputCount; $i++) {
                $dasararray[]           = '<li>' . $request->dasar[$i] . '</li>';
                $dasar                  = new SptDasar;
                $dasar->id_spt          = $request->id;
                $dasar->nomor_spt       = $request->nospt;
                $dasar->kode_spt        = $request->kodespt;
                $dasar->jumlah          = $request->inputCount;
                $dasar->nomor_urut      = $i;
                $dasar->dasar           = $request->dasar[$i];
                $dasar->save();
            }
            $post->dasar                = '<ol>' . implode(';', $dasararray) . '</ol>';

            //save ulang SPT Anggota
            $categoryIds                = explode(',', $pegawai);
            foreach ($categoryIds as $x => $spt) {
                $masterpegawai          = Pegawai::find($spt);
                $anggota                = new SptAnggota();
                $anggota->id_spt        = $request->id;
                $anggota->no_spt        = $request->nospt;
                $anggota->kode_spt      = $request->kodespt;
                $anggota->id_pegawai    = $spt;
                $anggota->jabatan_pegawai       = $masterpegawai->id_jabatan;
                $anggota->golongan_pegawai      = $masterpegawai->golongan;
                $anggota->urutan        = $x;
                $anggota->tanggal_berangkat = date('Y-m-d', strtotime($request->tanggal_berangkat));
                $anggota->tanggal_kembali = date('Y-m-d', strtotime($request->tanggal_kembali));
                $anggota->lama = $request->lama;
                $anggota->save();
            }

            $simpan                     = $post->save();
            if($simpan)
            {

                Session::flash('berhasil', 'Data SPT Berhasil di Simpan');
                if($request->print==1)
                    return redirect()->route('spt.cetak',$post->id);

                else
                    return redirect()->route('spt.index');
            }
            else
                return back()->withErrors(['Gagal' => ['Data SPT Gagal di Update']]);
        }
    }

    public function updatenospt(Request $request)
    {
        $messages = [
            'required'                  => 'Kolom :attribute Wajib diisi',
            'nospt.unique'              => 'No. SPT Tersebut Sudah digunakan sebelumnya',
        ];
        $validator = Validator::make($request->all(), [
            'nospt'                     =>'required|unique:spt,no_spt,'.$request->idspt,
        ],$messages);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()->all()
            ]);
        }

        else {
            $post                       = Spt::where('id', $request->idspt)->first();
            $post->no_spt               = $request->nospt;
            $post->no_urut              = $request->no_urut;
            $simpan                     = $post->save();
            if($simpan)
            {

                Session::flash('berhasil', 'No SPT Berhasil di Simpan');
                if ($request->laman == 'spt') {
                    return redirect()->route('spt.index');
                }
                else if($request->laman == 'sppd') {
                    return redirect()->route('sppd.index');
                }
                else if($request->laman == 'laporansppd') {
                    return redirect()->route('sppd.indexLaporan');
                }
                else if($request->laman == 'tandaterima') {
                    return redirect()->route('sppd.indexTandaTerima');
                }
                else if($request->laman == 'kwitansi') {
                    return redirect()->route('sppd.indexKwitansi');
                }
                else {
                    return redirect()->route('sppd.index');
                }
            }
            else
                return back()->withErrors(['Gagal' => ['No SPT Gagal di Update']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check=Spt::firstWhere('id',$id);
        $periksaspd=DB::table('sppd as sa')->where('sa.id_spt',$id)->get();
            if($check) {
                if(sizeof($periksaspd)==0) {
                    Spt::destroy($id);
                    SptDasar::where('id_spt', $id)
                        ->delete();
                    SptAnggota::where('id_spt', $id)
                        ->delete();
                    return response([
                        'status' => 'OK',
                        'message' => 'Data Deleted',
                    ], 200);
                }
                else {
                    return response([
                        'status' => 'Maaf',
                        'message' => 'Maaf Data SPT ini tidak dapat di hapus, Karena SPPD sudah terbit !',
                    ], 404);
                }

            }
            else{
                return response([
                    'status' => 'Gagal',
                    'message' => 'Data Not Found',
                ], 404);
            }


    }

    public function reset(Request $request, $id)
    {

            $post                           = Spt::find($id);
            $post->status                   = NULL;
            $post->alasan_penolakan         = NULL;
            $post->user_reset_status        = NULL;
            $post->tanggal_reset_status     = date("Y-m-d H:i:s");
            $post->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Berhasil di reset'
                ]);


    }

    public function getKegiatan($id)
    {
        $kabkota = Kegiatan::select(
            DB::raw("CONCAT(kode,' ',nama) AS name"),'id')
            ->where('id_program', $id)
            ->pluck('name', 'id');
        $tahun=Program::find($id)->tahun;
        return response()->json(['kabkota'=>$kabkota,'tahun'=>$tahun]);

        //return response()->json($kabkota);
    }

    public function getsubkegiatan($id)
    {
        $kabkota = SubKegiatan::select(
            DB::raw("CONCAT(kode,' ',nama) AS name"),'id')
            ->where('id_kegiatan', $id)
            ->pluck('name', 'id');
        return response()->json($kabkota);
    }

    public function getKabupatenkota($id)
    {
        $kabkota = DB::table("kabupatenkota")->where("id_provinsi",$id)->pluck("nama","id");
        return response()->json($kabkota);
    }

    public function getKecamatan($id)
    {
        $kecamatan = DB::table("kecamatan")->where("id_kabupatenkota",$id)->pluck("nama","id");
        return response()->json($kecamatan);
    }

    public function getKelurahan($id)
    {
        $kelurahan = DB::table("kelurahan")->where("id_kecamatan",$id)->pluck("nama","id");
        return response()->json($kelurahan);
    }

    public function cetak($id)
    {
        $model              = Spt::findOrFail($id);
        $kop                = UnitKerja::findOrFail(1);
        $ttd                = PejabatTtd::find(1);
        $program            = $model->program && $model->programlist ? $model->programlist["tahun"] : ' - ' ;
        $programkegiatan    = $model->kegiatan && $model->kegiatanlist ? $model->kegiatanlist["kode"].' '.$model->kegiatanlist["nama"] : ' - ' ;
        $programsubkegiatan = $model->subkegiatan && $model->subkegiatanlist ? $model->subkegiatanlist["kode"].' '.$model->subkegiatanlist["nama"] : ' - ' ;
        $formatnosurattabel = FormatSurat::find(1);
        if($model->no_spt==NULL) {
            $nosurat=$formatnosurattabel->digit_pertama.'/ '.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.$formatnosurattabel->digit_berikutnya.'/'.date("Y");


        }
        else {
            $nosurat=$model->no_spt;
        }
//        return view('spt.cetak',compact('model','kop','ttd','program','programkegiatan','programsubkegiatan'));
        $pdf= PDF::loadView('spt.cetak',compact('model','kop','ttd','program','programkegiatan','programsubkegiatan','nosurat'))->setPaper('a4', 'portrait');
        return $pdf->stream();

    }


    public function cetakword($id)
    {
        $model              = Spt::findOrFail($id);
        $kop                = UnitKerja::findOrFail(1);
        $ttd                = PejabatTtd::find($model->pejabat_pemberi_perintah);
//        $program            = $model->program && $model->programlist ? $model->programlist["tahun"] : ' - ' ;
//        $programkegiatan    = $model->kegiatan && $model->kegiatanlist ? $model->kegiatanlist["kode"].' '.$model->kegiatanlist["nama"] : ' - ' ;
//        $programsubkegiatan = $model->subkegiatan && $model->subkegiatanlist ? $model->subkegiatanlist["kode"].' '.$model->subkegiatanlist["nama"] : ' - ' ;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $bulanspt   = date('m', strtotime($model->tgl_spt));
        $bulan      = array(
            '01'    =>'Januari',
            '02'    =>'Februari',
            '03'    =>'Maret',
            '04'    =>'April',
            '05'    =>'Mei',
            '06'    =>'Juni',
            '07'    =>'Juli',
            '08'    =>'Agustus',
            '09'    =>'September',
            '10'    =>'Oktober',
            '11'    =>'November',
            '12'    =>'Desember');
        $tanggalspt = date('d', strtotime($model->tgl_spt)).' '.$bulan[$bulanspt].' '.date('Y', strtotime($model->tgl_spt));

        if($ttd <> NULL)
        {
            $jabatan=RefJabatanTtd::find($ttd->id_jabatan_ttd);
            if($jabatan == null)
            {
                $cetakjabatan='-';
            }
            else
            {
                $cetakjabatan=strtoupper($jabatan->nama);
            }

            $pegawaittd=Pegawai::find($ttd->id_pegawai);
            if($pegawaittd == null)
            {
                $nipttd='-';
                $namattd='-';
            }
            else
            {
                $nipttd=$pegawaittd->nip;
                $namattd=$pegawaittd->nama_pegawai;

                $gol=RefGolongan::find($pegawaittd->golongan);
                if($gol == null)
                {
                    $golongan='-';
                }
                else
                {
                    $golongan=$gol->nama;
                }
            }
        }
        else
        {
            echo 'Maaf Tentukan pejabat pemberi perintah terlebih dahulu';
            $cetakjabatan='-';
            $namattd='-';
            $nipttd='-';
            $golongan='-';
        }

        /*$htmldasar      =$model->dasar;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->addParagraphStyle('Heading2', ['alignment' => 'center']);

        $section = $phpWord->addSection();
        $html = '<h1>Adding element via HTML</h1>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
*/
//        $value = $model->dasar;
//        $wordTable = new \PhpOffice\PhpWord\Element\Table();
//        $wordTable->addRow();
//        $cell = $wordTable->addCell();
//        $value = str_replace('&', '&amp;', $value); // Fixed file error with symbol "&"
//        \PhpOffice\PhpWord\Shared\Html::addHtml($cell,$value);

        $html = '<h1>The Description</h1><p>Some description here!</p>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

        $templateProcessor = new TemplateProcessor('template/spt.docx');
        //$templateProcessor->setComplexBlock('dasar', $wordTable);
        $templateProcessor->setValue('dasar', $html);
        $templateProcessor->setValue('kop1', $kop->kopsurat_baris1);
        $templateProcessor->setValue('kop2', $kop->kopsurat_baris2);
        $templateProcessor->setValue('kop3', $kop->kopsurat_baris3);
        $templateProcessor->setValue('kop4', $kop->kopsurat_baris4);
        $templateProcessor->setValue('kop5', $kop->kopsurat_baris5);
        $templateProcessor->setValue('nomorsurat', $model->no_spt);

        $templateProcessor->setValue('untuk', htmlspecialchars($model->untuk));
//        $templateProcessor->setValue('dasar',ensureUtf8Encoded($model->dasar));
        $templateProcessor->setValue('tempat', $kop->tempat_ttd);
        $templateProcessor->setValue('tanggalsurat', $tanggalspt);
        $templateProcessor->setValue('jabatanttd', $cetakjabatan);
        $templateProcessor->setValue('namapejabat', $namattd);
        $templateProcessor->setValue('jabatanpejabat', $golongan);
        $templateProcessor->setValue('nippejabat', $nipttd);
        $fileName = 'SPT '.str_replace('/','-',$model->no_spt);

        \PhpOffice\PhpWord\Settings::setCompatibility(false);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');


        $templateProcessor->saveAs($fileName . '.docx');

        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);

    }

    public function cetakspd($id)
    {
        $model              = Spt::findOrFail($id);
        $kop                = UnitKerja::findOrFail(1);
        $ttd                = PejabatTtd::find($model->pejabat_pemberi_perintah);
        $program            = $model->program && $model->programlist ? $model->programlist["tahun"] : ' - ' ;
        $programkegiatan    = $model->kegiatan && $model->kegiatanlist ? $model->kegiatanlist["kode"].' '.$model->kegiatanlist["nama"] : ' - ' ;
        $programsubkegiatan = $model->subkegiatan && $model->subkegiatanlist ? $model->subkegiatanlist["kode"].' '.$model->subkegiatanlist["nama"] : ' - ' ;

        $pdf= PDF::loadView('spt.spd',compact('model','kop','ttd','program','programkegiatan','programsubkegiatan'))->setPaper('a4', 'portrait');
//        $pdf= PDF::loadView('spt.cetak',compact('model','kop','ttd','jabatanttd'))->setPaper('a4', 'portrait');
        return $pdf->stream();

    }


    public function editmodal($id)
    {
        $model = Spt::find($id);
        if($model)
        {
            return response()->json([
                'status'=>200,
                'model'=> $model,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Data Tidak Ditemukan...'
            ]);
        }
    }

    public function updatemodal(Request $request, $id)
    {
        $messages = [
            'required'              => 'Kolom :attribute Wajib diisi',
        ];
        $validator = Validator::make($request->all(), [
            'status'                =>'required',
        ],$messages);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()->all()
            ]);
        }
        else {
            $post                           = Spt::find($id);
            if($post) {
                if($request->input('status')) {
                    if ($request->input('status') == 1) {
                        $post->status = 1;
                        $post->alasan_penolakan = NULL;
                        $post->status_spt = 1;
                        $post->tanggal_status_spt = date("Y-m-d H:i:s");
                        $post->user_status_spt = 1;
                    } else {
                        $post->alasan_penolakan = $request->input('alasan_penolakan');
                        $post->status = 2;
                        $post->status_spt = 0;
                        $post->tanggal_status_spt = NULL;
                        $post->user_status_spt = NULL;
                    }
                }
                else{
                    $post->alasan_penolakan = NULL;
                    $post->status = $request->input('statusdefault');
                    $post->status_spt = NULL;
                    $post->tanggal_status_spt = NULL;
                    $post->user_status_spt = NULL;
                }
                $post->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Berhasil diubah'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'Data tidak ditemukan.'
                ]);
            }
        }
    }

    public function cekjadwalspt(Request $request) {
        $pegawaipost                = $request->pegawaiarray;
        $pegawaiarray               = explode(',', $pegawaipost);
        $tgla                       = $request->tgla;
        $tglb                       = $request->tglb;

        $sql                        =DB::table('spt_anggota as sa')
            ->select('sa.id', 'sa.id_spt', 'sa.no_spt', 'sa.kode_spt', 'sa.urutan','sa.lama',
                DB::raw('(CASE
                              WHEN mp.id_jabatan <> 99
                              THEN CONCAT( mp.nip , " ;-; " , mp.nama_pegawai )
                           ELSE
                              mp.nama_pegawai
                           END )
                AS pegawai'),
                DB::raw('(CASE
                              WHEN sa.tanggal_berangkat <> sa.tanggal_kembali
                              THEN CONCAT(DATE_FORMAT(sa.tanggal_berangkat, "%d-%m-%Y"), " s/d ", DATE_FORMAT( sa.tanggal_kembali, "%d-%m-%Y" ))
                          ELSE
                              DATE_FORMAT(sa.tanggal_berangkat, "%d-%m-%Y")
		                    END ) AS tanggal')
            )
            ->leftJoin('master_pegawai as mp', 'sa.id_pegawai', '=', 'mp.id')
            ->whereIn('sa.id_pegawai', $pegawaiarray)
            ->where(function ($query) use ($tgla, $tglb) {
                $query->whereBetween('sa.tanggal_berangkat',array($tgla, $tglb));
                $query->orwhereBetween('sa.tanggal_kembali',array($tgla, $tglb));
            })
//            ->andwhereBetween('tanggal_berangkat',array($tgla, $tglb))
//            ->orWhereBetween('tanggal_kembali',array($tgla, $tglb))
            ->orderBy('sa.id', 'ASC')
            ->orderBy('sa.no_spt','ASC')
            ->orderBy('sa.id_pegawai', 'ASC')
            ->orderBy('sa.urutan','ASC')
            ->get();


        $query                        =DB::table('spt_anggota as sa')
            ->select(DB::Raw("max(mp.nama_pegawai) AS pegawai"))
            ->leftJoin('master_pegawai as mp', 'sa.id_pegawai', '=', 'mp.id')
            ->whereIn('sa.id_pegawai', $pegawaiarray)
            ->where(function ($query) use ($tgla, $tglb) {
                $query->whereBetween('sa.tanggal_berangkat',array($tgla, $tglb));
                $query->orwhereBetween('sa.tanggal_kembali',array($tgla, $tglb));
            })
            ->groupBy('mp.nama_pegawai')
            ->get();

        if($tgla == $tglb)
            $tanggal=date('d-M-Y',strtotime($tgla));
        else
            $tanggal=date('d-M-Y',strtotime($tgla)).' s/d '.date('d-M-Y',strtotime($tglb));

        if(sizeof($sql)==0) {
            $responsenya = 'Belum Ada Jadwal SPT untuk tanggal : '."<br/>".$tanggal;
        }
        else {
            $responsenya='Anggota Tersebut sudah memiliki Jadwal SPT untuk tanggal : '."<br/>".$tanggal;
        }



        return response()->json(['sql'=>$sql,'tgla'=>$tgla,'tglb'=>$tglb,'jumlah'=>sizeof($sql),'response'=>$responsenya,'query'=>$query]);
    }

    public function SetSelectedValue(Request $request) {
        $wilayah=$request->wilayah;
        //return $wilayah;
        $kecamatan = DB::table("lokasi")->whereIn("id",$wilayah)
            ->orderByRaw('FIELD(id, '.implode(", " , $wilayah).')')
            ->pluck("nama","id");
        $cekformtujuan          = DB::table('sppd_formttd as a')
            ->select('*')
            ->where('id_spt',$request->idspt)
            ->count();
        return response()->json(['kecamatan'=>$kecamatan, 'cekformtujuan'=>$cekformtujuan]);
    }

    public function cekjadwalsptupdate(Request $request) {
        $pegawaipost                = $request->pegawaiarray;
        $pegawaiarray               = explode(',', $pegawaipost);
        $tgla                       = $request->tgla;
        $tglb                       = $request->tglb;

        $sql                        =DB::table('spt_anggota as sa')
            ->select('sa.id', 'sa.id_spt', 'sa.no_spt', 'sa.kode_spt', 'sa.urutan','sa.lama',
                DB::raw('(CASE
                              WHEN mp.id_jabatan <> 99
                              THEN CONCAT( mp.nip , " ;-; " , mp.nama_pegawai )
                           ELSE
                              mp.nama_pegawai
                           END )
                AS pegawai'),
                DB::raw('(CASE
                              WHEN sa.tanggal_berangkat <> sa.tanggal_kembali
                              THEN CONCAT(DATE_FORMAT(sa.tanggal_berangkat, "%d-%m-%Y"), " s/d ", DATE_FORMAT( sa.tanggal_kembali, "%d-%m-%Y" ))
                          ELSE
                              DATE_FORMAT(sa.tanggal_berangkat, "%d-%m-%Y")
		                    END ) AS tanggal')
            )
            ->leftJoin('master_pegawai as mp', 'sa.id_pegawai', '=', 'mp.id')
            ->whereIn('sa.id_pegawai', $pegawaiarray)
            ->where(function ($query) use ($tgla, $tglb) {
                $query->whereBetween('sa.tanggal_berangkat',array($tgla, $tglb));
                $query->orwhereBetween('sa.tanggal_kembali',array($tgla, $tglb));
            })
            ->where('sa.id_spt','<>',$request->id)

            //            ->andwhereBetween('tanggal_berangkat',array($tgla, $tglb))
//            ->orWhereBetween('tanggal_kembali',array($tgla, $tglb))
            ->orderBy('sa.id', 'ASC')
            ->orderBy('sa.no_spt','ASC')
            ->orderBy('sa.id_pegawai', 'ASC')
            ->orderBy('sa.urutan','ASC')
            ->get();


        $query                        =DB::table('spt_anggota as sa')
            ->select(DB::Raw("max(mp.nama_pegawai) AS pegawai"))
            ->leftJoin('master_pegawai as mp', 'sa.id_pegawai', '=', 'mp.id')
            ->whereIn('sa.id_pegawai', $pegawaiarray)
            ->where(function ($query) use ($tgla, $tglb) {
                $query->whereBetween('sa.tanggal_berangkat',array($tgla, $tglb));
                $query->orwhereBetween('sa.tanggal_kembali',array($tgla, $tglb));
            })
            ->where('sa.id_spt','<>',$request->id)
            ->groupBy('mp.nama_pegawai')
            ->get();

        if($tgla == $tglb)
            $tanggal=date('d-M-Y',strtotime($tgla));
        else
            $tanggal=date('d-M-Y',strtotime($tgla)).' s/d '.date('d-M-Y',strtotime($tglb));

        if(sizeof($sql)==0) {
            $responsenya = 'Belum Ada Jadwal SPT untuk tanggal : '."<br/>".$tanggal;
        }
        else {
            $responsenya='Anggota Tersebut sudah memiliki Jadwal SPT untuk tanggal : '."<br/>".$tanggal;
        }



        return response()->json(['sql'=>$sql,'tgla'=>$tgla,'tglb'=>$tglb,'jumlah'=>sizeof($sql),'response'=>$responsenya,'query'=>$query]);
    }

    public function cekjadwalsptmodalgrid(Request $request) {
        $pegawaipost                = $request->pegawaiarray;
        $pegawaiarray               = explode(',', $pegawaipost);
        $tgla                       = $request->tgla;
        $tglb                       = $request->tglb;

        $sql                        =DB::table('spt_anggota as sa')
            ->select('sa.id', 'sa.id_spt', 'sa.no_spt', 'sa.kode_spt', 'sa.urutan','sa.lama',
                DB::raw('(CASE
                              WHEN mp.id_jabatan <> 99
                              THEN CONCAT( mp.nip , " ;-; " , mp.nama_pegawai )
                           ELSE
                              mp.nama_pegawai
                           END )
                AS pegawai'),
                DB::raw('(CASE
                              WHEN sa.tanggal_berangkat <> sa.tanggal_kembali
                              THEN CONCAT(DATE_FORMAT(sa.tanggal_berangkat, "%d-%m-%Y"), " s/d ", DATE_FORMAT( sa.tanggal_kembali, "%d-%m-%Y" ))
                          ELSE
                              DATE_FORMAT(sa.tanggal_berangkat, "%d-%m-%Y")
		                    END ) AS tanggal')
            )
            ->leftJoin('master_pegawai as mp', 'sa.id_pegawai', '=', 'mp.id')
            ->whereIn('sa.id_pegawai', $pegawaiarray)
            ->where(function ($query) use ($tgla, $tglb) {
                $query->whereBetween('sa.tanggal_berangkat',array($tgla, $tglb));
                $query->orwhereBetween('sa.tanggal_kembali',array($tgla, $tglb));
            })
            ->where('sa.id_spt','<>',$request->idganda)

            //            ->andwhereBetween('tanggal_berangkat',array($tgla, $tglb))
//            ->orWhereBetween('tanggal_kembali',array($tgla, $tglb))
            ->orderBy('sa.id', 'ASC')
            ->orderBy('sa.no_spt','ASC')
            ->orderBy('sa.id_pegawai', 'ASC')
            ->orderBy('sa.urutan','ASC')
            ->get();


        $query                        =DB::table('spt_anggota as sa')
            ->select(DB::Raw("max(mp.nama_pegawai) AS pegawai"))
            ->leftJoin('master_pegawai as mp', 'sa.id_pegawai', '=', 'mp.id')
            ->whereIn('sa.id_pegawai', $pegawaiarray)
            ->where(function ($query) use ($tgla, $tglb) {
                $query->whereBetween('sa.tanggal_berangkat',array($tgla, $tglb));
                $query->orwhereBetween('sa.tanggal_kembali',array($tgla, $tglb));
            })
            ->where('sa.id_spt','<>',$request->idganda)
            ->groupBy('mp.nama_pegawai')
            ->get();

        if($tgla == $tglb)
            $tanggal=date('d-M-Y',strtotime($tgla));
        else
            $tanggal=date('d-M-Y',strtotime($tgla)).' s/d '.date('d-M-Y',strtotime($tglb));

        if(sizeof($sql)==0) {
            $responsenya = 'Belum Ada Jadwal SPT untuk tanggal : '."<br/>".$tanggal;
        }
        else {
            $responsenya='Anggota Tersebut sudah memiliki Jadwal SPT untuk tanggal : '."<br/>".$tanggal;
        }



        return response()->json(['sql'=>$sql,'tgla'=>$tgla,'tglb'=>$tglb,'jumlah'=>sizeof($sql),'response'=>$responsenya,'query'=>$query]);
    }



    public function dasarSptGet($id) {
        $sql                        = DB::table('spt_dasar')
                                    ->where('id_spt',$id)
                                    ->orderBy('nomor_urut', 'ASC')
                                    ->get();

        return response()->json(['sql'=>$sql]);
    }
}
