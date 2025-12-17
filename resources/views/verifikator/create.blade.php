@extends('layouts/master')
@section('title','User Verifikator Sekolah')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Data @yield('title')</h3>
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
                <h3 class="card-title">Tambah @yield('title')</h3>
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
                
                <form action="{{route('verifikator.store')}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="row mb-2">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Pilih Sekolah<span class="wajib"></span></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="id_sekolah" name="id_sekolah">
                                <option value="" disabled selected> Pilih Sekolah</option>
                                @foreach($sekolah as $i)
                                        <option value="{{ $i->id }}" {{(old('id_sekolah') == $i->id?'selected':'')}}>{{$i->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>        

                    <div class="row mb-2">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">User Verifikator <span class="wajib"></span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="verifikator" name="verifikator" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="jabatan_verifikator" class="col-sm-2 col-form-label">Jabatan Verifikator <span class="wajib"></span></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="jabatan_verifikator" name="jabatan_verifikator">
                                <option value="" disabled selected>Pilih Jabatan</option>
                                @foreach($jabatan as $j)
                                    <option value="{{ $j->id }}" {{ (old('jabatan_verifikator') == $j->id ? 'selected' : '') }}>
                                        {{ $j->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                        </div>
                    </div>

                    {{-- Checklist Memiliki Instrumen --}}
                    <div class="row mb-2">
                        <label class="col-sm-2 col-form-label">Memiliki Instrumen?</label>
                        <div class="col-sm-6 d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="memiliki_instrumen" id="instrumen_ya" value="iya">
                                <label class="form-check-label" for="instrumen_ya">Iya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="memiliki_instrumen" id="instrumen_tidak" value="tidak" checked>
                                <label class="form-check-label" for="instrumen_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Instrumen --}}
                    <div class="row mb-2" id="daftar_instrumen" style="display:none;">
                        <label class="col-sm-2 col-form-label">Pilih Instrumen</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach($instrumen as $ins)
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="instrumen[]" value="{{ $ins->id }}" id="instrumen_{{ $ins->id }}">
                                            <label class="form-check-label" for="instrumen_{{ $ins->id }}">{{ $ins->nama }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Goreskan Tanda Tangan</label>
                        <div class="col-sm-6">
                            <div class="onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="form-check-input" id="myonoffswitch" checked="" style="margin-top: 5px;">                               
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <label class="col-sm-2 col-form-label">Tanda Tangan</label>
                        <div class="col-sm-10">
                            <!-- WADAH FLEX UNTUK TAMPILAN BERGANTIAN -->
                            <div class="signature-container" style="display: flex; flex-direction: column; gap: 15px;">
                                
                                <!-- CANVAS TANDA TANGAN (DRAW) -->
                                <div id="ttd-container">
                                    <canvas id="signature-pad" width="w-90" height="200" style="border:1px solid #000"></canvas> <br/>
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


@endsection

@section('css')
<link href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css" rel="stylesheet" />

@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/signature_pad"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
$(document).ready(function() {
    $('#jabatan_verifikator').select2({
        tags: true, // memungkinkan input baru
        placeholder: "Pilih atau tambah jabatan...",
        allowClear: true,
        createTag: function (params) {
            let term = $.trim(params.term);
            if (term === '') return null;
            return { id: term, text: term, newOption: true };
        },
        templateResult: function (data) {
            // tampilkan label "Tambah ..." untuk item baru
            var $result = $("<span></span>");
            $result.text(data.text);
            if (data.newOption) {
                $result.append(" <em>(Tambah Baru)</em>");
            }
            return $result;
        }
    });

    // Event ketika opsi baru dibuat/dipilih
    $('#jabatan_verifikator').on('select2:select', function (e) {
        var data = e.params.data;
        if (data.newOption) {
            $.ajax({
                url: "{{ route('verifikator.SimpanNamaJabatan') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    nama: data.text
                },
                success: function(response) {
                    // Ganti value yang baru dibuat dengan ID dari DB
                    var newOption = new Option(response.nama, response.id, true, true);
                    $('#jabatan_verifikator').append(newOption).trigger('change');
                },
                error: function() {
                    alert("Gagal menyimpan jabatan baru!");
                    // hapus opsi yang gagal
                    $('#jabatan_verifikator').find("option[value='" + data.id + "']").remove();
                    $('#jabatan_verifikator').val('').trigger('change');
                }
            });
        }
    });

      // Toggle daftar instrumen
    $('input[name="memiliki_instrumen"]').change(function() {
        if ($('#instrumen_ya').is(':checked')) {
        $('#daftar_instrumen').slideDown();
        } else {
        $('#daftar_instrumen').slideUp();
        $('input[name="instrumen_list[]"]').prop('checked', false);
        }
    });
});
</script>

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