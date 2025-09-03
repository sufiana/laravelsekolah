@extends('layouts/master')
@section('title','Parameter Kebersihan')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><span><a href="{{ route('sekolahbersih.indexsekolah') }}"><i class="fa fa-list"></i> Data @yield('title')</a></span></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Edit @yield('title') {{$ruang->nama}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <div class="main-box-body clearfix">
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

                        <form role="form" method="POST" action="{{ route('sekolahbersih.update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{$model->id}}">
                            <div class="row" style="margin-top: 20px">
                                <div class="col-lg-8 col-sm-6 col-12">
                                    <div class="form-group">
                                        <h2 for="periode">Periode Kuesioner</h2>
                                        <input type="text" name="periode" class="form-control" id="daterange" value="{{$daterange}}" disabled/>
                                    </div>

                                    <div id="parameterContainer">
                                        @php $no = 1; @endphp
                                        @foreach ($rincian as $p)
                                        <div class="row">
                                            <div class="col-lg-12"><h2>{{ $no++. '. ' . $p->parameter }}</h2></div>
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
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


                                            <div class="col-md-7"
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

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <img alt="" src="{{ asset('images') }}/kuesioner3.png" width="100%" height="340px" />
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
