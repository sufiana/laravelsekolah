<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\IconGrid;

class HomeController extends Controller
{
    public function index()
    {
        $icon = IconGrid::all()->sortBy("id");
        return view('layouts/beranda', [
            'icon'    => $icon
        ]);
    }
}
