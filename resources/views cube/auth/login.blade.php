@extends('layouts/auth')

@section('content')
<div class="row">
    <div class="col-12 col-sm-12">
        <div id="login-box">
            <div id="login-box-holder">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <header id="login-header">
                            <div id="login-logo" style="background-color: white">
                                <img src="{{ asset('images') }}/flyer.png" alt="" style="width: 90%; height: 50%" />

                            </div>
                        </header>
                        <div id="login-box-inner">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="input-group  @error('email') has-error @enderror">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-user mx-auto"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" placeholder="{{ __('E-Mail Address') }}" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    <div class="col-md-12">
                                        @error('email')
                                        <span class="help-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group @error('password') has-error @enderror">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-key mx-auto"></i>
                                        </div>
                                    </div>
                                    <input id="password" name="password" required autocomplete="current-password" type="password" class="form-control" placeholder="{{ __('Password') }}">
                                    <div class="col-md-12">
                                        @error('password')
                                        <span class="help-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div id="remember-me-wrapper">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="checkbox-nice">
                                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label for="remember-me">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>

                                        @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" id="login-forget-link" class="col-6">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        @endif

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-sm col-12" style="color: #fff; background-color: #0D6EFD;">{{ __('Login') }}</button>
                                        <button type="button" class="btn btn-danger btn-sm col-12" onclick="window.location.href='{{ route('auth.google.redirect') }}'"> <i class="fa fa-google me-2"></i> <span style="padding-left: 20px">{{ __('Login by Google') }} </span></button>
                                    </div>
                                </div>
                                <div class="text-center my-3">
                                    <span style="font-style: italic;">Belum Terdaftar ? <a style="color: #3e5879">Klik disini untuk pendaftaran akun</a></span>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
