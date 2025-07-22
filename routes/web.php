<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/layouts/beranda');
});

Route::get('/', 'HomeController@index')->name('home');

Route::get('sekolahbersih/index', 'SekolahBersihController@index')->name('sekolahbersih.index');
Route::get('sekolahbersih/getData', 'SekolahBersihController@getData')->name('sekolahbersih.getData');
Route::get('sekolahbersih/create/{id}', 'SekolahBersihController@create')->name('sekolahbersih.create');
//Route::get('sekolahbersih/create/{singkatan}', 'SekolahBersihController@create')
//    ->where('singkatan', '[A-Za-z0-9]+')  // ini sebenarnya opsional jika tanpa karakter khusus
//    ->name('sekolahbersih.create');


