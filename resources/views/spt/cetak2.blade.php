<html>
<head>
    <style>
        @page
        {
            size: auto;   /* auto is the current printer page size */
            margin: 2mm 7mm 0mm 7mm;  /* this affects the margin in the printer settings */
        }
        #header { width:100%; text-align:center; font-size:1em; border-bottom:groove 4px black; }
        .kop1 {font-size:20px; text-align:center; word-spacing:3px;  font:"Times New Roman";}
        .kop2 {font-size:22px; text-align:center; font:"Times New Roman"; font-weight: bold; line-height: 22px}
        .kop3 {font-size:13px; text-align:center; word-spacing:3px; font:"Times New Roman"; line-height: 17px}
        .an { line-height: 1.02em; font-size:11px; text-align:justify; font:"Times New Roman";}
        .kotak { font-size:16px; text-align:center; line-height:1.2em; }
        .baris  { font-size:14px; text-align:justify; font:"Times New Roman"; line-height: 20px; }
        .tabel { border-collapse: collapse;}
        .tabel tr th { font-weight: normal; text-align:center; vertical-align: middle }
        .tabel tr th, .tabel tr td { border:1px solid black; font-size:14px; line-height: 20px; text-align:center; font:"Times New Roman"; vertical-align: middle; height: 34px }
        .ttd {float:right; }
        .judul {font-size:2.2em; letter-spacing:0.2px; word-spacing:5px;}
        .subjudul {font-size:1.6em; letter-spacing:0.1px; word-spacing:2px;}
        .an1 {line-height: 1.08em; font-size:10px; text-align:justify; font:"Times New Roman";}
        .baris1 {line-height:0.86em ; font-size:11px; text-align:justify; font:"Times New Roman"; word-spacing:0.1px }
        .kop11 {font-size:1.7em; text-align:center; word-spacing:3px; line-height:1em; font:"Times New Roman"}
        .baris2 {line-height: 1.05em; font-size:10.5px; text-align:justify; font:"Times New Roman";  }
        .footer {position: fixed; left: 0; bottom: 0; width: 100%; text-align: justify;  font-size:11px; font-style:italic}
    </style>

</head>
<body>
<?php
$bulanspt   = date('m', strtotime($model->tgl_spt));
$bulan      = array(
    '01'    =>'Januari',
    '02'    =>'Februari',
    '03'    =>'Maret',
    '04'    =>'April',
    '05'    =>'Mei',
    '06'    =>'Juni',
    '07'    =>'Juli',
    '08'    =>'Agustus',
    '09'    =>'September',
    '10'    =>'Oktober',
    '11'    =>'November',
    '12'    =>'Desember');
$tanggalspt = date('d', strtotime($model->tgl_spt)).' '.$bulan[$bulanspt].' '.date('Y', strtotime($model->tgl_spt));
?>
<div class="page">
    <table width="100%"border="0" class="baris">
        <tr><td colspan="2"><br></td></tr>
        <tr>
            <td colspan="2">
                <div id="header">
                    <table width="100%">
                        <tr>
                            <td width="12%">
                                <img class="navbar-brand-icon" src="{{ asset('images/') }}/logo.png" width="90px" height="90px">
                            </td>
                            <td width="88%"  align="center">
                                <span class="kop1"><?= $kop->kopsurat_baris1;?></span><br/>
                                <span class="kop2"><?= $kop->kopsurat_baris2;?></span><br/>
                                <span class="kop2"><?= $kop->kopsurat_baris3;?></span><br/>
                                <span class="kop3"><?= $kop->kopsurat_baris4;?></span><br/>
                                <span class="kop3"><?= $kop->kopsurat_baris5;?></span>
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
            <td colspan="2">
                <table width="100%" class="kotak">
                    <tr>
                        <td>
                            <b><u>SURAT PERINTAH TUGAS</u><br/>
                                Nomor :
                                {{$model->no_spt}}
                            </b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2"><br/></td>
        </tr>

        <tr>
            <td width="8%" valign="top">Dasar : </td>
            <td width="92%" valign="top">
                <table width="100%" class="baris">
                    <tr>
                        <td class="baris" valign="top">
                            @php
                            echo str_replace(
                            array("\$dinassurat","\$tahun","\$kegiatan","\$subkegiatan"),
                            array($kop->nama_dinas_surat, $program, $programkegiatan, $programsubkegiatan),
                            $model->dasar
                            );
                            @endphp
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center" style="letter-spacing: 2px"><b><u>MEMERINTAHKAN : </u></b></td>
        </tr>

        <tr>
            <td colspan="2" align="center">&nbsp;</td>
        </tr>

        <tr>
            <td style="vertical-align: top">Kepada :</td>
            <td>
                <table width="100%" style="line-height: 11px" class="tabel" align="center">
                    <tr>
                        <td width="5%"><b>No.</b></td>
                        <td width="50%"><b>Nama / NIP</b></td>
                        <td width="47%"><b>Jabatan</b></td>
                    </tr>
                    @php
                    $categoryIdString = $model->pegawai;
                    $categoryIds = explode(',', $categoryIdString);
                    $articles = App\Models\Pegawai::select("*")
                    ->whereIn('id', $categoryIds)
                    ->orderByRaw('FIELD(id, '.implode(", " , $categoryIds).')')
                    ->get();
                    $cetak=array();
                    $no=1;
                    foreach($articles as $pegawai)
                    {
                    @endphp
                    <tr>
                        <td>{{$no++}}</td>
                        <td style="text-align: left; vertical-align: middle; padding-left: 5px">
                            @php
                            $nama=strtolower($pegawai->nama_pegawai);
                            if($pegawai->nip <> '' || $pegawai->nip <> '-' || $pegawai->nip <> 'NULL')
                            echo ucwords($nama).' - '.$pegawai->nip;
                            else
                            echo ucwords($nama);
                            @endphp                        </td>
                        <td style="text-align: left; vertical-align: middle; padding-left: 5px">&nbsp;{{$pegawai->jabatan}}</td>
                    </tr>
                    @php } @endphp
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <tr>
            <td valign="top">Untuk :</td>
            <td>{!!$model->untuk!!}</td>
        </tr>

        <tr>
            <td colspan="2">
                Demikian Surat Perintah Tugas ini diperbuat untuk dilaksanakan sebagaimana mestinya.
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <table width="100%">
                    <tr>
                        <td width="10%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td width="27%"></td>
                                    <td colspan="3">Ditetapkan di {{$kop->tempat_ttd}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="30%">Pada Tanggal</td>
                                    <td width="3%">:</td>
                                    <td><?php echo $tanggalspt; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center"><b><?//= $kop->tertanda_jabatan;?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center"><b><?//= $kop->tertanda_jabatan2;?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center"><b><?= $kop->tertanda_jabatan3;?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center"><b><!--<?//= 'KABID. PENYELENGGARAAN PELAYANAN PERIZINAN <br/> DAN NON PERIZINAN';?>--> </b></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center">                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center">
                                        <b><?php  echo ($jabatanttd->nama);?><br/>
                                            <?php //echo strtoupper($ttd->jabatan);?><br/>
                                            NIP. <?php //echo ($ttd->nip);?></b>                                    </td>
                                </tr>
                            </table>                        </td>
                    </tr>
                </table>            </td>
        </tr>

        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <div class="footer"><br></div>

</div>
</body>
</html>
