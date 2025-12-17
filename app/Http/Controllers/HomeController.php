<?php

namespace App\Http\Controllers;

use App\models\Role;
use App\models\Sekolah;
use Illuminate\Http\Request;
use App\models\IconGrid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\models\User;
use App\models\Cabdis;
use App\models\Parameter;
use Yajra\Datatables\Datatables;
use App\Models\Kabupatenkota;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }

        $role = Role::where('id', $user->role)->first();

        switch ($role->name) {
            case 'developer':
            case 'superadmin':
                return redirect()->route('site.developer');

            case 'sekolah':
            case 'tata_usaha':
                return redirect()->route('site.sekolah');

            case 'kepala_dinas':
                return redirect()->route('site.kadis');

            case 'pengawas_sekolah':
                return redirect()->route('site.pengawas');

            default:
                return redirect()->route('site.cabdis');
        }
    }
    public function indexSekolah()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }

        $role = Role::where('id', $user->role)->first();
        $sekolah = Sekolah::where('id', $user->id_sekolah)->first();
        $ids = [];
        $showInstrumenAlert = '';
        $kab = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();

        if (isset($sekolah->instrumen) && trim($sekolah->instrumen) !== '') {
            // Ada instrumen → explode dan whereIn
            $ids = array_filter(explode(',', $sekolah->instrumen));
            $icon = IconGrid::whereIn('id', $ids)->get();
            $icon = $icon->sortBy(function ($item) use ($ids) {
                return array_search($item->id, $ids);
            });
        } else {
            // Tidak ada instrumen → ambil semua data, tampilkan alert
            $icon = IconGrid::all()->sortBy("id");
        }

        $instrumenKosong = !isset($sekolah->instrumen) || trim($sekolah->instrumen) === '';
        $kepalaSekolahKosong = !isset($sekolah->kepalasekolah) || trim($sekolah->kepalasekolah) === '';

        if ($instrumenKosong || $kepalaSekolahKosong) {
            $showInstrumenAlert = true;
        } else {
            $showInstrumenAlert = false;
        }

        return view('layouts/berandasekolah', [
            'icon' => $icon,
            'user' => $user,
            'role' => $role,
            'sekolah' => $sekolah,
            'showInstrumenAlert' => $showInstrumenAlert,
            'kab' => $kab,
        ]);
    }

    public function indexKadis()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id', $user->role)->first();
        $sekolah = Sekolah::where('id', $user->id_sekolah)->first();

        return view('layouts/berandakadis', [
            'icon' => $icon,
            'user' => $user,
            'role' => $role,
            'sekolah' => $sekolah,
        ]);
    }

    public function indexCabdis()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id', $user->role)->first();
        $sekolah = Sekolah::where('id', $user->id_sekolah)->first();

        return view('layouts/berandacabdis', [
            'icon' => $icon,
            'user' => $user,
            'role' => $role,
            'sekolah' => $sekolah,
        ]);
    }

    public function indexPengawas()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id', $user->role)->first();
        $sekolah = Sekolah::where('id', $user->id_sekolah)->first();

        return view('layouts/berandapengawas', [
            'icon' => $icon,
            'user' => $user,
            'role' => $role,
            'sekolah' => $sekolah,
        ]);
    }

    public function indexDeveloper()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id', $user->role)->first();
        $sekolah = Sekolah::where('id', $user->id_sekolah)->first();
        return view('layouts/berandadeveloper', [
            'icon' => $icon,
            'user' => $user,
            'role' => $role,
            'sekolah' => $sekolah,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // <== ini pakai facade yang kamu tunjukkan

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // atau halaman lain setelah logout
    }

    public function ListParameter(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }

        $sekolah = Sekolah::where('id', $user->id_sekolah)->first();
        $ids = [];
        $showInstrumenAlert = false;

        if (isset($sekolah->instrumen) && trim($sekolah->instrumen) !== '') {
            // Ada instrumen → explode dan whereIn
            $ids = array_filter(explode(',', $sekolah->instrumen));

            $model = DB::table('parameter_kebersihan')
                ->select('parameter_kebersihan.id_ruang', DB::raw('COUNT(*) as total'), 'rs.nama', 'rs.gambar')
                ->join('ruang_sekolah as rs', 'parameter_kebersihan.id_ruang', '=', 'rs.id')
                ->whereIn('parameter_kebersihan.id_ruang', $ids)
                ->groupBy('parameter_kebersihan.id_ruang', 'rs.nama', 'rs.gambar')
                ->orderBy('id_ruang')
                ->get();
        } else {
            // Tidak ada instrumen → ambil semua data, tampilkan alert
            $showInstrumenAlert = true;

            $model = DB::table('parameter_kebersihan')
                ->select('parameter_kebersihan.id_ruang', DB::raw('COUNT(*) as total'), 'rs.nama', 'rs.gambar')
                ->join('ruang_sekolah as rs', 'parameter_kebersihan.id_ruang', '=', 'rs.id')
                ->groupBy('parameter_kebersihan.id_ruang', 'rs.nama', 'rs.gambar')
                ->orderBy('id_ruang')
                ->get();
        }

        $verifikatorData = DB::table('verifikator_sekolah')
            ->where('id_sekolah', $sekolah->id)
            ->whereNotNull('instrumen')
            ->get();

        // Ambil daftar instrumen milik sekolah
        $instrumenSekolah = isset($sekolah->instrumen) && trim($sekolah->instrumen) !== ''
            ? array_map('trim', explode(',', $sekolah->instrumen))
            : [];

        // Ambil data verifikator yang relevan
        $verifikatorData = DB::table('verifikator_sekolah')
            ->where('id_sekolah', $sekolah->id)
            ->whereNotNull('instrumen')
            ->get();

        $verifikatorPerInstrumen = [];

        foreach ($verifikatorData as $row) {
            $instrumenList = explode(',', $row->instrumen);
            foreach ($instrumenList as $idInstrumen) {
                $idInstrumen = trim($idInstrumen);
                // Abaikan jika instrumen tidak dimiliki sekolah
                if (!in_array($idInstrumen, $instrumenSekolah))
                    continue;

                if (!isset($verifikatorPerInstrumen[$idInstrumen])) {
                    $verifikatorPerInstrumen[$idInstrumen] = [];
                }

                $verifikatorPerInstrumen[$idInstrumen][] = [
                    'nama' => $row->verifikator,
                    'jabatan' => $row->jabatan_verifikator,
                    'ttd' => $row->tandatangan,
                ];
            }
        }

        return view('page/parameterindex', [
            'model' => $model,
            'sekolah' => $sekolah,
            'user' => $user,
            'ids' => $ids,
            'showInstrumenAlert' => $showInstrumenAlert,
            'verifikatorPerInstrumen' => $verifikatorPerInstrumen,
        ]);
    }


    public function ListSekolah(Request $request)
    {
        $model = Sekolah::all()->sortBy("id");
        return view('page/sekolahindex', [
            'model' => $model
        ]);
    }

    /*
    public function GetDataSekolah(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
            //$model=Sekolah::orderBy('id', 'ASC')->get();

        }
        else {
            if($user->role==2 || $user->role==3) {
                $model=Sekolah::where('id',$user->id_sekolah)->orderBy('id', 'ASC')->get();
                //$model=Sekolah::orderBy('id', 'ASC')->get();
            }
            else {
                $model=Sekolah::orderBy('id', 'ASC')->get();
            }
        }

        return Datatables::of($model)
            ->editColumn('kabupaten_kota',function ($data){
                $kabupaten=Kabupatenkota::where('kode_kabupaten',$data->kabupaten_kota)->first();
                return !$data->kabupaten_kota || !$kabupaten ? '-': $kabupaten->nama_kabupaten;
            })
            ->editColumn('bentuk_pendidikan_id', function ($data) {
                if (empty($data->bentuk_pendidikan_id)) {
                    return '-';
                }
                return $data->bentuk_pendidikan_id == 1 ? 'Negeri' : 'Swasta';
            })
            ->editColumn('lintang', function ($data) {
                if (empty($data->lintang) || empty($data->bujur)) {
                    return '-';
                }
                $url = "https://www.google.com/maps?q={$data->lintang},{$data->bujur}";
                return '<a href="'.$url.'" target="_blank">'.$data->lintang.', '.$data->bujur.'</a>';
            })        
            ->addColumn('action', function ($model){
                $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("EditSekolah", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";

                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['lintang','action']) // penting supaya HTML link tidak di-escape

            ->make(true);
    }
    */

    public function GetDataSekolah(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Base query
        $query = Sekolah::query();

        // Filter berdasarkan role (role 2 dan 3 hanya sekolahnya sendiri)
        if (in_array($user->role, [2, 3])) {
            $query->where('id', $user->id_sekolah);
        }
        // Role lain (4,5,6,7,dst) akan dapat semua data

        // Search
        if ($request->has('search') && !empty(trim($request->search['value']))) {
            $search = strtolower(trim($request->search['value']));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(npsn) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(alamat_jalan) LIKE ?', ["%{$search}%"]);
            });
        }

        // Total sebelum pagination
        $total = $query->count();

        // Pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $data = $query->orderBy('id', 'ASC')->skip($start)->take($length)->get();

        // Format data
        $formatted = $data->map(function ($item) {
            $kabupaten = Kabupatenkota::where('kode_kabupaten', $item->kabupaten_kota)->first();

            $mapLink = (!empty($item->lintang) && !empty($item->bujur))
                ? "<a href='https://www.google.com/maps?q={$item->lintang},{$item->bujur}' target='_blank'>{$item->lintang}, {$item->bujur}</a>"
                : '-';

            $ids = !empty($item->instrumen) ? explode(',', $item->instrumen) : [];

            // Cegah error jika tabel kosong
            $list = !empty($ids) ? IconGrid::whereIn('id', $ids)->pluck('nama')->toArray() : [];
            $listno = IconGrid::count() > 0
                ? IconGrid::whereNotIn('id', $ids)->pluck('nama')->toArray()
                : [];

            return [
                'id' => $item->id ?? '-',
                'nama' => $item->nama ?? '-',
                'npsn' => $item->npsn ?? '-',
                'bentuk_pendidikan_id' => $item->bentuk_pendidikan_id == 1 ? 'Negeri' : ($item->bentuk_pendidikan_id == 2 ? 'Swasta' : '-'),
                'alamat_jalan' => $item->alamat_jalan ?? '-',
                'kabupaten_kota' => $kabupaten ? $kabupaten->nama_kabupaten : '-',
                'lintang' => $mapLink,
                'nomor_telepon' => $item->nomor_telepon ?? '-',
                'email' => $item->email ?? '-',
                'website' => $item->website ?? '-',
                'kepalasekolah' => $item->kepalasekolah ?? '-',
                'rtrw' => ($item->rt && $item->rw) ? "RT {$item->rt} / RW {$item->rw}" : '-',
                'instrumen' => $list,
                'instrumenno' => $listno,
                'action' => "
                <div class='btn-group'>
                    <a href='" . route("EditSekolah", $item->id) . "' class='btn btn-sm btn-warning'>Edit</a>
                </div>
            "
            ];
        });

        return response()->json([
            'data' => $formatted,
            'recordsTotal' => $total,
            'recordsFiltered' => $total
        ]);
    }

    public function EditSekolah($id)
    {
        $model = Sekolah::find($id);
        $kabupaten = Kabupatenkota::all();
        $instrumen = IconGrid::orderBy('id', 'asc')->get();
        $daftarInstrumen = IconGrid::orderBy('id', 'asc')->get();
        $selectedInstrumen = explode(',', $model->instrumen ?? '');
        $cabdis = Cabdis::all();
        return view('page.sekolahedit', compact('model', 'kabupaten', 'instrumen', 'daftarInstrumen', 'selectedInstrumen', 'cabdis'));
    }

    public function UpdateSekolah(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute Wajib diisi',
        ];

        // daftar instrumen yang wajib dicentang
        $requiredInstrumen = [1, 2, 3, 4];

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'npsn' => 'required',
            'alamat_jalan' => 'required',
            'kabupaten_kota' => 'required',
            'kepalasekolah' => 'required',
            'nomor_telepon' => 'required',
            'email' => 'required|string|email',
            'instrumen' => 'required|array',
            'instrumen.*' => 'integer',
            'cabdis' => 'required',
        ], $messages);

        // tambahkan validasi custom untuk instrumen wajib
        $validator->after(function ($validator) use ($request, $requiredInstrumen) {
            foreach ($requiredInstrumen as $req) {
                if (!in_array($req, $request->instrumen ?? [])) {
                    $validator->errors()->add(
                        'instrumen',
                        'Instrumen wajib (ID: ' . $req . ') harus dicentang.'
                    );
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $post = Sekolah::where('id', $request->id)->first();
        $koordinat = $request->input('koordinat');
        list($lintang, $bujur) = array_map('trim', explode(',', $koordinat));

        $post->nama = $request->nama;
        $post->npsn = $request->npsn;
        $post->alamat_jalan = $request->alamat_jalan;
        $post->kabupaten_kota = $request->kabupaten_kota;
        $post->bentuk_pendidikan_id = $request->bentuk_pendidikan_id;
        $post->kepalasekolah = $request->kepalasekolah;
        $post->nomor_telepon = $request->nomor_telepon;
        $post->email = $request->email;
        $post->website = $request->website;
        $post->lintang = $lintang;
        $post->bujur = $bujur;
        $post->instrumen = $request->filled('instrumen') ? implode(',', $request->instrumen) : null;
        $post->cabdis = $request->cabdis;

        if ($post->save()) {
            Session::flash('berhasil', 'Data Sekolah Berhasil Di Ubah');
            return redirect()->route('ListSekolah');
        } else {
            return back()->withErrors(['Gagal' => ['Data Sekolah Gagal di ubah']]);
        }
    }



}
