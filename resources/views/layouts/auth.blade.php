<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>LOGIN | Sekolah Bersih</title>


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/components/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/components/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/css/compiled/theme_styles.css" />
  
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes') }}/css/libs/nanoscroller.css" />
    <script src="{{ asset('assets/themes') }}/js/demo-rtl.js"></script> --}}

    
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

{{-- <script src="{{ asset('assets/themes') }}/js/demo-skin-changer.js"></script>
<script src="{{ asset('assets/themes') }}/components/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/bootstrap/assets/js/vendor/popper.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{ asset('assets/themes') }}/components/nanoscroller/bin/javascripts/jquery.nanoscroller.min.js"></script>
<script src="{{ asset('assets/themes') }}/js/demo.js"></script>
<script src="{{ asset('assets/themes') }}/js/scripts.js"></script> --}}


@yield('js')
</body>

</html>
