<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Pegawai;
use App\models\RefAgama;
use App\models\RefStatusPegawai;
use App\models\RefPangkat;
use App\models\RefGolongan;
use App\models\RefStatusJabatan;
use App\models\RefJabatan;
use App\models\UnitKerja;
use App\models\RefEselon;
use App\models\RefPendidikanTerakhir;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Auth;
Use Carbon\Carbon;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=Pegawai::all()->sortBy("id");
        return view('pegawai/index', [
            'model'    => $model
        ]);
    }

    public function getData(){
        $model=Pegawai::orderBy('id', 'ASC')->get();
        return Datatables::of($model)
            ->editColumn('golongan',function ($data){
                return !$data->golonganlist || !$data->golongan ?  ' - ' : $data->golonganlist["kode"].' - '.$data->golonganlist["nama"] ;
            })
            ->editColumn('id_jabatan',function ($data){
                return !$data->jabatanlist || !$data->id_jabatan ?  ' - ' : $data->jabatanlist["nama"] ;
            })
            ->editColumn('status_pegawai',function ($data){
                return !$data->statuspegawailist || !$data->status_pegawai ?  ' - ' : $data->statuspegawailist["nama"] ;
            })

            ->addColumn('action', function ($model){
                $button = "
                    <div class='btn-group-horizontal'>
                    <a href='" . route("pegawai.edit", $model->id) . "'  id='edit'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-pencil fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->nama_pegawai . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";

                $button = $button . "</div>";
                return $button;
            })
            ->escapeColumns('status')
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agama                  = RefAgama::all();
        $statuspegawai          = RefStatusPegawai::all();
        $pangkat                = RefPangkat::all();
        $golongan               = RefGolongan::all();
        $statusjabatan          = RefStatusJabatan::all();
        $jabatan                = RefJabatan::all();
        $unitkerja              = UnitKerja::all();
        $eselon                 = RefEselon::all();
        $pendidikan             = RefPendidikanTerakhir::all();

        return view('pegawai.create', compact(
            'agama',
            'statuspegawai',
            'pangkat',
            'golongan',
            'statusjabatan',
            'jabatan',
            'unitkerja',
            'eselon',
            'pendidikan'

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
            'required'                  => 'Kolom :attribute Wajib diisi',
            'nip.unique'                => 'NIP Tersebut Sudah digunakan sebelumnya',

        ];
        $validator = Validator::make($request->all(), [
            'nip'                       =>'required|unique:master_pegawai',
            'nama_pegawai'              =>'required',
            'jenis_kelamin'             =>'required',
            'tempat_lahir'              =>'required',
            'tanggal_lahir'             =>'required',
            'alamat'                    =>'required',
            'no_telp_wa'                =>'required',
            'pangkat'                   =>'required',
            'golongan'                  =>'required',
            'id_eselon'                 =>'required',
            'id_jabatan'                =>'required',
            'status_pegawai'            =>'required',
            'foto'                      => 'mimes:jpeg,jpg,bmp,png,gif,svg|max:20000',
        ],$messages);

        if($validator->fails())
        {
//            return response()->json([
//                'status'=>400,
//                'errors'=>$validator->errors()->all()
//            ]);
            return redirect()->back()->withInput()->withErrors($validator->errors());

        }
        else {


            $post = new Pegawai();
            $post->nip = $request->nip;
            $post->no_kartu_pegawai = $request->no_kartu_pegawai;
            $post->nama_pegawai = $request->nama_pegawai;
            $post->tempat_lahir = $request->tempat_lahir;
            $post->tanggal_lahir = date('Y-m-d', strtotime($request->tanggal_lahir));
            $post->jenis_kelamin = $request->jenis_kelamin;
            $post->agama = $request->agama;
            $post->status_pegawai = $request->status_pegawai;
            $post->alamat = $request->alamat;
            $post->no_telp_wa = $request->no_telp_wa;
            $post->no_npwp = $request->no_npwp;
            $post->pangkat = $request->pangkat;
            $post->golongan = $request->golongan;
            //nomor_sk_pangkat
            //tanggal_sk_pangkat
            //tanggal_mulai_pangkat
            //tanggal_selesai_pangkat
            //id_status_jabatan
            $post->id_jabatan = $request->id_jabatan;
            $post->id_unit_kerja = 1;
            //id_satuan_kerja
            //lokasi_kerja
            //nomor_sk_jabatan
            $post->id_eselon = $request->id_eselon;

            $post->pendidikan_terakhir = $request->pendidikan_terakhir;
            $post->user_created = NULL;
            //$post->foto                                 = $request->foto;
            $filefoto = $request->file('foto');

            if ($filefoto <> NULL) {
                $nama_foto = 'fotopegawai-' . $request->nip . ' - ' . $request->nama_pegawai . '.' . $filefoto->getClientOriginalExtension();
                $post->foto = $nama_foto;
            } else {
                $nama_foto = NULL;
                $post->foto = NULL;
            }

            $simpan = $post->save();
            if ($simpan) {
                if ($filefoto <> NULL)
                    $filefoto->move(public_path('fotopegawai/upload/'), $post->foto);

                Session::flash('berhasil', 'Data Pegawai Berhasil di tambah');
                return redirect()->route('pegawai.index');
            } else
                return back()->withErrors(['Gagal' => ['Data Pegawai Gagal di tambah']]);
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
        $model              = Pegawai::findOrFail($id);
        $unitkerja          = UnitKerja::findOrFail(1);
        $agama              = $model->agama && $model->agamalist ? $model->agamalist["nama"] : ' - ' ;
        $statuspegawai      = $model->status_pegawai && $model->statuspegawailist ? $model->statuspegawailist["nama"] : ' - ' ;
        $pangkat            = $model->pangkat && $model->pangkatlist ? $model->pangkatlist["nama"] : ' - ' ;
        $golongan           = $model->golongan && $model->golonganlist ? $model->golonganlist["nama"] : ' - ' ;
        $statusjabatan      = $model->id_status_jabatan && $model->statusjabatanlist ? $model->statusjabatanlist["nama"] : ' - ' ;
        $jabatan            = $model->id_jabatan && $model->jabatanlist ? $model->jabatanlist["nama"] : ' - ' ;
        $eselon             = $model->id_eselon && $model->eselonlist ? $model->eselonlist["nama"] : ' - ' ;
        $pendidikan         = $model->pendidikan_terakhir && $model->pendidikanlist ? $model->pendidikanlist["nama"] : ' - ' ;
        return view('pegawai.detail',compact('model','unitkerja','agama',
            'statuspegawai',
            'pangkat',
            'golongan',
            'statusjabatan',
            'jabatan',
            'unitkerja',
            'eselon',
            'pendidikan'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model                  = Pegawai::find($id);
        $agama                  = RefAgama::all();
        $statuspegawai          = RefStatusPegawai::all();
        $pangkat                = RefPangkat::all();
        $golongan               = RefGolongan::all();
        $statusjabatan          = RefStatusJabatan::all();
        $jabatan                = RefJabatan::all();
        $unitkerja              = UnitKerja::all();
        $eselon                 = RefEselon::all();
        $pendidikan             = RefPendidikanTerakhir::all();

        return view('pegawai.edit', compact(
            'model',
            'agama',
            'statuspegawai',
            'pangkat',
            'golongan',
            'statusjabatan',
            'jabatan',
            'unitkerja',
            'eselon',
            'pendidikan'

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
            'nip.unique'                => 'NIP Tersebut Sudah digunakan sebelumnya',

        ];
        $validator = Validator::make($request->all(), [
            'nip'                       =>'required|unique:master_pegawai,nip,'.$request->id,
            'nama_pegawai'              =>'required',
            'jenis_kelamin'             =>'required',
            'tempat_lahir'              =>'required',
            'tanggal_lahir'             =>'required',
            'alamat'                    =>'required',
            'no_telp_wa'                =>'required',
            'pangkat'                   =>'required',
            'golongan'                  =>'required',
            'id_eselon'                 =>'required',
            'id_jabatan'                =>'required',
            'status_pegawai'            =>'required',
            'foto'                      => 'mimes:jpeg,jpg,bmp,png,gif,svg|max:20000',
        ],$messages);

        if($validator->fails())
        {
//            return response()->json([
//                'status'=>400,
//                'errors'=>$validator->errors()->all()
//            ]);
            return redirect()->back()->withInput()->withErrors($validator->errors());

        }
        else {
            $post = Pegawai::where('id', $request->id)->first();
            $foto = $request->file('foto');

            //foto produk
            if ($foto <> NULL) {
                if ($post->foto <> NULL) {
                    $image_path2 = public_path("\fotopegawai\upload\\") . $post->foto;
                    if (File::exists($image_path2)) {
                        File::delete($image_path2);
                    }
                }
                $nama_fileproduk = 'fotopegawai-' . $request->nip . ' - ' . $request->nama_pegawai . '.' . $foto->getClientOriginalExtension();
                $post->foto = $nama_fileproduk;
            } else {
                if ($post->foto <> NULL) {
                    $nama_fileproduk = $post->foto;
                    $post->foto = $post->foto;
                } else {
                    $nama_fileproduk = NULL;
                    $post->foto = NULL;
                }
            }

            $post->nip = $request->nip;
            $post->no_kartu_pegawai = $request->no_kartu_pegawai;
            $post->nama_pegawai = $request->nama_pegawai;
            $post->tempat_lahir = $request->tempat_lahir;
            $post->tanggal_lahir = date('Y-m-d', strtotime($request->tanggal_lahir));
            $post->jenis_kelamin = $request->jenis_kelamin;
            $post->agama = $request->agama;
            $post->status_pegawai = $request->status_pegawai;
            $post->alamat = $request->alamat;
            $post->no_telp_wa = $request->no_telp_wa;
            $post->no_npwp = $request->no_npwp;
            $post->pangkat = $request->pangkat;
            $post->golongan = $request->golongan;
            //nomor_sk_pangkat
            //tanggal_sk_pangkat
            //tanggal_mulai_pangkat
            //tanggal_selesai_pangkat
            //id_status_jabatan
            $post->id_jabatan = $request->id_jabatan;
            $post->id_unit_kerja = 1;
            //id_satuan_kerja
            //lokasi_kerja
            //nomor_sk_jabatan
            $post->id_eselon = $request->id_eselon;

            $post->pendidikan_terakhir = $request->pendidikan_terakhir;
            $post->user_created = NULL;
            $post->foto = $nama_fileproduk;


            $simpan = $post->save();
            if ($simpan) {
                if ($request->file('foto') <> NULL)
                    $foto->move(public_path('fotopegawai/upload/'), $post->foto);

                Session::flash('berhasil', 'Data Pegawai Berhasil di tambah');
                return redirect()->route('pegawai.index');
            } else
                return back()->withErrors(['Gagal' => ['Data Pegawai Gagal di tambah']]);
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
        $check=Pegawai::firstWhere('id',$id);
        if($check) {
            Pegawai::destroy($id);
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
}
