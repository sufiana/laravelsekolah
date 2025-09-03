<div id="nav-col">
    <section id="col-left" class="col-left-nano">
        <div id="col-left-inner" class="col-left-nano-content">
            <div id="user-left-box" class="clearfix d-none d-lg-block profile2-dropdown text-center">
                <div style="display: flex; justify-content: center;">
                    <img src="{{ asset('images/logosm.png') }}" style="width: 60%;" />
                </div>
                <h5 style="font-size: 16px; color: #3e5879">KOLABORASI</h5>
                <h5 style="font-size: 12px; color: #3e5879; font-weight: bold; line-height: 1px">SUMUT BERKAH</h5>
                <h5 style="font-size: 12px; color: #3e5879">DISDIK</h5>
                <h5 style="font-size: 12px; color: #3e5879; font-weight: bold; line-height: 10px">SEKOLAH BERSIH</h5>
            </div>
            @php $user = Auth::user(); @endphp


            <div class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
                    <ul class="nav navbar-nav nav-pills nav-stacked">
                        <li class="nav-header nav-header-first d-none d-lg-block">Navigation</li>
                        <li class="active">
                            <a href="{{ route('home') }}">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="dropdown-toggle dropdown-nocaret">
                                <i class="fa fa-table"></i>
                                <span>Data Master</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('ListParameter') }}">List Parameter</a></li>
                                <li><a href="{{ route('ListSekolah') }}">Data Sekolah</a></li>
                                <li><a href="{{ route('verifikator.index') }}">User Verifikator</a></li>
                            </ul>                            
                        </li>
                        @if($user)
                        @if($user->role==4)
                        <li>
                            <a href="#" class="dropdown-toggle dropdown-nocaret">
                                <i class="fa fa-money"></i><span>Manajemen Data</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('sekolahbersih.indexdinas') }}">Verifikasi</a></li>
                                <li><a href="">Rekap</a></li>
                                <li><a href="">Laporan</a></li>
                            </ul>
                        </li>
                        @elseif($user->role==6)
                        <li>
                            <a href="#" class="dropdown-toggle dropdown-nocaret">
                                <i class="fa fa-money"></i><span>Manajemen Data</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('sekolahbersih.indexpengawas') }}">Verifikasi</a></li>
                                <li><a href="{{ route('sekolahbersih.rekappengawas') }}">Rekap</a></li>
                                <li><a href="">Laporan</a></li>
                            </ul>
                        </li>
                        @elseif($user->role==2 || $user->role==3)
                        <li>
                            <a href="#" class="dropdown-toggle dropdown-nocaret">
                                <i class="fa fa-money"></i><span>Manajemen Data</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('sekolahbersih.indexsekolah') }}">Lihat Data</a></li>
                            </ul>
                        </li>
                        @endif
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div id="nav-col-submenu"></div>
</div>
