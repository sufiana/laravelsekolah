@extends('layouts/master')
@section('title', 'Verifikasi Pengawas Sekolah')

@section('content')
    <style>
        .table td, .table th {
            padding: .5rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 10px;
        }
        .table tbody > tr > td:first-child {
            font-size: 12px;
            font-weight: 300;
        }
        .onoffswitch-sm {
            width: 60px;
            height: 24px;
        }
        .onoffswitch-sm .onoffswitch-label {
            display: block;
            overflow: hidden;
            cursor: pointer;
            height: 24px;
            padding: 0;
            line-height: 24px;
            border: 2px solid #E74C3C;
            border-radius: 24px;
            background-color: #E74C3C;
            font-size: 6px; /* Tambahkan ini untuk kecilkan font */
        }
        .onoffswitch-sm .onoffswitch-inner {
            display: block;
            width: 200%;
            margin-left: -100%;
            transition: margin 0.3s ease-in 0s;
        }
        .onoffswitch-sm .onoffswitch-switch {
            width: 10px;
            height: 10px;
            background: white;
            position: absolute;
            top: 1px; /* Sesuaikan agar vertikalnya pas */
            right: 26px;
            border: 1px solid #E74C3C;
            border-radius: 50%; /* Pastikan ini untuk bentuk bulat */
            transition: all 0.3s ease-in 0s;
            margin: 5px 18px 30px 40px;
        }
        .onoffswitch-sm .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
            margin-left: 0;
        }
        .onoffswitch-sm .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
            right: -10px;
        }
        .onoffswitch-inner:before {
            padding-left: 5px;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><span><a href="{{ route('sekolahbersih.indexpengawas') }}"><i class="fa fa-list"></i> Data @yield('title')</a></span></li>
                        <li class="active"><span>@yield('title')</span></li>
                    </ol>
                    <h1>Lihat Data @yield('title') #{{$model->id}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if($data && sizeof($data)>=1)
                    <div class="main-box-body clearfix">
                        <div class="alert alert-block alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><span aria-hidden="true">×</span></button>
                            <h4>Maaf ! Proses Validasi tidak dapat dilanjutkan, Silahkan isi Komponen dan verifikasi Terlebih dahulu</h4>
                            @foreach ($data as $dt)
                                <p style="margin-bottom: 3px">{{ $dt->nama }} {{$dt->status}} 
                                    @if($dt->status =='Belum diisi')
                                    <a href="{{ url('sekolahbersih/create/' . $dt->id) }}">(Klik disini untuk mengisi)</a>
                                    @endif
                                    @if($dt->status =='Belum Belum diverifikasi')
                                    <a href="{{ url('sekolahbersih/create/' . $dt->id) }}">(Klik disini untuk mengisi)</a>
                                    @endif
                                </p>
                            @endforeach
                        </div>
                    </div>
                    
                    @else
                    <div class="main-box clearfix profile-box-contact">
                        <div class="main-box-body clearfix">

                            <div class="profile-box-header gray-bg clearfix" style="background-color: #3e5879 !important;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h2>I. Identitas Sekolah </h2> <br/>
                                        <h2>{{$sekolah->nama}}</h2>
                                        <ul class="contact-details">
                                            <li>
                                                <i class="fa fa-calendar"></i> NPSN : {{$sekolah->npsn}}
                                            </li>
                                            <li>
                                                <i class="fa fa-map-marker"></i> Alamat Sekolah : {{$sekolah->alamat_jalan}}
                                            </li>
                                            <li>
                                                <i class="fa fa-envelope-open-o"></i> Kecamatan/Kabupatenkota : {{$kabupaten || !$sekolah->kabupaten_kota ? ' - ' : $kabupaten->nama_kabupaten}}
                                            </li>
                                            <li>
                                                <i class="fa fa-user"></i> Nama Kepala Sekolah : {{!$sekolah->kepalasekolah ? '-' : $sekolah->kepalasekolah}}
                                            </li>
                                        </ul>
                                    </div>



                                </div>
                            </div>
                            
                            <form method="POST" action="{{ route('sekolahbersih.storeVerifikasi') }}" id="form-penilaian">
                                @csrf
                                <div class="main-box-body clearfix">
                                    <div class="table-responsive">
                                        <input type="hidden" id="periode_awal_kuesioner" name="periode_awal_kuesioner" value="{{$model->periode_awal_kuesioner}}">
                                        <input type="hidden" id="periode_akhir_kuesioner" name="periode_akhir_kuesioner" value="{{$model->periode_akhir_kuesioner}}">
                                        <input type="hidden" id="sekolah" name="sekolah" value="{{$model->sekolah}}">

                                        <table width="98%" class="table">
                                            <thead>
                                            <tr>
                                                <td width="2%" style="text-align: center">No</td>
                                                <td width="30%">Parameter</td>
                                                <td width="5%">Score</td>
                                                <td width="8%">Rata-rata</td>
                                                <td width="8%">Kepatuhan</td>
                                                <td width="8%">Keterangan <br/> Kebersihan </td>
                                                <td width="14%">Catatan/Temuan</td>
                                                <td width="5%">Dokumentasi</td>
                                                <td width="15%">Catatan Pemeriksaan</td>
                                            </tr>
                                            </thead>

                                            @php
                                            $no=0;
                                            // $totalkebersihan=0;
                                            // $amountkepatuhan=0;
                                            // $totalkepatuhan=0;
                                            // $total_score=0;

                                            @endphp
                                            @foreach($hasilKuesioner as $i)
                                            @php
                                            $no++;
                                            // $ratarata = $i->score / $i->jumlah_parameter;
                                            // $switchId = 'switch_' . $no;
                                            // $totalkebersihan = $totalrerata/12;
                                            // $max=$i->jumlah_parameter*3;
                                            // $kepatuhan = round(($i->score / $max) * 100);
                                            // $amountkepatuhan += $kepatuhan;
                                            // $totalkepatuhan = $amountkepatuhan /12;

                                            // $total_score += $i->score;


                                            // if ($ratarata >= 2.75) {
                                            // $kesimpulan = '<span class="badge badge-primary">Sangat Bersih</span>';
                                            // $nilai = 4;
                                            // } elseif ($ratarata >= 2.00 && $ratarata < 2.75) {
                                            // $kesimpulan = '<span class="badge badge-success">Bersih</span>';
                                            // $nilai = 3;
                                            // } elseif ($ratarata >= 1.00 && $ratarata < 2.00) {
                                            // $kesimpulan = '<span class="badge badge-info">Cukup Bersih</span>';
                                            // $nilai = 2;
                                            // } elseif ($ratarata == 0) {
                                            // $kesimpulan = '<span class="badge badge-danger">Belum isi</span>';
                                            // $nilai = 0;
                                            // } else {
                                            // $kesimpulan = '<span class="badge badge-warning">Kurang Bersih</span>';
                                            // $nilai = 1;
                                            // }

                                            // if ($kepatuhan >= 85)
                                            // {
                                            // $nilaikepatuhan = 4;
                                            // $kesimpulankepatuhan = '<span class="badge badge-primary">Sangat Baik </span>';
                                            // }
                                            // elseif ($kepatuhan >= 70)
                                            // {
                                            // $nilaikepatuhan = 3;
                                            // $kesimpulankepatuhan = '<span class="badge badge-success">Baik  </span>';
                                            // }
                                            // elseif ($kepatuhan >= 50)
                                            // {
                                            // $nilaikepatuhan = 2;
                                            // $kesimpulankepatuhan = '<span class="badge badge-info"> Cukup </span>';
                                            // }
                                            // elseif ($kepatuhan ==0)
                                            // {
                                            // $nilaikepatuhan = 0;
                                            // $kesimpulankepatuhan = '<span class="badge badge-danger"> Belum isi </span>';
                                            // }
                                            // else {
                                            // $nilaikepatuhan = 1;
                                            // $kesimpulankepatuhan = '<span class="badge badge-warning"> Kurang </span>';
                                            // }

                                            //untuk akhir


                                            @endphp

                                            <tr>
                                                <td style="text-align: center">{{$no}}</td>
                                                <td>{{$i->nama.' ('.$i->jumlah_parameter.')'}}</td>
                                                <td>{{$i->score}}</td>
                                                <td></td>
                                                <td>
                                                    <input type="hidden" id="kepatuhan[{{$no}}]" name="kepatuhan[{{$no}}]" value="">
                                                    <input type="hidden" id="persenkepatuhan[{{$no}}]" name="persenkepatuhan[{{$no}}]" value="">
                                                    <input type="hidden" name="id[{{$no}}]" id="id[{{$no}}]" value="">
                                                </td>
                                                <td>
                                                    <input type="hidden" id="nilai[{{$no}}]" name="nilai[{{$no}}]" value="">
                                                </td>
                                                <td>
                                                    <a href="#"
                                                       class="editable-catatan"
                                                       data-type="text"
                                                       data-pk="{{ $no }}"
                                                       data-name="catatan[{{ $no }}]"
                                                       data-title="Masukkan catatan">
                                                        {{ old("catatan[$no]") ?? '' }}
                                                    </a>

                                                    <input type="hidden" name="txtcatatan[{{ $no }}]" id="txtcatatan_{{ $no }}" value="{{old("catatan[$no]") }}">

                                                </td>
                                                <td>
                                                    <div class="float-left">
                                                        <!--<div class="onoffswitch onoffswitch-danger onoffswitch-sm">-->
                                                        <!--   <input type="checkbox" name="kategori[{{$no}}]" class="onoffswitch-checkbox" id="switch_{{$no}}" checked>-->
                                                        <!--   <label class="onoffswitch-label" for="switch_{{$no}}">-->
                                                        <!--     <div class="onoffswitch-inner"></div>-->
                                                        <!--     <div class="onoffswitch-switch"></div>-->
                                                        <!--   </label>-->
                                                        <!-- </div>-->

                                                        <div class="form-check form-check-inline checkbox-nice">
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                id="dokumentasi_{{ $no }}"
                                                                onchange="updateCheckboxValue({{ $no }})"
                                                            >
                                                            <label class="form-check-label" for="dokumentasi_{{ $no }}">Ada</label>
                                                        </div>
                                                        <br/>
                                                        <input type="hidden" id="dokumentasi_hidden_{{ $no }}" name="dokumentasi[{{ $no }}]" value="0">
                                                </td>
                                                <td width="10%">
                                                    <a href="#"
                                                       class="editable-pemeriksaan"
                                                       data-type="text"
                                                       data-pk="{{ $no }}"
                                                       data-name="pemeriksaan[{{ $no }}]"
                                                       data-title="Masukkan catatan pemeriksaan">
                                                        {{ old("pemeriksaan[$no]") ?? '' }}
                                                    </a>
                                                    <input type="hidden" name="txtpemeriksaan[{{ $no }}]" id="txtpemeriksaan_{{ $no }}" value="{{old("pemeriksaan[$no]") }}">

                                                </td>
                                            </tr>

                                            @endforeach
                                            <tr class="green-bg" style="color: white">
                                                <td colspan="2" style="text-align: center">total</td>
                                                <td colspan="4"> Rata-Rata setelah di bagi 12 Komponen = 
                                                <td colspan="3" style="text-align: center">Tingkat Kepatuhan : </td>
                                            </tr>
                                        </table>
                                    </div>

                                      

                                    <!-- Hidden Inputs untuk total -->
                                    <input type="hidden" id="total_score" name="total_score" value="">
                                    <input type="hidden" id="total_ratarata" name="total_ratarata" value="">
                                    <input type="hidden" id="total_akhir" name="total_akhir" value="">
                                    <input type="hidden" id="nilai_kepatuhan" name="nilai_kepatuhan" value="">
                                    <input type="hidden" id="status_kepatuhan" name="status_kepatuhan" value="">
                                    <input type="hidden" id="nilai_kebersihan" name="nilai_kebersihan" value="">
                                    <input type="hidden" id="status_kebersihan" name="status_kebersihan" value="">
                                    <input type="hidden" id="idcollected" name="idcollected">

                                    <div class="main-box-body clearfix" style="padding: 20px">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row" id="popoverPwd-container">
                                                        <div class="form-group col-md-12">
                                                            <label for="popoverName">Tingkat Kepatuhan </label>
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value=4 >
                                                                    <label for="optionsRadios1">Sangat Baik (≥ 90%)</label>
                                                                </div>
                                                                <div class="radio">
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value=3>
                                                                    <label for="optionsRadios2">Baik (75% – < 90%)</label>
                                                                </div>
                                                                <div class="radio">
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios3" value=2>
                                                                    <label for="optionsRadios3">Cukup (50% – < 75%)</label>
                                                                </div>
                                                                <div class="radio">
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios4" value=1 >
                                                                    <label for="optionsRadios4">Kurang (< 50%)</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="popoverName">Tingkat Kebersihan </label>
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <input type="radio" name="optionsKebersihan" id="optionsKebersihan1" value=4  >
                                                                    <label for="optionsKebersihan1">Sangat Baik (≥ 2.75) </label>
                                                                </div>
                                                                <div class="radio">
                                                                    <input type="radio" name="optionsKebersihan" id="optionsKebersihan2" value=3>
                                                                    <label for="optionsKebersihan2">Baik (> 2.00 – < 2.75)</label>
                                                                </div>
                                                                <div class="radio">
                                                                    <input type="radio" name="optionsKebersihan" id="optionsKebersihan3" value=2>
                                                                    <label for="optionsKebersihan3">Cukup (1.00 – < 2.00)</label>
                                                                </div>
                                                                <div class="radio">
                                                                    <input type="radio" name="optionsKebersihan" id="optionsKebersihans4" value=1>
                                                                    <label for="optionsKebersihans4">Kurang (< 1)</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row" id="popoverPwd-container">
                                                        <div class="form-group col-md-12">
                                                            <label for="popoverName">Tanggal Supervisi </label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="tanggal" name="tanggal" required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="popoverName">Hasil Rekomendasi</label>
                                                            <div class="form-group">
                                                                <select class="form-control" id="jenis_tindak_lanjut" name="jenis_tindak_lanjut">
                                                                    <option value="" disabled selected>Pilih jenis tindak lanjut</option>
                                                                    <option value="1">Pembinaan</option>
                                                                    <option value="2">Penguatan</option>
                                                                    <option value="3">Penghargaan</option>
                                                                    <option value="4">Monitoring Lanjutan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group text-center">
                                                <button class="btn btn-primary tambah" type="submit">Verifikasi</button>
                                            </div>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<!--<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css">-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi datepicker
        $(document).ready(function () {
            $('#tanggal').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                container: 'body'
            }).datepicker('setDate', new Date()); // ✅ Gunakan new Date()
        });


        // Inisialisasi x-editable catatan
        $.fn.editable.defaults.mode = 'inline';

        $('.editable-catatan').editable({
            success: function(response, newValue) {
                var pk = $(this).data('pk');
                var $hiddenInput = $('#txtcatatan_' + pk);
                if ($hiddenInput.length) {
                    $hiddenInput.val(newValue);
                }
                console.log('Hidden input for ' + pk + ' updated to:', newValue);
            }
        });

        // Inisialisasi x-editable pemeriksaan
        $('.editable-pemeriksaan').editable({
            success: function(response, newValue) {
                var pk = $(this).data('pk');
                var $hiddenInput = $('#txtpemeriksaan_' + pk);
                if ($hiddenInput.length) {
                    $hiddenInput.val(newValue);
                }
                console.log('Hidden input for ' + pk + ' updated to:', newValue);
            }
        });
    });

    // Fungsi checkbox update
    function updateCheckboxValue(no) {
        const checkbox = document.getElementById('dokumentasi_' + no);
        const hiddenInput = document.getElementById('dokumentasi_hidden_' + no);

        hiddenInput.value = checkbox.checked ? 1 : 0;
    }

    //colected id
    $(document).ready(function() {
        function updateCollectedIds() {
            let values = [];
            $('input[name^="id["]').each(function() {
                const value = $(this).val().trim();
                if (value !== '' && value !== '0') {
                    values.push(value);
                }
            });
            $('#idcollected').val(values.join(', '));
        }
        updateCollectedIds();
        $(document).on('input', 'input[name^="id["]', updateCollectedIds);
    });

</script>
@endsection
