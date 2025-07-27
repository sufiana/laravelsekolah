<!DOCTYPE html>
<html>

<!-- Mirrored from cube-30.aircode.sk/login-full.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 06 Aug 2021 13:00:29 GMT -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>LOGIN | Sekolah Bersih</title>


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/components/bootstrap/dist/css/bootstrap.min.css" />
    <script src="{{ asset('assets/themes') }}/js/demo-rtl.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/components/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/css/libs/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/css/compiled/theme_styles.css" />

    <link type="image/x-icon" href="{{ asset('assets/themes') }}/favicon.png" rel="shortcut icon" />
    <link href='../fonts.googleapis.com/cssaaf0.css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
        <script src="{{ asset('assets/themes') }}/js/html5shiv.js"></script>
        <script src="{{ asset('assets/themes') }}/js/respond.min.js"></script>
    <![endif]-->
    <style>
        .wajib{color: #d9534f}
        .wajib::after {
            content: " * ";
        }
    </style>
    @yield('css')
</head>

<body id="login-page-full">
<div id="login-full-wrapper">
    <div class="container">
        @yield('isi')
        @yield('content')
    </div>
</div>

<script src="{{ asset('assets/themes') }}/js/demo-skin-changer.js"></script>
<script src="{{ asset('assets/themes') }}/components/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/bootstrap/assets/js/vendor/popper.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{ asset('assets/themes') }}/components/nanoscroller/bin/javascripts/jquery.nanoscroller.min.js"></script>
<script src="{{ asset('assets/themes') }}/js/demo.js"></script>
<script src="{{ asset('assets/themes') }}/js/scripts.js"></script>


@yield('js')
</body>

</html>
