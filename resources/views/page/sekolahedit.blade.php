@extends('layouts/master')
@section('title','Sekolah')
@section('content')
<style>
    .form-group {
        margin-bottom: 10px;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><span><a href="{{ route('ListSekolah') }}"><i class="fa fa-list"></i> Data @yield('title')</a></span></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Edit @yield('title')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="float-left">Edit @yield('title')</h2>
                        <a href="{{ route('ListSekolah') }}" class="btn btn-success float-right">
                            <i class="fa fa-list"></i> Data @yield('title')
                        </a>
                    </header>

                    <div class="main-box-body clearfix">
                        <i>Bagian Bertanda <span class="wajib"></span> wajib diisi</i><br/><br/>

                        @if ($message = Session::get('berhasil'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil </strong>Data @yield('title') Berhasil Di Edit
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form role="form" method="POST" action="{{ route('UpdateSekolah') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{$model->id}}">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Nama <span class="wajib"></span></label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{old('nama',$model->nama)}}" required>
                                </div>
                                <div class="form-group col-6">
                                    <label>NPSN <span class="wajib"></span></label>
                                    <input type="text" class="form-control" id="npsn" name="npsn" value="{{old('npsn',$model->npsn)}}" required>

                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Alamat <span class="wajib"></span></label>
                                    <input type="text" class="form-control" id="alamat_jalan" name="alamat_jalan" value="{{old('alamat_jalan',$model->alamat_jalan)}}" required>
                                </div>
                                <div class="form-group col-6">
                                    <label>Kabupaten / Kota <span class="wajib"></span></label>
                                    <select name="kabupaten_kota" id="kabupaten_kota" class="form-control select2" required>
                                      <option value="">== Pilih Kabupaten / Kota ==</option>
                                      @foreach ($kabupaten as $png)
                                        <option value="{{ $png->kode_kabupaten }}"
                                          {{ (old('kabupaten_kota', $model->kabupaten_kota) == $png->kode_kabupaten) ? 'selected' : '' }}>
                                          {{ $png->kode_kabupaten . ' - ' . $png->nama_kabupaten }}
                                        </option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Bentuk Pendidikan <span class="wajib"></span></label>
                                    <select name="bentuk_pendidikan_id" id="bentuk_pendidikan_id" class="form-control select2" required>
                                        <option value="">== Pilih Bentuk Pendidikan ==</option>
                                        <option value=1>Negeri</option>
                                        <option value=2>SWASTA</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Telepon <span class="wajib"></span></label>
                                    <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="{{old('nomor_telepon',$model->nomor_telepon)}}" required>
                                </div>
                            </div>
                            
                         
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Email <span class="wajib"></span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{old('email',$model->email)}}" required>
                                </div>
                                <div class="form-group col-6">
                                    <label>Website <span class="wajib"></span></label>
                                    <input type="text" class="form-control" id="website" name="website" value="{{old('website',$model->website)}}" required>
                                </div>
                            </div>                          
                            
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Koordinat <span class="wajib"></span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-primary" type="button" onclick="openMap()">Tentukan Koordinat</button>
                                        </div>
                                        <input type="text" class="form-control" id="koordinat" name="koordinat"
                                            value="{{ old('koordinat', trim($model->lintang . ($model->lintang && $model->bujur ? ',' : '') . $model->bujur, ',')) }}">
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Nama Kepala Sekolah <span class="wajib"></span></label>
                                    <input type="text" class="form-control" id="kepalasekolah" name="kepalasekolah" value="{{old('kepalasekolah',$model->kepalasekolah)}}" required>
                                </div>
                            </div>                    
                            
                            <div class="form-group text-center">
                                <button class="btn btn-primary tambah" type="submit">Simpan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Maps -->
<div id="mapModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999;">
    <div style="width:80%; height:80%; background:#fff; margin:5% auto; position:relative; border-radius:8px; overflow:hidden;">
        <div id="map" style="width:100%; height:100%;"></div>
        <button onclick="closeMap()" style="position:absolute; top:10px; right:10px; z-index:1000;">Tutup</button>
    </div>
</div>

@endsection


@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endsection

@section('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
document.getElementById('email').addEventListener('input', function() {
    const email = this.value.trim();
    const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    document.getElementById('emailError').textContent = email && !valid ? 'Email tidak valid' : '';
});

let map, marker;

function openMap() {
    document.getElementById('mapModal').style.display = 'block';

    // Inisialisasi peta jika belum ada
    if (!map) {
        map = L.map('map').setView([-2.5489, 118.0149], 5);

        // Tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // 🔍 Tambahkan geocoder (search box)
        const geocoder = L.Control.geocoder({
            position: 'topleft',
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(e) {
            const latlng = e.geocode.center;
            setMarker(latlng.lat, latlng.lng);
            map.setView(latlng, 15);
        })
        .addTo(map);

        // Klik di peta untuk set marker
        map.on('click', function(e) {
            setMarker(e.latlng.lat, e.latlng.lng);
        });
    }

    // Penting: resize peta karena modal mungkin disembunyikan
    setTimeout(() => {
        map.invalidateSize();
    }, 300);
}

function closeMap() {
    document.getElementById('mapModal').style.display = 'none';
}

function setMarker(lat, lng) {
    if (marker) {
        map.removeLayer(marker);
    }
    marker = L.marker([lat, lng]).addTo(map);
    document.getElementById('koordinat').value = lat.toFixed(6) + "," + lng.toFixed(6);
}
</script>
@endsection