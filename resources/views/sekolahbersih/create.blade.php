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
                <h2 class="float-left">Parameter Kebersihan - {{ $model->nama }}</h2>
            </header>

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

                <form method="POST" action="{{ route('sekolahbersih.store') }}" id="form-penilaian">
                    @csrf
                    <input type="hidden" name="id_ruang" value="{{ $model->id }}">
                    <div class="row" style="margin-top: 20px">
                        <div class="col-lg-8 col-sm-6 col-12">
                            <div class="form-group">
                                <h2 for="periode">Periode Kuesioner</h2>
                                <input type="text" name="periode" class="form-control" id="daterange" />
                            </div>

                            <!-- Tampilkan total nilai -->
                            <div class="text-center my-3" style="display:none;">
                                <h4>Total Nilai: <span id="totalDisplay">0</span></h4>
                            </div>

                            <div id="parameterContainer">
                                @php $no = 1; @endphp
                                @foreach($parameter as $index => $p)
                                <div class="parameter-item" style="{{ $index == 0 ? '' : 'display: none;' }}">
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

                            <div class="d-flex my-4">
                                <button type="button" class="btn btn-sumut" id="prevBtn" disabled>Previous</button>
                                <button type="button" class="btn btn-sumut" id="nextBtn" style="margin-left: 10px">Next</button>
                            </div>

                            <!-- Hidden input untuk total -->
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Date Range Picker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function() {
        $('#daterange').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            opens: 'left',
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });

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
            nextBtn.textContent = 'Simpan & Lanjutkan';
            nextBtn.classList.remove('btn-sumut');
            nextBtn.classList.add('btn-success');
        } else {
            nextBtn.textContent = 'Next';
            nextBtn.classList.remove('btn-success');
            nextBtn.classList.add('btn-sumut');
        }

        restoreAnswers(index);
    }

    function restoreAnswers(index) {
        const item = items[index];
        const radios = item.querySelectorAll('input[type="radio"]');
        const parameterId = radios[0].name.match(/\d+/)[0];

        if (!jawabanState[parameterId]) {
            jawabanState[parameterId] = "3";
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

        hitungTotal();
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
            delete alasanState[id];
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
        const alasan = document.getElementById('alasan_' + parameterId)?.value.trim() || '';

        if ((jawaban == 1 || jawaban == 2) && alasan === '') {
            Swal.fire('Peringatan!', 'Harap isi alasan untuk parameter ini.', 'warning');
            return false;
        }

        return true;
    }

  function handleSubmit() {
    const formData = new FormData();
    const idRuangInput = document.querySelector('input[name="id_ruang"]');
    const periodeInput = document.querySelector('input[name="periode"]');
    const totalInput = document.getElementById('total');

    // Pastikan elemen ada
    if (!idRuangInput || !periodeInput || !totalInput) {
        Swal.fire('Error!', 'Form tidak lengkap.', 'error');
        return;
    }

    formData.append('id_ruang', idRuangInput.value);
    formData.append('periode', periodeInput.value);
    formData.append('total', totalInput.value);

    // Tambahkan semua jawaban dan alasan
    for (const id in jawabanState) {
        formData.append(`jawaban[${id}]`, jawabanState[id]);
        const alasan = alasanState[id] || '';
        formData.append(`alasan[${id}]`, alasan);
    }

    // Debug: cek data yang dikirim
    console.log('Mengirim data:', Object.fromEntries(formData.entries()));

    fetch("{{ route('sekolahbersih.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',   // 🔑 Wajib untuk $request->ajax()
            'Accept': 'application/json'             // Agar Laravel tahu kita mau JSON
        }
    })
    .then(response => {
        console.log('Response status:', response.status);

        if (!response.ok) {
            // Jika error (422, 500, dll), baca sebagai text dulu
            return response.text().then(text => {
                console.error('Server response (error):', text);

                // Coba parse jika JSON
                try {
                    const json = JSON.parse(text);
                    throw json;
                } catch (e) {
                    // Jika bukan JSON (HTML), lempar error khusus
                    throw { message: 'Server returned invalid response. Check console.', details: text.substring(0, 500) };
                }
            });
        }

        // Jika OK, coba parse sebagai JSON
        return response.json();
    })
    .then(data => {
        // Jika sampai sini, artinya respons JSON valid
        if (data.success) {
            showRemainingRoomsAlert(data.ruang_belum_isi, data.next_url, data.index_url);
        } else {
            Swal.fire('Gagal!', data.message || 'Simpan gagal.', 'error');
        }
    })
    .catch(err => {
        console.error('Fetch error:', err);

        // Tampilkan pesan error yang lebih jelas
        let message = err.message || 'Terjadi kesalahan.';
        if (err.details) {
            message += '<br><br><strong>Detail (Console):</strong><br>' + err.details;
        }

        Swal.fire({
            title: 'Error!',
            html: message,
            icon: 'error',
            confirmButtonText: 'Tutup',
            allowOutsideClick: false
        });
    });
}

   function showRemainingRoomsAlert(ruangBelumIsi, nextUrl, indexUrl) {
    const idurl = window.location.pathname.split("/").pop();
    const daftarRuang = [
      "Ruang Kelas",
      "Ruang Guru",
      "Ruang Kepala Sekolah, Wakil dan Tata Usaha",
      "Toilet",
      "Laboratorium, Perpustakaan dan Ruang Praktek",
      "Ruang Gudang Sekolah",
      "Kantin",
      "Ruang Ibadah",
      "Ruang UKS",
      "Taman dan Halaman Sekolah",
      "Parkir",
      "Ruang Sekuriti dan Piket Guru"
    ];
    const ruangCurrent = daftarRuang[idurl - 1] || "Tidak ditemukan";
       
    if (!Array.isArray(ruangBelumIsi)) {
        console.error('ruangBelumIsi bukan array:', ruangBelumIsi);
        ruangBelumIsi = [];
    }

    if (ruangBelumIsi.length === 0) {
        Swal.fire({
            title: 'Selesai!',
            text: 'Semua ruang telah diisi. Terima kasih!',
            icon: 'success',
            confirmButtonText: 'Kembali ke Daftar'
        }).then(() => {
            window.location.href = indexUrl;
        });
    } else {
        let roomList = '<ul style="text-align: left; margin: 10px 0;">';
        ruangBelumIsi.forEach(r => {
            roomList += `<li><a href="#" onclick="goToRoom('${r.url}'); return false;" style="color:#007bff;">${r.nama}</a></li>`;
        });
        roomList += '</ul>';

        Swal.fire({
            title: `<strong>Berhasil</strong><br/>Data ${ruangCurrent} berhasil disimpan<br/><strong>Ruang Belum Diisi</strong>`,
            html: `
                <p>Anda belum mengisi kuesioner untuk ruang berikut:</p>
                ${roomList}
                <p><strong>Klik untuk melanjutkan.</strong></p>
            `,
            icon: 'info',
            showCancelButton: true,
            cancelButtonText: 'Kembali ke Daftar',
            confirmButtonText: 'Lanjut ke Berikutnya',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = nextUrl;
            } else {
                window.location.href = indexUrl;
            }
        });
    }
}
    function goToRoom(url) {
        window.location.href = url;
    }

    nextBtn.addEventListener('click', () => {
        if (!validasiAlasan()) return;

        if (currentIndex === items.length - 1) {
            handleSubmit();
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