@extends('layouts/master')
@section('title', 'Edit Penilaian Kebersihan Sekolah')

@section('css')
<style>
/* === COPY PASTE DARI CREATE === */
.switch-radio-group {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 1rem;
}
.switch-radio-label {
  position: relative;
  display: flex;
  align-items: center;
  cursor: pointer;
  margin: 0;
  padding: 0;
}
.switch-radio-label input[type="radio"] {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}
.switch-radio-custom {
  display: flex;
  align-items: center;
  padding: 0.2em 0.4em;
  border-radius: 20px;
  border: 2px solid #96d9f3;
  background: #96d9f3;
  color: #fff;
  font-weight: 300;
  transition: background 0.2s, color 0.2s, border 0.2s;
}
.switch-radio-label input[type="radio"]:checked + .switch-radio-custom {
  background: #0D6EFD;
  color: #fff;
  border-color: #0D6EFD;
  font-weight: 700;
}
.switch-radio-label input[type="radio"]:focus + .switch-radio-custom {
  outline: 2px solid #0D6EFD;
}

/* tombol sumut */
button.btn-sumut {
  background-color: #3e5879 !important;
  border: 1px solid #3e5879 !important;
  color: white !important;
}
button.btn-sumut:hover {
  background-color: #2f4460 !important;
  border-color: #2f4460 !important;
}

/* swal fix */
.swal2-container {
  z-index: 20000 !important;
}
</style>
@endsection

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">@yield('title')</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sekolahbersih.indexsekolah') }}">Data Penilaian</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    <div class="card card-success">
      <div class="card-header" style="background:#3e5879;color:white">
        <h3 class="card-title">Instrumen Kebersihan - {{ $model->nama }}</h3>
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

        <form method="POST" action="{{ route('sekolahbersih.update') }}">
          @csrf
          <input type="hidden" name="id" value="{{ $model->id }}">

          {{-- PERIODE --}}
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">
              <h5>Periode Instrumen</h5>
            </label>
            <div class="col-sm-5">
              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control" value="{{ $daterange }}" disabled>
              </div>
            </div>
          </div>

          <hr>

          {{-- PARAMETER LOOP (SEMUA TAMPIL SEKALIGUS) --}}
          <div id="parameterContainer">
            @php $no = 1; @endphp
            @foreach ($rincian as $p)
              <div class="mb-4">
                <h6>{{ $no++ . '. ' . $p->parameter }}</h6>

                <div class="switch-radio-group">
                  @foreach ([4=>'Sangat Bersih',3=>'Bersih',2=>'Cukup Bersih',1=>'Tidak Bersih'] as $val=>$label)
                    <label class="switch-radio-label">
                      <input type="radio"
                        name="jawaban[{{ $p->id }}]"
                        value="{{ $val }}"
                        {{ $p->jawaban == $val ? 'checked' : '' }}
                        onchange="handleJawabanChange({{ $p->id }}, {{ $val }})">
                      <span class="switch-radio-custom">{{ $label }}</span>
                    </label>
                  @endforeach
                </div>

                {{-- ALASAN --}}
                <div class="form-group mt-2"
                  id="alasanBox_{{ $p->id }}"
                  style="{{ in_array($p->jawaban,[1,2]) ? '' : 'display:none' }}">
                  <label>Alasan (Wajib diisi)</label>
                  <textarea
                    class="form-control"
                    name="alasan[{{ $p->id }}]"
                    rows="2">{{ $p->deskripsi_jawaban }}</textarea>
                </div>

                <input type="hidden" id="score_{{ $p->id }}" value="{{ $p->jawaban }}">
              </div>
            @endforeach
          </div>

          <input type="hidden" name="total" id="total">

          <div class="text-center mt-4">
            <button type="submit" class="btn btn-sumut px-4">Simpan Perubahan</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<script>
function handleJawabanChange(id, value) {
  document.getElementById('score_' + id).value = value;

  const alasanBox = document.getElementById('alasanBox_' + id);
  if (value == 1 || value == 2) {
    alasanBox.style.display = '';
  } else {
    alasanBox.style.display = 'none';
    alasanBox.querySelector('textarea').value = '';
  }

  hitungTotal();
}

function hitungTotal() {
  let total = 0;
  document.querySelectorAll('input[id^="score_"]').forEach(el => {
    total += parseInt(el.value) || 0;
  });
  document.getElementById('total').value = total;
}

hitungTotal();
</script>
@endsection
