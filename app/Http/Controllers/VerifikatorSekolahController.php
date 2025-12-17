<?php

namespace App\Http\Controllers;

use App\models\IconGrid;
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

    public function getData()
    {
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
                    return 
                        '<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#ttdModal" data-img="'.$url.'">
                            <i class="fa fa-search"></i>
                        </button>';
                }
                return '-';
            })
            ->editColumn('instrumen', function ($data) {
                if (!$data->instrumen) return '-';
                $ids = explode(',', $data->instrumen);
                $list = IconGrid::whereIn('id', $ids)->pluck('nama')->toArray();
                return implode(', ', $list);
            })
            ->addColumn('action', function ($model){
                $button = "<div class='d-flex flex-nowrap gap-1'>
                    <a href='" . route("verifikator.edit", $model->id) . "' id='editbtn' class='btn btn-success btn-sm'>
                        <i class='fa fa-pencil-square-o'></i>
                    </a>
                    <a href='#' class='btn btn-danger btn-sm' data-id='" . $model->id . "' data-nama='" . $model->verifikator . "' data-bs-toggle='modal' data-bs-target='#delModal'>
                       <i class='fa fa-trash'></i>
                    </a>
                    </div>
                ";
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
        $instrumen = IconGrid::orderBy('id', 'asc')->get();

        return view('verifikator.create', compact('sekolah', 'user', 'jabatan','instrumen'));
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
        //untuk menyimpan user verifikator  yang menilai instrumen
        $post->instrumen           = $request->filled('instrumen') ? implode(',', $request->instrumen) : null;


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
        $daftarInstrumen        = IconGrid::orderBy('id', 'asc')->get();
        $selectedInstrumen      = explode(',', $model->instrumen ?? '');
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
                'jabatan',
                'daftarInstrumen',
                'selectedInstrumen',
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
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'Kolom :attribute wajib diisi',
        ];

        $validator = Validator::make($request->all(), [
            'id_sekolah'          => 'required',
            'verifikator'         => 'required',
            'jabatan_verifikator' => 'required',
            'tandatangan_upload'  => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'tandatangan_drawn'   => 'nullable|string',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $post = VerifikatorSekolah::findOrFail($id);
        $uploadPath = public_path('upload/ttd/');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Default: jangan ubah tanda tangan
        $newTandaTanganPath = $post->tandatangan;

        // === Jika upload file baru ===
        if ($request->hasFile('tandatangan_upload')) {
            // Hapus file lama jika itu adalah file (bukan base64)
            if ($post->tandatangan && !Str::startsWith($post->tandatangan, 'data:image')) {
                $oldPath = public_path($post->tandatangan);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('tandatangan_upload');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);
            $newTandaTanganPath = 'upload/ttd/' . $fileName;
        }
        // === Jika gambar manual (canvas base64) ===
        elseif ($request->filled('tandatangan_drawn')) {
            $drawn = $request->tandatangan_drawn;
            if (Str::startsWith($drawn, 'data:image')) {
                // Hapus file lama jika itu file fisik
                if ($post->tandatangan && !Str::startsWith($post->tandatangan, 'data:image')) {
                    $oldPath = public_path($post->tandatangan);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $image = str_replace('data:image/png;base64,', '', $drawn);
                $image = str_replace(' ', '+', $image);
                $fileName = uniqid() . '.png';
                file_put_contents($uploadPath . $fileName, base64_decode($image));
                $newTandaTanganPath = 'upload/ttd/' . $fileName;
            }
        }
        // === Jika tidak ada input tanda tangan baru, pertahankan yang lama ===
        else {
            // Tidak lakukan apa-apa, gunakan $newTandaTanganPath = $post->tandatangan
        }

        // Update data
        $post->id_sekolah = $request->id_sekolah;
        $post->verifikator = $request->verifikator;
        $post->deskripsi = $request->deskripsi;
        $post->jabatan_verifikator = $request->jabatan_verifikator;
        $post->tandatangan = $newTandaTanganPath;
        $post->instrumen = $request->filled('instrumen') ? implode(',', $request->instrumen) : null;

        if ($post->save()) {
            Session::flash('berhasil', 'Data User verifikator berhasil diperbarui');
            return redirect()->route('verifikator.index');
        } else {
            return back()->withErrors(['Gagal' => ['Data User verifikator gagal diperbarui']]);
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
        $post = VerifikatorSekolah::findOrFail($id);

        // Hapus file tanda tangan jika itu file (bukan base64)
        if ($post->tandatangan && !Str::startsWith($post->tandatangan, 'data:image')) {
            $filePath = public_path($post->tandatangan);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $post->delete();

        Session::flash('berhasil', 'Data verifikator berhasil dihapus');
        return redirect()->route('verifikator.index');
    }
    public function SimpanNamaJabatan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100'
        ]);

        // Normalisasi nama agar konsisten (misalnya kapital di awal setiap kata)
        $namaInput = trim($request->nama);

        // Cek apakah sudah ada jabatan dengan nama yang sama (case-insensitive)
        $existing = RefJabatanVerifikator::whereRaw('LOWER(nama) = ?', [strtolower($namaInput)])->first();

        if ($existing) {
            // Kalau sudah ada, langsung kembalikan data lama
            return response()->json([
                'id' => $existing->id,
                'nama' => $existing->nama,
                'existing' => true
            ]);
        }

        // Jika belum ada, buat baru
        $newJabatan = RefJabatanVerifikator::create([
            'nama' => $namaInput,
            'deskripsi' => null
        ]);

        return response()->json([
            'id' => $newJabatan->id,
            'nama' => $newJabatan->nama,
            'existing' => false
        ]);
    }
}
