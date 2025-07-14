@extends('layouts/master')
@section('title','Dashboard')

@section('css')
@endsection


@section('content')
<div class="mdk-drawer-layout__content page">
    <div class="container-fluid  page__heading-container">
        <div class="page__heading">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                </ol>
            </nav>
            <h1 class="m-0">@yield('title')</h1>
        </div>
    </div>

    <div class="container-fluid page__container">
        <div class="card">
            <div class="card-header card-header-large">
                <h4 class="card-header__title">@yield('title')</h4>
            </div>
            <div class="card-body">
                ini isinya
            </div>
        </div>
    </div>
    @yield('content')
</div>
@endsection

@section('js')
@endsection

