<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\JenisKegiatan;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
class JenisKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=JenisKegiatan::all()->sortBy("id");
        return view('kegiatan/index', [
            'model'    => $model,
        ]);
    }

    public function getData(){
        $model=JenisKegiatan::orderBy('id', 'ASC')->get();
        return Datatables::of($model)
            ->addColumn('action', function ($model){
                $button = "
                    <div class='btn-group-horizontal'>
                    <a href='#' class='table-link' data-id='" . $model->id . "' data-nama='" . $model->nama . "' id='editbtn' >
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'required'              => 'Kolom :attribute Wajib diisi',
            'kode.unique'           => 'Kode Tersebut Sudah digunakan sebelumnya',
        ];
        $validator = Validator::make($request->all(), [
            'nama'         =>'required',
            'kode'         =>'required|unique:ref_jenis_kegiatan',
        ],$messages);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()->all()
            ]);
        }
        else {
            $post                   = new JenisKegiatan();
            $post->nama             = $request->input('nama');
            $post->kode             = $request->input('kode');
            $post->status           = $request->input('status');
            $post->deskripsi        = $request->input('deskripsi');
            $post->save();
            return response()->json([
                'status'=>200,
                'message'=>'Data Berhasil ditambah'
            ]);
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
        $model=JenisKegiatan::findOrFail($id);
        return view('kegiatan.detail',compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = JenisKegiatan::find($id);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'required'              => 'Kolom :attribute Wajib diisi',
            'kodeedit.unique'       => 'Kode Tersebut Sudah digunakan sebelumnya',
        ];
        $validator = Validator::make($request->all(), [
            'namaedit'        =>'required',
            'kodeedit'        =>'required|unique:ref_jenis_kegiatan,kode,'.$id,
        ],$messages);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()->all()
            ]);
        }
        else {
            $post                           = JenisKegiatan::find($id);
            if($post) {
                $post->nama                 = $request->input('namaedit');
                $post->kode                 = $request->input('kodeedit');
                $post->status               = $request->input('statusedit');
                $post->deskripsi            = $request->input('deskripsiedit');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check=JenisKegiatan::firstWhere('id',$id);
        if($check) {
            JenisKegiatan::destroy($id);
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
