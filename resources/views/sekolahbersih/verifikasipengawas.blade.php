@extends('layouts/master')
@section('title', 'Detail validasi Penilaian Sekolah Bersih')@section('css')
    <style>
        .card-footer {
            padding: .75rem 1.25rem;
            background-color: #3e5879 !important;
            color: #fff;
            text-align: center;
        }

        .widget-user-header {
            background-color: #3e5879 !important;
            color: #fff;
            padding: 0 20px;
        }

        .widget-user-image {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin: 20px 0;
        }

        .chart-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }

        .chart-wrapper canvas {
            position: relative;
            z-index: 1;
        }

        .chart-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            font-size: 20px;
            color: #3e5879;
            z-index: 2;
            pointer-events: none;
        }

        .instrumen-wrapper {
            display: none;
            margin-top: 10px;
        }

        .instrumen-row {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .instrumen-row:hover {
            background-color: #f8f9fa;
        }

        .instrumen-row.expanded {
            background-color: #e9ecef;
        }

        .instrumen-toggle {
            margin-left: 10px;
            font-size: 12px;
            color: #6c757d;
        }

        /* Desktop styles for consistent appearance */
        @media (min-width: 769px) {
            .jawaban-pengawas {
                min-width: 150px !important;
                /* Consistent minimum width on desktop */
                max-width: 250px !important;
                /* Reasonable maximum width */
            }

            .select-wrapper {
                width: 100% !important;
                max-width: 250px !important;
            }
        }

        /* Custom dropdown arrow */
        .select-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .select-wrapper::after {
            content: '▼';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
            font-size: 12px;
        }

        /* Mobile specific adjustments */
        @media (max-width: 768px) {
            .jawaban-pengawas {
                font-size: 16px !important;
                /* Prevents zoom on focus in iOS */
                min-height: 48px !important;
                padding: 12px 16px !important;
                margin-bottom: 8px !important;
                min-width: 200px !important;
                /* Minimum width for dropdown */
                max-width: none !important;
                /* Allow full width */
            }

            .select-wrapper {
                min-width: 200px !important;
                width: auto !important;
                display: block !important;
            }

            .instrumen-row {
                padding: 12px 8px !important;
            }

            .instrumen-wrapper table {
                font-size: 14px !important;
                min-width: 100% !important;
            }

            .instrumen-wrapper table td {
                padding: 8px 4px !important;
                white-space: nowrap;
                /* Prevent text wrapping */
            }

            .instrumen-wrapper table td:last-child {
                min-width: 200px !important;
                /* Ensure select column has minimum width */
                width: auto !important;
            }

            /* Ensure table doesn't get too compressed */
            .table-responsive {
                overflow-x: auto !important;
            }

            /* Ensure select is fully clickable on mobile */
            .jawaban-pengawas:focus {
                outline: 2px solid #007bff !important;
                outline-offset: 2px !important;
            }
        }

        @media (max-width: 480px) {
            .jawaban-pengawas {
                font-size: 16px !important;
                min-height: 50px !important;
                padding: 14px 18px !important;
                min-width: 180px !important;
                /* Slightly smaller for very small screens */
            }

            .select-wrapper {
                min-width: 180px !important;
            }

            .instrumen-wrapper table td:last-child {
                min-width: 180px !important;
            }

            .instrumen-wrapper table {
                font-size: 13px !important;
            }
        }
    </style>
@endsection

@php
    $score = $model->nilai_kebersihan;
    $max = 4;
    $percentage = round(($score / $max) * 100);

    $scorekepatuhan = $model->nilai_kepatuhan;
    $percentagekepatuhan = round(($scorekepatuhan / $max) * 100);
@endphp

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
                        <li class="breadcrumb-item active"><span>@yield('title')</span></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header">
                        <div class="row align-items-center">
                            <div class="col-md-6" style="display:inline-block; vertical-align: top;">
                                <h6 class="widget-user-username" style="padding-top: 10px; font-weight: bold;">
                                    {{$sekolah->nama}}
                                    {{ $kabupaten->nama_kabupaten }}
                                </h6>
                                <ul class="contact-details list-unstyled" style="font-size: 12px;">
                                    <li>
                                        <i class="fa fa-envelope-open-o"></i> NPSN : {{$sekolah->npsn}}
                                    </li>
                                    <li>
                                        <i class="fa fa-calendar"></i> Periode :
                                        {{date('d-M-Y', strtotime($model->periode_awal)) . ' s/d ' . date('d-M-Y', strtotime($model->periode_akhir))}}
                                    </li>
                                    <li>
                                        <i class="fa fa-calculator"></i> Score Kebersihan : {{$model->nilai_kebersihan}}
                                    </li>
                                    <li>
                                        <i class="fa fa-check-square"></i> Keterangan Kebersihan :
                                        {{$model->keterangan_kebersihan}}
                                    </li>

                                    <li>
                                        <i class="fa fa-check-square"></i> Keterangan Kepatuhan :
                                        {{$model->keterangan_kepatuhan}}
                                    </li>
                                    <li>
                                        <i class="fa fa-user"></i> Kepala Sekolah : {{$sekolah->kepalasekolah}}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6" style="display:inline-block; vertical-align: top;">
                                <h6 class="widget-user-username" style="padding-top: 10px; font-weight: bold;">
                                    {{$sekolah->nama}}
                                    {{ $kabupaten->nama_kabupaten }}
                                </h6>
                                <ul class="contact-details list-unstyled" style="font-size: 12px;">
                                    <li>
                                        <i class="fa fa-envelope-open-o"></i> Wilayah Binaan : {{$sekolah->npsn}}
                                    </li>
                                    <li>
                                        <i class="fa fa-calendar"></i> Cabdis :
                                        {{date('d-M-Y', strtotime($model->periode_awal)) . ' s/d ' . date('d-M-Y', strtotime($model->periode_akhir))}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('sekolahbersih.storeVerifikasi') }}" id="form-penilaian">
                        @csrf
                        <input type="hidden" name="id" value="{{ $model->id }}">
                        @php $globalIndex = 0; @endphp

                        <div class="main-box-body clearfix">
                            <div class="row">
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <td style="text-align: center; width: 2%;">No</td>
                                                <td>Instrumen</td>
                                                <td>Penilaian verifikator Sekolah</td>
                                            </tr>
                                        </thead>
                                        @php $no = 0; @endphp
                                        @foreach($child as $i)
                                            @php $no++; @endphp

                                            <tr class="instrumen-row" data-instrumen-id="{{ $i->id }}">
                                                <td style="text-align: center">
                                                    {{$no}}
                                                    <span class="instrumen-toggle">▼</span>
                                                </td>
                                                <td>
                                                    {{$i->nama}}
                                                    <input type="hidden" name="id_child[{{ $i->id }}]" value='{{ $i->id }}'>
                                                    <div class="instrumen-wrapper" id="instrumen-{{ $i->id }}">
                                                        <table class="table table-bordered table-striped">
                                                            <tr>
                                                                <td>Parameter Penilaian</td>
                                                                <td>Jawaban Sekolah</td>
                                                                <td>Hasil Verifikasi Pengawas</td>

                                                            </tr>
                                                            @php
                                                                $hasilKuesioner = DB::table('hasil_kuesioner')
                                                                    ->select('p.parameter', 'hasil_kuesioner.jawaban', 'hasil_kuesioner.id')
                                                                    ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
                                                                    ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
                                                                    ->where('hasil_kuesioner.id_evaluasi_kuesioner', $i->id_evaluasi)
                                                                    ->orderBy('p.id', 'asc')
                                                                    ->get();
                                                            @endphp
                                                            @php $nohk = 0; @endphp
                                                            @foreach($hasilKuesioner as $hk)
                                                                @php $nohk++;
                                                                $globalIndex++; @endphp
                                                                <tr>
                                                                    <td>
                                                                        {{$hk->parameter}}
                                                                        <input type="hidden"
                                                                            name="id_parameter_pengawas[{{ $globalIndex }}]"
                                                                            value='{{ $hk->id }}'>
                                                                    </td>
                                                                    <td>
                                                                        @if($hk->jawaban == 3)
                                                                            <span class="badge text-bg-success">Bersih</span>
                                                                        @elseif($hk->jawaban == 4)
                                                                            <span class="badge text-bg-success">Sangat Bersih</span>
                                                                        @elseif($hk->jawaban == 2)
                                                                            <span class="badge text-bg-warning">Cukup Bersih</span>
                                                                        @else
                                                                            <span class="badge text-bg-danger">Kurang Bersih</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div class="select-wrapper">
                                                                            <select name="jawaban_pengawas[{{ $globalIndex }}]"
                                                                                id="jawaban_pengawas[{{ $globalIndex }}]"
                                                                                class="form-control form-select jawaban-pengawas">

                                                                                <option value="4" {{ $hk->jawaban == 4 ? 'selected' : '' }}>
                                                                                    Sangat Bersih</option>
                                                                                <option value="3" {{ $hk->jawaban == 3 ? 'selected' : '' }}>
                                                                                    Bersih
                                                                                </option>
                                                                                <option value="2" {{ $hk->jawaban == 2 ? 'selected' : '' }}>
                                                                                    Cukup Bersih</option>
                                                                                <option value="1" {{ $hk->jawaban == 1 ? 'selected' : '' }}>
                                                                                    Kurang Bersih</option>
                                                                            </select>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr style="font-weight:bold;">
                                                                <td>Total Score :
                                                                    <input type="hidden" name="scorepengawas[{{ $i->id }}]"
                                                                        id="scorepengawas[{{ $i->id }}]">
                                                                </td>
                                                                <td colspan="2" class="total-score">0</td>
                                                            </tr>
                                                            <tr style="font-weight:bold;">
                                                                <td>Rata-rata :
                                                                    <input type="hidden" name="ratapengawas[{{ $i->id }}]"
                                                                        id="ratapengawas[{{ $i->id }}]">
                                                                </td>
                                                                <td colspan="2" class="rata-rata">0</td>
                                                            </tr>
                                                            <tr style="font-weight:bold;">
                                                                <td>Score Kebersihan
                                                                    <input type="hidden"
                                                                        name="nilaikebersihanpengawas[{{ $i->id }}]"
                                                                        id="nilaikebersihanpengawas[{{ $i->id }}]">

                                                                </td>
                                                                <td colspan="2" class="nilaikebersihan">0</td>
                                                            </tr>
                                                            <tr style="font-weight:bold;">
                                                                <td>Keterangan
                                                                    <input type="hidden"
                                                                        name="ketkebersihanpengawas[{{ $i->id }}]"
                                                                        id="ketkebersihanpengawas[{{ $i->id }}]">
                                                                </td>

                                                                <td colspan="2" class="ket-kebersihan">-</td>
                                                            </tr>
                                                            <tr style="font-weight:bold;">
                                                                <td>Kepatuhan
                                                                    {{-- <input type="hidden"
                                                                        name="ketkepatuhanpengawas[{{ $i->id }}]"
                                                                        id="ketkepatuhanpengawas[{{ $i->id }}]">
                                                                    <input type="hidden"
                                                                        name="scorekepatuhanpengawas[{{ $i->id }}]"
                                                                        id="scorekepatuhanpengawas[{{ $i->id }}]"> --}}
                                                                </td>
                                                                <td colspan="2" class="kepatuhan">-</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{$i->keterangan_kebersihan}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>

                                                    Catatan/Temuan : <input type="text" name="catatan_temuan[{{ $i->id }}]"
                                                        id="catatan_temuan[{{ $i->id }}]" class="form-control"></td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" style="text-align: center; font-weight: bold;">Total Score
                                                Penialaian Pengawas
                                                <input type="hidden" name="rekap_total_score" id="rekap_total_score_input">
                                            </td>
                                            <td id="rekap-total-score" colspan="2" style="font-weight: bold;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center; font-weight: bold;">Nilai Kebersihan
                                            </td><input type="hidden" name="rekap_nilai_kebersihan"
                                                id="rekap_nilai_kebersihan_input">

                                            <td id="rekap-nilai-kebersihan" colspan="2" style="font-weight: bold;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center; font-weight: bold;">Tingkat
                                                Kebersihan

                                            </td><input type="hidden" name="rekap_ket_kebersihan"
                                                id="rekap_ket_kebersihan_input">

                                            <td id="rekap-ket-kebersihan" colspan="2" style="font-weight: bold;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center; font-weight: bold;">Total Nilai
                                                Kepatuhan
                                            </td><input type="hidden" name="rekap_nilai_kepatuhan"
                                                id="rekap_nilai_kepatuhan_input">

                                            <td id="rekap-nilai-kepatuhan" colspan="2" style="font-weight: bold;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center; font-weight: bold;">Tingkat Kepatuhan
                                            </td><input type="hidden" name="rekap_ket_kepatuhan"
                                                id="rekap_ket_kepatuhan_input">

                                            <td id="rekap-ket-kepatuhan" colspan="2" style="font-weight: bold;"></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row" id="popoverPwd-container">
                                            <div class="form-group col-md-12">
                                                <label for="popoverName">Tanggal Supervisi Pengawas </label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="tanggal_supervisi"
                                                        name="tanggal_supervisi" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row" id="popoverPwd-container">
                                            <div class="form-group col-md-12">
                                                <label for="popoverName">Hasil Rekomendasi </label>
                                                <div class="form-group">
                                                    <select class="form-control form-select" id="jenis_tindak_lanjut"
                                                        name="jenis_tindak_lanjut">
                                                        <option value="" disabled="" selected="">Pilih jenis tindak lanjut
                                                        </option>
                                                        <option value="1">Pembinaan</option>
                                                        <option value="2">Penguatan</option>
                                                        <option value="3">Penghargaan</option>
                                                        <option value="4">Monitoring Lanjutan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="popoverName">Catatan Verifikator Pengawas </label>
                                                <div class="form-group">
                                                    <textarea class="form-control" id="catatan_verifikator" name="catatan_verifikator" rows="3"></textarea>
                                                </div>
                                        </div>
                                    </div>

                                        <div class="form-group text-center mt-4">
                                            <button class="btn btn-primary tambah" type="submit">Simpan Verfikasi Pengawas</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
@endsection

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(function () {
                $('#tanggal_supervisi').datepicker({
                    format: 'dd-M-yyyy',
                    autoclose: true,
                    todayHighlight: true
                }).datepicker('setDate', new Date()); // ← ini untuk default hari ini
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('progressChart').getContext('2d');
                const ctx1 = document.getElementById('progressChart1').getContext('2d');

                const percentage = {{ $percentage }};
                const percentagekepatuhan = {{ $percentagekepatuhan }};

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [percentage, 100 - percentage],
                            backgroundColor: ['#00aaff', '#eeeeee'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '80%',
                        responsive: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        }
                    }
                });

                new Chart(ctx1, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [percentagekepatuhan, 100 - percentagekepatuhan],
                            backgroundColor: ['#3e5879', '#eeeeee'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '80%',
                        responsive: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        }
                    }
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                document.querySelectorAll('.instrumen-row').forEach(row => {
                    row.addEventListener('click', function (e) {

                        // ❗ JIKA KLIK DARI SELECT / INPUT → JANGAN TOGGLE
                        if (e.target.closest('select, input, option')) {
                            return;
                        }

                        const instrumenId = this.dataset.instrumenId;
                        const wrapper = document.getElementById('instrumen-' + instrumenId);
                        const toggle = this.querySelector('.instrumen-toggle');

                        if (!wrapper) return;

                        const isOpen = wrapper.style.display === 'block';

                        wrapper.style.display = isOpen ? 'none' : 'block';
                        toggle.textContent = isOpen ? '▼' : '▲';
                        this.classList.toggle('expanded', !isOpen);
                    });
                });

            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function () {

                function hitungInstrumen(wrapper) {
                    let total = 0;
                    let count = 0;

                    wrapper.querySelectorAll('.jawaban-pengawas').forEach(select => {
                        const nilai = parseInt(select.value);
                        if (!isNaN(nilai)) {
                            total += nilai;
                            count++;
                        }
                    });

                    const rata = count ? total / count : 0;

                    wrapper.querySelector('.total-score').innerText = total;
                    wrapper.querySelector('.rata-rata').innerText = Math.round(rata * 1000) / 1000

                    wrapper.querySelector('input[name^="scorepengawas"]').value = total;
                    wrapper.querySelector('input[name^="ratapengawas"]').value = rata.toFixed(2);

                    // ===== KEBERSIHAN =====
                    let nilaiKebersihan = 1;
                    let ket = 'Kurang Bersih';

                    if (rata > 3 && rata <= 4) { nilaiKebersihan = 4; ket = 'Sangat Bersih'; }
                    else if (rata > 2 && rata <= 3) { nilaiKebersihan = 3; ket = 'Bersih'; }
                    else if (rata > 1 && rata <= 2) { nilaiKebersihan = 2; ket = 'Cukup Bersih'; }

                    wrapper.querySelector('.nilaikebersihan').innerText = nilaiKebersihan;
                    wrapper.querySelector('.ket-kebersihan').innerText = ket;
                    wrapper.querySelector('input[name^="nilaikebersihanpengawas"]').value = nilaiKebersihan;
                    wrapper.querySelector('input[name^="ketkebersihanpengawas"]').value = ket;
                    //wrapper.querySelector('input[name^="ketkepatuhanpengawas"]').value = ket;

                    // wrapper.querySelector('.kepatuhan').innerText =
                    //     rata >= 3 ? 'Patuh' : 'Tidak Patuh';
                }

                document.querySelectorAll('.instrumen-wrapper').forEach(hitungInstrumen);

                document.querySelectorAll('.jawaban-pengawas').forEach(select => {
                    select.addEventListener('change', function () {
                        const wrapper = this.closest('.instrumen-wrapper');
                        hitungInstrumen(wrapper);
                        hitungRekapPengawas();
                    });
                });

            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                function hitungRekapPengawas() {

                    let totalScore = 0;
                    let totalParameter = 0;

                    // HITUNG BERDASARKAN PARAMETER PENILAIAN
                    document.querySelectorAll('.jawaban-pengawas').forEach(select => {
                        const nilai = parseInt(select.value);
                        if (!isNaN(nilai)) {
                            totalScore += nilai;
                            totalParameter++;
                        }
                    });

                    if (totalParameter === 0) return;

                    // RATA-RATA
                    const rataKebersihan = totalScore / totalParameter;
                    const rataKepatuhan = rataKebersihan/3;

                    // ================= TAMPILAN =================
                    document.getElementById('rekap-total-score').innerText = totalScore;
                    document.getElementById('rekap-nilai-kebersihan').innerText = rataKebersihan.toFixed(2);
                    document.getElementById('rekap-nilai-kepatuhan').innerText = rataKepatuhan.toFixed(2);

                    // ================= KEBERSIHAN =================
                    let nilaiKebersihan = 1;
                    let nilaiKepatuhan = 1;
                    let ketKebersihan = 'Kurang Bersih';
                    let ketKepatuhan = 'Kurang Patuh';

                    if (rataKebersihan > 3 && rataKebersihan <= 4) {
                        nilaiKebersihan = 4;
                        ketKebersihan = 'Sangat Bersih';
                        nilaiKepatuhan = 4;
                        ketKepatuhan = 'Sangat Patuh';
                    } else if (rataKebersihan > 2 && rataKebersihan <= 3) {
                        nilaiKebersihan = 3;
                        ketKebersihan = 'Bersih';
                        nilaiKepatuhan = 3;
                        ketKepatuhan = 'Patuh';
                    } else if (rataKebersihan > 1 && rataKebersihan <= 2) {
                        nilaiKebersihan = 2;
                        ketKebersihan = 'Cukup Bersih';
                        nilaiKepatuhan = 2;
                        ketKepatuhan = 'Cukup Patuh';
                    }

                    // ================= KEPATUHAN =================


                    // const nilaiKepatuhanSkala = Math.round(rataKebersihan / 3) * 3;
                    // let nilaiKepatuhan =1;
                    // let ketKepatuhan = 'Kurang Patuh';
                    // if(nilaiKepatuhanSkala > 2.5 && nilaiKepatuhanSkala <=3){
                    //     nilaiKepatuhan=3;
                    //     ketKepatuhan='Sangat Patuh';
                    // }else if(nilaiKepatuhanSkala > 2 && nilaiKepatuhanSkala <=2.5){
                    //     nilaiKepatuhan=2;
                    //     ketKepatuhan='Patuh';
                    // }
                    // else {
                    //     nilaiKepatuhan=1;
                    //     ketKepatuhan='Kurang Patuh';
                    // }


                    // ================= OUTPUT =================
                    document.getElementById('rekap-ket-kebersihan').innerText = ketKebersihan;
                    //document.getElementById('rekap-ket-kepatuhan').innerText = ketKepatuhan;

                    document.getElementById('rekap-nilai-kepatuhan').innerText = nilaiKepatuhan;
                    document.getElementById('rekap-ket-kepatuhan').innerText = ketKepatuhan;

                    // ================= HIDDEN INPUT =================
                    document.getElementById('rekap_total_score_input').value = totalScore;
                    document.getElementById('rekap_nilai_kebersihan_input').value = nilaiKebersihan;
                    document.getElementById('rekap_ket_kebersihan_input').value = ketKebersihan;
                    //document.getElementById('rekap_nilai_kepatuhan_input').value = rataKepatuhan.toFixed(2);
                    document.getElementById('rekap_ket_kepatuhan_input').value = ketKepatuhan;

                    document.getElementById('rekap_nilai_kepatuhan_input').value = nilaiKepatuhan;
                }

                // JALANKAN SAAT LOAD
                hitungRekapPengawas();

                // UPDATE SAAT NILAI BERUBAH
                document.querySelectorAll('.jawaban-pengawas').forEach(select => {
                    select.addEventListener('change', hitungRekapPengawas);
                });

            });

        </script>

        <script>
            $(document).ready(function () {

                $('#form-penilaian').on('submit', function (e) {
                    e.preventDefault(); 

                    Swal.fire({
                        title: 'Apakah anda yakin akan memproses verifikasi penilaian ini ??',
                        text: "Pastikan data sudah benar.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading alert
                            Swal.fire({
                                title: 'Menyimpan...',
                                text: 'Mohon tunggu',
                                icon: 'info',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit form via AJAX
                            $.ajax({
                                url: $(this).attr('action'),
                                type: 'POST',
                                data: new FormData(this),
                                processData: false,
                                contentType: false,
                                success: function (response) {
                                    // Show success alert
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Verifikasi berhasil disimpan.',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Redirect after showing alert
                                        window.location.href = "{{ route('sekolahbersih.rekappengawas') }}";
                                    });
                                },
                                error: function (xhr) {
                                    let errorMessage = 'Gagal menyimpan verifikasi';
                                    
                                    // Check if response has validation errors
                                    if (xhr.status === 422) {
                                        let errors = xhr.responseJSON.errors;
                                        errorMessage = Object.values(errors).flat().join('\n');
                                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }
                                    
                                    // Show error alert
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: errorMessage,
                                        confirmButtonText: 'Coba Lagi'
                                    });
                                }
                            });
                        }
                    });
                });

            });
        </script>

    @endsection