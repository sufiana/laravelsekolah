<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         View::composer('layouts.navbar', function ($view) {
        $user = Auth::user();

        $results = collect(); // default kosong
        if ($user && in_array($user->role, [2, 8])) {
            $results = DB::table('ruang_sekolah as r')
                ->select('r.id', 'r.nama','r.singkatan')
                ->whereNotExists(function ($query) use ($user) {
                    $query->select(DB::raw(1))
                        ->from('hasil_kuesioner as h')
                        ->where('h.id_sekolah', $user->id_sekolah)
                        ->whereRaw('h.id_ruang = r.id')
                        ->whereRaw("h.periode_awal_kuesioner = date_trunc('month', CURRENT_DATE)::date")
                        ->whereRaw("h.periode_akhir_kuesioner = (date_trunc('month', CURRENT_DATE) + interval '1 month - 1 day')::date");
                })
                ->orderBy('r.id', 'asc')
                ->get();
        }

        $view->with('results', $results);
    });
    }
}
