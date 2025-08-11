<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\EvaluasiKuesioner;
use App\models\HasilKuesioner;
use App\models\Sekolah;
use App\models\User;
use App\models\IconGrid;
use App\models\Parameter;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kabupatenkota;
use App\Models\Cabdis;
use Carbon\Carbon;

class SekolahBersihController extends Controller
{
    //

    public function index()
    {
        $model=EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/index', [
            'model'    => $model
        ]);
    }

    public function indexsekolah()
    {
        $model=EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/indexsekolah', [
            'model'    => $model
        ]);
    }

    public function indexpengawas()
    {
        $model=EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/indexpengawas', [
            'model'    => $model
        ]);
    }

    public function indexdinas()
    {
        $model=EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/indexdinas', [
            'model'    => $model
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData(){
        $model=EvaluasiKuesioner::orderBy('id', 'ASC')->get();
        return Datatables::of($model)
            ->editColumn('periode_awal_kuesioner',function ($data){
                if($data->periode_awal_kuesioner <> null && $data->periode_akhir_kuesioner) {
                    $periode=date('d-M-Y', strtotime($data->periode_awal_kuesioner)).' s/d '.date('d-M-Y', strtotime($data->periode_akhir_kuesioner));
                }
                else {
                    $periode=date('d-M-Y', strtotime($data->periode_awal_kuesioner));
                }
                return $periode;
            })
            ->editColumn('id_ruang',function ($data){
                return !$data->ruanglist || !$data->id_ruang ?  ' - ' : $data->ruanglist["nama"]  ;
            })
            ->editColumn('id_ruang',function ($data){
                return !$data->ruanglist || !$data->id_ruang ?  ' - ' : $data->ruanglist["nama"]  ;
            })
            ->editColumn('id_kuesioner', function ($data) {
                $stringIds = $data->id_kuesioner;  // contoh: "{319,320,321}"
                $arrayIds = explode(',', trim($stringIds, '{}'));

                $hasilKuesioner = DB::table('hasil_kuesioner')
                    ->select('p.parameter', 'hasil_kuesioner.jawaban')
                    ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
                    ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
                    ->whereIn('hasil_kuesioner.id', $arrayIds)
                    ->get();

                $html = '<div style="font-size: 13px;">';
                $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
             <div style="flex: 1;">Parameter</div>
             <div style="width: 80px; text-align:center;">Status</div>
             </div>';

                foreach ($hasilKuesioner as $row) {
                    // Status label
                    if ($row->jawaban == 3) {
                        $status = '<span style="color:green;">Bersih</span>';
                    } elseif ($row->jawaban == 2) {
                        $status = '<span style="color:orange;">Cukup Bersih</span>';
                    } else {
                        $status = '<span style="color:red;">Tidak Bersih</span>';
                    }

                $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
                 <div style="flex: 1;">' . $row->parameter . '</div>
                 <div style="width: 80px; text-align:center;">' . $status . '</div>
              </div>';
                }
                return $html;
            })
            ->addColumn('action', function ($model){
                if($model->status_verifikasi_sekolah ==1) {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.print", $model->id) . "' id='printbtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-file-pdf-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->nama . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                }
                else {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.verifikasi", $model->id) . "' id='verifikasibtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-check-square fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->nama . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                }

                $button = $button . "</div>";
                return $button;
            })
            ->editColumn('status_verifikasi_sekolah',function ($data){
                if($data->status_verifikasi_sekolah == 1 ){
                    $statusverifikasisekolah='<span class="badge badge-success">Terverifikasi</span>';
                }
                else {
                    $statusverifikasisekolah='<span class="badge badge-warning">Belum Verifikasi</span>';
                }
                $html='<div class="btn-group-horizontal">'.$statusverifikasisekolah.'</div>';
                return $html;

            })
        ->rawColumns(['id_kuesioner','action','status_verifikasi_sekolah'])
        ->make(true);
    }


    public function getDataSekolah(){
        $model=EvaluasiKuesioner::orderBy('id', 'ASC')->get();
        return Datatables::of($model)
            ->editColumn('periode_awal_kuesioner',function ($data){
                if($data->periode_awal_kuesioner <> null && $data->periode_akhir_kuesioner) {
                    $periode=date('d-M-Y', strtotime($data->periode_awal_kuesioner)).' s/d '.date('d-M-Y', strtotime($data->periode_akhir_kuesioner));
                }
                else {
                    $periode=date('d-M-Y', strtotime($data->periode_awal_kuesioner));
                }
                return $periode;
            })

            ->editColumn('id_ruang',function ($data){
                return !$data->ruanglist || !$data->id_ruang ?  ' - ' : $data->ruanglist["nama"]  ;
            })
            ->editColumn('id_kuesioner', function ($data) {
                $stringIds = $data->id_kuesioner;  // contoh: "{319,320,321}"
                $arrayIds = explode(',', trim($stringIds, '{}'));

                $hasilKuesioner = DB::table('hasil_kuesioner')
                    ->select('p.parameter', 'hasil_kuesioner.jawaban')
                    ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
                    ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
                    ->whereIn('hasil_kuesioner.id', $arrayIds)
                    ->get();

                $html = '<div style="font-size: 10px; line-height: 12px">';
                $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
             <div style="flex: 1;">Parameter</div>
             <div style="width: 80px; text-align:center;">Status</div>
             </div>';

                foreach ($hasilKuesioner as $row) {
                    // Status label
                    if ($row->jawaban == 3) {
                        $status = '<span style="color:green;">Bersih</span>';
                    } elseif ($row->jawaban == 2) {
                        $status = '<span style="color:orange;">Cukup Bersih</span>';
                    } else {
                        $status = '<span style="color:red;">Tidak Bersih</span>';
                    }

                    $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
                 <div style="flex: 1;">' . $row->parameter . '</div>
                 <div style="width: 80px; text-align:center;">' . $status . '</div>
              </div>';
                }
                return $html;
            })
            ->addColumn('action', function ($model){
                if($model->status_verifikasi_sekolah ==1) {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.print", $model->id) . "' id='printbtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-file-pdf-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->nama . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                }
                else {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.verifikasi", $model->id) . "' id='verifikasibtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-check-square fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->nama . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                }

                $button = $button . "</div>";
                return $button;
            })
            ->editColumn('status_verifikasi_sekolah',function ($data){
                if($data->status_verifikasi_sekolah == 1 ){
                    $statusverifikasisekolah='<span class="badge badge-success">Terverifikasi</span>';
                }
                else {
                    $statusverifikasisekolah='<span class="badge badge-warning">Belum Verifikasi</span>';
                }
                $html='<div class="btn-group-horizontal">'.$statusverifikasisekolah.'</div>';
                return $html;

            })
            ->rawColumns(['id_kuesioner','action','status_verifikasi_sekolah'])
            ->make(true);
    }

    public function getDataPengawas(){
        $model = DB::select("
                    SELECT *
                    FROM (
                        SELECT *,
                            ROW_NUMBER() OVER (
                                PARTITION BY sekolah, periode_awal_kuesioner, periode_akhir_kuesioner
                                ORDER BY time_created DESC
                            ) AS rn
                        FROM evaluasi_kuesioner
                    ) t
                    WHERE rn = 1
        ");
        return Datatables::of($model)
            ->editColumn('periode_awal_kuesioner',function ($data){
                if($data->periode_awal_kuesioner <> null && $data->periode_akhir_kuesioner) {
                    $periode=date('d-M-Y', strtotime($data->periode_awal_kuesioner)).' s/d '.date('d-M-Y', strtotime($data->periode_akhir_kuesioner));
                }
                else {
                    $periode=date('d-M-Y', strtotime($data->periode_awal_kuesioner));
                }
                return $periode;
            })
            ->editColumn('sekolah',function ($data){
                $a= Sekolah::find($data->sekolah);
                return !$a || !$data->sekolah ?  ' - ' : $a["nama"]  ;

            })
            ->editColumn('tanggal_supervisi',function ($data){
                return !$data->tanggal_supervisi ?  ' - ' : Date('d-M-Y', strtotime($data->tanggal_supervisi));
            })
            ->editColumn('catatan_pengawas', function ($data) {
                $existing = DB::table('evaluasi_pengawas')
                    ->where('sekolah', $data->sekolah)
                    ->where('periode_awal_kuesioner', $data->periode_awal_kuesioner)
                    ->where('periode_akhir_kuesioner', $data->periode_akhir_kuesioner)
                    ->first();
            
                // Mapping tindak lanjut
                $jenisTindakLanjut = [
                    '1' => 'Pembinaan',
                    '2' => 'Penguatan',
                    '3' => 'Penghargaan',
                    '4' => 'Monitoring Lanjutan',
                ];
            
                if ($existing) {
                    $statusKepatuhan = 'Status Kepatuhan = ' . $existing->status_kepatuhan;
                    $statusKebersihan = 'Status Kebersihan = ' . $existing->status_kebersihan;
                    $tindakLanjut = 'Tindak Lanjut = ' . ($jenisTindakLanjut[$existing->hasil_rekomendasi] ?? 'Tidak diketahui');
            
                    $hasil = $statusKepatuhan . '<br>' . $statusKebersihan . '<br>' . $tindakLanjut;
                } else {
                    $hasil = '-';
                }
            
                return $hasil;
            })
                        // ->editColumn('id_ruang',function ($data){
            //     $a= IconGrid::find($data->id_ruang);
            //     return !$a || !$data->id_ruang ?  ' - ' : $a["nama"]  ;
            // })

             ->editColumn('id_ruang', function ($data) {
                 $sekolahId= $data->sekolah;
                 $periodeAwal= $data->periode_awal_kuesioner;
                 $periodeAkhir= $data->periode_akhir_kuesioner;

            $hasilKuesioner = DB::table('ruang_sekolah as rs')
                ->leftJoin('evaluasi_kuesioner as ek', function($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
                    $join->on('ek.id_ruang', '=', 'rs.id')
                        ->where('ek.sekolah', '=', $sekolahId)
                        ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
                        ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
                })
    ->select(
        'rs.nama',
        DB::raw('COALESCE(SUM(ek.score), 0) as score'),
        DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter')

    )
    ->groupBy('rs.id', 'rs.nama')
    ->orderBy('rs.id')
    ->get();

    $html = '<div style="font-size: 10px; line-height: 12px">';
    $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
         <div style="flex: 1;">Parameter</div>
         <div style="width: 80px; text-align:center;">Score</div>
         <div style="width: 80px; text-align:center;">Penilaian</div>

         </div>';

    foreach ($hasilKuesioner as $row) {
        $hasil=$row->score/$row->jumlah_parameter;
        $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
             <div style="flex: 1;">' . $row->nama .' ('. $row->jumlah_parameter.')'. '</div>
             <div style="width: 80px; text-align:center;">' . $row->score . '</div>
            <div style="width: 80px; text-align:center;">' . $hasil . '</div>

          </div>';
    }

    $html .= '</div>';
    return $html;
})


            ->addColumn('action', function ($model){
                if($model->status_evaluasi_pengawas ==1) {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.verifikasiPengawas", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.printPengawas", $model->id) . "' id='printbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-file-pdf-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                }
                else {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.verifikasiPengawas", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                }

                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['catatan_pengawas','id_ruang','action'])
            ->make(true);
    }

    public function getDataDinas(){
        $model = DB::select("
                    SELECT *
                    FROM (
                        SELECT *,
                            ROW_NUMBER() OVER (
                                PARTITION BY sekolah, periode_awal_kuesioner, periode_akhir_kuesioner
                                ORDER BY time_created DESC
                            ) AS rn
                        FROM evaluasi_kuesioner
                    ) t
                    WHERE rn = 1
        ");
        return Datatables::of($model)
            ->editColumn('periode_awal_kuesioner',function ($data){
                if($data->periode_awal_kuesioner <> null && $data->periode_akhir_kuesioner) {
                    $periode=date('d-M-Y', strtotime($data->periode_awal_kuesioner)).' s/d '.date('d-M-Y', strtotime($data->periode_akhir_kuesioner));
                }
                else {
                    $periode=date('d-M-Y', strtotime($data->periode_awal_kuesioner));
                }
                return $periode;
            })
            ->editColumn('sekolah',function ($data){
                $a= Sekolah::find($data->sekolah);
                return !$a || !$data->sekolah ?  ' - ' : $a["nama"]  ;

            })
            // ->editColumn('id_ruang',function ($data){
            //     $a= IconGrid::find($data->id_ruang);
            //     return !$a || !$data->id_ruang ?  ' - ' : $a["nama"]  ;
            // })

             ->editColumn('id_ruang', function ($data) {
                 $sekolahId= $data->sekolah;
                 $periodeAwal= $data->periode_awal_kuesioner;
                 $periodeAkhir= $data->periode_akhir_kuesioner;

$hasilKuesioner = DB::table('ruang_sekolah as rs')
    ->leftJoin('evaluasi_kuesioner as ek', function($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
        $join->on('ek.id_ruang', '=', 'rs.id')
            ->where('ek.sekolah', '=', $sekolahId)
            ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
            ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
    })
    ->select(
        'rs.nama',
        DB::raw('COALESCE(SUM(ek.score), 0) as score'),
        DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter')

    )
    ->groupBy('rs.id', 'rs.nama')
    ->orderBy('rs.id')
    ->get();

    $html = '<div style="font-size: 10px; line-height: 12px">';
    $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
         <div style="flex: 1;">Parameter</div>
         <div style="width: 80px; text-align:center;">Status</div>
         </div>';

    foreach ($hasilKuesioner as $row) {
        $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
             <div style="flex: 1;">' . $row->nama . '</div>
             <div style="width: 80px; text-align:center;">' . $row->score . '</div>
            <div style="width: 80px; text-align:center;">' . $row->jumlah_parameter . '</div>

          </div>';
    }

    $html .= '</div>';
    return $html;
})
            ->addColumn('action', function ($model){
                if($model->status_verifikasi_sekolah ==1) {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.print", $model->id) . "' id='printbtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-file-pdf-o fa-stack-1x fa-inverse'></i></span>
                    </a>

                ";
                }
                else {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.verifikasi", $model->id) . "' id='verifikasibtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-check-square fa-stack-1x fa-inverse'></i></span>
                    </a>

                ";
                }

                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['id_ruang','action'])
            ->make(true);
    }

//    public function create($singkatan)
//    {
//        $icon = IconGrid::where('singkatan', $singkatan)->firstOrFail();
//        return view('sekolahbersih.create', [
//            'icon' => $icon,
//        ]);
//    }

//    public function create()
//    {
//        // Cari icon berdasarkan singkatan
//        $icon = IconGrid::all();
//        // Kirim data icon ke view (sekolahbersih/create.blade.php)
//        return view('sekolahbersih.create', [
//            'icon' => $icon
//        ]);
//    }


    public function create($id)
    {
        $model=IconGrid::find($id);
        $parameter=Parameter::where('id_ruang',$id)->get();
        //dd($parameter);
        return view('sekolahbersih.create',compact('model','parameter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_ruang' => 'required|integer',
            'periode' => 'required|string',
            'jawaban' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        if (!Auth::check()) {
            $user = 3;
            $id_sekolah = 103;
            $id_user = 3;
        } else {
            $user = Auth::user();
            $id_sekolah = $user->id_sekolah;
            $id_user = $user->id;
        }

        if (!$id_sekolah) {
            return redirect()->back()->withInput()->withErrors(['User tidak memiliki id_sekolah.']);
        }

        // Pisahkan periode menjadi awal dan akhir
        $periode_parts = explode(' - ', $request->periode);
        $periode_awal = $periode_parts[0] ?? now()->format('Y-m-d');
        $periode_akhir = $periode_parts[1] ?? now()->format('Y-m-d');

        // ✅ Cek apakah kombinasi sudah pernah diinput sebelumnya
        $existing = EvaluasiKuesioner::where('id_ruang', $request->id_ruang)
            ->where('sekolah', $id_sekolah)
            ->whereDate('periode_awal_kuesioner', $periode_awal)
            ->whereDate('periode_akhir_kuesioner', $periode_akhir)
            ->exists();

        if ($existing) {
            return redirect()->back()->withInput()->withErrors([
                'Data untuk ruang dan periode tersebut sudah pernah diinput, silahkan coba periode dan komponen ruang yang lain'
            ]);
        }

        DB::beginTransaction();
        try {
            $totalScore = 0;
            $hasilKuesionerIds = [];

            foreach ($request->jawaban as $id_parameter => $jawaban) {
                $hasil = HasilKuesioner::create([
                    'id_sekolah'        => $id_sekolah,
                    'id_user'           => $id_user,
                    'id_parameter'      => $id_parameter,
                    'id_ruang'          => $request->id_ruang,
                    'jawaban'           => $jawaban,
                    'deskripsi_jawaban' => $request->alasan[$id_parameter] ?? null,
                    'tahun_ajaran'      => env('TAHUN_AJARAN'),
                    'periode'           => 1,
                    'periode_awal_kuesioner'     => $periode_awal,
                    'periode_akhir_kuesioner'    => $periode_akhir,
                ]);
                $hasilKuesionerIds[] = $hasil->id;
                $totalScore += $jawaban;
            }

            EvaluasiKuesioner::create([
                'id_kuesioner'               => '{' . implode(',', $hasilKuesionerIds) . '}',
                'sekolah'                    => $id_sekolah,
                'periode_awal_kuesioner'     => $periode_awal,
                'periode_akhir_kuesioner'    => $periode_akhir,
                'status_verifikasi_sekolah'  => 0,
                'status_evaluasi_pengawas'   => 0,
                'status_evaluasi_cabdis'     => 0,
                'id_ruang'                   => $request->id_ruang,
                'score'                      => $totalScore,
                'hasil_score'                => $totalScore / count($request->jawaban),
            ]);

            DB::commit();

            return redirect()->route('sekolahbersih.index')
                ->with('berhasil', 'Kuesioner berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->withInput()->withErrors([
                'Gagal menyimpan kuesioner: ' . $e->getMessage()
            ]);
        }
    }


    // public function storeverifikasi(Request $request)
    // {
    //     $messages = [
    //         'required'                  => 'Kolom :attribute Wajib diisi',
    //     ];
    //     $validator = Validator::make($request->all(), [
    //         'jabatan_verifikasi'                =>'required',
    //         'user_verifikasi'                   =>'required',
    //     ],$messages);

    //     if($validator->fails())
    //     {
    //         return redirect()->back()->withInput()->withErrors($validator->errors());
    //     }
    //     else {
    //         $post                           = EvaluasiKuesioner::where('id', $request->id)->first();
    //         $post->jabatan_verifikasi       = $request->jabatan_verifikasi;
    //         $post->user_verifikasi          = $request->user_verifikasi;
    //         $post->tanggal_verifikasi       = date('Y-m-d');
    //         $post->status_verifikasi_sekolah= 1;
    //         $simpan = $post->save();
    //         if ($simpan) {
    //             Session::flash('berhasil', 'Verifikasi Berhasil');
    //             return redirect()->route('sekolahbersih.index');
    //         } else
    //             return back()->withErrors(['Gagal' => ['Verifikasi Gagal']]);
    //     }

    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model=EvaluasiKuesioner::findOrFail($id);
        $ruang=IconGrid::find($model->id_ruang);
        $sekolah=Sekolah::find($model->sekolah);
        $stringIds = $model->id_kuesioner;  // contoh: "{319,320,321}"
        $arrayIds = explode(',', trim($stringIds, '{}'));

        $hasilKuesioner = DB::table('hasil_kuesioner')
            ->select('p.parameter', 'hasil_kuesioner.jawaban','hasil_kuesioner.deskripsi_jawaban')
            ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
            ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
            ->whereIn('hasil_kuesioner.id', $arrayIds)
            ->get();
        return view('sekolahbersih.detail',compact('model','ruang','hasilKuesioner','sekolah'));
    }

    public function verifikasi($id)
    {
        $model=EvaluasiKuesioner::findOrFail($id);
        $ruang=IconGrid::find($model->id_ruang);
        $sekolah=Sekolah::find($model->sekolah);
        $stringIds = $model->id_kuesioner;  // contoh: "{319,320,321}"
        $arrayIds = explode(',', trim($stringIds, '{}'));

        $hasilKuesioner = DB::table('hasil_kuesioner')
            ->select('p.parameter', 'hasil_kuesioner.jawaban','hasil_kuesioner.deskripsi_jawaban')
            ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
            ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
            ->whereIn('hasil_kuesioner.id', $arrayIds)
            ->get();
        return view('sekolahbersih.verifikasi',compact('model','ruang','hasilKuesioner','sekolah'));
    }

    public function verifikasiPengawas($id)
    {
        $model=EvaluasiKuesioner::findOrFail($id);
        $sekolah=Sekolah::find($model->sekolah);
        $kabupaten=Kabupatenkota::where('kode_kabupaten',$sekolah->kabupaten_kota)->first();
        if (Auth::check()) {
            $user = Auth::user();
            $cabdis = Cabdis::find($user->cabdis);
            if ($cabdis) {
                $wilayah = DB::select("
                    SELECT
                        cab.id,
                        cab.nama,
                        cab.kabupatenkota,
                        string_agg(kab.nama_kabupaten, ', ' ORDER BY kab.nama_kabupaten) AS nama_kabupaten
                    FROM
                        cabdis cab
                    JOIN
                        LATERAL unnest(string_to_array(cab.kabupatenkota, ', ')) AS kab_id ON TRUE
                    JOIN
                        kabupaten kab ON kab.kode_kabupaten::text = kab_id
                    WHERE
                        cab.id = ?
                    GROUP BY
                        cab.id, cab.nama, cab.kabupatenkota
                ", [$user->cabdis]);

            } else {
                $wilayah = [];
            }

        } else {
            $user = null;
            $cabdis = null;
            $wilayah = [];
        }

        $sekolahId= $model->sekolah;
        $periodeAwal= $model->periode_awal_kuesioner;
        $periodeAkhir= $model->periode_akhir_kuesioner;
        $hasilKuesioner = DB::table('ruang_sekolah as rs')
            ->leftJoin('evaluasi_kuesioner as ek', function($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
                $join->on('ek.id_ruang', '=', 'rs.id')
                    ->where('ek.sekolah', '=', $sekolahId)
                    ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
                    ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
            })
            ->select(
                DB::raw('COALESCE(max(ek.id), 0) as idnya'),
                'rs.nama',
                DB::raw('COALESCE(SUM(ek.score), 0) as score'),
                DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter')

            )
            ->groupBy('rs.id', 'rs.nama')
            ->orderBy('rs.id')
            ->get();
        return view('sekolahbersih.verifikasipengawas',compact('model','sekolah','kabupaten','sekolahId','periodeAwal','periodeAkhir','hasilKuesioner','user','cabdis','wilayah'));
    }

    public function print($id)
    {
        $model=EvaluasiKuesioner::findOrFail($id);
        $ruang=IconGrid::findOrFail($model->id_ruang);
        $sekolah=Sekolah::find($model->sekolah);
        $stringIds = $model->id_kuesioner;  // contoh: "{319,320,321}"
        $arrayIds = explode(',', trim($stringIds, '{}'));

        $hasilKuesioner = DB::table('hasil_kuesioner')
            ->select('p.parameter', 'hasil_kuesioner.jawaban','hasil_kuesioner.deskripsi_jawaban')
            ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
            ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
            ->whereIn('hasil_kuesioner.id', $arrayIds)
            ->get();

        $pdf= PDF::loadView('sekolahbersih.cetak',compact('model','ruang','hasilKuesioner','sekolah'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function printPengawas($id)
    {
        $model=EvaluasiKuesioner::findOrFail($id);
        $ruang=IconGrid::find($model->id_ruang);
        $sekolah=Sekolah::find($model->sekolah);
        $kabupaten=Kabupatenkota::where('kode_kabupaten',$sekolah->kabupaten_kota)->first();
        $stringIds = $model->id_kuesioner;  // contoh: "{319,320,321}"
        $arrayIds = explode(',', trim($stringIds, '{}'));
        
        $sekolahId= $model->sekolah;
        $periodeAwal= $model->periode_awal_kuesioner;
        $periodeAkhir= $model->periode_akhir_kuesioner;
        $hasilKuesioner = DB::table('ruang_sekolah as rs')
            ->leftJoin('evaluasi_kuesioner as ek', function($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
                $join->on('ek.id_ruang', '=', 'rs.id')
                    ->where('ek.sekolah', '=', $sekolahId)
                    ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
                    ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
            })
            ->select(
                DB::raw('COALESCE(max(ek.id), 0) as idnya'),
                'rs.nama',
                DB::raw('COALESCE(SUM(ek.kesimpulan_pengawas), 0) as kesimpulan_pengawas'),
                DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter'),
                DB::raw('MAX(ek.catatan_pengawas) as catatan_pengawas'),
                DB::raw('COALESCE(MAX(CASE WHEN ek.dokumentasi_pengawas THEN 1 ELSE 0 END), 0) as dokumentasi_pengawas'),
                DB::raw('MAX(ek.catatan_dokumentasi_pengawas) as catatan_dokumentasi_pengawas')
            )
            ->groupBy('rs.id', 'rs.nama')
            ->orderBy('rs.id')
            ->get();
            
        $evaluasipengawas = DB::table('evaluasi_pengawas')
                ->where('sekolah', $sekolahId)
                ->where('periode_awal_kuesioner', $periodeAwal)
                ->where('periode_akhir_kuesioner', $periodeAkhir)
                ->first();

        $pdf= PDF::loadView('sekolahbersih.cetakpengawas',compact('model','ruang','hasilKuesioner','sekolah','kabupaten','evaluasipengawas'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model                  = ManajemenBiaya::find($id);
        $golongan               = RefGolongan::all();
        $jenisbiaya             = RefJenisBiaya::all();
        $statusbiaya            = RefStatusWilayahBiaya::all();

        return view('manajemenbiaya.edit', compact(
            'model',
            'golongan',
            'jenisbiaya',
            'statusbiaya'
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
        ];
        $validator = Validator::make($request->all(), [
            'jabatan'                   =>'required',
            'jenis_biaya'               =>'required',
            //'deskripsi'                 =>'required',
            'status_wilayah_biaya'      =>'required',
            'nominal'                   =>'required'
        ],$messages);

        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        else {
            $post                           = ManajemenBiaya::where('id', $request->id)->first();
            $post->jabatan                  = $request->jabatan;
            $post->jenis_biaya              = $request->jenis_biaya;
            $post->deskripsi                = $request->deskripsi;
            $post->status_wilayah_biaya     = $request->status_wilayah_biaya;
            $badChars                       = array(".");
            $nominal                        = str_ireplace($badChars, "", $request->nominal);
            $post->nominal                  = $nominal;
            $post->user_created = NULL;
            $simpan = $post->save();
            if ($simpan) {
                Session::flash('berhasil', 'Data Manajemen Biaya Berhasil di tambah');
                return redirect()->route('biaya.index');
            } else
                return back()->withErrors(['Gagal' => ['Data Manajemen Biaya Gagal di tambah']]);
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
        $check=EvaluasiKuesioner::firstWhere('id',$id);
        if($check) {
            EvaluasiKuesioner::destroy($id);
            return response([
                'status' => 'OK',
                'message' => 'Data Deleted',
            ], 200);
        }
        else{
            return response([
                'status' => 'Gagal',
                'message' => 'Data Not Found',
            ], 404);
        }
    }

    public function storeVerifikasi(Request $request)
    {
        $request->validate([
            'sekolah' => 'required|integer',
            'periode_awal_kuesioner' => 'required|date',
            'periode_akhir_kuesioner' => 'required|date',
            'tanggal' => 'required|date',
            'optionsRadios' => 'required|in:1,2,3,4',
            'optionsKebersihan' => 'required|in:1,2,3,4',
        ]);

        $sekolah = $request->sekolah;
        $periode_awal = $request->periode_awal_kuesioner;
        $periode_akhir = $request->periode_akhir_kuesioner;
        $tgl_supervisi = date('Y-m-d', strtotime($request->tanggal));
        $id_evaluasi = $request->id_evaluasi ?? null;
        $user = Auth::check() ? Auth::user()->username : 'system';

        $totalScore = $request->total_score ?? null;
        $totalRataRata = $request->total_ratarata ?? null;
        $totalAkhir = $request->total_akhir ?? null;
        $nilai_kepatuhan = $request->optionsRadios; // dari radio
        $nilai_kebersihan = $request->optionsKebersihan; // dari radio
        $status_kepatuhan = $request->status_kepatuhan;
        $status_kebersihan = $request->status_kebersihan;
        $hasil = $request->jenis_tindak_lanjut ?? null;

        $now = Carbon::now();

        DB::beginTransaction();

        try {
            // Cek apakah sudah ada data di evaluasi_pengawas
            $existing = DB::table('evaluasi_pengawas')
                ->where('sekolah', $sekolah)
                ->where('periode_awal_kuesioner', $periode_awal)
                ->where('periode_akhir_kuesioner', $periode_akhir)
                ->first();

            if ($existing) {
                DB::table('evaluasi_pengawas')->where('id', $existing->id)->update([
                    'tgl_supervisi' => $tgl_supervisi,
                    'id_evaluasi' => $id_evaluasi,
                    'total_score' => $totalScore,
                    'total_ratarata' => $totalRataRata,
                    'total_akhir' => $totalAkhir,
                    'nilai_kepatuhan' => $nilai_kepatuhan,
                    'status_kepatuhan' => $status_kepatuhan,
                    'nilai_kebersihan' => $nilai_kebersihan,
                    'status_kebersihan' => $status_kebersihan,
                    'hasil_rekomendasi' => $hasil,
                    'time_update' => $now,
                    'user_updated' => $user,
                ]);
                $evaluasiPengawasId = $existing->id;
            } else {
                $evaluasiPengawasId = DB::table('evaluasi_pengawas')->insertGetId([
                    'sekolah' => $sekolah,
                    'periode_awal_kuesioner' => $periode_awal,
                    'periode_akhir_kuesioner' => $periode_akhir,
                    'tgl_supervisi' => $tgl_supervisi,
                    'id_evaluasi' => $id_evaluasi,
                    'total_score' => $totalScore,
                    'total_ratarata' => $totalRataRata,
                    'total_akhir' => $totalAkhir,
                    'nilai_kepatuhan' => $nilai_kepatuhan,
                    'status_kepatuhan' => $status_kepatuhan,
                    'nilai_kebersihan' => $nilai_kebersihan,
                    'status_kebersihan' => $status_kebersihan,
                    'hasil_rekomendasi' => $hasil,
                    'time_created' => $now,
                    'user_created' => $user,
                    'time_update' => $now,
                    'user_updated' => $user,
                ]);
            }

            // Ambil semua id dari input dinamis
            $idInputs = $request->input('id', []);

            foreach ($idInputs as $index => $idKuesioner) {
                if (!$idKuesioner || $idKuesioner == 0) {
                    continue;
                }

                $scorePengawas = $request->input("persenkepatuhan.$index");
                $catatanPengawas = $request->input("txtcatatan.$index");
                $catatanpemeriksaanPengawas = $request->input("txtpemeriksaan.$index");
                $dokumentasi = $request->input("dokumentasi.$index") == '1';
                $tingkatKepatuhan = $request->input("kepatuhan.$index");
                $kesimpulanPengawas = $request->input("nilai.$index");
                $tgl_supervisi = date('Y-m-d', strtotime($request->tanggal));
                $user = Auth::check() ? Auth::user()->username : 'system';

                $affected = DB::table('evaluasi_kuesioner')
                    ->where('id', $idKuesioner)
                    ->update([
                        'score_pengawas' => $scorePengawas,
                        'tanggal_supervisi' =>$tgl_supervisi,
                        'status_evaluasi_pengawas' => 1,
                        'catatan_pengawas' => $catatanPengawas,
                        'dokumentasi_pengawas' => $dokumentasi,
                        'catatan_dokumentasi_pengawas' => $catatanpemeriksaanPengawas,
                        'tingkat_kepatuhan' => $tingkatKepatuhan,
                        'kesimpulan_pengawas' => $kesimpulanPengawas,
                        'time_update' => $now,
                        'user_updated' => $user,
                        'user_approval_pengawas'=>$user,
                    ]);

                if ($affected === 0) {
                    throw new \Exception("Gagal update evaluasi_kuesioner dengan ID: $idKuesioner. Mungkin ID tidak ditemukan.");
                }
            }

            DB::commit();

            return redirect()
                ->route('sekolahbersih.indexpengawas')
                ->with('success', 'Verifikasi berhasil disimpan.')
                ->with('evaluasi_id', $evaluasiPengawasId);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->route('sekolahbersih.indexpengawas')
                ->with('error', 'Gagal menyimpan verifikasi. Data dibatalkan.')
                ->with('exception', $e->getMessage());
        }
    }
}
