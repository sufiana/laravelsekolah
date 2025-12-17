<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: auto;
            /* auto is the current printer page size */
            margin: 2mm 7mm 0mm 7mm;
            /* this affects the margin in the printer settings */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
        }

        #header {
            width: 100%;
            text-align: center;
            font-size: 1em;
            border-bottom: groove 4px black;
        }

        .kop1 {
            font-size: 20px;
            text-align: center;
            word-spacing: 3px;
            font: "Times New Roman";
        }

        .kop2 {
            font-size: 22px;
            text-align: center;
            font: "Times New Roman";
            font-weight: bold;
            line-height: 22px;
        }

        .kop3 {
            font-size: 13px;
            text-align: center;
            word-spacing: 3px;
            font: "Times New Roman";
            line-height: 17px;
        }

        .an {
            line-height: 1.02em;
            font-size: 11px;
            text-align: justify;
            font: "Times New Roman";
        }

        .kotak {
            font-size: 16px;
            text-align: center;
            line-height: 1.2em;
        }

        .baris {
            font-size: 14px;
            text-align: justify;
            font: "Times New Roman";
            line-height: 20px;
        }

        .tabel {
            border-collapse: collapse;
        }

        .tabel tr th {
            font-weight: normal;
            text-align: center;
            vertical-align: middle;
            font: "Times New Roman";
        }

        .tabel tr th,
        .tabel tr td {
            border: 1px solid black;
            font-size: 14px;
            line-height: 20px;
            text-align: center;
            font: "Times New Roman";
            vertical-align: middle;
            height: 34px;
        }

        .tabel tr td ikonchecklist {
            font-size: 14px;
            font-family: DejaVu Sans, sans-serif;
        }

        .ttd {
            float: right;
        }

        .judul {
            font-size: 2.2em;
            letter-spacing: 0.2px;
            word-spacing: 5px;
        }

        .subjudul {
            font-size: 1.6em;
            letter-spacing: 0.1px;
            word-spacing: 2px;
        }

        .an1 {
            line-height: 1.08em;
            font-size: 10px;
            text-align: justify;
            font: "Times New Roman";
        }

        .baris1 {
            line-height: 0.86em;
            font-size: 11px;
            text-align: justify;
            font: "Times New Roman";
            word-spacing: 0.1px;
        }

        .kop11 {
            font-size: 1.7em;
            text-align: center;
            word-spacing: 3px;
            line-height: 1em;
            font: "Times New Roman";
        }

        .baris2 {
            line-height: 1.05em;
            font-size: 10.5px;
            text-align: justify;
            font: "Times New Roman";
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: justify;
            font-size: 11px;
            font-style: italic;
        }

        .ikonchecklist {
            font-family: DejaVu Sans, sans-serif;
        }

        .barisbaru {
            display: block;
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            page-break-before: always;
            /* Pindah ke halaman baru */
            break-before: page;
        }

        /* CSS tetap */
    </style>
</head>

<body>
    <div class="page">
        <table width="100%" border="0" class="baris">
            <tr>
                <td colspan="2">
                    <div id="header">
                        <table width="100%">
                            <tr>
                                <td width="12%">
                                    <img class="navbar-brand-icon" src="" width="160px" height="120px" />
                                </td>
                                <td width="88%" align="center">
                                    <span class="kop1">GERAKAN KOLABORASI SUMUT BERKAH</span><br />
                                    <span class="kop2">SEKOLAH BERSIH</span><br />
                                    <span class="kop1">FORMAT SUPERVISI PENGAWAS SEKOLAH</span><br />
                                    <span class="kop1">{{strtoupper($sekolah->nama)}}
                                        {{ strtoupper($kabupaten->jenis) . ' ' . strtoupper($kabupaten->nama_kabupaten) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2" valign="top">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="2" valign="top">
                    <table width="95%" border="0" class="baris" align="center">
                        <tr>
                            <td colspan="4"><b>I. IDENTITAS SEKOLAH</b></td>
                        </tr>
                        <tr>
                            <td width="3%">a.</td>
                            <td width="17%">Nama Sekolah</td>
                            <td width="2%">:</td>
                            <td width="78%">{{$sekolah->nama}}</td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>NPSN</td>
                            <td>:</td>
                            <td>{{$sekolah->npsn}}</td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td>Alamat Sekolah</td>
                            <td>:</td>
                            <td>{{$sekolah->alamat_jalan}}</td>
                        </tr>
                        <tr>
                            <td>d.</td>
                            <td>Kecamatan/Kabupaten</td>
                            <td>:</td>
                            <td>{{ $kabupaten->nama_kabupaten }}</td>
                        </tr>
                        <tr>
                            <td>e.</td>
                            <td>Nama Kepala Sekolah</td>
                            <td>:</td>
                            <td>{{$sekolah->kepalasekolah}}</td>
                        </tr>
                        <tr>
                            <td>f.</td>
                            <td>Bulan Pelaporan</td>
                            <td>:</td>
                            <td>
                                {{ \Carbon\Carbon::parse($model->periode_awal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                -
                                {{ \Carbon\Carbon::parse($model->periode_akhir)->locale('id')->isoFormat('D MMMM YYYY') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        {{-- data pengawas --}}
                        <tr>
                            <td colspan="4"><b>II. IDENTITAS PENGAWAS</b></td>
                        </tr>
                        <tr>
                            <td width="3%">g.</td>
                            <td width="17%">Nama Pengawas</td>
                            <td width="2%">:</td>
                            <td width="78%">{{$user->username}}</td>
                        </tr>
                        <tr>
                            <td>h.</td>
                            <td>Wilayah Binaan</td>
                            <td>:</td>
                            <td>{{$binaan->nama_kabupaten}}</td>
                        </tr>
                        <tr>
                            <td>i.</td>
                            <td>Instansi</td>
                            <td>:</td>
                            <td>{{$cabdis->nama}}</td>
                        </tr>
                        <tr>
                            <td>j.</td>
                            <td>Tanggal Supervisi</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($model->tanggal_supervisi_pengawas)->locale('id')->isoFormat('D MMMM YYYY') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>III. PENILAIAN {{ sizeof($child) }} AREA STRATEGIS KEBERSIHAN SEKOLAH
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="3"><i>( Gunakan Skor 4 = Sangat Bersih, 3 = Bersih, 2 = Cukup dan 1 =
                                    Kurang)</i>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <table width="90%" style="line-height: 11px" class="tabel" align="center">
                        <tr>
                            <td width="5%"><b>No.</b></td>
                            <td width="37%"><b>Area Strategis</b></td>
                            <td width="8%"><b>Sangat Bersih</b></td>
                            <td width="8%"><b>Bersih</b></td>
                            <td width="8%"><b>Cukup</b></td>
                            <td width="8%"><b>Kurang</b></td>
                            <td><b>Ket</b></td>
                        </tr>

                        @foreach ($child as $i => $item): ?>
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td align="left" style="text-align: left; padding-left: 5px">{{$item->nama}}</td>
                                <td class="ikonchecklist">
                                    @if($item->nilai_kebersihan_pengawas == 4)
                                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                                    @else
                                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                                    @endif
                                </td>
                                <td class="ikonchecklist">
                                    @if($item->nilai_kebersihan_pengawas == 3)
                                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                                    @else
                                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                                    @endif
                                </td>
                                <td class="ikonchecklist">
                                    @if($item->nilai_kebersihan_pengawas == 2)
                                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                                    @else
                                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                                    @endif
                                </td>
                                <td class="ikonchecklist">
                                    @if($item->nilai_kebersihan_pengawas == 1)
                                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                                    @else
                                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                                    @endif
                                </td>
                                <td align="left" style="text-align: left; padding-left: 5px">{{$item->catatan}}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
        <br />

        <div class="barisbaru">
            <table width="95%" style="line-height: 11px" class="tabel" align="center">
                <tr>
                    <td colspan="5" style="text-align: left; border-top: none; border-left: none; border-right: none;">
                        <b>IV. DOKUMENTASI (DIPERIKSA SECARA LANGSUNG)</b> <br /><br />
                    </td>
                </tr>
                <tr>
                    <td width="5%"><b>No.</b></td>
                    <td width="37%"><b>Area Strategis</b></td>
                    <td width="8%"><b>Ada</b></td>
                    <td width="8%"><b>Tidak Ada</b></td>
                    <td><b>Catatan</b></td>
                </tr>

                @foreach ($child as $i => $item): ?>
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td align="left" style="text-align: left; padding-left: 5px">{{$item->nama}}</td>
                        <td class="ikonchecklist">
                            @if($item->dokumentasi == 1)
                                <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                            @else
                                <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                            @endif
                        </td>
                        <td class="ikonchecklist">
                            @if($item->dokumentasi != 1 || $item->dokumentasi == null)
                                <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                            @else
                                <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                            @endif
                        </td>
                        <td align="left" style="text-align: left; padding-left: 5px">{{$item->catatan}}
                        </td>
                    </tr>
                @endforeach
            </table>

            <br />

            <table width="95%" border="0" class="baris" align="center">
                <tr>
                    <td width="3%"><b>V.</b></td>
                    <td colspan="8"><b> RANGKUMAN DAN REKOMENDASI PENGAWAS</b></td>
                </tr>
                <tr>
                    <td width="3%"></td>
                    <td colspan="8">a. Tingkat Kepatuhan Pelaksanaan Sekolah Bersih</td>
                </tr>
                <tr>
                    <td></td>
                    <td width="3%">
                        @if($model->nilai_kepatuhan == 4)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td>Sangat Baik</td>
                    <td width="3%">
                        @if($model->nilai_kepatuhan == 3)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td>Baik</td>
                    <td width="3%">
                        @if($model->nilai_kepatuhan == 2)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td>Cukup</td>
                    <td width="3%">
                        @if($model->nilai_kepatuhan == 1)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td>Kurang</td>
                </tr>
                <tr><br /></tr>
                <tr>
                    <td width="3%"></td>
                    <td colspan="8">b. Sekolah ini direkomendasikan untuk : {{ $model->hasil_rekomendasi }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td width="3%">
                        @if($model->hasil_rekomendasi == 1)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td>Pembinaan</td>
                    <td width="3%">
                        @if($model->hasil_rekomendasi == 2)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td>Penguatan</td>
                    <td width="3%">
                        @if($model->hasil_rekomendasi == 3)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td>Penghargaan</td>
                    <td width="3%">
                        @if($model->hasil_rekomendasi == 4)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td>Monitoring Lanjutan</td>
                </tr>
            </table>


        </div>

        <div class="footer"><br /></div>
    </div>
</body>

</html>