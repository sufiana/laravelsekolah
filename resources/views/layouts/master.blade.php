<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>SEKOLAH BERSIH</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/components/bootstrap/dist/css/bootstrap.min.css" />
    <script src="{{ asset('assets/themes') }}/js/demo-rtl.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/components/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/css/libs/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/css/compiled/theme_styles.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/components-custom/jquery-jvectormap-2.0.3/jquery-jvectormap-2.0.3.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/components/weather-icons/css/weather-icons.min.css" />
    <link type="image/x-icon" href="{{ asset('assets/themes') }}/favicon.png" rel="shortcut icon" />
<!--    <link href='../fonts.googleapis.com/cssaaf0.css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>-->
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

<body>
<div id="theme-wrapper">
    @include('layouts.navbar')
    <div id="page-wrapper" class="container">
        <div class="row">
            @include('layouts.sidebar')
            <div id="content-wrapper">
                @yield('isi')
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
@include('layouts.lefttoolbar')
<script src="{{ asset('assets/themes') }}/js/demo-skin-changer.js"></script>
<script src="{{ asset('assets/themes') }}/components/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/bootstrap/assets/js/vendor/popper.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{ asset('assets/themes') }}/components/nanoscroller/bin/javascripts/jquery.nanoscroller.min.js"></script>
<script src="{{ asset('assets/themes') }}/js/demo.js"></script>

<script src="{{ asset('assets/themes') }}/components/moment/min/moment.min.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/jquery-jvectormap-2.0.3/jquery-jvectormap-2.0.3.min.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/jvectormap-maps/jquery-jvectormap-world-merc.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/jvectormap-maps/gdp-data.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{ asset('assets/themes') }}/components/flot/excanvas.min.js"></script><![endif]-->
<script src="{{ asset('assets/themes') }}/components/flot/jquery.flot.js"></script>
<script src="{{ asset('assets/themes') }}/components/flot/jquery.flot.resize.js"></script>
<script src="{{ asset('assets/themes') }}/components/flot/jquery.flot.time.js"></script>
<script src="{{ asset('assets/themes') }}/components/flot/jquery.flot.threshold.js"></script>
<script src="{{ asset('assets/themes') }}/components/flot-axislabels/jquery.flot.axislabels.js"></script>
<script src="{{ asset('assets/themes') }}/components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!--<script src="{{ asset('assets/themes') }}/components/skycons/skycons.js"></script>-->

<script src="{{ asset('assets/themes') }}/js/scripts.js"></script>
<script src="{{ asset('assets/themes') }}/components/PACE/pace.min.js"></script>


@yield('js')
</body>

</html>
