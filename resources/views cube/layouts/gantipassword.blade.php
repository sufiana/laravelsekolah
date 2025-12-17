@extends('layouts/master')
@section('title','Ubah Kantor')
@section('content')

<div class="preloader"></div>

<div class="mdk-header-layout js-mdk-header-layout">
    <div id="header" class="mdk-header js-mdk-header m-0" data-fixed></div>
    <div class="mdk-header-layout__content">
        <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
            <div class="mdk-drawer-layout__content page">
                <div style="padding-bottom: calc(5.125rem / 2); position: relative; margin-bottom: 1.5rem;">
                    <div class="bg-primary" style="min-height: 150px;">
                        <div class="d-flex align-items-end container-fluid page__container" style="position: absolute; left: 0; right: 0; bottom: 0;">
                            <div class="avatar avatar-xl">
                                <img src="{{ asset('upload/berkas pegawai/'.$foto) }}" alt="avatar" class="avatar-img rounded" style="border: 2px solid white;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid page__container">
                    <div class="row">
                        <div class="col-lg-3">
                            <h1 class="h4 mb-1">{{$karyawan->nama_lengkap}}</h1>
                            <p class="text-muted">{{'@'.$karyawan->email_corporate}}</p>
                            <p>{{$karyawan->id_karyawan}}</p>
                        </div>
                        <div class="col-lg-9">
                            <div class="tab-content">
                                <div class="tab-pane active" id="activity">
                                    <div class="card">
                                        <div class="px-4 py-3">
                                            <div class="d-flex mb-1">
                                                <div class="flex">
                                                    @if ($message = Session::get('berhasil'))
                                                    <div class="alert alert-success" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                                        <strong>{!! session('berhasil') !!}</strong>
                                                    </div>
                                                    @endif

                                                    @if (count($errors) > 0)
                                                    <div class="alert alert-danger" role="alert">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif

                                                    <form method="POST" enctype="multipart/form-data" action="{{ route('karyawan.savepassword') }}">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden"  id="id" name="id" value="{{Auth::user()->id}}">
                                                        <div class="form-row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label>Password</label>
                                                                <input class="form-control" type="password" required id="password" name="password" placeholder="Enter your password"/>
                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label>Konfirmasi Password</label>
                                                                <input id="password_confirm" name="password_confirm" type="password" required autocomplete="new-password" class="form-control" placeholder="Confirm your password"></td>
                                                            </div>
                                                        </div>
                                                        <div class="form-group text-center">
                                                            <button type="submit" class="btn btn-success" id="btn-save">Save</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

