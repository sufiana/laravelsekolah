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
            page-break-before: always;
            break-before: page;
        }
        .barisbarunext {
            display: block;
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            page-break-after: always;
            break-after: page;
        }

        .page-section {
        page-break-before: always;
        }

        .page-section:first-child {
            page-break-before: auto; /* halaman pertama jangan ada page break */
        }
        .page-section:first-of-type {
    page-break-before: auto;
}
        /* CSS tetap */
    </style>
</head>
<body>

    
@foreach($loop as $z)   
 <div class="page-section"> 
    <table width="100%" border="0" class="baris">
        <tr><td colspan="2"><br /></td></tr>

        <tr>
            <td colspan="2">
                <div id="header">
                    <table width="100%">
                        <tr>
                            <td width="100%" align="center">
                                <span class="kop1">GERAKAN KOLABORASI SUMUT BERKAH</span><br />
                                <span class="kop2">SEKOLAH BERSIH</span><br />
                                <span class="kop1">FORMAT CHECKLIST HARIAN KEBERSIHAN {{strtoupper($z->nama_ruang)}}</span><br />
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
                        <td width="17%">Hari / Tanggal</td>
                        <td width="2%">:</td>
                        <td width="81%">x</td>
                    </tr>
                    <tr><td>Nama Petugas</td><td>:</td><td>&nbsp;</td></tr>
                    <tr><td>Nama Guru Piket</td><td>:</td><td>&nbsp;</td></tr>
                </table>
            </td>
        </tr>

        <tr><td colspan="2" align="center" style="letter-spacing: 2px">&nbsp;</td></tr>

        <tr>
            <td colspan="2" align="center">
                <table width="100%" style="line-height: 11px" class="tabel" align="center">
                    <tr>
                        <td width="5%"><b>No.</b></td>
                        <td width="37%"><b>Komponen {{$ruang->nama}}</b></td>
                        <td width="8%"><b>Bersih</b></td>
                        <td width="8%"><b>Cukup Bersih</b></td>
                        <td width="8%"><b>Tidak Bersih</b></td>
                        <td><strong>Keterangan / Tindakan </strong></td>
                    </tr>

                    @php        
                    $ulang= DB::table('hasil_kuesioner as ek')
                        ->select('ek.*','p.parameter', 'ek.jawaban','ek.deskripsi_jawaban')
                        ->join('parameter_kebersihan as p', 'p.id', '=', 'ek.id_parameter')

                        ->where('ek.id_sekolah', $z->sekolah)
                        ->where('ek.periode_awal_kuesioner', $z->periode_awal_kuesioner)
                        ->where('ek.periode_akhir_kuesioner', $z->periode_akhir_kuesioner)
                        ->where('ek.id_ruang', $z->id_ruang)
                        ->orderBy('ek.id_ruang')
                        ->get();
                    @endphp

                    @foreach ($ulang as $i => $item): ?>
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td align="left" style="text-align: left; padding-left: 5px">{{$item->parameter}}</td>
                            <td class="ikonchecklist">
                                @if($item->jawaban==3)
                                <span style="font-family: DejaVu Sans; font-size: 20px">&#9745;</span> {{-- ☑ --}}
                                @else
                                <span style="font-family: DejaVu Sans; font-size: 20px"">&#9744;</span> {{-- ☐ --}}
                                @endif
                            </td>
                            <td class="ikonchecklist">
                                @if($item->jawaban==2)
                                <span style="font-family: DejaVu Sans; font-size: 20px"">&#9745;</span> {{-- ☑ --}}
                                @else
                                <span style="font-family: DejaVu Sans; font-size: 20px"">&#9744;</span> {{-- ☐ --}}
                                @endif
                            </td>
                            <td class="ikonchecklist">
                                @if($item->jawaban==1)
                                <span style="font-family: DejaVu Sans; font-size: 20px"">&#9745;</span> {{-- ☑ --}}
                                @else
                                <span style="font-family: DejaVu Sans; font-size: 20px"">&#9744;</span> {{-- ☐ --}}
                                @endif
                            </td>
                            <td align="left" style="text-align: left; padding-left: 5px">{{$item->deskripsi_jawaban}}</td>
                        </tr>
                   @endforeach
                </table>
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td colspan="2">
                <table width="100%" border="0" class="baris" align="center">
                    <tr>
                        <td width="30%">Tanda Tangan Petugas</td>
                        <td width="3%">:</td>
                        <td width="67%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Tanda Tangan {{!$model->jabatan_verifikasi && !$verifikator ?  ' - ' : $verifikator->jabatan}}</td>
                        <td>
                            @if ($verifikator->tandatangan)
                                <img src="{{ public_path($verifikator->tandatangan) }}" alt="Tanda Tangan" style="width: 120px; height: auto;">
                            @endif           
                        </td>
                        <td>{{!$model->user_verifikasi && !$verifikator ?  ' - ' : $verifikator->verifikator}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
 </div>
    @endforeach

</body>
</html>
