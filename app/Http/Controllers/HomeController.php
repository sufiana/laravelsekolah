<?php

namespace App\Http\Controllers;

use App\models\Role;
use App\models\Sekolah;
use Illuminate\Http\Request;
use App\models\IconGrid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\models\User;
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

        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id', $user->role)->first();
        $sekolah = Sekolah::where('id', $user->id_sekolah)->first();
        
        return view('layouts/berandasekolah', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'   => $sekolah,
        ]);
    }

    public function indexKadis()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id',$user->role)->first();
        $sekolah = Sekolah::where('id',$user->id_sekolah)->first();
        
        return view('layouts/berandakadis', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'      => $sekolah,
        ]);
    }

    public function indexCabdis()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id',$user->role)->first();
        $sekolah = Sekolah::where('id',$user->id_sekolah)->first();
        
        return view('layouts/berandacabdis', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'      => $sekolah,
        ]);
    }

    public function indexPengawas()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id',$user->role)->first();
        $sekolah = Sekolah::where('id',$user->id_sekolah)->first();
        
        return view('layouts/berandapengawas', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'      => $sekolah,
        ]);
    }

    public function indexDeveloper()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id',$user->role)->first();
        $sekolah = Sekolah::where('id',$user->id_sekolah)->first();
        return view('layouts/berandadeveloper', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'      => $sekolah,
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
        $model = DB::table('parameter_kebersihan')
        ->select('parameter_kebersihan.id_ruang', DB::raw('COUNT(*) as total'), 'rs.nama', 'rs.gambar')
        ->join('ruang_sekolah as rs', 'parameter_kebersihan.id_ruang', '=', 'rs.id')
        ->groupBy('parameter_kebersihan.id_ruang', 'rs.nama','rs.gambar')
        ->orderBy('id_ruang')
        ->get();
        
        return view('page/parameterindex', [
            'model'    => $model
        ]);
    }
    
    public function ListSekolah(Request $request)
    {
        $model=Sekolah::all()->sortBy("id");
        return view('page/sekolahindex', [
            'model'    => $model
        ]);
    }
    
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
    
    public function EditSekolah($id)
    {
        $model = Sekolah::find($id);
        $kabupaten = Kabupatenkota::all();
        return view('page.sekolahedit', compact('model','kabupaten'));
    }
    
    public function UpdateSekolah(Request $request)
    {
        $messages = [
            'required'                  => 'Kolom :attribute Wajib diisi',
        ];
        $validator = Validator::make($request->all(), [
            'nama'                  =>'required',
            'npsn'                  =>'required',
            'alamat_jalan'          =>'required',
            'kabupaten_kota'        =>'required',
            'bentuk_pendidikan_id'  =>'required',
            'nomor_telepon'         =>'required',
            'email'                 =>'required',
            'website'               =>'required',
            'kepalasekolah'         =>'required',
        ],$messages);

        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        else {
            $post                           = Sekolah::where('id', $request->id)->first();
            $koordinat                      = $request->input('koordinat'); 
            list($lintang, $bujur)          = array_map('trim', explode(',', $koordinat));

            $post->nama                     = $request->nama;
            $post->npsn                     = $request->npsn;
            $post->alamat_jalan             = $request->alamat_jalan;
            $post->kabupaten_kota           = $request->kabupaten_kota;
            $post->bentuk_pendidikan_id     = $request->bentuk_pendidikan_id;
            $post->nomor_telepon            = $request->nomor_telepon;
            $post->email                    = $request->email;
            $post->website                  = $request->website;
            $post->lintang                  = $lintang;
            $post->bujur                    = $bujur;
           
            $simpan = $post->save();
            if ($simpan) {
                Session::flash('berhasil', 'Data Sekolah Berhasil Di Ubah');
                return redirect()->route('ListSekolah');
            } else
                return back()->withErrors(['Gagal' => ['Data Sekolah Gagal di ubah']]);
        }
    }


}
