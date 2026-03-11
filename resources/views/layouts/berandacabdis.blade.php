@extends('layouts/master')
@section('title', 'Dashboard')
@section('css')
    <style>
    .row.grid-equal-height {
      display: grid;
      grid-auto-rows: 1fr;
    }

    .row.grid-equal-height > [class*='col-'] {
      display: flex;
    }

    .main-box {
        background: #FFFFFF;
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
        margin-bottom: 16px;
        /* overflow: hidden; */
        border-radius: 3px;
    }

    .profile-box-contact .main-box-body {
        padding: 0;
    }

    .profile-box-contact .profile-box-header {
        padding: 15px 15px;
        color: #fff;
        border-radius: 3px 3px 0 0;
    }

    /* .profile-box-contact .profile-box-footer {
        padding-top: 10px;
        padding-bottom: 15px;
    } */

    .profile-box-contact .profile-box-footer a {
        display: block;
        width: 33%;
        width: 33.33%;
        float: left;
        text-align: center;
        padding: 15px 10px;
        color: #212121;
        text-decoration: none;
    }

    .profile-box-contact .profile-box-footer .value {
        display: block;
        font-size: 1.8em;
        font-weight: 300;
    }

    .direct-chat-img {
        border-radius: 50%;
        float: left;
        height: 130px;
        width: 130px;
    }

    .col-md-1-5 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    .table-text-sm td, .table-text-sm th { font-size: 0.8rem; /* kecilkan ukuran font */ padding: 0.2rem 0.4rem; /* kecilkan padding */ vertical-align: middle; /* rapikan posisi */ }
    @media (min-width: 768px) {
        .col-md-1-5 {
        flex: 0 0 auto;
        width: 12.5%;
        max-width: 12.5%;
    }
    }

    </style>
@endsection
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                    <div class="inner"><h3>{{ $jumlahsekolah }}</h3><p>Jumlah Sekolah Binaan</p></div>                  
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner"><h3>{{ $counts['on_progress'] }}</h3><p>Verifikasi On Progress</p></div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                    <div class="inner"><h3>{{ $counts['terverifikasi'] }}</h3><p>Verifikasi Selesai</p></div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner"><h3>{{ $counts['belum_lapor'] }}</h3><p>Sekolah Belum Lapor</p></div>                  
                    </div>
                </div>
            </div>

            <div class="main-box clearfix profile-box-contact">
                <div class="main-box-body clearfix">
                    <div class="profile-box-header gray-bg clearfix" style="background-color: #3e5879 !important;">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-1-5">
                                @if(!is_null($user->img) && file_exists(public_path('images/user/' . $user->img)))
                                    <img src="{{ asset('images/user/' . $user->img) }}" alt="Foto Profil" class="direct-chat-img">
                                @else
                                    <img src="{{ asset('images/user/user.png') }}" alt="Default Foto" class="direct-chat-img">
                                @endif
                            </div>
                            <div class="col-md-10"> <!-- kasih padding kecil manual -->
                                <h5 class="widget-user-username">{{$user->username}}</h5>
                                <h6 class="widget-user-desc"> {{$role->name}}</h6>

                                <ul class="contact-details list-unstyled">
                                    <li>
                                        <i class="fa fa-map-marker"></i> Wilayah Binaan : {{$user->binaan}}
                                    </li>
                                    <li>
                                        <i class="fa fa-map-o"></i>  
                                        @php 
                                            $cabdis = App\Models\Cabdis::where('id', $user->cabdis)->first();
                                        @endphp
                                        Instansi: {{$cabdis->deskripsi}}                                        
                                    </li>
                                </ul>
                            </div>
                        </div>                        
                    </div>                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sekolah Belum Lapor</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @php
                                // Definisikan fungsi sekali saja
                                function normalizeWaNumber($number)
                                {
                                    // Buang semua karakter non angka
                                    $num = preg_replace('/[^0-9]/', '', (string) $number);
                                    if ($num === '')
                                        return '';

                                    // Jika diawali 0 → ganti jadi 62
                                    if (substr($num, 0, 1) === '0') {
                                        return '62' . substr($num, 1);
                                    }

                                    // Jika sudah diawali 62 → biarkan
                                    if (substr($num, 0, 2) === '62') {
                                        return $num;
                                    }

                                    // Jika diawali 8 → tambahkan 62
                                    if (substr($num, 0, 1) === '8') {
                                        return '62' . $num;
                                    }

                                    return $num;
                                }
                            @endphp
                            <div class="table-responsive">
                                <table class="table table-bordered table-text-sm" id="tabelku">
                                    <thead>
                                        <tr>
                                            <th width="1%">
                                                <input type="checkbox" id="checkAll" class="checkItem form-check-input">
                                            </th>
                                            <th width="1%">No.</th>
                                            <th width="35%">Sekolah</th>
                                            <th width="15%">Periode</th>
                                            <th width="30%">Nama Kepala Sekolah</th>
                                            <th width="13%">No. HP</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($databelumlapor as $key => $item)
                                            @php
                                                // Pisahkan nomor jika ada tanda /
                                                $numbers = explode('/', $item->nomor_telepon);
                                                // Normalisasi semua nomor
                                                $normalizedNumbers = array_map('normalizeWaNumber', $numbers);
                                            @endphp

                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="checkItem form-check-input" value="{{ $item->nomor_telepon }}">
                                                </td>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->periode_awal }}</td>
                                                <td>{{ $item->kepalasekolah }}</td>
                                                <td>{{ $item->nomor_telepon }}</td>
                                                <td>
                                                    @foreach($normalizedNumbers as $waNumber)
                                                        @if($waNumber !== '')
                                                            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, ini pesan otomatis dari dashboard.') }}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-success">
                                                                <i class="fa fa-whatsapp fa-lg"></i> 
                                                            </a><br>
                                                        @endif
                                                    @endforeach
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    <button id="sendWa" class="btn btn-success">
                                        <i class="fa fa-whatsapp"></i> Kirim WA ke yang terpilih
                                    </button>
                                </div>

                                <div class="card-footer clearfix">
                                    {{ $databelumlapor->links() }}
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Penialaian Sekolah</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i> 
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart"></canvas>
                        </div>
                        <div class="card-body">
                            <div id="customLegend" class="row mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rekap penilaian sekolah -->

            <div class="row mt-3">
                <div class="col-md-6 mt-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sekolah Bersih Terbaik Periode {{ $periodeFormattedlalu }}</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            </div>
                        </div>
                        <div class="card-body">       
                            @if($databeforebaik->count() == 0)
                                <p>Tidak ada data sekolah bersih terbaik pada periode {{ $periodeFormattedlalu }}.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-text-sm" id="tabelbaik">
                                        <thead>
                                            <tr>                                            
                                                <th width="1%">No.</th>
                                                <th width="35%">Sekolah</th>
                                                <th width="30%">Nama Kepala Sekolah</th>
                                                <th width="13%">Hasil Penilaian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($databeforebaik as $baik => $itembaik)
                                                <tr>
                                                    <td>{{ $baik + 1 }}</td>
                                                    <td>{{ $itembaik->nama }}</td>
                                                    <td>{{ $itembaik->kepalasekolah }}</td>
                                                    <td>{{ $itembaik->rekap_keterangan_kebersihan }}</td>                                            
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>                             
                                </div>
                            @endif
                        </div>                        
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Sekolah Butuh Pembinaan Periode {{ $periodeFormattedlalu }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i> 
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($databeforekurang->count() == 0)
                                <p>Tidak ada data sekolah yang butuh pembinaan pada periode {{ $periodeFormattedlalu }}.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-text-sm" id="tabelbaik">
                                        <thead>
                                            <tr>                                            
                                                <th width="1%">No.</th>
                                                <th width="35%">Sekolah</th>
                                                <th width="30%">Nama Kepala Sekolah</th>
                                                <th width="13%">Hasil Penilaian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($databeforekurang as $kurang => $itemkurang)
                                                <tr>
                                                    <td>{{ $kurang + 1 }}</td>
                                                    <td>{{ $itemkurang->nama }}</td>
                                                    <td>{{ $itemkurang->kepalasekolah }}</td>
                                                    <td>{{ $itemkurang->rekap_keterangan_kebersihan }}</td>                                            
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>                             
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>



        </div>
    </div>


@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let selectedNumbers = JSON.parse(localStorage.getItem('selectedNumbers')) || [];

        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('checkAll');
            const checkItems = document.querySelectorAll('.checkItem');

            // restore state checkbox saat halaman load
            checkItems.forEach(cb => {
                if (selectedNumbers.includes(cb.value)) {
                    cb.checked = true;
                }
                cb.addEventListener('change', function() {
                    if (this.checked) {
                        if (!selectedNumbers.includes(this.value)) {
                            selectedNumbers.push(this.value);
                        }
                    } else {
                        selectedNumbers = selectedNumbers.filter(num => num !== this.value);
                    }
                    localStorage.setItem('selectedNumbers', JSON.stringify(selectedNumbers));
                });
            });

            // event untuk checkAll
            checkAll.addEventListener('change', function() {
                if (this.checked) {
                    checkItems.forEach(cb => {
                        cb.checked = true;
                        if (!selectedNumbers.includes(cb.value)) {
                            selectedNumbers.push(cb.value);
                        }
                    });
                } else {
                    checkItems.forEach(cb => {
                        cb.checked = false;
                    });
                    // kosongkan semua nomor di halaman ini
                    selectedNumbers = [];
                }
                localStorage.setItem('selectedNumbers', JSON.stringify(selectedNumbers));
            });
        });

        // fungsi normalisasi nomor WA
        function normalizeNumber(num) {
            let n = num.replace(/[^0-9]/g, '');
            if (n.startsWith('0')) {
                return '62' + n.substring(1);
            } else if (n.startsWith('8')) {
                return '62' + n;
            } else if (n.startsWith('62')) {
                return n;
            }
            return n;
        }

        // tombol kirim WA
        document.getElementById('sendWa').addEventListener('click', function() {
            if (selectedNumbers.length === 0) {
                Swal.fire("Tidak ada nomor yang dipilih!", "", "warning");
                return;
            }

            // normalisasi semua nomor
            let normalized = selectedNumbers.map(num => normalizeNumber(num));

            // tampilkan konfirmasi
            Swal.fire({
                title: "Apakah Anda yakin?",
                html: "Nomor WA yang akan dikirim:<br><b>" + normalized.join("<br>") + "</b>",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Ya, kirim!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    let message = "Halo, ini pesan otomatis dari dashboard.";

                    // kirim satu per satu dengan delay agar aman
                    let i = 0;
                    function sendNext() {
                        if (i < normalized.length) {
                            let waUrl = "https://wa.me/" + normalized[i] + "?text=" + encodeURIComponent(message);
                            window.open(waUrl, '_blank');
                            i++;
                            // delay acak 5–10 detik
                            let delay = Math.floor(Math.random() * 5000) + 5000;
                            setTimeout(sendNext, delay);
                        } else {
                            Swal.fire("Berhasil!", "Pesan sudah dikirim ke nomor terpilih.", "success");
                        }
                    }
                    sendNext();
                }
            });
        });


    </script>

    <script>
        const ctx = document.getElementById('pieChart').getContext('2d');

        const data = {
            labels: {!! json_encode(array_keys($datapie)) !!},
            datasets: [{
                data: {!! json_encode(array_values($datapie)) !!},
                backgroundColor: [
                    '#00a65a', // hijau
                    '#36A2EB', // biru
                    '#f56954', // merah
                    '#FFCE56', // kuning
                ],
                borderWidth: 1,
                hoverOffset: 20, // slice keluar 20px saat di-hover
                // offset slice tertentu (misalnya slice ke-2 disorot keluar 20px)
                offset: [0, 20, 0, 0]
            }]
        };

        const pieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // matikan legend bawaan
                    }
                }
            }
        });

        // Buat legend custom di div
        const legendContainer = document.getElementById('customLegend');
        const labels = data.labels;
        const colors = data.datasets[0].backgroundColor;

        let legendHTML = '';
        labels.forEach((label, i) => {
            legendHTML += `
                <div class="col-md-6 col-sm-6 mb-2 d-flex align-items-center">
                    <span style="display:inline-block;width:20px;height:20px;background:${colors[i]};margin-right:8px;"></span>
                    ${label}
                </div>
            `;
        });
        legendContainer.innerHTML = legendHTML;
    </script>
@endsection
