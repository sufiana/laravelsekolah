@extends('layouts/master')
@section('title','Rekap Pengawas')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Data @yield('title')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    {{-- <header class="main-box-header clearfix">
                        <h2 class="float-left">Data @yield('title')</h2>
                        <a href="{{ route('sekolahbersih.create') }}" class="btn btn-turqoise float-right">
                            <i class="fa fa-plus-circle fa-lg"></i> Tambah
                        </a>
                    </header> --}}

                    <div class="main-box-body clearfix">
                        <div role="alert" id="success_message"></div>
                        <div class="table-responsive">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#downloadModal">
                               Cetak Laporan Supervisi Pengawas Sekolah
                            </button>
                            <table class="table table-bordered table-striped table-hover" id="tabelku">
                                <thead>
                                <tr class="green-bg" style="color: white">
                                    <th width="20"><a href="#" style="color: white">No.</a></th>
                                    <th><a href="#" style="color: white">Sekolah</a></th>
                                    <th><a href="#" style="color: white">Periode</a></th>
                                    <th><a href="#" style="color: white">Status Kebersihan</a></th>
                                    <th><a href="#" style="color: white">Status Kepatuhan</a></th>
                                    <th><a href="#" style="color: white">Tgl Supervisi</a></th>
                                    <th><a href="#" style="color: white">Hasil Rekomendasi</th>
                                    <th width="40"><a href="#" style="color: white">Action</a></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>dateRange
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downloadModalLabel">Pilih Periode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="downloadForm">
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <input type="text" name="dateRange" id="dateRange" class="form-control" placeholder="dd-mm-yyyy - dd-mm-yyyy" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="btnDownload">Download</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">-->
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


@endsection

@section('js')

<!-- jQuery (harus pertama -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 Bundle (Popper + JS) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="{{ asset('assets/themes') }}/components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Date Range Picker -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Optional: modalEffects.js (jika benar-benar dipakai) -->
<script src="{{ asset('assets/themes') }}/components-custom/modal-animations/modalEffects.js"></script>

<script>
    $(document).ready(function () {

        // Setup CSRF token untuk semua AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inisialisasi DataTable
        var oTable = $('#tabelku').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('sekolahbersih.getDataRekapPengawas') }}",
                error: function(xhr, error, code) {
                    console.error("Ajax Error:", error);
                    console.error("Status Code:", xhr.status);
                    Swal.fire('Error', 'Gagal memuat data. Cek konsol untuk detail.', 'error');
                }
            },
            columns: [
                { 
                    data: 'id', 
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'nama', name: 'nama' },
                { data: 'periode_awal_kuesioner', name: 'periode_awal_kuesioner' },
                { data: 'status_kebersihan', name: 'status_kebersihan' },
                { data: 'status_kepatuhan', name: 'status_kepatuhan' },
                { data: 'tgl_supervisi', name: 'tgl_supervisi' },
                { data: 'catatan_pengawas', name: 'catatan_pengawas' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                processing: "Sedang memuat data...",
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ada data ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(difilter dari _MAX_ total entri)",
                search: "Cari:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        // Inisialisasi Date Range Picker
        $('#dateRange').daterangepicker({
            startDate: moment().startOf('month'),   // Awal bulan ini
            endDate: moment().endOf('month'),       // Akhir bulan ini
            opens: 'left',
            locale: {
                format: 'DD-MM-YYYY',
                applyLabel: "Pilih",
                cancelLabel: "Batal",
                fromLabel: "Dari",
                toLabel: "Sampai",
                customRangeLabel: "Pilih Rentang"
            }
        });
    });
</script>

<script>

$('#btnDownload').click(function(e) {
    e.preventDefault();

    let range = $('#dateRange').val();
    console.log('📌 Date Range dari input:', range);

    if (!range.includes(' - ')) {
        Swal.fire('Error!', 'Format periode tidak valid.', 'error');
        return;
    }

    let parts = range.split(' - ');
    let startParts = parts[0].split('-');
    let endParts   = parts[1].split('-');

    let startDate = `${startParts[2]}-${startParts[1]}-${startParts[0]}`;
    let endDate   = `${endParts[2]}-${endParts[1]}-${endParts[0]}`;

    console.log('📤 Start Date:', startDate);
    console.log('📤 End Date:', endDate);

    $.ajax({
        url: "{{ route('sekolahbersih.CetakRekapPengawas') }}",
        method: 'GET',
        data: { startDate, endDate },
        xhrFields: { responseType: 'blob' },
        beforeSend: function() {
            console.log('🚀 Mengirim request ke server...');
        },
        success: function(data, status, xhr) {
            // ✅ Cek apakah server mengembalikan PDF atau JSON
            let contentType = xhr.getResponseHeader("content-type") || "";
            if (contentType.includes("application/json")) {
                // Ini berarti server mengembalikan pesan, bukan PDF
                let reader = new FileReader();
                reader.onload = function() {
                    let res = JSON.parse(reader.result);
                    if (res.status === 'nodata') {
                        Swal.fire('Maaf!', res.message, 'warning');
                    } else {
                        Swal.fire('Gagal!', res.message || 'Terjadi kesalahan.', 'error');
                    }
                };
                reader.readAsText(data);
                return;
            }

            // ✅ Kalau PDF, proses download
            let blob = new Blob([data], { type: 'application/pdf' });
            let link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = `Laporan_Supervisi_${parts[0]}_sd_${parts[1]}.pdf`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('Berhasil!', 'File berhasil diunduh.', 'success');
        },
        error: function(xhr) {
            console.error('❌ Error dari server:', xhr);
            let res = xhr.responseJSON || {};
            if (res.status === 'nodata') {
                Swal.fire('Maaf!', res.message, 'warning');
            } else {
                Swal.fire('Gagal!', res.message || 'Terjadi kesalahan.', 'error');
            }
        }
    });
});
        
/*
            if(pegawai && pegawailain && tgla && tglb) {
            $('#isitable').empty();
            $('#responnya').empty();
            $('#kosong').empty();
            $.ajax({
                type: 'GET',
                url: 'cekjadwalspt',
                data: {'pegawaiarray': pegawaiarray, 'tgla': tgla, 'tglb': tglb},
                dataType: "json",
                contentType: 'application/json; charset=ytf-8',
                success: function (data) {
                    $('#modalcekjadwal').modal('show');
                    if (data.sql.length >= 1) {
                        for (var i = 0; i < data.sql.length; i++) {
                            let ptext = data.sql[i].pegawai;
                            let rtext = ptext.replace(';-;', '\n');

                            var kode='';
                            if(data.sql[i].no_spt == null)
                                kode=data.sql[i].kode_spt;
                            else
                                kode=data.sql[i].no_spt;

                            $('#responnya').html(data.response);
                            var row = $('<tr><td style="font-size: 10px !important;">' + data.sql[i].no_spt + '</td><td>' + rtext + '</td><td>' + data.sql[i].tanggal + '</td></tr>');
                            $('#myTable').append(row);
                        }
                    } else {
                        //$('#myTable').empty();
                        //$('#isitable').empty();
                        if (tgl1dmy == tgl2dmy) {
                            var pesan = tgl1dmy;
                        } else {
                            var pesan = tgl1dmy + ' s/d ' + tgl2dmy;
                        }
                        $('#kosong').html('Tidak Ada Jadwal SPT ' + pesan + ' untuk Anggota tersebut.. Silahkan Lanjutkan untuk menyimpan SPT ini');
                    }
                },

                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }


            });
        }
        */

</script>


@endsection