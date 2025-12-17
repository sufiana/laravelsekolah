@php $user = Auth::user(); @endphp

<aside class="app-sidebar bg-light-subtle" data-bs-theme="light">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('images') }}/flyer.png" width="100%" />
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p> Data Master <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ListParameter') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>List Instrumen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ListSekolah') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Data Sekolah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('verifikator.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>User Verifikator</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">DOCUMENTATIONS</li>
                @if($user)
                    @if($user->role == 4)
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p> Manajemen Data<i class="nav-arrow bi bi-chevron-right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('sekolahbersih.indexdinas') }}" class="nav-link"><i
                                            class="nav-icon bi bi-circle"></i>
                                        <p>Verifikasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i>
                                        <p>Rekap</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i>
                                        <p>Laporan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    @elseif($user->role == 6)
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p> Manajemen Data<i class="nav-arrow bi bi-chevron-right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('sekolahbersih.indexpengawas') }}" class="nav-link"><i
                                            class="nav-icon bi bi-circle"></i>
                                        <p>Verifikasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('sekolahbersih.rekappengawas') }}" class="nav-link"><i
                                            class="nav-icon bi bi-circle"></i>
                                        <p>Rekap</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i>
                                        <p>Laporan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    @elseif($user->role == 2 || $user->role == 3)
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p> Manajemen Data<i class="nav-arrow bi bi-chevron-right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('sekolahbersih.indexsekolah') }}" class="nav-link"><i
                                            class="nav-icon bi bi-circle"></i>
                                        <p>Lihat Data</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('sekolahbersih.indexValidasi') }}" class="nav-link"><i
                                            class="nav-icon bi bi-circle"></i>
                                        <p>Validasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('sekolahbersih.indexsubmitValidasi') }}" class="nav-link"><i
                                            class="nav-icon bi bi-circle"></i>
                                        <p>Data Validasi Instrumen</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i>
                                        <p>Laporan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            </ul>
        </nav>
    </div>
</aside>