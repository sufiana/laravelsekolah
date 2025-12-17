<html>
    <head>
        <style>
            .awal{background-image:url(../images/background.png); height: 100%;background-position: center;background-repeat: no-repeat;background-size: cover;}
        </style>
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/dist/css/skins/_all-skins.min.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/bower_components/morris.js/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/bower_components/jvectormap/jquery-jvectormap.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{ asset('assets/themes') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    </head>

    <body>
        <div class="col-md-12 awal" style="padding-top: 10px;">
            <center>
                <img src="{{ asset('assets/themes') }}/dist/img/sabang.png" width="8%">
                <h2 style="font-weight: 700"><center>APLIKASI UMKM PINTAR</center></h2>
                <h2 style="font-weight: 700"><center>DINAS PERINDUSTRIAN, PERDAGANGAN, KOPERASI DAN UMKM</center></h2>
                <h2 style="font-weight: 700"><center>PEMERINTAH KOTA SABANG</center></h2>
            <br/>
                <a href="{{ route('loginadmin') }}" class="btn btn-danger"><i class="fa fa-user"> Admin Dinas</i></a>
                <a href="{{ route('login') }}" class="btn btn-danger"><i class="fa fa-users"> Operator Gampong</i></a>
            <br/><br/>
                <div style="font-weight: 700">Copyright&copy; 2021 PT. Lunata Teknokindo Group </div>
            </center>
        </div>
    </body>
</html>





