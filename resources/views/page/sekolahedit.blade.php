@extends('layouts/master')
@section('title','Sekolah')
@section('content')
<style>
    .form-group {
        margin-bottom: 10px;
    }
</style>

<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Edit Data @yield('title')</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><span>@yield('title')</span></li>
        </ol>
      </div>
    </div>
  </div>
</div>


<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="cursor: move; color: white; background-color: #3e5879">
                <h3 class="card-title">Edit @yield('title')</h3>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
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
                            <select name="kabupaten_kota" id="kabupaten_kota" class="form-control form-select" required>
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
                            <label>Cabdis<span class="wajib"></span></label>
                            <select name="cabdis" id="cabdis" class="form-control select2" required>
                                <option value="">== Pilih Cabdis ==</option>
                                    @foreach ($cabdis as $c)
                                        <option value="{{ $c->id }}"
                                            {{ (old('cabdis', $model->cabdis) == $c->id) ? 'selected' : '' }}>
                                            {{ $c->nama }}
                                        </option>
                                    @endforeach
                            </select>
                        </div>
                         <div class="form-group col-6">
                            <label>Kepala Sekolah <span class="wajib"></span></label>
                            <input type="text" class="form-control" id="kepalasekolah" name="kepalasekolah" value="{{old('kepalasekolah',$model->kepalasekolah)}}" required>
                        </div>                        
                    </div>
                    
                    
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Email <span class="wajib"></span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email',$model->email)}}" required>
                        </div>
                        <div class="form-group col-6">
                            <label>Website <span class="wajib"></span></label>
                            <input type="text" class="form-control" id="website" name="website" value="{{old('website',$model->website)}}">
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
                            <label>Telepon <span class="wajib"></span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">WA & Telegram</span>
                                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="{{old('nomor_telepon',$model->nomor_telepon)}}" required>
                            </div>
                        </div>                       
                    </div>   
                    
                    <div class="row mb-3">
                        <label>Pilih Instrumen yang tersedia di sekolah ini</label>
                        <div class="row">                            
                            @foreach($daftarInstrumen as $i)
                                <div class="col-md-6 col-12 mb-2">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input required-checkbox" 
                                            type="checkbox" 
                                            name="instrumen[]" 
                                            value="{{ $i->id }}" 
                                            id="instrumen_{{ $i->id }}"
                                            {{ in_array($i->id, $selectedInstrumen) ? 'checked' : '' }}
                                            @if(in_array($i->id, [1,2,3,4])) data-required="true" @endif
                                        >
                                        <label class="form-check-label" for="instrumen_{{ $i->id }}"> 
                                            {{ $i->nama }}
                                            @if(in_array($i->id, [1,2,3,4])) <span class="text-danger">*</span> @endif
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('instrumen')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group text-center">
                        <button id="submitBtn" class="btn btn-primary tambah" type="submit">Simpan</button>               
                    </div>

                </form>
                   
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

document.getElementById('submitBtn').addEventListener('click', function(e) {
    e.preventDefault(); // hentikan submit sementara

    const message = `⚠️ Perhatian!\n\n` +
                    `Mengubah instrumen dapat berdampak pada hasil penilaian dan laporan.\n` +
                    `Nama Kepala Sekolah serta jumlah instrumen akan memengaruhi cetakan laporan dan penilaian akhir.\n\n` +
                    `Apakah Anda tetap ingin menyimpan perubahan?`;

    if (confirm(message)) {
        // Jika user klik "OK", lanjutkan submit
        this.form.submit();
    }
    // Jika "Cancel", tidak terjadi apa-apa
});
</script>

<script>
document.querySelector("form").addEventListener("submit", function(e) {
    let requiredBoxes = document.querySelectorAll(".required-checkbox[data-required='true']");
    let allChecked = true;

    requiredBoxes.forEach(cb => {
        if (!cb.checked) {
            allChecked = false;
        }
    });

    if (!allChecked) {
        e.preventDefault();
        alert("Instrumen wajib (bertanda *) harus dicentang!");
    }
});
</script>
@endsection