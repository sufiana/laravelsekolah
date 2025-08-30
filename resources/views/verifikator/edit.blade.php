@extends('layouts/master')
@section('title','User Verifikator Sekolah')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('sekolahbersih.index') }}"><i class="fa fa-list"></i> Data @yield('title')</a></li>
            <li class="active">@yield('title')</li>
        </ol>
        <h1>Tambah @yield('title')</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">

            <div class="main-box-body clearfix">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="main-box-body clearfix" style="padding: 20px">
                    <form action="{{route('verifikator.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" nama="id" value="{{$model->id}}">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Pilih Sekolah<span class="wajib"></span></label>
                            <div class="col-sm-10">
                                <select class="form-control" id="id_sekolah" name="id_sekolah">
                                    <option value="" disabled selected> Pilih Sekolah</option>
                                    @foreach($sekolah as $i)
                                            <option value="{{ $i->id }}" {{(old('id_sekolah', $model->id_sekolah )== $i->id?'selected':'')}}>{{$i->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">User Verifikator <span class="wajib"></span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="verifikator" name="verifikator" required value={{$model->verifikator}}>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Jabatan Verifikator <span class="wajib"></span></label>
                            <div class="col-sm-10">
                                <select class="form-control" id="jabatan_verifikator" name="jabatan_verifikator">
                                    <option value="" disabled selected> Pilih Jabatan</option>
                                    @foreach($jabatan as $j)
                                            <option value="{{ $j->id }}" {{(old('jabatan_verifikator', $model->jabatan_verifikator) == $j->id?'selected':'')}}>{{$j->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="deskripsi" name="deskripsi" value={{$model->deksripsi}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Goreskan Tanda Tangan</label>
                            <div class="col-sm-10">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked="">
                                    <label class="onoffswitch-label" for="myonoffswitch">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanda Tangan</label>
                            <div class="col-sm-10">
                                <!-- WADAH FLEX UNTUK TAMPILAN BERGANTIAN -->
                                <div class="signature-container" style="display: flex; flex-direction: column; gap: 15px;">

                                    <!-- CANVAS TANDA TANGAN (DRAW) -->
                                    <div id="ttd-container">
                                        <canvas id="signature-pad" width="400" height="200" style="border:1px solid #000"></canvas> <br/>
                                        <button type="button" id="clear" class="btn btn-danger btn-sm">Clear</button>
                                        <input type="hidden" name="tandatangan_drawn" id="tandatangan_drawn">
                                    </div>

                                    <!-- UPLOAD TTD -->
                                    <div id="upload-container" style="display: none;">
                                        <div>
                                            <input type="file" name="tandatangan_upload" accept="image/*" onchange="previewImage(event)">
                                        </div>
                                        <div class="mt-2">
                                            <img id="preview-upload" src="" style="max-width:200px; display:none; border:1px solid #ccc;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/signature_pad"></script>

<script>
    const canvas = document.getElementById("signature-pad");
    const signaturePad = new SignaturePad(canvas, {
        minWidth: 2,
        maxWidth: 4,
        penColor: "black"
    });

    document.getElementById("clear").addEventListener("click", () => {
        signaturePad.clear();
    });

// document.querySelector("form").addEventListener("submit", () => {
//   document.getElementById("tandatangan_drawn").value = canvas.toDataURL("image/png");
// });

document.querySelector("form[action='{{ route('verifikator.store') }}']").addEventListener("submit", (e) => {
    if (!signaturePad.isEmpty()) {
        document.getElementById("tandatangan_drawn").value = signaturePad.toDataURL("image/png");
    } else {
        document.getElementById("tandatangan_drawn").value = "";
    }
});
</script>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview-upload');
        output.src = reader.result;
        output.style.display = "block";
    };
    reader.readAsDataURL(event.target.files[0]);
}

//switch
document.addEventListener("DOMContentLoaded", function () {
    const switchCheckbox = document.getElementById("myonoffswitch");
    const drawContainer = document.getElementById("ttd-container");
    const uploadContainer = document.getElementById("upload-container");

    function updateDisplay() {
        if (switchCheckbox.checked) {
            // Gunakan canvas (draw)
            drawContainer.style.display = "block";
            uploadContainer.style.display = "none";
        } else {
            // Gunakan upload
            alert("Pilihan diubah ke 'Tidak'. Silakan upload tanda tangan baru.");
            drawContainer.style.display = "none";
            uploadContainer.style.display = "block";
        }
    }
    // Jalankan saat muat
    updateDisplay();
    // Dengarkan perubahan
    switchCheckbox.addEventListener("change", updateDisplay);
});
</script>
@endsection
