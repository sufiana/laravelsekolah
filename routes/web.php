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


//beban
Route::get('beban/index', 'BebanController@index')->name('beban.index');
Route::get('beban/create', 'BebanController@create')->name('beban.create');
Route::get('beban/getData', 'BebanController@getData')->name('beban.getData');
Route::delete('beban/destroy/{id}', 'BebanController@destroy')->name('beban.delete');
Route::post('beban/store', 'BebanController@store')->name('beban.simpan');
Route::get('beban/edit/{id}', 'BebanController@edit')->name('beban.edit');
Route::put('beban/update/{id}','BebanController@update')->name('beban.update');
Route::get('beban/show/{id}','BebanController@show')->name('beban.show');



//angkutan
Route::get('angkutan/index', 'JenisAngkutanController@index')->name('angkutan.index');
Route::get('angkutan/create', 'JenisAngkutanController@create')->name('angkutan.create');
Route::get('angkutan/getData', 'JenisAngkutanController@getData')->name('angkutan.getData');
Route::delete('angkutan/destroy/{id}', 'JenisAngkutanController@destroy')->name('angkutan.delete');
Route::post('angkutan/store', 'JenisAngkutanController@store')->name('angkutan.simpan');
Route::get('angkutan/edit/{id}', 'JenisAngkutanController@edit')->name('angkutan.edit');
Route::put('angkutan/update/{id}','JenisAngkutanController@update')->name('angkutan.update');
Route::get('angkutan/show/{id}','JenisAngkutanController@show')->name('angkutan.show');

//kegiatan
//tidak terpakai
//Route::get('kegiatan/index', 'JenisKegiatanController@index')->name('kegiatan.index');
//Route::get('kegiatan/create', 'JenisKegiatanController@create')->name('kegiatan.create');
//Route::get('kegiatan/getData', 'JenisKegiatanController@getData')->name('kegiatan.getData');
//Route::delete('kegiatan/destroy/{id}', 'JenisKegiatanController@destroy')->name('kegiatan.delete');
//Route::post('kegiatan/store', 'JenisKegiatanController@store')->name('kegiatan.simpan');
//Route::get('kegiatan/edit/{id}', 'JenisKegiatanController@edit')->name('kegiatan.edit');
//Route::put('kegiatan/update/{id}','JenisKegiatanController@update')->name('kegiatan.update');
//Route::get('kegiatan/show/{id}','JenisKegiatanController@show')->name('kegiatan.show');


//transportasi
Route::get('transportasi/index', 'JenisTransportasiController@index')->name('transportasi.index');
Route::get('transportasi/create', 'JenisTransportasiController@create')->name('transportasi.create');
Route::get('transportasi/getData', 'JenisTransportasiController@getData')->name('transportasi.getData');
Route::delete('transportasi/destroy/{id}', 'JenisTransportasiController@destroy')->name('transportasi.delete');
Route::post('transportasi/store', 'JenisTransportasiController@store')->name('transportasi.simpan');
Route::get('transportasi/edit/{id}', 'JenisTransportasiController@edit')->name('transportasi.edit');
Route::put('transportasi/update/{id}','JenisTransportasiController@update')->name('transportasi.update');
Route::get('transportasi/show/{id}','JenisTransportasiController@show')->name('transportasi.show');

//jenis biaya
Route::get('jenisbiaya/index', 'RefJenisBiayaController@index')->name('jenisbiaya.index');
Route::get('jenisbiaya/create', 'RefJenisBiayaController@create')->name('jenisbiaya.create');
Route::get('jenisbiaya/getData', 'RefJenisBiayaController@getData')->name('jenisbiaya.getData');
Route::delete('jenisbiaya/destroy/{id}', 'RefJenisBiayaController@destroy')->name('jenisbiaya.delete');
Route::post('jenisbiaya/store', 'RefJenisBiayaController@store')->name('jenisbiaya.simpan');
Route::get('jenisbiaya/edit/{id}', 'RefJenisBiayaController@edit')->name('jenisbiaya.edit');
Route::put('jenisbiaya/update/{id}','RefJenisBiayaController@update')->name('jenisbiaya.update');
Route::get('jenisbiaya/show/{id}','RefJenisBiayaController@show')->name('jenisbiaya.show');

//statuswilayahbiaya
Route::get('statuswilayahbiaya/index', 'RefStatusWilayahBiayaController@index')->name('statuswilayahbiaya.index');
Route::get('statuswilayahbiaya/create', 'RefStatusWilayahBiayaController@create')->name('statuswilayahbiaya.create');
Route::get('statuswilayahbiaya/getData', 'RefStatusWilayahBiayaController@getData')->name('statuswilayahbiaya.getData');
Route::delete('statuswilayahbiaya/destroy/{id}', 'RefStatusWilayahBiayaController@destroy')->name('statuswilayahbiaya.delete');
Route::post('statuswilayahbiaya/store', 'RefStatusWilayahBiayaController@store')->name('statuswilayahbiaya.simpan');
Route::get('statuswilayahbiaya/edit/{id}', 'RefStatusWilayahBiayaController@edit')->name('statuswilayahbiaya.edit');
Route::put('statuswilayahbiaya/update/{id}','RefStatusWilayahBiayaController@update')->name('statuswilayahbiaya.update');
Route::get('statuswilayahbiaya/show/{id}','RefStatusWilayahBiayaController@show')->name('statuswilayahbiaya.show');

//rekening
Route::get('rekening/index', 'RekeningController@index')->name('rekening.index');
Route::get('rekening/create', 'RekeningController@create')->name('rekening.create');
Route::get('rekening/getData', 'RekeningController@getData')->name('rekening.getData');
Route::delete('rekening/destroy/{id}', 'RekeningController@destroy')->name('rekening.delete');
Route::post('rekening/store', 'RekeningController@store')->name('rekening.simpan');
Route::get('rekening/edit/{id}', 'RekeningController@edit')->name('rekening.edit');
Route::put('rekening/update/{id}','RekeningController@update')->name('rekening.update');
Route::get('rekening/show/{id}','RekeningController@show')->name('rekening.show');

//NPPD
Route::get('nppd/index', 'NppdController@index')->name('nppd.index');
Route::get('nppd/create', 'NppdController@create')->name('nppd.create');
Route::get('nppd/getData', 'NppdController@getData')->name('nppd.getData');
Route::delete('nppd/destroy/{id}', 'NppdController@destroy')->name('nppd.delete');
Route::post('nppd/store', 'NppdController@store')->name('nppd.simpan');
Route::get('nppd/edit/{id}', 'NppdController@edit')->name('nppd.edit');
Route::put('nppd/update/{id}','NppdController@update')->name('nppd.update');
Route::get('nppd/show/{id}','NppdController@show')->name('nppd.show');
Route::get('nppd/getKabupatenkota/{id}','NppdController@getKabupatenkota')->name('nppd.getKabupatenkota');
Route::get('nppd/getKecamatan/{id}','NppdController@getKecamatan')->name('nppd.getKecamatan');
Route::get('nppd/getKelurahan/{id}','NppdController@getKelurahan')->name('nppd.getKelurahan');
Route::get('nppd/cetak/{id}','NppdController@cetak')->name('nppd.cetak');


//spt

Route::get('spt/index', 'SptController@index')->name('spt.index');
Route::get('spt/Sptditerima', 'SptController@indexsptditerima')->name('spt.indexsptditerima');
Route::get('spt/getsptditerima', 'SptController@getsptditerima')->name('spt.getsptditerima');
Route::get('spt/Sptditolak', 'SptController@indexsptditolak')->name('spt.indexsptditolak');
Route::get('spt/getsptditolak', 'SptController@getsptditolak')->name('spt.getsptditolak');
Route::get('spt/dasarSptGet/{id}', 'SptController@dasarSptGet')->name('spt.dasarSptGet');
Route::get('spt/create', 'SptController@create')->name('spt.create');
Route::get('spt/createSppd/{id}', 'SptController@createSppd')->name('spt.createSppd');
Route::get('spt/getData', 'SptController@getData')->name('spt.getData');
Route::get('spt/cekjadwalspt', 'SptController@cekjadwalspt')->name('spt.cekjadwalspt');
Route::get('spt/cekjadwalsptupdate', 'SptController@cekjadwalsptupdate')->name('spt.cekjadwalsptupdate');
Route::get('spt/SetSelectedValue', 'SptController@SetSelectedValue')->name('spt.SetSelectedValue');
Route::get('spt/cekjadwalsptmodalgrid', 'SptController@cekjadwalsptmodalgrid')->name('spt.cekjadwalsptmodalgrid');
Route::delete('spt/destroy/{id}', 'SptController@destroy')->name('spt.delete');
Route::post('spt/store', 'SptController@store')->name('spt.simpan');
Route::get('spt/edit/{id}', 'SptController@edit')->name('spt.edit');
//Route::put('spt/update/{id}','SptController@update')->name('spt.update');
Route::post('spt/update','SptController@update')->name('spt.update');
Route::post('spt/updatenospt','SptController@updatenospt')->name('spt.updatenospt');

Route::get('spt/show/{id}','SptController@show')->name('spt.show');
Route::get('spt/getKabupatenkota/{id}','SptController@getKabupatenkota')->name('spt.getKabupatenkota');
Route::get('spt/getKecamatan/{id}','SptController@getKecamatan')->name('spt.getKecamatan');
Route::get('spt/getKelurahan/{id}','SptController@getKelurahan')->name('spt.getKelurahan');
Route::get('spt/getKegiatan/{id}','SptController@getKegiatan')->name('spt.getKegiatan');
Route::get('spt/getsubkegiatan/{id}','SptController@getsubkegiatan')->name('spt.getsubkegiatan');
Route::get('spt/cetak/{id}','SptController@cetak')->name('spt.cetak');
Route::get('spt/cetakword/{id}','SptController@cetakword')->name('spt.cetakword');
Route::get('spt/cetakspd/{id}','SptController@cetakspd')->name('spt.cetakspd');
Route::get('spt/show/{id}','SptController@show')->name('spt.show');
Route::get('spt/editmodal/{id}', 'SptController@editmodal')->name('spt.editmodal');
Route::put('spt/updatemodal/{id}','SptController@updatemodal')->name('spt.updatemodal');
Route::put('spt/reset/{id}','SptController@reset')->name('spt.reset');

//SPPD
Route::get('sppd/index', 'SppdController@index')->name('sppd.index');
Route::get('sppd/indexLaporan', 'SppdController@indexLaporan')->name('sppd.indexLaporan');
Route::get('sppd/indexTandaTerima', 'SppdController@indexTandaTerima')->name('sppd.indexTandaTerima');
Route::get('sppd/indexKwitansi', 'SppdController@indexKwitansi')->name('sppd.indexKwitansi');
Route::get('sppd/List', 'SppdController@List')->name('sppd.List');
Route::get('sppd/getList', 'SppdController@getList')->name('sppd.getList');
Route::get('sppd/getData', 'SppdController@getData')->name('sppd.getData');
Route::get('sppd/getTandaTerima', 'SppdController@getTandaTerima')->name('sppd.getTandaTerima');
Route::get('sppd/getLaporan', 'SppdController@getLaporan')->name('sppd.getLaporan');
Route::get('sppd/getKwitansi', 'SppdController@getKwitansi')->name('sppd.getKwitansi');
Route::get('sppd/create', 'SppdController@create')->name('sppd.create');
Route::get('sppd/createlaporan', 'SppdController@createlaporan')->name('sppd.createlaporan');
Route::get('sppd/getDataFormTtdt/{id}', 'SppdController@getDataFormTtd')->name('sppd.getDataFormTtd');
Route::get('sppd/getDataAbsensi/{id}', 'SppdController@getDataAbsensi')->name('sppd.getDataAbsensi');
Route::get('sppd/createtandaterima', 'SppdController@createtandaterima')->name('sppd.createtandaterima');
Route::get('sppd/createkwitansi', 'SppdController@createkwitansi')->name('sppd.createkwitansi');
Route::get('sppd/getSpt/{id}','SppdController@getSpt')->name('sppd.getSpt');
Route::get('sppd/getSptLaporan/{id}','SppdController@getSptLaporan')->name('sppd.getSptLaporan');
Route::get('sppd/getSptTandaTerima/{id}','SppdController@getSptTandaTerima')->name('sppd.getSptTandaTerima');
Route::get('sppd/getSptKwitansi/{id}','SppdController@getSptKwitansi')->name('sppd.getSptKwitansi');
Route::get('sppd/generateSppdLuar/{id}','SppdController@generateSppdLuar')->name('sppd.generateSppdLuar');
Route::post('sppd/store', 'SppdController@store')->name('sppd.simpan');
Route::delete('sppd/destroy/{id}', 'SppdController@destroy')->name('sppd.delete');
Route::delete('sppd/hapusSppdLuarwilayah/{id}', 'SppdController@hapusSppdLuarwilayah')->name('sppd.hapusSppdLuarwilayah');
Route::delete('sppd/hapusFormTtd/{id}', 'SppdController@hapusFormTtd')->name('sppd.hapusFormTtd');
Route::get('sppd/cetak/{id}','SppdController@cetak')->name('sppd.cetak');
Route::get('sppd/CetakLaporan/{id}','SppdController@CetakLaporan')->name('sppd.CetakLaporan');
Route::get('sppd/CetakTandaTerima/{id}','SppdController@CetakTandaTerima')->name('sppd.CetakTandaTerima');
Route::get('sppd/CetakKwitansi/{id}','SppdController@CetakKwitansi')->name('sppd.CetakKwitansi');
Route::get('sppd/show/{id}','SppdController@show')->name('sppd.show');
Route::get('sppd/edit/{id}', 'SppdController@edit')->name('sppd.edit');
Route::post('sppd/update','SppdController@update')->name('sppd.update');
Route::post('sppd/SimpanLaporan','SppdController@SimpanLaporan')->name('sppd.SimpanLaporan');
Route::post('sppd/Simpantandaterima','SppdController@Simpantandaterima')->name('sppd.Simpantandaterima');
Route::post('sppd/Simpantandaterimaluardaerah','SppdController@Simpantandaterimaluardaerah')->name('sppd.Simpantandaterimaluardaerah');
Route::post('sppd/Simpantandaterimachild','SppdController@Simpantandaterimachild')->name('sppd.Simpantandaterimachild');
Route::post('sppd/SimpanKwitansi','SppdController@SimpanKwitansi')->name('sppd.SimpanKwitansi');
Route::post('sppd/SimpanAbsensi','SppdController@SimpanAbsensi')->name('sppd.SimpanAbsensi');
Route::post('sppd/SimpanAbsensiSpt','SppdController@SimpanAbsensiSpt')->name('sppd.SimpanAbsensiSpt');
Route::post('sppd/simpanformttd','SppdController@simpanformttd')->name('sppd.simpanformttd');
Route::post('sppd/saveDocument','SppdController@saveDocument')->name('sppd.saveDocument');

Route::get('sppd/BuatLaporan/{id}', 'SppdController@BuatLaporan')->name('sppd.BuatLaporan');
Route::get('sppd/BuatTandaTerima/{id}', 'SppdController@BuatTandaTerima')->name('sppd.BuatTandaTerima');
Route::get('sppd/Buat/{id}', 'SppdController@Buat')->name('sppd.Buat');
Route::get('sppd/TerbitkanTandaTerima/{id}', 'SppdController@TerbitkanTandaTerima')->name('sppd.TerbitkanTandaTerima');
Route::get('sppd/BuatTerbitkanTandaTerima/{id}', 'SppdController@BuatTerbitkanTandaTerima')->name('sppd.BuatTerbitkanTandaTerima');
Route::get('sppd/BuatTerbitkanKwitansi/{id}', 'SppdController@BuatTerbitkanKwitansi')->name('sppd.BuatTerbitkanKwitansi');
Route::get('sppd/Absensi/{id}', 'SppdController@Absensi')->name('sppd.Absensi');
Route::post('sppd/upload', 'SppdController@upload')->name('sppd.upload');
Route::post('sppd/PencarianSptTandaterima', 'SppdController@PencarianSptTandaterima')->name('sppd.PencarianSptTandaterima');
Route::post('sppd/PencarianKwitansi', 'SppdController@PencarianKwitansi')->name('sppd.PencarianKwitansi');

//verif sppd
Route::get('sppd/editmodal/{id}', 'SppdController@editmodal')->name('sppd.editmodal');
Route::put('sppd/VerifikasiSppd/{id}','SppdController@VerifikasiSppd')->name('sppd.VerifikasiSppd');
Route::put('sppd/VerifikasiLaporan/{id}','SppdController@VerifikasiLaporan')->name('sppd.VerifikasiLaporan');
Route::put('sppd/VerifikasiTandaterima/{id}','SppdController@VerifikasiTandaterima')->name('sppd.VerifikasiTandaterima');

//dropzone
Route::post('sppd/upload', 'SppdController@uploads')->name('dropzone.upload');
Route::get('sppd/fetch/{id}', 'SppdController@fetch')->name('dropzone.fetch');
Route::get('sppd/delete', 'SppdController@delete')->name('dropzone.delete');
Route::get('sppd/datapersonal/{id}/{idsppd}/{jenis}','SppdController@datapersonal' )->name('sppd.datapersonal');
Route::get('sppd/getDatagridBiaya/{id}', 'SppdController@getDatagridBiaya')->name('sppd.getDatagridBiaya');


//tante
Route::post('sppd/storemodal', 'SppdController@storemodal')->name('sppd.storemodal');



//lokasi

//provinsi
Route::get('provinsi/index', 'ProvinsiController@index')->name('provinsi.index');
Route::get('provinsi/getData', 'ProvinsiController@getData')->name('provinsi.getData');

//kabupatenkota
Route::get('kabupatenkota/index', 'KabkotaController@index')->name('kabupatenkota.index');
Route::get('kabupatenkota/getData', 'KabkotaController@getData')->name('kabupatenkota.getData');

//kecamatan
Route::get('kecamatan/index', 'KecamatanController@index')->name('kecamatan.index');
Route::get('kecamatan/getData', 'KecamatanController@getData')->name('kecamatan.getData');

//kelurahan
Route::get('kelurahan/index', 'KelurahanController@index')->name('kelurahan.index');
Route::get('kelurahan/getData', 'KelurahanController@getData')->name('kelurahan.getData');

//program
Route::get('program/index', 'ProgramController@index')->name('program.index');
Route::get('program/create', 'ProgramController@create')->name('program.create');
Route::get('program/getData', 'ProgramController@getData')->name('program.getData');
Route::delete('program/destroy/{id}', 'ProgramController@destroy')->name('program.delete');
Route::post('program/store', 'ProgramController@store')->name('program.simpan');
Route::get('program/edit/{id}', 'ProgramController@edit')->name('program.edit');
Route::put('program/update/{id}','ProgramController@update')->name('program.update');
Route::get('program/show/{id}','ProgramController@show')->name('program.show');

//programkegiatan
Route::get('programkegiatan/index', 'KegiatanController@index')->name('programkegiatan.index');
Route::get('programkegiatan/create', 'KegiatanController@create')->name('programkegiatan.create');
Route::get('programkegiatan/getData', 'KegiatanController@getData')->name('programkegiatan.getData');
Route::delete('programkegiatan/destroy/{id}', 'KegiatanController@destroy')->name('programkegiatan.delete');
Route::post('programkegiatan/store', 'KegiatanController@store')->name('programkegiatan.simpan');
Route::get('programkegiatan/edit/{id}', 'KegiatanController@edit')->name('programkegiatan.edit');
Route::put('programkegiatan/update/{id}','KegiatanController@update')->name('programkegiatan.update');
Route::get('programkegiatan/show/{id}','KegiatanController@show')->name('programkegiatan.show');
Route::get('programkegiatan/getProgram/{id}','KegiatanController@getProgram')->name('programkegiatan.getProgram');
Route::get('programkegiatan/getProgramKegiatan/{id}','KegiatanController@getProgramKegiatan')->name('programkegiatan.getProgramKegiatan');


//subkegiatan
Route::get('subkegiatan/index', 'SubKegiatanController@index')->name('subkegiatan.index');
Route::get('subkegiatan/create', 'SubKegiatanController@create')->name('subkegiatan.create');
Route::get('subkegiatan/getData', 'SubKegiatanController@getData')->name('subkegiatan.getData');
Route::delete('subkegiatan/destroy/{id}', 'SubKegiatanController@destroy')->name('subkegiatan.delete');
Route::post('subkegiatan/store', 'SubKegiatanController@store')->name('subkegiatan.simpan');
Route::get('subkegiatan/edit/{id}', 'SubKegiatanController@edit')->name('subkegiatan.edit');
Route::put('subkegiatan/update/{id}','SubKegiatanController@update')->name('subkegiatan.update');
Route::get('subkegiatan/show/{id}','SubKegiatanController@show')->name('subkegiatan.show');
Route::get('subkegiatan/getProgramKegiatan/{id}','SubKegiatanController@getProgramKegiatan')->name('subkegiatan.getProgramKegiatan');


//ref pegawai
//ref agama
Route::get('agama/index', 'RefAgamaController@index')->name('agama.index');
//Route::get('agama/create', 'RefAgamaController@create')->name('agama.create');
Route::get('agama/getData', 'RefAgamaController@getData')->name('agama.getData');
Route::delete('agama/destroy/{id}', 'RefAgamaController@destroy')->name('agama.delete');
//Route::post('agama/store', 'RefAgamaController@store')->name('agama.simpan');
//Route::get('agama/edit/{id}', 'RefAgamaController@edit')->name('agama.edit');
//Route::put('agama/update/{id}','RefAgamaController@update')->name('agama.update');
//Route::get('agama/show/{id}','RefAgamaController@show')->name('agama.show');

//ref pendidikan
Route::get('pendidikan/index', 'RefPendidikanController@index')->name('pendidikan.index');
//Route::get('pendidikan/create', 'RefPendidikanController@create')->name('pendidikan.create');
Route::get('pendidikan/getData', 'RefPendidikanController@getData')->name('pendidikan.getData');
Route::delete('pendidikan/destroy/{id}', 'RefPendidikanController@destroy')->name('pendidikan.delete');
//Route::post('pendidikan/store', 'RefPendidikanController@store')->name('pendidikan.simpan');
//Route::get('pendidikan/edit/{id}', 'RefPendidikanController@edit')->name('pendidikan.edit');
//Route::put('pendidikan/update/{id}','RefPendidikanController@update')->name('pendidikan.update');
//Route::get('pendidikan/show/{id}','RefPendidikanController@show')->name('pendidikan.show');

//refstatusjabatan
Route::get('statusjabatan/index', 'RefStatusJabatanController@index')->name('statusjabatan.index');
//Route::get('statusjabatan/create', 'RefStatusJabatanController@create')->name('statusjabatan.create');
Route::get('statusjabatan/getData', 'RefStatusJabatanController@getData')->name('statusjabatan.getData');
Route::delete('statusjabatan/destroy/{id}', 'RefStatusJabatanController@destroy')->name('statusjabatan.delete');
//Route::post('statusjabatan/store', 'RefStatusJabatanController@store')->name('statusjabatan.simpan');
//Route::get('statusjabatan/edit/{id}', 'RefStatusJabatanController@edit')->name('statusjabatan.edit');
//Route::put('statusjabatan/update/{id}','RefStatusJabatanController@update')->name('statusjabatan.update');
//Route::get('statusjabatan/show/{id}','RefStatusJabatanController@show')->name('statusjabatan.show');

//Ref Golongan
Route::get('golongan/index', 'RefGolonganController@index')->name('golongan.index');
Route::get('golongan/create', 'RefGolonganController@create')->name('golongan.create');
Route::get('golongan/getData', 'RefGolonganController@getData')->name('golongan.getData');
Route::delete('golongan/destroy/{id}', 'RefGolonganController@destroy')->name('golongan.delete');
Route::post('golongan/store', 'RefGolonganController@store')->name('golongan.simpan');
Route::get('golongan/edit/{id}', 'RefGolonganController@edit')->name('golongan.edit');
Route::put('golongan/update/{id}','RefGolonganController@update')->name('golongan.update');
Route::get('golongan/show/{id}','RefGolonganController@show')->name('golongan.show');

//Ref Pangkat
Route::get('pangkat/index', 'RefPangkatController@index')->name('pangkat.index');
Route::get('pangkat/create', 'RefPangkatController@create')->name('pangkat.create');
Route::get('pangkat/getData', 'RefPangkatController@getData')->name('pangkat.getData');
Route::delete('pangkat/destroy/{id}', 'RefPangkatController@destroy')->name('pangkat.delete');
Route::post('pangkat/store', 'RefPangkatController@store')->name('pangkat.simpan');
Route::get('pangkat/edit/{id}', 'RefPangkatController@edit')->name('pangkat.edit');
Route::put('pangkat/update/{id}','RefPangkatController@update')->name('pangkat.update');
Route::get('pangkat/show/{id}','RefPangkatController@show')->name('pangkat.show');

//Ref Status Pegawai
Route::get('statuspegawai/index', 'RefStatusPegawaiController@index')->name('statuspegawai.index');
Route::get('statuspegawai/create', 'RefStatusPegawaiController@create')->name('statuspegawai.create');
Route::get('statuspegawai/getData', 'RefStatusPegawaiController@getData')->name('statuspegawai.getData');
Route::delete('statuspegawai/destroy/{id}', 'RefStatusPegawaiController@destroy')->name('statuspegawai.delete');
Route::post('statuspegawai/store', 'RefStatusPegawaiController@store')->name('statuspegawai.simpan');
Route::get('statuspegawai/edit/{id}', 'RefStatusPegawaiController@edit')->name('statuspegawai.edit');
Route::put('statuspegawai/update/{id}','RefStatusPegawaiController@update')->name('statuspegawai.update');
Route::get('statuspegawai/show/{id}','RefStatusPegawaiController@show')->name('statuspegawai.show');


//eselon
Route::get('eselon/index', 'RefEselonController@index')->name('eselon.index');
Route::get('eselon/create', 'RefEselonController@create')->name('eselon.create');
Route::get('eselon/getData', 'RefEselonController@getData')->name('eselon.getData');
Route::delete('eselon/destroy/{id}', 'RefEselonController@destroy')->name('eselon.delete');
Route::post('eselon/store', 'RefEselonController@store')->name('eselon.simpan');
Route::get('eselon/edit/{id}', 'RefEselonController@edit')->name('eselon.edit');
Route::put('eselon/update/{id}','RefEselonController@update')->name('eselon.update');
Route::get('eselon/show/{id}','RefEselonController@show')->name('eselon.show');

//Ref Jabatan
Route::get('jabatan/index', 'RefJabatanController@index')->name('jabatan.index');
Route::get('jabatan/create', 'RefJabatanController@create')->name('jabatan.create');
Route::get('jabatan/getData', 'RefJabatanController@getData')->name('jabatan.getData');
Route::delete('jabatan/destroy/{id}', 'RefJabatanController@destroy')->name('jabatan.delete');
Route::post('jabatan/store', 'RefJabatanController@store')->name('jabatan.simpan');
Route::get('jabatan/edit/{id}', 'RefJabatanController@edit')->name('jabatan.edit');
Route::put('jabatan/update/{id}','RefJabatanController@update')->name('jabatan.update');
Route::get('jabatan/show/{id}','RefJabatanController@show')->name('jabatan.show');

//Ref jabatanttd
Route::get('jabatanttd/index', 'RefJabatanTtdController@index')->name('jabatanttd.index');
Route::get('jabatanttd/create', 'RefJabatanTtdController@create')->name('jabatanttd.create');
Route::get('jabatanttd/getData', 'RefJabatanTtdController@getData')->name('jabatanttd.getData');
Route::delete('jabatanttd/destroy/{id}', 'RefJabatanTtdController@destroy')->name('jabatanttd.delete');
Route::post('jabatanttd/store', 'RefJabatanTtdController@store')->name('jabatanttd.simpan');
Route::get('jabatanttd/edit/{id}', 'RefJabatanTtdController@edit')->name('jabatanttd.edit');
Route::put('jabatanttd/update/{id}','RefJabatanTtdController@update')->name('jabatanttd.update');
Route::get('jabatanttd/show/{id}','RefJabatanTtdController@show')->name('jabatanttd.show');


//Ref pejabatttd
Route::get('pejabatttd/index', 'PejabatTtdController@index')->name('pejabatttd.index');
Route::get('pejabatttd/create', 'PejabatTtdController@create')->name('pejabatttd.create');
Route::get('pejabatttd/getData', 'PejabatTtdController@getData')->name('pejabatttd.getData');
Route::delete('pejabatttd/destroy/{id}', 'PejabatTtdController@destroy')->name('pejabatttd.delete');
Route::post('pejabatttd/store', 'PejabatTtdController@store')->name('pejabatttd.simpan');
Route::get('pejabatttd/edit/{id}', 'PejabatTtdController@edit')->name('pejabatttd.edit');
Route::put('pejabatttd/update/{id}','PejabatTtdController@update')->name('pejabatttd.update');
Route::get('pejabatttd/show/{id}','PejabatTtdController@show')->name('pejabatttd.show');


//pegawai
Route::get('pegawai/index', 'PegawaiController@index')->name('pegawai.index');
Route::get('pegawai/create', 'PegawaiController@create')->name('pegawai.create');
Route::get('pegawai/getData', 'PegawaiController@getData')->name('pegawai.getData');
Route::delete('pegawai/destroy/{id}', 'PegawaiController@destroy')->name('pegawai.delete');
Route::post('pegawai/store', 'PegawaiController@store')->name('pegawai.simpan');
Route::get('pegawai/edit/{id}', 'PegawaiController@edit')->name('pegawai.edit');
Route::post('pegawai/update','PegawaiController@update')->name('pegawai.update');
//Route::post('pegawai/update/{id}', 'PegawaiController@update')->name('pegawai.update');

Route::get('pegawai/show/{id}','PegawaiController@show')->name('pegawai.show');
Route::get('pegawai/show/{id}','PegawaiController@show')->name('pegawai.show');

//biaya
Route::get('biaya/index', 'ManajemenBiayaController@index')->name('biaya.index');
Route::get('biaya/create', 'ManajemenBiayaController@create')->name('biaya.create');
Route::get('biaya/getData', 'ManajemenBiayaController@getData')->name('biaya.getData');
Route::delete('biaya/destroy/{id}', 'ManajemenBiayaController@destroy')->name('biaya.delete');
Route::post('biaya/store', 'ManajemenBiayaController@store')->name('biaya.simpan');
Route::get('biaya/edit/{id}', 'ManajemenBiayaController@edit')->name('biaya.edit');
Route::post('biaya/update','ManajemenBiayaController@update')->name('biaya.update');
//Route::post('biaya/update/{id}', 'ManajemenBiayaController@update')->name('biaya.update');
Route::get('biaya/show/{id}','ManajemenBiayaController@show')->name('biaya.show');
