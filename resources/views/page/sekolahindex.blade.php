@extends('layouts/master')
@section('title','Sekolah')

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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                    Show
                    <select id="customLength" class="form-select form-select-sm d-inline-block w-auto">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    data
                    </div>
                    <input type="search" id="customSearch" class="form-control form-control-sm w-50" placeholder="Cari...">
                </div>

                <div class="row" id="card-container"></div>

                <div class="d-flex justify-content-center mt-3" id="pagination-controls"></div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('css')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.7.1/css/autoFill.dataTables.min.css">

{{-- <link rel="stylesheet" href="{{ asset('assets/themes') }}/components/datatables.net-bs4/css/dataTables.bootstrap4.min.css"> --}}
<style>
.table thead tr th {
    background-color: #0D6EFD !important;
    color: #FFF !important;
    text-align: center;   /* optional */
    vertical-align: middle; /* optional */
    border: 1px solid #dee2e6
}
.table td, .table th {
    border: 1px solid #dee2e6;
    padding: .5rem;
    vertical-align: top;
    font-size: 12px;
}
div.dataTables_length,
div.dataTables_filter {
  display: none;
}

.table {
  width: 100%;
}
.table td, .table th {
    vertical-align: middle;
}
</style>

@endsection


@section('js')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/modal-animations/modalEffects.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
let currentPage = 1;
let pageLength = 25;
let searchTerm = '';

function loadCards(page = 1, search = '') {
  $.ajax({
    url: '{{ route("GetDataSekolah") }}',
    data: {
      start: (page - 1) * pageLength,
      length: pageLength,
      search: { value: search }
    },
success: function(response) {
  $('#card-container').empty();

  response.data.forEach((item, index) => {   

    $('#card-container').append(`
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">${item.nama} ${item.kabupaten_kota}</h5>
                            <small><i class='fa fa-map'></i> ${item.alamat_jalan} RT/RW:${item.rtrw}</small><br/>
                            <small><i class='fa fa-user'></i> Kepala Sekolah: ${item.kepalasekolah}</small>
                        </div>
                    </div>
                </div>

                <div class="card-footer p-0">          
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tr><th width="30%">NPSN</th><td>${item.npsn}</td></tr>
                            <tr><th>Alamat</th><td>${item.alamat_jalan}</td></tr>
                            <tr><th>Kabupaten/Kota</th><td>${item.kabupaten_kota}</td></tr>
                            <tr><th>Cabdis</th><td>${item.cabdis}</td></tr>
                            <tr><th>Email</th><td>${item.email}</td></tr>
                            <tr><th>Website</th><td>${item.website}</td></tr>
                            <tr><th>Koordinat</th><td>${item.lintang}</td></tr>
                            <tr><th>Telepon</th><td>${item.nomor_telepon}</td></tr>
                            <tr>
                                <th>Instrumen yang dimiliki</th>
                                <td>${item.instrumen.map((nama, index) => `
                                    <div>
                                        <input class="form-check-input" type="checkbox" checked  id="instrumen-${index}">
                                        <label class="form-check-label" for="instrumen-${index}">${nama}</label>
                                    </div>
                                    `).join('')}
                                </td>
                            </tr>
                            ${item.instrumenno && item.instrumenno.length > 0 ? `
                            <tr>
                                <th>Instrumen yang tidak dimiliki</th>
                                <td>
                                    ${item.instrumenno.map((nama, index) => `
                                        <div>
                                            <label class="form-check-label text-danger" for="instrumen-no-${index}">❌ ${nama}</label>
                                        </div>
                                    `).join('')}
                                </td>
                            </tr>
                            ` : ''}                  
                        </table>
                    </div>
                </div>

                <div class="card-footer text-end">
                    ${item.action}
                </div>
            </div>
        </div>
    `);
  });

  renderPagination(response.recordsTotal, page);
}

  });
}

function renderPagination(total, current) {
  const totalPages = Math.ceil(total / pageLength);
  let html = '';
  for (let i = 1; i <= totalPages; i++) {
    html += `<button class="btn btn-sm ${i === current ? 'btn-primary' : 'btn-outline-primary'} me-1" onclick="loadCards(${i}, '${searchTerm}')">${i}</button>`;
  }
  $('#pagination-controls').html(html);
}

$('#customLength').on('change', function () {
  pageLength = parseInt($(this).val());
  loadCards(1, searchTerm);
});

$('#customSearch').on('keyup', function () {
  searchTerm = this.value;
  loadCards(1, searchTerm);
});

$(document).ready(function () {
  loadCards();
});
</script>

<!---->
@endsection
