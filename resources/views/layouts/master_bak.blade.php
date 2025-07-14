<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield("title","WHIZZ")</title>
    <meta name="robots" content="noindex">
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/vendor/simplebar.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/app.rtl.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/vendor-material-icons.rtl.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/vendor-fontawesome-free.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/theme/dist') }}/assets/css/vendor-fontawesome-free.rtl.css" rel="stylesheet">
    @yield('css')
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=327167911228268&ev=PageView&noscript=1" /></noscript>
</head>

<body class="layout-default payout">
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
<!--                <div class="container-fluid  page__heading-container">-->
<!--                    <div class="page__heading">-->
<!--                        <nav aria-label="breadcrumb">-->
<!--                            <ol class="breadcrumb mb-0">-->
<!--                                <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>-->
<!--                                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>-->
<!--                            </ol>-->
<!--                        </nav>-->
<!--                        <h1 class="m-0">@yield('title')</h1>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="container-fluid page__container">-->
<!--                    <div class="card">-->
<!--                        <div class="card-header card-header-large">-->
<!--                            <h4 class="card-header__title">@yield('title')</h4>-->
<!--                        </div>-->
<!--                        <div class="card-body">-->
<!--                            ini isinya-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                @yield('isi')
                @yield('content')
            </div>
            <!-- // END drawer-layout__content -->
            @include('layouts.aside')

            <!-- menu samping -->
        </div>
    </div>
</div>
<!-- // END header-layout -->

<!-- App Settings FAB -->
<div id="app-settings">
    <app-settings layout-active="default" :layout-location="{
      'default': 'payout.html',
      'fixed': 'fixed-payout.html',
      'fluid': 'fluid-payout.html',
      'mini': 'mini-payout.html'
    }"></app-settings>
</div>

<!-- jQuery -->
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/popper.min.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/bootstrap.min.js"></script>
<!-- Simplebar -->
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/simplebar.min.js"></script>
<!-- DOM Factory -->
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/dom-factory.js"></script>
<!-- MDK -->
<script src="{{ asset('assets/theme/dist') }}/assets/vendor/material-design-kit.js"></script>
<!-- App -->
<script src="{{ asset('assets/theme/dist') }}/assets/js/toggle-check-all.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/js/check-selected-row.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/js/dropdown.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/js/sidebar-mini.js"></script>
<script src="{{ asset('assets/theme/dist') }}/assets/js/app.js"></script>
<!-- App Settings (safe to remove) -->
<script src="{{ asset('assets/theme/dist') }}/assets/js/app-settings.js"></script>
    @yield('js')
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133433427-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-133433427-1');
    </script>

    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '327167911228268');
        fbq('track', 'PageView');
    </script>

</body>

</html>
