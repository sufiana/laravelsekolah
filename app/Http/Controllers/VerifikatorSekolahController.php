<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Sekolah;
use App\models\VerifikatorSekolah;
use App\models\RefJabatanVerifikator;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;


class VerifikatorSekolahController extends Controller
{
     public function index()
    {
        $model=VerifikatorSekolah::all()->sortBy("id");
        return view('verifikator/index', [
            'model'    => $model
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData(){
          if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $query=VerifikatorSekolah::orderBy('id', 'ASC');
        if (in_array($user->role, [2, 8])){
            $query=$query->where('verifikator_sekolah.id_sekolah', $user->id_sekolah);
        }
        
        $model= $query->get();
        return Datatables::of($model)
            ->editColumn('jabatan_verifikator',function ($data){
                return !$data->Jabatanlist || !$data->jabatan_verifikator ?  ' - ' : $data->Jabatanlist["nama"];
            })
            ->editColumn('id_sekolah',function ($data){
                return !$data->sekolahlist || !$data->id_sekolah ?  ' - ' : $data->sekolahlist["nama"];
            })
            ->addColumn('tandatangan_url', function ($data) {
                if ($data->tandatangan) {
                    $url = asset($data->tandatangan);
                    return '<a href="'.$url.'" target="_blank" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ttdModal" data-img="'.$url.'">
                                Lihat TTD
                            </a>';
                }
                return '-';
            })


            ->addColumn('action', function ($model){
                $button = "
                    <div class='btn-group-horizontal'>
                    <a href='" . route("verifikator.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->verifikator . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";

                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['tandatangan_url','action']) // biar html link ga di-escape
            ->make(true);
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        // Cek role: hanya role 2, 3, 6 yang dibatasi per sekolah
        if ($user->role == 2 || $user->role == 3 || $user->role == 8 ) {
            $sekolah = Sekolah::where('id', $user->id_sekolah)->get();
        } else {
            $sekolah = Sekolah::all(); // Semua sekolah untuk role lain
        }

        $jabatan = RefJabatanVerifikator::all();

        return view('verifikator.create', compact('sekolah', 'user', 'jabatan'));
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
        'required' => 'Kolom :attribute wajib diisi',
    ];

    $validator = Validator::make($request->all(), [
        'id_sekolah'          => 'required',
        'verifikator'         => 'required',
        'jabatan_verifikator' => 'required',
        'tandatangan_upload'  => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        'tandatangan_drawn'   => 'nullable|string', // tambahkan validasi utk base64 signature
    ], $messages);

    if ($validator->fails()) {
        return redirect()->back()->withInput()->withErrors($validator->errors());
    }

    $tandaTanganPath = null;
    $uploadPath = public_path('upload/ttd/'); // folder public/upload/ttd

    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    // === kalau upload file (gambar) ===
    if ($request->hasFile('tandatangan_upload')) {
        $file = $request->file('tandatangan_upload');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $fileName);

        // simpan path relatif biar bisa diakses asset()
        $tandaTanganPath = 'upload/ttd/' . $fileName;
    }

    // === kalau gambar manual (canvas base64) ===
    elseif ($request->filled('tandatangan_drawn')) {
        $image = $request->input('tandatangan_drawn'); // ambil value dari form

        // pastikan string ada "data:image/png;base64,"
        if (strpos($image, 'data:image') === 0) {
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $fileName = uniqid() . '.png';
            file_put_contents($uploadPath . $fileName, base64_decode($image));

            $tandaTanganPath = 'upload/ttd/' . $fileName;
        }
    }

    $post = new VerifikatorSekolah();
    $post->id_sekolah          = $request->id_sekolah;
    $post->verifikator         = $request->verifikator;
    $post->deskripsi           = $request->deskripsi;
    $post->jabatan_verifikator = $request->jabatan_verifikator;
    $post->tandatangan         = $tandaTanganPath; // path relatif (contoh: upload/ttd/xxxx.png)

    if ($post->save()) {
        Session::flash('berhasil', 'Data User verifikator berhasil ditambah');
        return redirect()->route('verifikator.index');
    } else {
        return back()->withErrors(['Gagal' => ['Data User verifikator gagal ditambah']]);
    }
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model                  = VerifikatorSekolah::find($id);
        if($model)
        {
             if (!Auth::check()) {
                return redirect()->route('login');
             }
             $user = Auth::user();
             // Cek role: hanya role 2, 3, 6 yang dibatasi per sekolah
            if ($user->role == 2 || $user->role == 3 || $user->role == 8 ) {
                $sekolah = Sekolah::where('id', $user->id_sekolah)->get();
            } else {
                $sekolah = Sekolah::all(); // Semua sekolah untuk role lain
            }
            $jabatan = RefJabatanVerifikator::all();
            return view('verifikator.edit', compact(
                'model',
                'user',
                'sekolah',
                'jabatan'
            ));
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Data Tidak Ditemukan...'
            ]);
        }
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
            $post                           = VerifikatorSekolah::where('id', $request->id)->first();
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
                Session::flash('berhasil', 'Data Verifikator Sekolah Berhasil di tambah');
                return redirect()->route('verifikator.index');
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
        $check=VerifikatorSekolah::firstWhere('id',$id);
        if($check) {
            VerifikatorSekolah::destroy($id);
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
