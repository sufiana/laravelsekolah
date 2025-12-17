@extends('layouts/master')
@section('title','Parameter Kebersihan')

@section('css')
<style>
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

/* ✅ Custom button sumut */
button.btn-sumut,
a.btn-sumut {
  background-color: #3e5879 !important;
  border: 1px solid #3e5879 !important;
  color: white !important;
}
button.btn-sumut:hover,
a.btn-sumut:hover {
  background-color: #2f4460 !important;
  border-color: #2f4460 !important;
}
button.btn-sumut:disabled,
a.btn-sumut:disabled {
  background-color: #3e5879 !important;
  border-color: #3e5879 !important;
  opacity: 0.65 !important;
  cursor: not-allowed !important;
}

/* ✅ Fix Swal agar tidak ketimpa AdminLTE */
.swal2-container {
  z-index: 20000 !important;
}

@media (max-width: 600px) {
  .switch-radio-group {
    gap: 0.3rem;
  }
  .switch-radio-custom {
    padding: 0.2em 0.4em;
    font-size: 0.7em;
  }
}
</style>
@endsection
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
        <div class="card card-success">
            <div class="card-header" style="color: white; background-color: #3e5879">
                <h3 class="card-title">Instrumen Kebersihan - {{ $model->nama }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                </div>
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

                <form role="form" method="POST" action="{{ route('sekolahbersih.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{$model->id}}">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><h5>Periode Instrumen</h5></label>
                        <div class="col-sm-5">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="periode" class="form-control" id="daterange" value="{{$daterange}}" disabled />
                            </div>
                        </div>
                    </div>
                    <div id="parameterContainer">
                        @php $no = 1; @endphp
                        @foreach ($rincian as $p)                      
                                <div class="row">
                                    <div class="col-lg-12"><h6>{{ $no++. '. ' . $p->parameter }}</h6></div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                                                    <label class="btn btn-warning btn-secondary {{ $p->jawaban == 4 ? 'active' : '' }}">
                                                        <input type="radio"
                                                                name="jawaban[{{ $p->id }}]"
                                                                value="4"
                                                                autocomplete="off"
                                                                onchange="handleJawabanChange({{ $p->id }}, this.value)" {{ $p->jawaban == 3 ? 'checked' : '' }}> Sangat Bersih
                                                    </label>
                                                    <label class="btn btn-warning btn-secondary {{ $p->jawaban == 3 ? 'active' : '' }}">
                                                        <input type="radio"
                                                                name="jawaban[{{ $p->id }}]"
                                                                value="3"
                                                                autocomplete="off"
                                                                onchange="handleJawabanChange({{ $p->id }}, this.value)" {{ $p->jawaban == 3 ? 'checked' : '' }}> Bersih
                                                    </label>

                                                    <label class="btn btn-warning btn-secondary {{ $p->jawaban == 2 ? 'active' : '' }}">
                                                        <input type="radio"
                                                                name="jawaban[{{ $p->id }}]"
                                                                value="2"
                                                                autocomplete="off"
                                                                onchange="handleJawabanChange({{ $p->id }}, this.value)"
                                                                {{ $p->jawaban == 2 ? 'checked' : '' }}>
                                                        Cukup Bersih
                                                    </label>

                                                    <label class="btn btn-warning btn-secondary {{ $p->jawaban == 1 ? 'active' : '' }}">
                                                        <input type="radio"
                                                                name="jawaban[{{ $p->id }}]"
                                                                value="1"
                                                                autocomplete="off"
                                                                onchange="handleJawabanChange({{ $p->id }}, this.value)" {{ $p->jawaban == 1 ? 'checked' : '' }}> Tidak Bersih
                                                    </label>
                                                        <!-- Hidden score -->
                                                    <input type="hidden" name="score[{{ $p->id }}]" id="score_{{ $p->id }}" value="{{$p->jawaban}}">
                                                    <input type="hidden" name="id_kuesioner[{{ $p->id }}]" id="score_{{ $p->id }}" value="{{$p->id}}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6"
                                            id="alasan_{{ $p->id }}"
                                            @if($p->jawaban == 1 || $p->jawaban == 2)
                                        style="display:block;"
                                        @else
                                        style="display:none;"
                                        @endif
                                        >
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="alasan[{{ $p->id }}]"
                                                    placeholder="Tuliskan alasan..."
                                                    value="{{ $p->deskripsi_jawaban ?? '' }}"
                                                    @if($p->jawaban == 1 || $p->jawaban == 2)
                                                required
                                                @endif
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="form-group text-center">
                        <input type="hidden" name="sum" id="sum">
                        <button class="btn btn-primary tambah" type="submit">Simpan</button>
                    </div>

                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>

    function handleJawabanChange(id, value) {
        // Update nilai hidden input score
        let scoreInput = document.getElementById('score_' + id);
        if (scoreInput) {
            scoreInput.value = value;
        }

        // 🔁 Langsung hitung total
        hitungTotal();

        // Tampilkan/sembunyikan alasan
        let alasanDiv = document.getElementById('alasan_' + id);
        if (alasanDiv) {
            if (value == '1' || value == '2') {
                alasanDiv.style.display = 'block';
            } else {
                alasanDiv.style.display = 'none';
            }
        }
    }


    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('input[id^="score_"]').forEach(function(el) {
            let val = parseFloat(el.value) || 0;
            total += val;
        });
        document.getElementById("sum").value = total;
    }

    // panggil saat ada perubahan nilai
    document.querySelectorAll('input[id^="score_"]').forEach(function(el) {
        el.addEventListener("input", hitungTotal); // event input lebih realtime
    });

    // hitung total awal saat halaman load
    hitungTotal();

</script>


@endsection
