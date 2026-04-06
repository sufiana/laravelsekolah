<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleAuthController;
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

//Route::get('/', function () {
//    return view('/layouts/beranda');
//});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:60,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/registrasi', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/registrasi', [AuthController::class, 'register'])->name('register.post');

// Security Monitoring Routes
Route::post('/auth/login-status', [AuthController::class, 'getLoginStatus'])->name('auth.login-status');
Route::post('/auth/generate-captcha', [AuthController::class, 'generateCaptcha'])->name('auth.generate-captcha');

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Temporary route to update password
Route::get('/update-password', function () {
    $user = \App\models\User::where('email', 'raffialfarizky@gmail.com')->first();
    if ($user) {
        $user->password_hash = \Illuminate\Support\Facades\Hash::make('developer123');
        $user->save();
        return 'Password updated for ' . $user->email;
    }
    return 'User not found';
});


Route::middleware(['auth'])->group(function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/DaftarUser', [LoginController::class, 'index'])->name('register.index');
    Route::get('/GetDataDaftarUser', [LoginController::class, 'getData'])->name('register.getData');



    Route::get('/HomeSekolah', 'HomeController@indexSekolah')->name('site.sekolah');
    Route::get('/HomeCabdis', 'HomeController@indexCabdis')->name('site.cabdis');
    Route::get('/HomeKadis', 'HomeController@indexKadis')->name('site.kadis');
    Route::get('/HomePengawas', 'HomeController@indexPengawas')->name('site.pengawas');
    Route::get('/HomeDeveloper', 'HomeController@indexDeveloper')->name('site.developer');

    //datamaster
    Route::get('page/ListParameter', 'HomeController@ListParameter')->name('ListParameter');
    Route::get('page/ListSekolah', 'HomeController@ListSekolah')->name('ListSekolah');
    Route::get('page/GetDataSekolah', 'HomeController@GetDataSekolah')->name('GetDataSekolah');
    Route::get('page/EditSekolah/{id}', 'HomeController@EditSekolah')->name('EditSekolah');
    Route::post('page/UpdateSekolah', 'HomeController@UpdateSekolah')->name('UpdateSekolah');


    //sekolahbersih
    Route::get('sekolahbersih/index', 'SekolahBersihController@index')->name('sekolahbersih.index');
    Route::get('sekolahbersih/indexsekolah', 'SekolahBersihController@indexsekolah')->name('sekolahbersih.indexsekolah');
    Route::get('sekolahbersih/indexpengawas', 'SekolahBersihController@indexpengawas')->name('sekolahbersih.indexpengawas');
    Route::get('sekolahbersih/indexdinas', 'SekolahBersihController@indexdinas')->name('sekolahbersih.indexdinas');
    Route::get('sekolahbersih/indexValidasi', 'SekolahBersihController@indexValidasi')->name('sekolahbersih.indexValidasi');
    Route::get('sekolahbersih/indexsubmitValidasi', 'SekolahBersihController@indexsubmitValidasi')->name('sekolahbersih.indexsubmitValidasi');



    Route::get('sekolahbersih/getData', 'SekolahBersihController@getData')->name('sekolahbersih.getData');
    Route::get('sekolahbersih/getDataSekolah', 'SekolahBersihController@getDataSekolah')->name('sekolahbersih.getDataSekolah');
    Route::get('sekolahbersih/getDataPengawas', 'SekolahBersihController@getDataPengawas')->name('sekolahbersih.getDataPengawas');
    Route::get('sekolahbersih/getDataDinas', 'SekolahBersihController@getDataDinas')->name('sekolahbersih.getDataDinas');
    Route::get('sekolahbersih/getDataValidasi', 'SekolahBersihController@getDataValidasi')->name('sekolahbersih.getDataValidasi');
    Route::get('sekolahbersih/getDatasubmitValidasi', 'SekolahBersihController@getDatasubmitValidasi')->name('sekolahbersih.getDatasubmitValidasi');
    Route::get('sekolahbersih/validasi/{id}', 'SekolahBersihController@validasi')->name('sekolahbersih.validasi');


    Route::get('sekolahbersih/create/{id}', 'SekolahBersihController@create')->name('sekolahbersih.create');
    Route::post('sekolahbersih/store', 'SekolahBersihController@store')->name('sekolahbersih.store');
    Route::post('sekolahbersih/saveVerifikasi', 'SekolahBersihController@saveVerifikasi')->name('sekolahbersih.saveVerifikasi');
    Route::post('sekolahbersih/storeVerifikasi', 'SekolahBersihController@storeVerifikasi')->name('sekolahbersih.storeVerifikasi');
    Route::post('sekolahbersih/storeValidasi', 'SekolahBersihController@storeValidasi')->name('sekolahbersih.storeValidasi');

    //rekap
    Route::get('sekolahbersih/rekappengawas', 'SekolahBersihController@rekappengawas')->name('sekolahbersih.rekappengawas');
    Route::get('sekolahbersih/rekapsekolah', 'SekolahBersihController@rekapsekolah')->name('sekolahbersih.rekapsekolah');
    Route::get('sekolahbersih/getDataRekapPengawas', 'SekolahBersihController@getDataRekapPengawas')->name('sekolahbersih.getDataRekapPengawas');
    Route::get('sekolahbersih/CetakRekapPengawas', 'SekolahBersihController@CetakRekapPengawas')->name('sekolahbersih.CetakRekapPengawas');
    // Route::get('sekolahbersih/DownloadRekapPengawas', 'SekolahBersihController@DownloadRekapPengawas')->name('report.DownloadRekapPengawas');
    Route::get('sekolahbersih/getDataRekapSekolah', 'SekolahBersihController@getDataRekapSekolah')->name('sekolahbersih.getDataRekapSekolah');


    //Route::get('sekolahbersih/create/{singkatan}', 'SekolahBersihController@create')
    //    ->where('singkatan', '[A-Za-z0-9]+')  // ini sebenarnya opsional jika tanpa karakter khusus
    //    ->name('sekolahbersih.create');
    Route::delete('sekolahbersih/destroy/{id}', 'SekolahBersihController@destroy')->name('sekolahbersih.delete');
    Route::get('sekolahbersih/edit/{id}', 'SekolahBersihController@edit')->name('sekolahbersih.edit');
    Route::post('sekolahbersih/update', 'SekolahBersihController@update')->name('sekolahbersih.update');
    Route::get('sekolahbersih/verifikasi/{id}', 'SekolahBersihController@verifikasi')->name('sekolahbersih.verifikasi');
    Route::get('sekolahbersih/verifikasiPengawas/{id}', 'SekolahBersihController@verifikasiPengawas')->name('sekolahbersih.verifikasiPengawas');
    Route::get('sekolahbersih/show/{id}', 'SekolahBersihController@show')->name('sekolahbersih.show');
    Route::get('sekolahbersih/print/{id}', 'SekolahBersihController@print')->name('sekolahbersih.print');
    Route::get('sekolahbersih/printPengawas/{id}', 'SekolahBersihController@printPengawas')->name('sekolahbersih.printPengawas');
    Route::get('sekolahbersih/printCabdis/{id}', 'SekolahBersihController@printCabdis')->name('sekolahbersih.printCabdis');
    Route::get('sekolahbersih/printRekapCabdisSekolah/{id}', 'SekolahBersihController@printRekapCabdisSekolah')->name('sekolahbersih.printRekapCabdisSekolah');
    Route::get('sekolahbersih/printCabdisSekolah/{id}', 'SekolahBersihController@printCabdisSekolah')->name('sekolahbersih.printCabdisSekolah');
    Route::post('sekolahbersih/storeValidasi', 'SekolahBersihController@storeValidasi')->name('sekolahbersih.storeValidasi');
    Route::get('sekolahbersih/showValidasi/{id}', 'SekolahBersihController@showValidasi')->name('sekolahbersih.showValidasi');
    Route::get('sekolahbersih/CetakRekapPengawasPdf', 'SekolahBersihController@CetakRekapPengawasPdf')->name('sekolahbersih.CetakRekapPengawasPdf');


    //verifikator
    Route::get('verifikator/create', 'VerifikatorSekolahController@create')->name('verifikator.create');
    Route::get('verifikator/index', 'VerifikatorSekolahController@index')->name('verifikator.index');
    Route::get('verifikator/getData', 'VerifikatorSekolahController@getData')->name('verifikator.getData');
    Route::post('verifikator/store', 'VerifikatorSekolahController@store')->name('verifikator.store');
    Route::delete('verifikator/destroy/{id}', 'VerifikatorSekolahController@destroy')->name('verifikator.delete');
    Route::get('verifikator/edit/{id}', 'VerifikatorSekolahController@edit')->name('verifikator.edit');
    Route::post('verifikator/update', 'VerifikatorSekolahController@update')->name('verifikator.update');
    Route::post('verifikator/SimpanNamaJabatan', 'VerifikatorSekolahController@SimpanNamaJabatan')->name('verifikator.SimpanNamaJabatan');

    // Security Monitoring Routes (Admin Only)
    Route::prefix('admin/security')->group(function () {
        Route::get('/', [App\Http\Controllers\SecurityMonitoringController::class, 'index'])->name('security.index');
        Route::post('/user-attempts', [App\Http\Controllers\SecurityMonitoringController::class, 'getUserAttempts'])->name('security.user-attempts');
        Route::post('/ip-stats', [App\Http\Controllers\SecurityMonitoringController::class, 'getIpStatistics'])->name('security.ip-stats');
        Route::post('/unlock', [App\Http\Controllers\SecurityMonitoringController::class, 'unlockAccount'])->name('security.unlock');
        Route::post('/block-ip', [App\Http\Controllers\SecurityMonitoringController::class, 'blockIpAddress'])->name('security.block-ip');
        Route::get('/export', [App\Http\Controllers\SecurityMonitoringController::class, 'export'])->name('security.export');
    });

});