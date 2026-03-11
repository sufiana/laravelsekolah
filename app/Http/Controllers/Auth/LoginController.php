<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\models\User;
use App\models\Role;
use App\models\Cabdis;
use App\models\Sekolah;
use App\models\Kabupatenkota;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // pastikan view login ada
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Logout any existing user
        Auth::logout();

        \Log::info('Login attempt: email=' . $request->email);
        $user = User::where('email', $request->email)->first();
        \Log::info('User found: ' . ($user ? $user->id . ' ' . $user->username . ' role=' . $user->role : 'none'));

        \Log::info('Login attempt for email: ' . $request->email);
        if ($user) {
            \Log::info('User found: ' . $user->email . ', ID: ' . $user->id . ', Active: ' . $user->is_active . ', Verified: ' . $user->is_verified);
            $passwordCheck = Hash::check($request->password, $user->password_hash);
            \Log::info('Password check result: ' . ($passwordCheck ? 'true' : 'false'));
        } else {
            \Log::info('User not found for email: ' . $request->email);
        }

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            Alert::error('Login Gagal', 'Email atau password salah.');
            return redirect('/login');
        }

        if (!$user->is_active || !$user->is_verified) {
            Alert::error('Login Gagal', 'Akun belum aktif atau belum diverifikasi.');
            return redirect('/login');
        }

        Auth::login($user, $request->remember);
        \Log::info('Logged in user: ' . Auth::user()->email . ', ID: ' . Auth::user()->id . ', Role: ' . Auth::user()->role);

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegistrationForm()
    {
        $role = Role::where('id', '!=', 1)->get(); // Exclude role 1 (hidden)
        $sekolah = Sekolah::all();
        $cabdis = Cabdis::all();
        $kabupaten = Kabupatenkota::all();
        return view('auth.register', compact('role', 'sekolah', 'cabdis', 'kabupaten'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'role' => 'required|integer|exists:role,id',
            'id_sekolah' => 'nullable|integer|exists:sekolah,id',
            'cabdis' => 'nullable|integer|exists:cabdis,id',
            'binaan_kabkota' => 'nullable|string|exists:kabupaten,kode_kabupaten',
        ]);

        // Validate role-specific requirements
        $role = $request->role;
        if (in_array($role, [2, 3, 8]) && !$request->id_sekolah) {
            Alert::error('Error', 'Sekolah harus dipilih untuk role ini.');
            return redirect('/login');
        }
        if ($role == 4 && !$request->cabdis) {
            Alert::error('Error', 'Cabdis harus dipilih untuk role ini.');
            return redirect('/login');
        }
        if ($role == 6 && !$request->binaan_kabkota) {
            Alert::error('Error', 'Binaan harus dipilih untuk role ini.');
            return redirect('/login');
        }

        try {
            // Generate password hash using Laravel's Hash::make (bcrypt)
            $passwordHash = Hash::make($request->password);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password_hash' => $passwordHash, // Use bcrypt hash
                'nohp' => $request->no_hp,
                'role' => $request->role,
                'id_sekolah' => in_array($role, [2, 3, 8]) ? $request->id_sekolah : null,
                'cabdis' => $role == 4 ? $request->cabdis : null,
                'binaan_kabkota' => $role == 6 ? $request->binaan_kabkota : null,
                'is_active' => false, // Set to false, needs approval
                'is_verified' => false, // Set to false, needs approval
                'verification_token' => Str::random(60),
            ]);

            // Remove auto login, user needs approval first
            // Auth::login($user);

            Alert::success('Berhasil', 'Registrasi berhasil! Tunggu approval dari pengawas/cabdis.');
            return redirect('/login');
        } catch (\Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());
            Alert::error('Gagal', 'Registrasi gagal: ' . $e->getMessage());
            return redirect('/login');
        }
    }

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 1 || $user->role == 4 || $user->role == 6) {
                $sekolah = Sekolah::all();
                $kabupaten = Kabupatenkota::all();
                $cabdis = Cabdis::all();
                $role = Role::all();
                return view('auth.index', compact('sekolah', 'kabupaten', 'cabdis', 'role'));
            } else {
                return redirect()->back()->with('error', 'Anda tidak memiliki hak akses untuk laman ini');
            }
        }
        //dd($kabupaten);

        return redirect('login');
    }

    public function getData(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $query = User::query();

            // Filter sekolah
            if ($request->filled('sekolah')) {
                $query->where('id_sekolah', $request->sekolah);
            }

            // Filter kabupaten
            if ($request->filled('kabupaten')) {
                $query->where('id_kabupaten', $request->kabupaten);
            }

            // Filter cabdis
            if ($request->filled('cabdis')) {
                $query->where('id_cabdis', $request->cabdis);
            }

            // Tambahan filter lain (misalnya role)
            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }

            $model = $query->orderBy('id', 'ASC')->get();
        } else {
            $model = collect(); // kosongkan koleksi
        }

        return Datatables::of($model)
            ->editColumn('id_sekolah', function ($data) {
                $a = Sekolah::where('id', $data->id_sekolah)->first();
                return !$a ? '-' : $a->nama;
            })
            ->editColumn('role', function ($data) {
                $a = Role::where('id', $data->role)->first();
                return !$a ? '-' : $a->name;
            })
            ->editColumn('binaan_kabkota', function ($data) {
                $a = Kabupatenkota::where('kode_kabupaten', $data->binaan_kabkota)->first();
                return !$a ? '-' : $a->nama_kabupaten;
            })
            ->editColumn('cabdis', function ($data) {
                $a = Cabdis::where('id', $data->cabdis)->first();
                return !$a ? '-' : $a->nama;
            })
            //->addColumn('action', function ($model) {
            //     $button = '-
            //     // <a class="btn btn-primary btn-sm" href="' . route("user.edit", $model->id) . '" id="editbtn">
            //     //   <i class="fa fa-edit"></i>
            //     // </a>
            //     // <a class="btn btn-danger btn-sm" href="#" data-id="' . $model->id . '" data-nama="' . $model->name . '" id="deletebtn" data-toggle="modal" data-target="#delModal">
            //     //   <i class="fa fa-trash"></i>
            //     // </a>
            // ';
            //     return $button;
            // })
            ->rawColumns(['action'])
            ->make(true);
    }


}
