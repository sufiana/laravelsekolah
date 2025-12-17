<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cetak Form Langganan Non Government</title>
    <style>

        @page
        {
            size: auto;   /* auto is the current printer page size */
            margin: 2mm 7mm 0mm 7mm;  /* this affects the margin in the printer settings */
        }


        .line {
            width:200px;
            height:100px;
            border-left:5px solid;
            background:linear-gradient(#000,#000) center/100% 5px no-repeat;
        }

        .gambar{width:100%;}
        .judulbiru{color:#0033FF; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold; font-size:14px}
        .noform{color:black; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; width:100%}
        .tabela{ border:solid #0a75c2;}
        .tabelb{ border:solid #00b050; line-height:0.5em
                                                      tableb td {
                                                          table-layout: fixed;
                                                          overflow: hidden;
                                                          word-wrap: break-word;
                                                      }
        tablea td {
            table-layout: fixed;
            overflow: hidden;
            word-wrap: break-word;
        }
        .tabelisi{ border:0;}
        tableisi td {
            table-layout: fixed;
            overflow: hidden;
            word-wrap: break-word;
            background-color: white;
        }
        .isi
        {font-size: 10px; text-align: left}
        }
        .tabelatasa{border-left: solid #0a75c2; border-top: solid #0a75c2; border-right: solid #0a75c2}
        .tabelsampinga{border-left: solid #0a75c2; border-bottom: solid #0a75c2; border-right: solid #0a75c2}
        .kolom {
            float: left;
            padding: 10px;
        }
        .kiri {
            width: 25%;
        }
        .baris:after {
            content: "";
            display: table;
            clear: both;
        }
        .halamanbaru  { display:block; page-break-before:always;}

        hr.colored {
            border: 0;   /* in order to override TWBS stylesheet */
            height: 5px;
            background: -moz-linear-gradient(left, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%);  /* FF3.6+ */
            background: -webkit-linear-gradient(left, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(left, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(left, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%); /* IE10+ */
            background: linear-gradient(to right, rgba(196,222,138,1) 0%, rgba(196,222,138,1) 12.5%, rgba(245,253,212,1) 12.5%, rgba(245,253,212,1) 25%, rgba(255,208,132,1) 25%, rgba(255,208,132,1) 37.5%, rgba(242,122,107,1) 37.5%, rgba(242,122,107,1) 50%, rgba(223,157,185,1) 50%, rgba(223,157,185,1) 62.5%, rgba(192,156,221,1) 62.5%, rgba(192,156,221,1) 75%, rgba(95,156,217,1) 75%, rgba(95,156,217,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 87.5%, rgba(94,190,227,1) 100%); /* W3C */
        }
        .style3 {font-size: 25px;}
        .style4 {font-size: 34px; font-weight: bold;}
    </style>
</head>

<body>
<div class="gambar" align="right"><img class="navbar-brand-icon" src="{{ asset('assets/theme/dist') }}/assets/images/whiz_logo_long.png" width="200px"></div>
<div class="utama">
    <div class="judulbiru" align="left">Formulir Berlangganan /<i> Subscription Form </i></div>
    <div class="noform" align="right">
        <table width="20%" align="right" style="line-height: 12px; font-size: 12px">
            <tr>
                <td width="12%">Nomor</td>
                <td width="2%">:</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
            </tr>
        </table>
    </div>

    <div class="noform">
        <table width="100%" class="tabela" border="4">
            <tr>
                <td colspan="3"><strong>A. </strong><strong>Jenis Permintaan</strong></td>
            </tr>

            <tr>

            </tr>
        </table>
    </div>

    <div class="noform" style="margin-top: 10px">
        <table width="100%" class="tabelb" border="4" style="line-height: 12px">
            <tr>
                <td colspan="3" style="position: absolute"><strong>B. </strong><strong>Informasi Pelanggan</strong></td>
            </tr>

            <tr>
                <td colspan="3">
                    <table width="100%" class="isi" style="font-size: 14px; text-align: left">
                        <tr>
                            <td width="13%">Nama Pelanggan </td>
                            <td width="1%">:</td>
                        </tr>
                        <tr>
                            <td>Alamat Lengkap </td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Kota / Provinsi </td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Telp / FAX </td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td>:</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

  <div class="noform"  style="margin-top: 10px"></div>

    <div class="noform" style="margin-top: 10px">
        <table width="100%" class="tabelb" border="4">
            <tr>
                <td colspan="3" style="position: absolute"><strong>D. </strong><strong>Penanggung Jawab / <i>Contact Person </i></strong></td>
            </tr>

            <tr>
                <td colspan="3"><table width="100%" class="isi" style="font-size: 14px; text-align: left">
                        <tr>
                            <td width="9%">Nama</td>
                            <td width="1%">:</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Telp / WA </td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>No. Identitas </td>
                            <td>:</td>
                            <td width="8%"><div style="font-family:helvetica; font-size:20px">&#x2610;<span style="font-size: 12px; vertical-align: center">Lainnya</span></div></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
    </div>

    <div class="noform" style="margin-top: 10px">
        <table width="100%" class="tabelb" border="4" style="border: solid #00b050">
            <tr>
                <td colspan="3" style="position: absolute"><strong>E. </strong><strong>Informasi Kontak</strong></td>
            </tr>
            <tr>
                <td colspan="3" style="position: absolute"><table width="95%" align="right">
                        <tr>
                            <td width="11%">1. Teknis </td>
                            <td width="1%">&nbsp;</td>
                            <td width="50%">&nbsp;</td>
                            <td width="11%">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="24%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>&nbsp;</td>
                            <td>Nama</td>
                            <td>:</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>&nbsp;</td>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>&nbsp;</td>
                            <td>Email</td>
                            <td>:</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left">No Telp / WA </td>
                            <td>:</td>
                            <td>&nbsp;</td>
                            <td>No Telp / WA </td>
                            <td>:</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table></td>
            </tr>

        </table>
    </div>
</div>
<div align="left"><img class="navbar-brand-icon" src="{{ asset('assets/theme/dist') }}/assets/images/footer.png" width="100%">


    <div class="halamanbaru">
        <div class="gambar" align="right"><img class="navbar-brand-icon" src="{{ asset('assets/theme/dist') }}/assets/images/whiz_logo_long.png" width="200px"></div>
        <div class="utama">
            <div class="judulbiru" align="left">Formulir Berlangganan /<i> Subscription Form </i></div>
        </div>
    </div>

    <br/>
    <br/>
<div class="noform" style="margin-top: 10px"></div>





    <p>&nbsp;</p>
</body>
</html>
