@extends('layouts/master')
@section('title','Penilaian Kebersihan Sekolah')
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
            <header class="main-box-header clearfix" style="color: white; background-color: #3e5879">
                <h2 class="float-left">Parameter Kebersihan - {{$model->nama}}</h2>
            </header>

            <div class="main-box-body clearfix">
                <form method="POST" action="{{ route('biaya.simpan') }}" id="form-penilaian">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-sm-6 col-12">

                            <!-- Tempat menampilkan total -->
<!--                            <div class="text-center my-3">-->
<!--                                <h4>Total Nilai: <span id="totalDisplay">0</span></h4>-->
<!--                            </div>-->
                            <input type="hidden" name="id_ruang" id="total">

                            <div id="parameterContainer">
                                @php $no = 1; @endphp
                                @foreach($parameter as $index => $p)
                                <div class="parameter-item" style="{{ $index == 0 ? '' : 'display: none;' }}">
                                    <input type="hidden" name="id_parameter[{{ $p->id }}]" id="total">

                                    <h2>{{ $no++. '. ' . $p->parameter }}</h2>

                                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                                        <label class="btn btn-warning btn-secondary">
                                            <input type="radio" name="jawaban[{{ $p->id }}]" value="3" autocomplete="off"
                                                   onchange="handleJawabanChange({{ $p->id }}, this.value)"> Bersih
                                        </label>
                                        <label class="btn btn-warning btn-secondary">
                                            <input type="radio" name="jawaban[{{ $p->id }}]" value="2" autocomplete="off"
                                                   onchange="handleJawabanChange({{ $p->id }}, this.value)"> Cukup Bersih
                                        </label>
                                        <label class="btn btn-warning btn-secondary">
                                            <input type="radio" name="jawaban[{{ $p->id }}]" value="1" autocomplete="off"
                                                   onchange="handleJawabanChange({{ $p->id }}, this.value)"> Tidak Bersih
                                        </label>
                                    </div>

                                    <div class="form-group alasan-box mt-3" id="alasanBox_{{ $p->id }}" style="display: none;">
                                        <label for="alasan_{{ $p->id }}">Alasan (Wajib diisi):</label>
                                        <textarea name="alasan[{{ $p->id }}]" class="form-control alasan-textarea" id="alasan_{{ $p->id }}"></textarea>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="d-flex  my-4">
                                <button type="button" class="btn btn-sumut" id="prevBtn" disabled>Previous</button>
                                <button type="button" class="btn btn-warning" id="nextBtn" style="margin-left: 10px">Next</button>
                            </div>

                            <!-- Input hidden untuk total nilai -->
                            <input type="hidden" name="total" id="total">
                        </div>

                        <div class="col-lg-4 col-sm-6 col-12">
                            <img alt="" src="{{ asset('images') }}/kuesioner3.png" width="100%" height="80%" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    const items = document.querySelectorAll('.parameter-item');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let currentIndex = 0;

    const jawabanState = {};
    const alasanState = {};

    function showItem(index) {
        items.forEach((item, idx) => {
            item.style.display = (idx === index) ? '' : 'none';
        });

        prevBtn.disabled = (index === 0);

        if (index === items.length - 1) {
            nextBtn.textContent = 'Simpan';
            nextBtn.classList.remove('btn-warning');
            nextBtn.classList.add('btn-success');
        } else {
            nextBtn.textContent = 'Next';
            nextBtn.classList.remove('btn-success');
            nextBtn.classList.add('btn-warning');
        }

        restoreAnswers(index);
    }

    function restoreAnswers(index) {
        const item = items[index];
        const radios = item.querySelectorAll('input[type="radio"]');
        const parameterId = radios[0].name.match(/\d+/)[0];

        if (!jawabanState[parameterId]) {
            jawabanState[parameterId] = "3"; // Default jawaban "Bersih"
        }

        radios.forEach(radio => {
            radio.checked = (radio.value === jawabanState[parameterId]);
        });

        const alasanBox = document.getElementById('alasanBox_' + parameterId);
        const alasanTextarea = document.getElementById('alasan_' + parameterId);

        if (jawabanState[parameterId] == 2 || jawabanState[parameterId] == 1) {
            alasanBox.style.display = '';
            alasanTextarea.value = alasanState[parameterId] || '';
        } else {
            alasanBox.style.display = 'none';
            if (!alasanState[parameterId]) {
                alasanTextarea.value = '';
            }
        }

        hitungTotal(); // Hitung ulang total setiap halaman ditampilkan
    }

    function handleJawabanChange(id, value) {
        const alasanBox = document.getElementById('alasanBox_' + id);
        const alasanTextarea = document.getElementById('alasan_' + id);

        jawabanState[id] = value;

        if (value == 2 || value == 1) {
            alasanBox.style.display = '';
            alasanTextarea.addEventListener('input', function () {
                alasanState[id] = this.value;
            });
        } else {
            alasanBox.style.display = 'none';
            if (!alasanState[id]) {
                alasanTextarea.value = '';
            }
        }

        hitungTotal();
    }

    function hitungTotal() {
        let total = 0;
        for (const id in jawabanState) {
            total += parseInt(jawabanState[id]) || 0;
        }

        document.getElementById('total').value = total;
        document.getElementById('totalDisplay').innerText = total;
    }

    function validasiAlasan() {
        const item = items[currentIndex];
        const radios = item.querySelectorAll('input[type="radio"]');
        const parameterId = radios[0].name.match(/\d+/)[0];

        const jawaban = jawabanState[parameterId];
        const alasan = document.getElementById('alasan_' + parameterId).value.trim();

        if ((jawaban == 1 || jawaban == 2) && alasan === '') {
            alert('Harap isi alasan untuk parameter ini.');
            return false;
        }

        return true;
    }

    nextBtn.addEventListener('click', () => {
        if (!validasiAlasan()) return;

        if (currentIndex === items.length - 1) {
            document.getElementById('form-penilaian').submit();
        } else {
            currentIndex++;
            showItem(currentIndex);
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            showItem(currentIndex);
        }
    });

    showItem(currentIndex);
</script>
@endsection
