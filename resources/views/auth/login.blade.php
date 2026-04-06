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
            <!-- Display error messages for brute force protection -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Perhatian!</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Show lockout warning if applicable -->
            @if (session('lockout_warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>⚠️ Akun Terkunci!</strong><br>
                    {{ session('lockout_warning') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Username / Email -->
                <div class="form-group row">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="color: #03a9f4;"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control @error('username') is-invalid @endif" id="username"
                            name="username" value="{{ old('username') ?? old('email') }}" 
                            placeholder="Username atau Email" required
                            autocomplete="off">
                    </div>
                    @error('username')
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

                <!-- CAPTCHA Field (shown conditionally) -->
                @if (session('show_captcha'))
                    <div class="form-group row">
                        <div class="alert alert-info" role="alert" style="line-height: 20px; padding-top: 5px; padding-bottom: 5px;">
                            <i class="fa fa-shield-alt"></i> 
                            <strong>Verifikasi keamanan diperlukan</strong><br>
                            <div style="font-size: 1.2em; text-align: center; font-weight: bold;">
                                @if ($captcha)
                                    {{ $captcha }}
                                @else
                                    Pertanyaan CAPTCHA
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">                        
                        <div class="input-group mb-3">
                            <span class="input-group-text" style="color: #03a9f4;"><i class="fa-solid fa-lightbulb"></i></span>
                               
                                <input type="text" class="form-control @error('captcha_answer') is-invalid @enderror" 
                                    id="captcha_answer"
                                    name="captcha_answer" 
                                    placeholder="Jawaban Anda" 
                                    required
                                    autocomplete="off"
                                    inputmode="numeric">
                        </div>
                    </div>

                        @error('captcha_answer')
                            <small class="text-danger d-block mb-3">{{ $message }}</small>
                        @enderror

                       
                @endif

                <!-- Remember Me & Forgot Password -->
                <div id="remember-me-wrapper" class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="checkbox-nice">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                    class="form-check-input">
                                <label for="remember">
                                    {{ __('Ingat Saya') }}
                                </label>
                            </div>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" id="login-forget-link" class="col-6">
                                {{ __('Lupa Password?') }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Login & Google Button -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mb-1 col-12"
                            style="font-size: 1.125em; font-weight: 600" id="loginBtn">
                            <i class="fa fa-sign-in"></i> {{ __('Masuk') }}
                        </button>
                        <button type="button" class="btn btn-danger col-12"
                            onclick="window.location.href='{{ route('auth.google.redirect') }}'"
                            style="background-color: #dd191d;">
                            <i class="fa fa-google me-2"></i> 
                            <span style="padding-left: 20px">{{ __('Masuk dengan Google') }}</span>
                        </button>
                    </div>
                </div>

                <!-- Registration Link -->
                <div class="text-center my-3">
                    <span style="font-style: italic;">Belum Terdaftar ? 
                        <a href="{{ route('register') }}" style="color: #3e5879;">
                            Klik disini untuk mendaftar
                        </a>
                    </span>
                </div>

                <!-- Security Notice -->
                {{-- <div class="alert alert-secondary" role="alert" style="font-size: 0.85em; margin-top: 15px;">
                    <i class="fa fa-lock"></i> <strong>Keamanan Akun Anda:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Akun akan terkunci sementara setelah 5 percobaan login gagal</li>
                        <li>CAPTCHA akan muncul setelah 3 percobaan gagal</li>
                        <li>Semua percobaan login dipantau untuk keamanan</li>
                    </ul>
                </div> --}}
            </form>
        </div>
    </div>

    @include('sweetalert::alert')
@endsection