@extends('layouts/master')
@section('title','Dashboard')
@section('css')
<style>
.row.grid-equal-height {
  display: grid;
  grid-auto-rows: 1fr;
}

.row.grid-equal-height > [class*='col-'] {
  display: flex;
}

</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div id="content-header" class="clearfix">
                    <div class="float-left">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active"><span>Dashboard</span></li>
                        </ol>
                        <h1>Dashboard</h1>
                    </div>
<!--                    <div class="float-right d-none d-sm-block">-->
<!--                        <div class="xs-graph float-left">-->
<!--                            <div class="graph-label">-->
<!--                                <b><i class="fa fa-shopping-cart"></i> 838</b> SPPD Realisasi-->
<!--                            </div>-->
<!--                            <div class="graph-content spark-orders"></div>-->
<!--                        </div>-->
<!--                        <div class="xs-graph float-left mrg-l-lg mrg-r-sm">-->
<!--                            <div class="graph-label">-->
<!--                                <b>&dollar;12.338</b> SPPD-->
<!--                            </div>-->
<!--                            <div class="graph-content spark-revenues"></div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>

       <div class="row g-3 d-flex flex-wrap align-items-stretch">
  <div class="col-lg-3 col-sm-6 col-12 d-flex">
    <div class="info-box emerald-bg w-100 d-flex flex-column">
      <i class="fa fa-user icon"></i>
      <span class="headline">Jumlah Sekolah</span>
      <span class="value">46</span>
    </div>
  </div>

  <div class="col-lg-3 col-sm-6 col-12 d-flex">
    <div class="info-box red-bg w-100 d-flex flex-column">
      <i class="fa fa-tag icon"></i>
      <span class="headline">Sekolah Terintegrasi</span>
      <span class="value">9</span>
    </div>
  </div>

  <div class="col-lg-3 col-sm-6 col-12 d-flex">
    <div class="info-box green-bg w-100 d-flex flex-column">
      <i class="fa fa-tags icon"></i>
      <span class="headline">Sekolah Belum Terintegrasi</span>
      <span class="value">45</span>
    </div>
  </div>

  <div class="col-lg-3 col-sm-6 col-12 d-flex">
    <div class="info-box purple-bg w-100 d-flex flex-column">
      <i class="fa fa-credit-card icon"></i>
      <span class="headline">Persentase Sekolah Bersih</span>
      <span class="value">42</span>
    </div>
  </div>
</div>

       

        <div class="col-md-12">
            <div class="main-box clearfix profile-box-contact">
                <div class="main-box-body clearfix">
                    <div class="profile-box-header gray-bg clearfix" style="background-color: #3e5879 !important;">
                        @if(!is_null($user->img) && file_exists(public_path('images/user/' . $user->img)))
                        <img src="{{ asset('images/user/' . $user->img) }}" alt="Foto Profil" class="profile-img img-fluid">
                        @else
                        <img src="{{ asset('images/user/user.png') }}" alt="Default Foto" class="profile-img img-fluid">
                        @endif
                        <h2>{{$user->username}}</h2>
                        <div class="job-position">
                            {{$role->name}}
                        </div>
                        <ul class="contact-details">
                            <li>
                                <i class="fa fa-map-marker"></i> Wilayah Binaan : {{$user->binaan}}
                            </li>
                            <li>
                                <i class="fa fa-map-o"></i>  
                                @php 
                                    $cabdis = App\Models\Cabdis::where('id',$user->cabdis)->first();
                                @endphp
                                Instansi: {{$cabdis->deskripsi}}
                                
                            </li>
                        </ul>
                    </div>
                    <div class="profile-box-footer clearfix">
                        <a href="#">
                            <span class="value">44</span>
                            <span class="label">Messages</span>
                        </a>
                        <a href="#">
                            <span class="value">91</span>
                            <span class="label">Sales</span>
                        </a>
                        <a href="#">
                            <span class="value">3</span>
                            <span class="label">Projects</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($icon as $i)
            <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                <div class="main-box clearfix profile-box-contact" style="box-shadow: none; background-color: transparent; border: none;">
                    <div class="main-box-body clearfix" style="border: none;">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center" style="height: 200px;">
                            <img src="{{ asset('images/icon/' . $i->gambar) }}" alt="" style="width: 80px; height: 80px; object-fit: cover;">
                            <a href="{{ route('sekolahbersih.create', $i->id) }}">
                                <h2 class="mb-0" style="font-size: 1.2rem; color: #3e5879;">{{ $i->singkatan }}</h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


    </div>



@endsection

@section('js')
@endsection
