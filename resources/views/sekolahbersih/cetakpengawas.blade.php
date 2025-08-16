<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: auto; /* auto is the current printer page size */
            margin: 2mm 7mm 0mm 7mm; /* this affects the margin in the printer settings */
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
        .tabel tr td ikonchecklist{
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
          page-break-before: always;   /* Pindah ke halaman baru */
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
                                <img
                                    class="navbar-brand-icon"
                                    src=""
                                    width="160px"
                                    height="120px"
                                />
                            </td>
                            <td width="88%" align="center">
                                <span class="kop1">GERAKAN KOLABORASI SUMUT BERKAH</span><br />
                                <span class="kop2">SEKOLAH BERSIH</span><br />
                                <span class="kop1">FORMAT SUPERVISI PENGAWAS SEKOLAH </span><br />
                                <span class="kop1">{{strtoupper($sekolah->nama)}}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr><td colspan="2"></td></tr>
        <tr><td colspan="2" valign="top">&nbsp;</td></tr>

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
                        <td>{{$kabupaten->nama_kabupaten}}</td>
                    </tr>
                    <tr>
                        <td>e.</td>
                        <td>Nama Kepala Sekolah</td>
                        <td>:</td>
                        <td>{{$sekolah->kepalasekolah}}</td>
                    </tr>
                    
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td colspan="4"><b>II. IDENTITAS PENGAWAS</b></td>
                    </tr>
                    <tr>
                        <td>f.</td>
                        <td>Nama Pengawas</td>
                        <td>:</td>
                        <td>{{$user->username}}</td>
                    </tr>
                    <tr>
                        <td>g.</td>
                        <td>Wilayah Binaan</td>
                        <td>:</td>
                        <td>{{$user->binaan}}</td>
                    </tr>
                    <tr>
                        <td>h.</td>
                        <td>Instansi</td>
                        <td>:</td>
                        <td>{{ $wilayah[0]->nama_kabupaten }}</td>
                    </tr>
                    <tr>
                        <td>i.</td>
                        <td>Tanggal Supervisi</td>
                        <td>:</td>
                        <td>{{date('Y-M-d', strtotime($evaluasipengawas->tgl_supervisi))}}</td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td colspan="4"><b>III. PENILAIAN 12 AREA STRATEGIS KEBERSIHAN SEKOLAH</b></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3"><i>(Gunakan Skor 4 = Sangat Bersih, 3 =  Bersih, 2 = Cukup, 1 = Kurang)</i></td>
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
                        <td><b>Catatan atau Temuan</b></td>
                    </tr>

                    @foreach ($hasilKuesioner as $i => $item): ?>
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td align="left" style="text-align: left; padding-left: 5px">{{$item->nama}}</td>
                            <td class="ikonchecklist">
                                @if($item->kesimpulan_pengawas == 4)
                                    <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                                @else
                                    <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                                @endif
                            </td>
                            <td class="ikonchecklist">
                                @if($item->kesimpulan_pengawas == 3)
                                    <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                                @else
                                    <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                                @endif
                            </td>
                            <td class="ikonchecklist">
                                @if($item->kesimpulan_pengawas == 2)
                                    <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                                @else
                                    <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                                @endif
                            </td>
                            <td class="ikonchecklist">
                                @if($item->kesimpulan_pengawas == 1)
                                    <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                                @else
                                    <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                                @endif
                            </td>
                            <td align="left" style="text-align: left; padding-left: 5px">{{$item->catatan_pengawas}}</td>
                        </tr>
                   @endforeach
              </table>
            </td>
        </tr>
    </table>
    
    <div class="barisbaru">
        <table width="98%" border="0" class="baris" align="center">
            <tr>
                <td><b>IV. DOKUMENTASI (DIPERIKSA SECARA LANGSUNG)</b></td>
            </tr>
        </table>
        <table width="90%" style="line-height: 11px" class="tabel" align="center">
            <tr>
                <td width="5%"><b>No.</b></td>
                <td width="37%"><b>Area Strategis</b></td>
                <td width="8%"><b>Ada</b></td>
                <td width="8%"><b>Tidak Ada</b></td>
                <td><b>Catatan</b></td>
            </tr>

            @foreach ($hasilKuesioner as $i => $item): ?>
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td align="left" style="text-align: left; padding-left: 5px">{{$item->nama}}</td>
                    <td class="ikonchecklist">
                        @if($item->dokumentasi_pengawas === 1)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td class="ikonchecklist">
                        @if($item->dokumentasi_pengawas === 0)
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                        @else
                            <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                        @endif
                    </td>
                    <td align="left" style="text-align: left; padding-left: 5px">{{$item->catatan_dokumentasi_pengawas}}</td>
                </tr>
           @endforeach
        </table>
        <br/>
        
        <table width="98%" border="0" class="baris" align="center">
            <tr>
                <td colspan="5"><b>V. RANGKUMAN DAN REKOMENDASI PENGAWAS</b></td>
            </tr>
            <tr>
                <td width='3%'>a.</td>
                <td colspan="4">Tingkat Kepatuhan Pelaksanaan Gerakan Sekolah Bersih : </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    @if($evaluasipengawas->nilai_kepatuhan == 4)
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                    @else
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                    @endif
                    Sangat Baik
                </td>
                <td>
                    @if($evaluasipengawas->nilai_kepatuhan == 3)
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                    @else
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                    @endif
                    Baik
                </td>
                <td>
                    @if($evaluasipengawas->nilai_kepatuhan == 2)
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                    @else
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                    @endif
                    Cukup
                </td>
                <td>
                    @if($evaluasipengawas->nilai_kepatuhan == 1)
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                    @else
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                    @endif
                    Kurang
                </td>
            </tr>
            <br/>
            <tr>
                <td width='3%'>b.</td>
                <td colspan="4">Sekolah ini direkomendasikan untuk : </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    @if($evaluasipengawas->hasil_rekomendasi == 4)
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                    @else
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                    @endif
                    Pembinaan
                </td>
                <td>
                    @if($evaluasipengawas->hasil_rekomendasi == 3)
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                    @else
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                    @endif
                    Penguatan
                </td>
                <td>
                    @if($evaluasipengawas->hasil_rekomendasi == 2)
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                    @else
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                    @endif
                    Penghargaan
                </td>
                <td>
                    @if($evaluasipengawas->hasil_rekomendasi == 1)
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9745;</span> {{-- ☑ --}}
                    @else
                        <span style="font-family: DejaVu Sans; font-size: 20px;">&#9744;</span> {{-- ☐ --}}
                    @endif
                    Monitoring Lanjutan
                </td>
            </tr>
        </table>
        
        
    </div>

    <div class="footer"><br /></div>
</div>
</body>
</html>
