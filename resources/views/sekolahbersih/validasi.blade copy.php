
    <div class="row">
        <div class="col-lg-12">

            <div class="row">
                @if(session('error'))
                <div class="alert alert-danger">
                    <strong>{{ session('error') }}</strong><br>
                    <code>{{ session('exception') }}</code><br>
                    <details>
                        <summary>Trace</summary>
                        <pre>{{ session('trace') }}</pre>
                    </details>
                </div>
@endif
                <div class="col-12">

                    <div class="main-box clearfix profile-box-contact">
                        <div class="main-box-body clearfix">


                            
                            <form method="POST" action="{{ route('sekolahbersih.storeValidasi') }}" id="form-penilaian">
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
                                        $totalrerata = 0;
                                        $totalkebersihan=0;
                                        $amountkepatuhan=0;
                                        $totalkepatuhan=0;
                                        $total_score=0;

                                        @endphp
                                        @foreach($hasilKuesioner as $i)
                                        @php
                                        $no++;
                                        $ratarata = $i->score / $i->jumlah_parameter;
                                        $switchId = 'switch_' . $no;
                                        $totalrerata += $ratarata;
                                        $totalkebersihan = $totalrerata;
                                        $max=$i->jumlah_parameter*4;
                                        $kepatuhan = round(($i->score / $max) * 100);
                                        $amountkepatuhan += $kepatuhan;
                                        $totalkepatuhan = $amountkepatuhan /12;

                                        $total_score += $i->score;


                                        if ($ratarata >= 3.75) {
                                        $kesimpulan = '<span class="badge badge-primary">Sangat Bersih</span>';
                                        $nilai = 4;
                                        } elseif ($ratarata >= 3.00 && $ratarata < 3.75) {
                                        $kesimpulan = '<span class="badge badge-success">Bersih</span>';
                                        $nilai = 3;
                                        } elseif ($ratarata >= 2.00 && $ratarata < 3.00) {
                                        $kesimpulan = '<span class="badge badge-info">Cukup Bersih</span>';
                                        $nilai = 2;
                                        } elseif ($ratarata == 0) {
                                        $kesimpulan = '<span class="badge badge-danger">Belum isi</span>';
                                        $nilai = 0;
                                        } else {
                                        $kesimpulan = '<span class="badge badge-warning">Kurang Bersih</span>';
                                        $nilai = 1;
                                        }

                                        if ($kepatuhan >= 85)
                                        {
                                        $nilaikepatuhan = 4;
                                        $kesimpulankepatuhan = '<span class="badge badge-primary">Sangat Baik </span>';
                                        }
                                        elseif ($kepatuhan >= 70)
                                        {
                                        $nilaikepatuhan = 3;
                                        $kesimpulankepatuhan = '<span class="badge badge-success">Baik  </span>';
                                        }
                                        elseif ($kepatuhan >= 50)
                                        {
                                        $nilaikepatuhan = 2;
                                        $kesimpulankepatuhan = '<span class="badge badge-info"> Cukup </span>';
                                        }
                                        elseif ($kepatuhan ==0)
                                        {
                                        $nilaikepatuhan = 0;
                                        $kesimpulankepatuhan = '<span class="badge badge-danger"> Belum isi </span>';
                                        }
                                        else {
                                        $nilaikepatuhan = 1;
                                        $kesimpulankepatuhan = '<span class="badge badge-warning"> Kurang </span>';
                                        }

                                        //untuk akhir


                                        @endphp

                                        <tr>
                                            <td style="text-align: center">{{$no}}</td>
                                            <td>{{$i->nama.' ('.$i->jumlah_parameter.')'}}</td>
                                            <td>{{$i->score}}</td>
                                            <td>{{round($ratarata, 2)}}</td>
                                            <td>
                                                <!--{{round($kepatuhan)}}-->
                                                {!!$kesimpulankepatuhan!!}
                                                <input type="hidden" id="kepatuhan[{{$no}}]" name="kepatuhan[{{$no}}]" value="{{$nilaikepatuhan}}">
                                                <input type="hidden" id="persenkepatuhan[{{$no}}]" name="persenkepatuhan[{{$no}}]" value="{{$kepatuhan}}">
                                                <input type="hidden" name="id[{{$no}}]" id="id[{{$no}}]" value="{{ $i->idnya }}">
                                            </td>
                                            <td>
                                                {!!$kesimpulan!!}
                                                <input type="hidden" id="nilai[{{$no}}]" name="nilai[{{$no}}]" value="{{$nilai}}">
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
                                            <td colspan="4">{{round($totalrerata, 2)}} Rata-Rata setelah di bagi 12 Komponen = {{round($totalkebersihan,2)}}</td>
                                            <td colspan="3" style="text-align: center">Tingkat Kepatuhan : {{round($totalkepatuhan,2). ' %'}}</td>
                                        </tr>
                                    </table>
                                </div>

                                @php
                                    if($totalkepatuhan >= 85 ) {
                                        $nilaiakhirkepatuhan = 4;
                                        $statuskepatuhan='Sangat Baik';
                                    }
                                    elseif ($totalkepatuhan >= 70) {
                                        $nilaiakhirkepatuhan = 3;
                                        $statuskepatuhan='Baik';
                                    }
                                    elseif ($totalkepatuhan >= 50) {
                                        $nilaiakhirkepatuhan = 2;
                                        $statuskepatuhan='Cukup';
                                    }
                                    else {
                                        $nilaiakhirkepatuhan = 1;
                                        $statuskepatuhan='Kurang';
                                    }

                                    if($totalkebersihan  >= 3.75) {
                                        $nilaiakhirkebersihan=4;
                                        $statuskebersihan='Sangat';
                                    }
                                    else if($totalkebersihan  >= 3.00 && $totalkebersihan < 3.75) {
                                        $nilaiakhirkebersihan=3;
                                        $statuskebersihan='Baik';
                                    }
                                    else if($totalkebersihan  >= 1.75 && $totalkebersihan < 3.00) {
                                        $nilaiakhirkebersihan=2;
                                        $statuskebersihan='Cukup';
                                    }
                                    else {
                                        $nilaiakhirkebersihan=1;
                                        $statuskebersihan='Kurang';
                                    }

                                @endphp

                                <!-- Hidden Inputs untuk total -->
                                <input type="hidden" id="total_score" name="total_score" value="{{$total_score}}">
                                <input type="hidden" id="total_ratarata" name="total_ratarata" value="{{round($totalrerata,2)}}">
                                <input type="hidden" id="total_akhir" name="total_akhir" value="{{round($totalkebersihan,2)}}">
                                <input type="hidden" id="nilai_kepatuhan" name="nilai_kepatuhan" value="{{$nilaiakhirkepatuhan}}">
                                <input type="hidden" id="status_kepatuhan" name="status_kepatuhan" value="{{$statuskepatuhan}}">
                                <input type="hidden" id="nilai_kebersihan" name="nilai_kebersihan" value="{{$nilaiakhirkebersihan}}">
                                <input type="hidden" id="status_kebersihan" name="status_kebersihan" value="{{$statuskebersihan}}">
                                <input type="hidden" id="idcollected" name="idcollected">

                                <div class="main-box-body clearfix" style="padding: 20px">
                                        {{--
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row" id="popoverPwd-container">
                                                    <div class="form-group col-md-12">
                                                        <label for="popoverName">Tingkat Kepatuhan </label>
                                                        <div class="form-group">
                                                            <div class="radio">
                                                                <input type="radio" name="optionsRadios" id="optionsRadios1" value=4 <?php echo ($nilaiakhirkepatuhan == 4) ? 'checked' : ''; ?> >
                                                                <label for="optionsRadios1">Sangat Baik (≥ 90%)</label>
                                                            </div>
                                                            <div class="radio">
                                                                <input type="radio" name="optionsRadios" id="optionsRadios2" value=3 <?php echo ($nilaiakhirkepatuhan == 3) ? 'checked' : ''; ?>>
                                                                <label for="optionsRadios2">Baik (75% – < 90%)</label>
                                                            </div>
                                                            <div class="radio">
                                                                <input type="radio" name="optionsRadios" id="optionsRadios3" value=2 <?php echo ($nilaiakhirkepatuhan == 2) ? 'checked' : ''; ?>>
                                                                <label for="optionsRadios3">Cukup (50% – < 75%)</label>
                                                            </div>
                                                            <div class="radio">
                                                                <input type="radio" name="optionsRadios" id="optionsRadios4" value=1 <?php echo ($nilaiakhirkepatuhan == 1) ? 'checked' : ''; ?>>
                                                                <label for="optionsRadios4">Kurang (< 50%)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="popoverName">Tingkat Kebersihan {{$nilaiakhirkebersihan}}</label>
                                                        <div class="form-group">
                                                            <div class="radio">
                                                                <input type="radio" name="optionsKebersihan" id="optionsKebersihan1" value=4 <?php echo ($nilaiakhirkebersihan == 4) ? 'checked' : ''; ?> >
                                                                <label for="optionsKebersihan1">Sangat Baik (≥ 3.75) </label>
                                                            </div>
                                                            <div class="radio">
                                                                <input type="radio" name="optionsKebersihan" id="optionsKebersihan2" value=3 <?php echo ($nilaiakhirkebersihan == 3) ? 'checked' : ''; ?>>
                                                                <label for="optionsKebersihan2">Baik (> 3.00 – < 3.75)</label>
                                                            </div>
                                                            <div class="radio">
                                                                <input type="radio" name="optionsKebersihan" id="optionsKebersihan3" value=2 <?php echo ($nilaiakhirkebersihan == 2) ? 'checked' : ''; ?>>
                                                                <label for="optionsKebersihan3">Cukup (> 1.75 – < 3)</label>
                                                            </div>
                                                            <div class="radio">
                                                                <input type="radio" name="optionsKebersihan" id="optionsKebersihans4" value=1 <?php echo ($nilaiakhirkebersihan == 1) ? 'checked' : ''; ?> >
                                                                <label for="optionsKebersihans4">Kurang (< 1.75)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        --}}

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="row" id="popoverPwd-container">
                                                    <div class="form-group col-md-12">
                                                        <label for="popoverName">Tanggal Validasi </label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="tanggal" name="tanggal" required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="popoverName">Disusun Oleh</label>
                                                        <div class="form-group">
                                                            @if($verifikator && count($verifikator) > 0)
                                                                <select name="user_validator" id="user_validator" class="form-control">
                                                                    @foreach($verifikator as $user)
                                                                        <option value="{{ $user->id }}" {{ old('user_validator') == $user->id ? 'selected' : '' }}>
                                                                            {{ $user->verifikator.' - jabatan '.$user->jabatan }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="alert alert-warning">
                                                                    Data verifikator sekolah tidak ditemukan. 
                                                                    Silakan <a href="{{ route('verifikator.create') }}">tambahkan verifikator</a> terlebih dahulu.
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="popoverName">Mengetahui</label>
                                                        <div class="form-group">
                                                            @if($verifikator && count($verifikator) > 0)
                                                                <select name="user_validator_kepsek" id="user_validator_kepsek" class="form-control">
                                                                    @foreach($verifikator as $kepsek)
                                                                        <option value="{{ $kepsek->id }}" {{ old('user_validator_kepsek') == $kepsek->id ? 'selected' : '' }}>
                                                                            {{ $kepsek->verifikator.' - jabatan '.$kepsek->jabatan }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="alert alert-warning">
                                                                    Data verifikator sekolah tidak ditemukan. 
                                                                    Silakan <a href="{{ route('verifikator.create') }}">tambahkan verifikator</a> terlebih dahulu.
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="dokumentasi">Dokumetasi</label>
                                            <textarea id="dokumentasi" name="dokumentasi" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="kendala">Kendala</label>
                                            <textarea id="kendala" name="kendala" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="hasil_evaluasi">Hasil Rekomendasi dan Evaluasi</label>
                                            <textarea id="hasil_evaluasi" name="hasil_evaluasi" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group text-center">
                                            <button class="btn btn-primary tambah" type="submit">Verifikasi</button>
                                        </div>
                                </div>
                            </div>
                        </form>
                            
                        </div>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>