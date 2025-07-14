<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield("title","WHIZZ")</title>
    <meta name="robots" content="noindex">

    <!-- FullCalendar -->
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/vendor/fullcalendar/fullcalendar.min.css" rel="stylesheet">

    <!-- Simplebar -->
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/vendor/simplebar.min.css" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/app.rtl.css" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/vendor-material-icons.rtl.css" rel="stylesheet">

    <style>
        .wajib{color: red;}
        .wajib:after{content: "*"}
        .fc-content{
            background-color: #48BA16 !important;
            color: #fff;
            margin-top: 2px;
            cursor: pointer;
            line-height: 1.5;
            border-color: transparent;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
</head>

<body class="layout-default">
    <div class="preloader"></div>
    
    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">
    
    <!-- Header -->
    @include('layouts.navbar')
    <!-- // END Header -->
    
    <!-- Header Layout Content -->
    <div class="mdk-header-layout__content">
        <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
            <div class="mdk-drawer-layout__content page">
                @yield('isi')
                @yield('content')
            </div>
            <!-- // END drawer-layout__content -->
            @include('layouts.sidebar')

            <!-- menu samping -->
        </div>
    </div>
    <!-- // END header-layout -->
</div>


<!-- jQuery -->
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/jquery.min.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/jquery-ui.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>

<!-- DOM Factory -->
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/dom-factory.js"></script>

<!-- MDK -->
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/material-design-kit.js"></script>

<!-- App -->
<script src="{{ asset('assets/theme/dist') }}/assets/js/toggle-check-all.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/js/check-selected-row.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/js/dropdown.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/js/sidebar-mini.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/js/app.js" defer></script>
 
 <!-- Moment.js -->
 <script src="{{ asset('assets/theme/dist') }}/assets/vendor/moment.min.js"></script>
 
 <!-- FullCalendar -->
 <script src="{{ asset('assets/theme/dist') }}/assets/vendor/fullcalendar/fullcalendar.min.js"></script>
@yield('js')
</body>

</html>
