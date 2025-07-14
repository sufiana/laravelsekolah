<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\models\ManajemenBiaya;
use App\models\RefGolongan;
use App\models\RefJenisBiaya;
use App\models\RefStatusWilayahBiaya;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Session;


class ManajemenBiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=ManajemenBiaya::all()->sortBy("id");
        return view('manajemenbiaya/index', [
            'model'    => $model
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData(){
        $model=ManajemenBiaya::orderBy('id', 'ASC')->get();
        return Datatables::of($model)
            ->editColumn('jabatan',function ($data){
                return !$data->Jabatanlist || !$data->jabatan ?  ' - ' : $data->Jabatanlist["kode"].' - '.$data->Jabatanlist["nama"];
            })
            ->editColumn('jenis_biaya',function ($data){
                return !$data->Jenisbiayalist || !$data->jenis_biaya ?  ' - ' : $data->Jenisbiayalist["nama"]  ;
            })
            ->editColumn('status_wilayah_biaya',function ($data){
                return !$data->WilayahBiayalist || !$data->status_wilayah_biaya ?  ' - ' : $data->WilayahBiayalist["nama"]  ;
            })
            ->editColumn('nominal',function ($data){
                return 'Rp. '. number_format($data->nominal, 0, ",", ".");
            })

            ->addColumn('action', function ($model){
                $button = "
                    <div class='btn-group-horizontal'>
                    <a href='" . route("biaya.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->nama . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";

                $button = $button . "</div>";
                return $button;
            })
            ->make(true);
    }

    public function create()
    {
        $golongan               = RefGolongan::all();
        $jenisbiaya             = RefJenisBiaya::all();
        $statusbiaya            = RefStatusWilayahBiaya::all();

        return view('manajemenbiaya.create', compact(
            'golongan',
            'jenisbiaya',
            'statusbiaya'
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
            if($request->jabatan <> NULL && $request->jabatan <> 0 ) {
                $post                       = new ManajemenBiaya();
                $post->jabatan              = $request->jabatan;
                $post->jenis_biaya          = $request->jenis_biaya;
                $post->deskripsi            = $request->deskripsi;
                $post->status_wilayah_biaya = $request->status_wilayah_biaya;
                $badChars                   = array(".");
                $nominal                    = str_ireplace($badChars, "", $request->nominal);
                $post->nominal              = $nominal;
                $post->user_created         = NULL;
                $simpan                     = $post->save();

            }
            else {
                $loopgol                    = RefGolongan::all();
                foreach($loopgol as $i)
                {
                    $post                       = new ManajemenBiaya();
                    $post->jabatan              = $i->id;
                    $post->jenis_biaya          = $request->jenis_biaya;
                    $post->deskripsi            = $request->deskripsi;
                    $post->status_wilayah_biaya = $request->status_wilayah_biaya;
                    $badChars                   = array(".");
                    $nominal                    = str_ireplace($badChars, "", $request->nominal);
                    $post->nominal              = $nominal;
                    $post->user_created         = NULL;
                    $simpan                     = $post->save();
                }
            }
            if ($simpan) {
                Session::flash('berhasil', 'Data Manajemen Biaya Berhasil di tambah');
                return redirect()->route('biaya.index');
            } else
                return back()->withErrors(['Gagal' => ['Data Manajemen Biaya Gagal di tambah']]);
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
        $model=ManajemenBiaya::findOrFail($id);
        $rincian=Pegawai::where('golongan',$model->jabatan)->get();
        return view('manajemenbiaya.detail',compact('model','rincian'));
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
        $check=ManajemenBiaya::firstWhere('id',$id);
        if($check) {
            ManajemenBiaya::destroy($id);
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
