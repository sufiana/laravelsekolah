@extends('layouts/authadmin')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* .form-group {
                        margin-bottom: 1rem;
                    }

                    .form-label {
                        font-weight: 600;
                        margin-bottom: 0.5rem;
                        display: block;
                    }

                    .select2-container--default .select2-selection--single {
                        height: 31px !important;
                        border: 2px solid #03a9f4; !important;
                        border-radius: 0.25rem;
                    }

                    .select2-container--default .select2-selection--single .select2-selection__rendered {
                        line-height: 29px !important;
                        padding-left: 12px !important;
                    }

                    .select2-container--default .select2-selection--single .select2-selection__arrow {
                        height: 29px !important;
                    } */
        @media (max-width: 768px) {
            .card {
                width: 100% !important;
                margin: 0 !important;
                border-radius: 0;
                /* biar rapat ke sisi layar */
            }

            .card-header img {
                width: 100% !important;
                height: auto !important;
            }

            .register-card-body {
                padding: 1rem !important;
                /* biar nyaman di layar kecil */
            }
        }
    </style>
@endsection


@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <img src="{{ asset('images') }}/flyer.png" alt="" class="img-fluid w-100" />
        </div>

        <div class="card-body register-card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group row">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="color: #03a9f4;"><i class="fa fa-user"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" placeholder="Email" required>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group row">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="color: #03a9f4;"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Password" required autocomplete="new-password">
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div id="remember-me-wrapper" class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="checkbox-nice">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                    class="form-check-input">
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
                        <button type="submit" class="btn btn-primary mb-1 col-12"
                            style="font-size=1.125e; font-weight: 600">{{ __('Login') }}</button>
                        <button type="button" class="btn btn-danger col-12"
                            onclick="window.location.href='{{ route('auth.google.redirect') }}'"
                            style="background-color: #dd191d;">
                            <i class="fa fa-google me-2"></i> <span style="padding-left: 20px">{{ __('Login by Google') }}
                            </span>
                        </button>
                    </div>
                </div>

                <div class="text-center my-3">
                    <span style="font-style: italic;">Belum Terdaftar ? <a href="{{ route('register') }}"
                            style="color: #3e5879;">Klik disini untuk pendaftaran akun</a>
                    </span>
                </div>
            </form>
        </div>
    </div>

    @include('sweetalert::alert')
@endsection