@php
    $user = Auth::user();
@endphp

<header class="navbar navbar-expand-lg navbar-light container d-block d-lg-flex" id="header-navbar">
    <a class="navbar-brand float-left float-lg-none" href="index.html" id="logo">
        <!--
        <img alt="" class="normal-logo logo-white" src="{{ asset('assets/themes') }}/img/logo.png" />
        <img alt="" class="normal-logo logo-black" src="{{ asset('assets/themes') }}/img/logo-black.png" />
        -->
        Sekolah Bersih
    </a>
    <button aria-controls="navbar-ex1-collapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler float-right float-lg-none" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav mr-auto mrg-l-none">
            @if($user && in_array($user->role, [2, 8]))
                @isset($results)
                    @if($results->isNotEmpty())
                        <li class="dropdown">
                            <a class="btn dropdown-toggle dropdown-nocaret" data-toggle="dropdown">
                                <i class="fa fa-bell"></i>
                                <span class="count">{{ sizeof($results) }}</span>
                            </a>
                            <ul class="dropdown-menu notifications-list">
                                <li class="pointer">
                                    <div class="pointer-inner">
                                        <div class="arrow"></div>
                                    </div>
                                </li>
                                <li class="item-header">                   
                                    <p>Jumlah Komponen belum diisi: {{ sizeof($results) }}</p>
                                </li>
                                @foreach($results as $x)
                                    <li class="item">
                                        <a href="{{ url('sekolahbersih/create/' . $x->id) }}">
                                            <span class="content-headline">{{ $x->singkatan }} </span>
                                        </a>
                                    </li>
                                @endforeach

                                <li class="item-footer"></li>
                            </ul>           
                        </li>
                    @endif
                @endisset
            @endif
            <li class="dropdown">
                <a class="btn dropdown-toggle dropdown-nocaret" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="count">16</span>
                </a>
                <ul class="dropdown-menu notifications-list messages-list">
                    <li class="pointer">
                        <div class="pointer-inner">
                            <div class="arrow"></div>
                        </div>
                    </li>
                    <li class="item first-item">
                        <a href="#">
                            <img alt="" src="{{ asset('assets/themes') }}/img/samples/messages-photo-1.png" />
                            <span class="content">
                                    <span class="content-headline">George Clooney</span>
                                    <span class="content-text">
                                        Look, just because I don't be givin' no man a foot massage don't make it
                                        right for Marsellus to throw...
                                    </span>
                                </span>
                            <span class="time">
                                    <i class="fa fa-clock-o"></i>13 min.</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="#">
                            <img alt="" src="{{ asset('assets/themes') }}/img/samples/messages-photo-2.png" />
                            <span class="content">
                                    <span class="content-headline">Emma Watson</span>
                                        <span class="content-text">
                                            Look, just because I don't be givin' no man a foot massage don't make it
                                            right for Marsellus to throw...
                                        </span>
                                    </span>
                            <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="#">
                            <img alt="" src="{{ asset('assets/themes') }}/img/samples/messages-photo-3.png" />
                            <span class="content">
                                    <span class="content-headline">Robert Downey Jr.</span>
                                    <span class="content-text">
                                        Look, just because I don't be givin' no man a foot massage don't make it
                                        right for Marsellus to throw...
                                    </span>
                                </span>
                            <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>
                        </a>
                    </li>
                    <li class="item-footer">
                        <a href="#">
                            View all messages
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto float-right float-lg-none" id="header-nav">
            <li class="mobile-search">
                <a class="btn"><i class="fa fa-search"></i></a>
                <div class="drowdown-search">
                    <form role="search">
                        <div class="form-group">
                            <input class="form-control" placeholder="Search..." type="text">
                            <i class="fa fa-search nav-search-icon"></i>
                            </input>
                        </div>
                    </form>
                </div>
            </li>
            <li class="dropdown profile-dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <img alt="" src="{{ asset('assets/themes') }}/img/samples/scarlet-159.png" />

                    @auth
                        <span class="d-none d-md-block">
                            {{ Auth::user()->username }}
                        </span>
                    @endauth

                    @guest
                        <span class="d-none d-md-block">
                            Guest
                        </span>
                    @endguest

                    <b class="caret"></b>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    @auth
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <li>
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i> {{ __('Logout') }}
                            </a>
                        </li>
                    @endauth

                    @guest
                        <li>
                            <a href="{{ route('login') }}">
                                <i class="fa fa-sign-in"></i> {{ __('Login') }}
                            </a>
                        </li>
                    @endguest
                </ul>
            </li>

            <li class="d-none d-sm-block">
                <a class="btn"><i class="fa fa-power-off"></i></a>
            </li>
        </ul>
    </div>
</header>