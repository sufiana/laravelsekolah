@extends('layouts/master')
@section('title', 'Penilaian Kebersihan Sekolah')

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

    .switch-radio-label input[type="radio"]:checked+.switch-radio-custom {
      background: #0D6EFD;
      color: #fff;
      border-color: #0D6EFD;
      font-weight: 700;
    }

    .switch-radio-label input[type="radio"]:focus+.switch-radio-custom {
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
          <h3 class="mb-0">Tambah @yield('title')</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sekolahbersih.indexsekolah') }}">Data @yield('title')</a></li>
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

          <form method="POST" action="{{ route('sekolahbersih.store') }}" id="form-penilaian">
            @csrf
            <input type="hidden" name="id_ruang" value="{{ $model->id }}">

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">
                <h5>Periode Instrumen</h5>
              </label>
              <div class="col-sm-5">
                <div class="input-group mb-3">
                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  {{-- <input type="text" name="periode" class="form-control" id="daterange" /> --}}
                  <input type="text" name="periode" class="form-control" id="daterange"
                    value="{{ $periode_awal && $periode_akhir ? $periode_awal . ' - ' . $periode_akhir : '' }}" />
                </div>
              </div>
            </div>

            <div class="text-center my-3" style="display:none;">
              <h6>Total Nilai: <span id="totalDisplay">0</span></h6>
            </div>

            <div id="parameterContainer">
              @php $no = 1; @endphp
              @foreach($parameter as $index => $p)
                <div class="parameter-item" style="{{ $index == 0 ? '' : 'display: none;' }}">
                  <h6>{{ $no++ . '. ' . $p->parameter }}</h6>
                  <div class="switch-radio-group">
                    @foreach([4 => 'Sangat Bersih', 3 => 'Bersih', 2 => 'Cukup Bersih', 1 => 'Tidak Bersih'] as $val => $label)
                      <label class="switch-radio-label">
                        <input type="radio" name="jawaban[{{ $p->id }}]" value="{{ $val }}"
                          onchange="handleJawabanChange({{ $p->id }}, this.value)">
                        <span class="switch-radio-custom">{{ $label }}</span>
                      </label>
                    @endforeach
                  </div>

                  <div class="form-group alasan-box mt-3" id="alasanBox_{{ $p->id }}" style="display: none;">
                    <label for="alasan_{{ $p->id }}">Alasan (Wajib diisi):</label>
                    <textarea name="alasan[{{ $p->id }}]" class="form-control alasan-textarea"
                      id="alasan_{{ $p->id }}"></textarea>
                  </div>
                </div>
              @endforeach
            </div>

            <div class="d-flex my-4">
              <button type="button" class="btn btn-sumut" id="prevBtn" disabled>Sebelumnya</button>
              <button type="button" class="btn btn-sumut" id="nextBtn" style="margin-left:10px">Selanjutnya</button>
            </div>

            <input type="hidden" name="total" id="total">
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(function () {
      // $('#daterange').daterangepicker({
      //   startDate: moment().startOf('month'),
      //   endDate: moment().endOf('month'),
      //   opens: 'left',
      //   locale: { format: 'YYYY-MM-DD' }
      // });

      let periode_awal = "{{ $periode_awal }}";
      let periode_akhir = "{{ $periode_akhir }}";

      // Jika create berasal dari validasi dan periode ditemukan
      if (periode_awal && periode_akhir) {

        $('#daterange').daterangepicker({
          startDate: periode_awal,
          endDate: periode_akhir,
          opens: 'left',
          locale: { format: 'YYYY-MM-DD' }
        });

      } else {

        // default: bulan berjalan
        $('#daterange').daterangepicker({
          startDate: moment().startOf('month'),
          endDate: moment().endOf('month'),
          opens: 'left',
          locale: { format: 'YYYY-MM-DD' }
        });

      }

    });

    const items = document.querySelectorAll('.parameter-item');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let currentIndex = 0;
    const jawabanState = {};
    const alasanState = {};

    function showItem(index) {
      items.forEach((item, idx) => item.style.display = idx === index ? '' : 'none');
      prevBtn.disabled = index === 0;

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

      if (!jawabanState[parameterId]) jawabanState[parameterId] = "4";

      radios.forEach(r => r.checked = (r.value === jawabanState[parameterId]));

      const alasanBox = document.getElementById('alasanBox_' + parameterId);
      const alasanTextarea = document.getElementById('alasan_' + parameterId);

      if (jawabanState[parameterId] == 2 || jawabanState[parameterId] == 1) {
        alasanBox.style.display = '';
        alasanTextarea.value = alasanState[parameterId] || '';
      } else {
        alasanBox.style.display = 'none';
        if (!alasanState[parameterId]) alasanTextarea.value = '';
      }

      hitungTotal();
    }

    function handleJawabanChange(id, value) {
      jawabanState[id] = value;
      const alasanBox = document.getElementById('alasanBox_' + id);
      const alasanTextarea = document.getElementById('alasan_' + id);

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
      for (const id in jawabanState) total += parseInt(jawabanState[id]) || 0;
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
      const formData = new FormData(document.getElementById('form-penilaian'));

      for (const id in jawabanState) {
        formData.set(`jawaban[${id}]`, jawabanState[id]);
        formData.set(`alasan[${id}]`, alasanState[id] || '');
      }

      fetch("{{ route('sekolahbersih.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
        .then(async res => {

          // 🔥 CASE 1: Jika backend kirim status 422 (data existing)
          if (res.status === 422) {
            const errData = await res.json();

            // Show pesan existing dari backend (custom)
            throw {
              message: errData.message ||
                "Maaf data instrumen untuk periode tersebut sudah ada, silahkan coba instrumen/periode yg lain"
            };
          }

          // 🔥 CASE 2: ERROR selain 422
          if (!res.ok) {
            const text = await res.text();
            throw { message: "Server error", details: text };
          }

          // 🔥 CASE 3: SUCCESS
          return res.json();
        })
        .then(data => {
          if (data.success) {
            showRemainingRoomsAlert(
              data.ruang_belum_isi,
              data.next_url,
              data.index_url,
              data.periode_awal,
              data.periode_akhir
            );
          } else {
            Swal.fire('Gagal!', data.message || 'Simpan gagal.', 'error');
          }
        })
        .catch(err => {
          Swal.fire({
            title: 'Error!',
            text: err.message || 'Terjadi kesalahan.',
            icon: 'error'
          });
          console.error(err);
        });
    }

    function showRemainingRoomsAlert(ruangBelumIsi, nextUrl, indexUrl, periode_awal, periode_akhir) {

      if (!Array.isArray(ruangBelumIsi)) ruangBelumIsi = [];

      // Build daftar ruang sebagai link
      let list = '<ul style="text-align:left;">';

      ruangBelumIsi.forEach(r => {
        const ruangUrl = `${r.url}?periode_awal=${periode_awal}&periode_akhir=${periode_akhir}`;
        list += `<li><a href="${ruangUrl}" style="color:#007bff;">${r.nama}</a></li>`;
      });

      list += '</ul>';

      Swal.fire({
        title: "Berhasil Disimpan!",
        html: `
                <b>Instrumen berhasil dinilai.</b><br>
                Anda belum mengisi ruang berikut:
                ${list}
                <br>
                Lanjut mengisi instrumen berikutnya?
            `,
        icon: "success",
        showCancelButton: true,
        confirmButtonText: "Ya, lanjutkan",
        cancelButtonText: "Kembali ke daftar",
        reverseButtons: true
      }).then((result) => {

        if (result.isConfirmed) {

          // FIX: inject periode ke tombol LANJUTKAN
          const url = `${nextUrl}?periode_awal=${periode_awal}&periode_akhir=${periode_akhir}`;
          window.location.href = url;

        } else {
          window.location.href = indexUrl;
        }
      });

    }


    nextBtn.addEventListener('click', () => {
      if (!validasiAlasan()) return;
      if (currentIndex === items.length - 1) handleSubmit();
      else { currentIndex++; showItem(currentIndex); }
    });
    prevBtn.addEventListener('click', () => {
      if (currentIndex > 0) { currentIndex--; showItem(currentIndex); }
    });

    showItem(currentIndex);
  </script>
@endsection