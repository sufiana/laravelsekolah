<div id="nav-col">
    <section id="col-left" class="col-left-nano">
        <div id="col-left-inner" class="col-left-nano-content">
            <div id="user-left-box" class="clearfix d-none d-lg-block profile2-dropdown">
                <img alt="" src="{{ asset('assets/themes') }}/img/samples/scarlet-159.png" />
                <div class="user-box">
                    <span class="dropdown name">
                        <a href="#" class="dropdown-nocaret dropdown-toggle" data-toggle="dropdown">SPPD<i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="item"><a href="user-profile.html"><i class="fa fa-user"></i>Profile</a></li>
                            <li class="item"><a href="#"><i class="fa fa-cog"></i>Settings</a></li>
                            <li class="item"><a href="#"><i class="fa fa-envelope-o"></i>Messages</a></li>
                            <li class="item"><a href="#"><i class="fa fa-power-off"></i>Logout</a></li>
                        </ul>
                    </span>
                    <span class="status"><i class="fa fa-circle"></i> Online</span>
                </div>
            </div>
            <div class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
                    <ul class="nav navbar-nav nav-pills nav-stacked">
                        <li class="nav-header nav-header-first d-none d-lg-block">Navigation</li>
                        <li class="active">
                            <a href="index.html">
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
                                <li>
                                    <a href="#" class="dropdown-toggle dropdown-nocaret">
                                        Lokasi
                                        <i class="fa fa-angle-right drop-icon"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('provinsi.index') }}">Povinsi</a></li>
                                        <li><a href="{{ route('kabupatenkota.index') }}">Kabupaten / Kota</a></li>
                                        <li><a href="{{ route('kecamatan.index') }}">Kecamatan</a></li>
                                        <li><a href="{{ route('kelurahan.index') }}">kelurahan</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#" class="dropdown-toggle dropdown-nocaret">
                                        Program & Kegiatan
                                        <i class="fa fa-angle-right drop-icon"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('program.index') }}">Program</a></li>
                                        <li><a href="{{ route('programkegiatan.index') }}">Kegaiatan</a></li>
                                        <li><a href="{{ route('subkegiatan.index') }}">Sub Kegiatan</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#" class="dropdown-toggle dropdown-nocaret">
                                        Ref. Kepegawaian
                                        <i class="fa fa-angle-right drop-icon"></i>
                                    </a>
                                    <ul class="submenu">
<!--                                        <li><a href="{{ route('agama.index') }}">Agama</a></li>-->
<!--                                        <li><a href="{{ route('pendidikan.index') }}">Pendidikan</a></li>-->
<!--                                        <li><a href="{{ route('statusjabatan.index') }}">Status Jabatan</a></li>-->
                                        <li><a href="{{ route('pangkat.index') }}">Pangkat</a></li>
                                        <li><a href="{{ route('golongan.index') }}">Golongan</a></li>
                                        <li><a href="{{ route('jabatan.index') }}">Jabatan</a></li>
                                        <li><a href="{{ route('statuspegawai.index') }}">Status Pegawai</a></li>
                                        <li><a href="{{ route('eselon.index') }}">Eselon</a></li>

                                    </ul>
                                </li>

                                <li><a href="{{ route('angkutan.index') }}">Jenis Angkutan</a></li>

                                <li><a href="{{ route('transportasi.index') }}">Jenis Transportasi</a></li>
<!--                                <li><a href="{{ route('rekening.index') }}">Rekening</a></li>-->
                                <li><a href="{{ route('beban.index') }}">Rekening</a></li>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle dropdown-nocaret">
                                <i class="fa fa-money"></i><span>Manajemen Anggaran</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('jenisbiaya.index') }}">Jenis Biaya</a></li>
                                <li><a href="{{ route('statuswilayahbiaya.index') }}">Status Wilayah Biaya</a></li>
                                <li><a href="{{ route('biaya.index') }}">Manajemen Biaya</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle dropdown-nocaret">
                                <i class="fa fa-users"></i>
                                <span>Pegawai/Pejabat</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('pegawai.index') }}">Data Pegawai</a></li>
                                <li><a href="{{ route('pejabatttd.index') }}">Pemberi Perintah</a></li>
                                <li><a href="{{ route('jabatanttd.index') }}">Jabatan TTD</a></li>
                            </ul>
                        </li>
<!--                        <li>-->
<!--                            <a href="{{ route('nppd.index') }}">-->
<!--                                <i class="fa fa-credit-card"></i>-->
<!--                                <span>NPPD</span>-->
<!--                                <span class="badge badge-success float-right">1</span>-->
<!--                            </a>-->
<!--                        </li>-->


                        <li class="{{ request()->is('spt/*') ? 'active open' : '' }}">
                            <a href="{{route('spt.index')}}">
                                <i class="fa fa-table"></i>
                                <span>SPT</span>
                                <span class="badge badge-primary float-right">5</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('sppd/create') ||  request()->is('sppd/index') ? 'active open' : '' }}">
                            <a href="{{route('sppd.index')}}">
                                <i class="fa fa-table"></i>
                                <span>SPPD</span>
                                <span class="badge badge-primary float-right">7</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('sppd/indexLaporan') || request()->is('sppd/BuatLaporan/*') ? 'active open' : '' }}">
                            <a href="{{route('sppd.indexLaporan')}}">
                                <i class="fa fa-table"></i>
                                <span>Laporan SPPD</span>
                                <span class="badge badge-primary float-right">7</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('sppd/createtandaterima') || request()->is('sppd/indexTandaTerima') || request()->is('sppd/BuatTerbitkanTandaTerima/*')  ? 'active open' : '' }}">
                            <a href="{{route('sppd.indexTandaTerima')}}">
                                <i class="fa fa-table"></i>
                                <span>Tanda Terima SPPD</span>
                                <span class="badge badge-primary float-right">7</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('sppd/indexKwitansi') || request()->is('sppd/createkwitansi') || request()->is('sppd/BuatTerbitkanKwitansi/*')  ? 'active open' : '' }}">
                            <a href="{{route('sppd.indexKwitansi')}}">
                                <i class="fa fa-table"></i>
                                <span>Kwitansi SPPD</span>
                                <span class="badge badge-primary float-right">7</span>
                            </a>
                        </li>

                        <!--                        <li>-->
<!--                            <a href="#" class="dropdown-toggle dropdown-nocaret">-->
<!--                                <i class="fa fa-table"></i>-->
<!--                                <span>SPT</span>-->
<!--                                <span class="badge badge-primary float-right">5</span>-->
<!--                                <i class="fa fa-angle-right drop-icon"></i>-->
<!--                            </a>-->
<!--                            <ul class="submenu">-->
<!--                                <li><a href="{{ route('spt.index') }}">Data SPT</a></li>-->
<!--                                <li><a href="{{ route('spt.create') }}">Tambah SPT</a></li>-->
<!--                                <li><a href="{{ route('spt.indexsptditolak') }}">SPT Belum Di Proses</a></li>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->

                        <li>
                            <a href="#" class="dropdown-toggle dropdown-nocaret">
                                <i class="fa fa-table"></i>
                                <span>SPPD</span>
                                <span class="badge badge-primary float-right">5</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('sppd.List') }}">Data History</a></li>
                                <li><a href="{{ route('sppd.create') }}">Tambah SPPD </a></li>
                                <li><a href="{{ route('sppd.index') }}">Data SPPD </a></li>
<!--                                <li><a href="{{ route('sppd.index') }}">Verifikasi & Cetak SPPD</a></li>-->
                                <li><a href="{{ route('sppd.createlaporan') }}">Terbitkan Laporan SPPD</a></li>
                                <li><a href="{{ route('sppd.indexLaporan') }}">Data Laporan SPPD</a></li>
                                <li><a href="{{ route('sppd.createtandaterima') }}">Terbitkan Tanda Terima</a></li>
                                <li><a href="{{ route('sppd.indexTandaTerima') }}">Data Tanda Terima</a></li>
                                <li><a href="{{ route('sppd.createkwitansi') }}">Terbitkan Kwitansi</a></li>
                                <li><a href="{{ route('sppd.indexKwitansi') }}">Data Kwitansi</a></li>
                            </ul>
                        </li>





                        <li>
                            <a href="#" class="dropdown-toggle dropdown-nocaret">
                                <i class="fa fa-bar-chart"></i>
                                <span>laporan</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="graphs-morris.html">Laporan SPT</a></li>
                                <li><a href="graphs-dygraphs.html">Laporan SPPD</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div id="nav-col-submenu"></div>
</div>
