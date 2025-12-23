@extends('layouts/master')
@section('title', 'Verifikasi Sekolah Bersih oleh Pengawas')

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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data @yield('title')</h3>
                </div>

                <div class="card-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6 d-flex align-items-center">
                            <label for="customLength" class="me-2 mb-0">Tampilkan:</label>
                            <select id="customLength" class="form-select form-select-sm w-auto">
                                <option value="10">10</option>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span class="ms-2">data</span>
                        </div>
                        <div class="col-md-6 text-end">
                            <input type="text" id="customSearch" class="form-control form-control-sm w-50 d-inline-block"
                                placeholder="Cari...">
                        </div>
                    </div>

                    {{-- filter --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="row" id="popoverPwd-container">
                                <div class="form-group col-md-12">
                                    <label for="popoverName">Periode </label>
                                    <div class="form-group">
                                        <input type="text" id="periodeRange" class="form-control form-control"
                                            placeholder="Pilih Periode" autocomplete="off">
                                        <input type="hidden" id="periode_start">
                                        <input type="hidden" id="periode_end">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row" id="popoverPwd-container">
                                <div class="form-group col-md-12">
                                    <label for="popoverName">Sekolah </label>
                                    <div class="form-group">
                                        <select id="sekolah" class="form-select">
                                            <option value="">-- Semua Sekolah --</option>
                                            @foreach ($sekolah as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="row" id="popoverPwd-container">
                                <div class="form-group col-md-12">
                                    <label for="popoverName">Status Kebersihan </label>
                                    <div class="form-group">
                                        <select class="form-control form-select" id="rekap_nilai_kebersihan"
                                            name="rekap_nilai_kebersihan">
                                            <option value="" disabled="" selected="">Pilih status kebersihan
                                            </option>
                                            <option value="4">Sangat Bersih</option>
                                            <option value="3">Bersih</option>
                                            <option value="2">Cukup Bersih</option>
                                            <option value="1">Kurang Bersih</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row" id="popoverPwd-container">
                                <div class="form-group col-md-12">
                                    <label for="popoverName">Hasil Rekomendasi </label>
                                    <div class="form-group">
                                        <select class="form-control form-select" id="hasil_rekomendasi"
                                            name="hasil_rekomendasi">
                                            <option value="" disabled="" selected="">Pilih hasil rekomendasi
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
                    </div>

                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#downloadModal">
                        Cetak Laporan Supervisi Pengawas Sekolah
                    </button>
                    <br /><br />

                    <div class="table-responsive-lg">
                        <table id="tabelku" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20">No.</th>
                                    <th>Sekolah</th>
                                    <th>Periode</th>
                                    <th>Deskripsi</th>
                                    <th>Tgl Supervisi</th>
                                    <th>Status Kebersihan</th>
                                    <th>Status Kepatuhan</th>
                                    <th>Tindak Lanjut</th>
                                    <th width="40">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
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
                            <input type="text" name="dateRange" id="dateRange" class="form-control"
                                placeholder="dd-mm-yyyy - dd-mm-yyyy" required>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.7.1/css/autoFill.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet">

    {{--
    <link rel="stylesheet"
        href="{{ asset('assets/themes') }}/components/datatables.net-bs4/css/dataTables.bootstrap4.min.css"> --}}
    <style>
        .table thead tr th {
            background-color: #0D6EFD !important;
            color: #FFF !important;
            text-align: center;
            /* optional */
            vertical-align: middle;
            /* optional */
            border: 1px solid #dee2e6
        }

        .table td,
        .table th {
            border: 1px solid #dee2e6;
            padding: .5rem;
            vertical-align: top;
            font-size: 12px;
        }

        div.dataTables_length,
        div.dataTables_filter {
            display: none;
        }
    </style>


@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(function () {
            $('#customLength').on('change', function () {
                oTable.page.len($(this).val()).draw();
            });

            // Custom search field
            $('#customSearch').on('keyup', function () {
                oTable.search(this.value).draw();
            });

            var oTable = $('#tabelku').DataTable({
                //order: [[0, "desc"]],
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{route("sekolahbersih.getDataRekapPengawas")}}',
                    data: function (d) {
                        // PERIODE (harus string "YYYY-MM-DD - YYYY-MM-DD")
                        if ($('#periode_start').val() && $('#periode_end').val()) {
                            d.periode = $('#periode_start').val() + ' - ' + $('#periode_end').val();
                        }
                        // SEKOLAH
                        d.id_sekolah = $('#sekolah').val();
                        // STATUS KEBERSIHAN
                        d.status_kebersihan = $('#rekap_nilai_kebersihan').val();
                        // HASIL REKOMENDASI
                        d.hasil_rekomendasi = $('#hasil_rekomendasi').val();
                    }
                },
                columns: [
                    {
                        data: null, sortable: false, render: function (data, type, row, meta) {
                            var i = meta.row + meta.settings._iDisplayStart + 1;
                            return "<a href='show/" + row.id + "' style='text-decoration: none;'>" + i + "</a>"
                        }
                    },
                    { data: 'id_sekolah', name: 'id_sekolah', searchable: true, orderable: true },
                    { data: 'periode_awal', name: 'periode_awal', searchable: true, orderable: true },
                    { data: 'deskripsi', name: 'deskripsi', searchable: true, orderable: true },
                    { data: 'tanggal_supervisi_pengawas', name: 'tanggal_supervisi_pengawas', searchable: true, orderable: true },
                    { data: 'keterangan_kebersihan', name: 'keterangan_kebersihan', searchable: true, orderable: true },
                    { data: 'keterangan_kepatuhan', name: 'keterangan_kepatuhan', searchable: true, orderable: true },
                    { data: 'hasil_rekomendasi', name: 'hasil_rekomendasi', searchable: true, orderable: true },
                    { data: 'action', name: 'action' },
                ]
            });
            $('#sekolah, #rekap_nilai_kebersihan, #hasil_rekomendasi').on('change', function () {
                oTable.ajax.reload();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Inisialisasi date range picker untuk periode
            $('#periodeRange').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear',
                    applyLabel: 'Pilih'
                }
            });

            $('#periodeRange').on('apply.daterangepicker', function (ev, picker) {
                $('#periode_start').val(picker.startDate.format('YYYY-MM-DD'));
                $('#periode_end').val(picker.endDate.format('YYYY-MM-DD'));

                $(this).val(
                    picker.startDate.format('YYYY-MM-DD') +
                    ' - ' +
                    picker.endDate.format('YYYY-MM-DD')
                );

                oTable.ajax.reload();
            });

            $('#periodeRange').on('cancel.daterangepicker', function () {
                $(this).val('');
                $('#periode_start, #periode_end').val('');
                oTable.ajax.reload();
            });
            // Inisialisasi Select2 untuk dropdown sekolah
            $('#sekolah').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Semua Sekolah --',
                allowClear: true,
                width: '100%'
            });
        });


        $(document).ready(function () {
            $("#success_message").delay(9000).slideUp(300);
        });

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

    </script>
    <!---->

    <script>
        $('#btnDownload').click(function (e) {
            e.preventDefault();

            let range = $('#dateRange').val();
            console.log('📌 Date Range dari input:', range);

            if (!range.includes(' - ')) {
                Swal.fire('Error!', 'Format periode tidak valid.', 'error');
                return;
            }

            let parts = range.split(' - ');
            let startParts = parts[0].split('-');
            let endParts = parts[1].split('-');

            let startDate = `${startParts[2]}-${startParts[1]}-${startParts[0]}`;
            let endDate = `${endParts[2]}-${endParts[1]}-${endParts[0]}`;

            console.log('📤 Start Date:', startDate);
            console.log('📤 End Date:', endDate);

            $.ajax({
                //Route::get('sekolahbersih/CetakRekapPengawasPdf', 'SekolahBersihController@CetakRekapPengawasPdf')->name('sekolahbersih.CetakRekapPengawasPdf');

                url: "{{ route('sekolahbersih.CetakRekapPengawasPdf') }}",
                method: 'GET',
                data: { startDate, endDate },
                xhrFields: { responseType: 'blob' },
                beforeSend: function () {
                    console.log('🚀 Mengirim request ke server...');
                },
                success: function (data, status, xhr) {
                    // ✅ Cek apakah server mengembalikan PDF atau JSON
                    let contentType = xhr.getResponseHeader("content-type") || "";
                    if (contentType.includes("application/json")) {
                        // Ini berarti server mengembalikan pesan, bukan PDF
                        let reader = new FileReader();
                        reader.onload = function () {
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
                error: function (xhr) {
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

    </script>
@endsection