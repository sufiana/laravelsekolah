@extends('layouts/master')
@section('title','Dashboard')
@section('css')
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

        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="main-box infographic-box colored emerald-bg">
                    <i class="fa fa-user"></i>
                    <span class="headline" style="font-size: 10.5px">Jumlah sekolah</span>
                    <span class="value">46</span>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="main-box infographic-box colored red-bg">
                    <i class="fa fa-tag"></i>
                    <span class="headline" style="font-size: 10.5px">Sekolah Terintegrasi</span>
                    <span class="value">9</span>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="main-box infographic-box colored green-bg">
                    <i class="fa fa-tags"></i>
                    <span class="headline" style="font-size: 10.5px">Sekolah Belum Terintegrasi</span>
                    <span class="value">45</span>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="main-box infographic-box colored purple-bg">
                    <i class="fa fa-credit-card"></i>
                    <span class="headline" style="font-size: 10.5px">Persentase Sekolah Bersih</span>
                    <span class="value">42</span>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="main-box clearfix profile-box-contact">
                <div class="main-box-body clearfix">
                    <div class="profile-box-header gray-bg clearfix">
                        <img src="img/samples/kunis-300.jpg" alt="" class="profile-img img-fluid">
                        <h2>Mila Kunis</h2>
                        <div class="job-position">
                            Actress
                        </div>
                        <ul class="contact-details">
                            <li>
                                <i class="fa fa-map-marker"></i> San Francisco
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i> mila@kunis.com
                            </li>
                            <li>
                                <i class="fa fa-phone"></i> (823) 321-0192
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
                <div class="main-box clearfix profile-box-contact">
                    <div class="main-box-body clearfix">
                        <div class="profile-box-header gray-bg clearfix">
                            <img src="img/samples/robert-300.jpg" alt="" class="profile-img img-fluid">
                            <h2>{{$i->singkatan}}</h2>
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
