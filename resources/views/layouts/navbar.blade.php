@php
  $user = Auth::user();
  $role = App\models\Role::find($user->role)->name;
@endphp
<nav class="app-header navbar navbar-expand bg-body">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
    </ul>
    <!--end::Start Navbar Links-->

    <!--begin::End Navbar Links-->
    <ul class="navbar-nav ms-auto">

      @if($user && in_array($user->role, [2, 8]))
        @isset($results)
          @if($results->isNotEmpty())
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-bell-fill"></i>
                <span class="navbar-badge badge text-bg-danger">{{ count($results) }}</span>
              </a>

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <span class="dropdown-item dropdown-header">
                  {{ count($results) }} Notifikasi
                </span>
                <div class="dropdown-divider"></div>

                @foreach($results as $x)
                  <a href="{{ url('sekolahbersih/create/' . $x->id) }}" class="dropdown-item">
                    <i class="bi bi-info-circle me-2"></i> {{ $x->singkatan }}
                  </a>
                  <div class="dropdown-divider"></div>
                @endforeach

                <a href="#" class="dropdown-item dropdown-footer">Lihat Semua</a>
              </div>
            </li>
          @endif
        @endisset
      @endif


      <li class="nav-item dropdown user-menu">

        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img src="{{ asset('assets/admin') }}/assets/img/user2-160x160.jpg"
            class="user-image rounded-circle shadow" />
          <span class="d-none d-md-inline">
            @auth
              {{ $role }}
            @endauth
          </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">
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
          </a>
          <div class="dropdown-divider"></div>
          @auth
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
            <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fa fa-power-off"></i> {{ __('Logout') }}
            </a>
          @endauth
        </ul>

      </li>
      <!--end::User Menu Dropdown-->
    </ul>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>