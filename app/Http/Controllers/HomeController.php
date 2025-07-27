<?php

namespace App\Http\Controllers;

use App\models\Role;
use App\models\Sekolah;
use Illuminate\Http\Request;
use App\models\IconGrid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\models\User;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        //dd(Auth::user()->toArray());
        if($user) {
            switch ($user->role) {
                case 'developer' : case 'superadmin':
                    return redirect()->route('site.developer');
                case 'sekolah': case 'tata_usaha':
                    return redirect()->route('site.sekolah');
                case 'kepala_dinas':
                    return redirect()->route('site.kadis');
                case 'pengawas_sekolah':
                    return redirect()->route('site.pengawas');
                default:
                    return redirect()->route('site.cabdis');
            }
        }
        else {
            return redirect('login');
        }
    }

    public function indexSekolah()
    {
        $user = Auth::user();
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id',$user->role)->first();
        $sekolah = Sekolah::where('id',$user->id_sekolah)->first();
        return view('layouts/berandasekolah', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'      => $sekolah
        ]);
    }

    public function indexKadis()
    {
        $user = Auth::user();
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id',$user->role)->first();
        $sekolah = Sekolah::where('id',$user->id_sekolah)->first();
        return view('layouts/berandakadis', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'      => $sekolah
        ]);
    }

    public function indexCabdis()
    {
        $user = Auth::user();
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id',$user->role)->first();
        $sekolah = Sekolah::where('id',$user->id_sekolah)->first();
        return view('layouts/berandacabdis', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'      => $sekolah
        ]);
    }

    public function indexPengawas()
    {
        $user = Auth::user();
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id',$user->role)->first();
        $sekolah = Sekolah::where('id',$user->id_sekolah)->first();
        return view('layouts/berandapengawas', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'      => $sekolah
        ]);
    }

    public function indexDeveloper()
    {
        $user = Auth::user();
        $icon = IconGrid::all()->sortBy("id");
        $role = Role::where('id',$user->role)->first();
        $sekolah = Sekolah::where('id',$user->id_sekolah)->first();
        return view('layouts/berandadeveloper', [
            'icon'      => $icon,
            'user'      => $user,
            'role'      => $role,
            'sekolah'      => $sekolah
        ]);
    }



}
