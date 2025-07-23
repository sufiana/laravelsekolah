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
Route::post('sekolahbersih/store', 'SekolahBersihController@store')->name('sekolahbersih.store');
//Route::get('sekolahbersih/create/{singkatan}', 'SekolahBersihController@create')
//    ->where('singkatan', '[A-Za-z0-9]+')  // ini sebenarnya opsional jika tanpa karakter khusus
//    ->name('sekolahbersih.create');
Route::delete('sekolahbersih/destroy/{id}', 'SekolahBersihController@destroy')->name('sekolahbersih.delete');
Route::get('sekolahbersih/edit/{id}', 'SekolahBersihController@edit')->name('sekolahbersih.edit');



// Authentication Routes
Route::get('login', 'AuthController@showLoginForm')->name('login');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout')->name('logout');

// Registration Routes
Route::get('register', 'AuthController@showRegistrationForm')->name('register');
Route::post('register', 'AuthController@register');

// Google SSO Routes
Route::get('auth/google', 'AuthController@redirectToGoogle')->name('auth.google');
Route::get('auth/google/callback', 'AuthController@handleGoogleCallback');
