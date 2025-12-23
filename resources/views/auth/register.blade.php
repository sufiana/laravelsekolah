@extends('layouts/authadmin')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .select2-container--default .select2-selection--single {
            height: 31px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 29px !important;
            padding-left: 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 29px !important;
        }
    </style>
@endsection

@section('content')

    <div class="card card-outline card-primary">
        <div class="card-header">
            <img src="{{ asset('images') }}/flyer.png" alt="" style="width: 98%; height: 50%" />
        </div>

        <div class="card-body register-card-body">
            <p class="register-box-msg">Form Registrasi User</p>
            <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                @csrf
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group ">
                                <input type="text" class="form-control" aria-label="Nama Lengkap" required id="username"
                                    name="username" value="{{ old('username') }}" required autofocus
                                    placeholder="Nama Lengkap">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            @error('username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="Email" required>
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Password" required autocomplete="new-password">
                            <span class="input-group-text">
                                <i class="fa fa-key"></i>
                            </span>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Konfirmasi Password" required>
                            <span class="input-group-text">
                                <i class="fa fa-key"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- No HP -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No HP</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                name="no_hp" value="{{ old('no_hp') }}" placeholder="No HP" required>
                            <span class="input-group-text">
                                <i class="fa fa-phone"></i>
                            </span>
                        </div>
                        @error('no_hp')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Role -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Role</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                @foreach($role as $r)
                                    <option value="{{ $r->id }}" {{ old('role') == $r->id ? 'selected' : '' }}>
                                        {{ $r->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="input-group-text">
                                <i class="fa fa-users"></i>
                            </span>
                        </div>
                        @error('role')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Sekolah -->
                <div class="form-group row" id="sekolahGroup">
                    <label class="col-sm-3 col-form-label">Sekolah</label>
                    <div class="col-sm-9">
                        <select class="form-control select2-sekolah @error('id_sekolah') is-invalid @enderror"
                            id="id_sekolah" name="id_sekolah">
                            <option value="">Pilih Sekolah</option>
                            @foreach($sekolah as $s)
                                <option value="{{ $s->id }}" {{ old('id_sekolah') == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_sekolah')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Cabdis -->
                <div class="form-group row" id="cabdisGroup">
                    <label class="col-sm-3 col-form-label">Cabdis</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <select class="form-control @error('cabdis') is-invalid @enderror" id="cabdis" name="cabdis">
                                <option value="">Pilih Cabdis</option>
                                @foreach($cabdis as $c)
                                    <option value="{{ $c->id }}" {{ old('cabdis') == $c->id ? 'selected' : '' }}>
                                        {{ $c->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="input-group-text">
                                <i class="fa fa-building"></i>
                            </span>
                        </div>
                        @error('cabdis')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Binaan -->
                <div class="form-group row" id="binaanGroup">
                    <label class="col-sm-3 col-form-label">Binaan</label>
                    <div class="col-sm-9">
                        <select class="form-control select2-kabupaten @error('binaan_kabkota') is-invalid @enderror"
                            id="binaan_kabkota" name="binaan_kabkota">
                            <option value="">Pilih Binaan</option>
                            @foreach($kabupaten as $k)
                                <option value="{{ $k->kode_kabupaten }}" {{ old('binaan_kabkota') == $k->kode_kabupaten ? 'selected' : '' }}>
                                    {{ $k->nama_kabupaten }}
                                </option>
                            @endforeach
                        </select>

                        @error('binaan_kabkota')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn col-12 btn-primary">TAMBAH</button>
                    </div>
                </div>
                <div class="text-center my-3">
                    <span style="font-style: italic;">
                        <span style="color: black;">Sudah Terdaftar ? </span>
                        <a style=" text-decoration: none; color: #3e5879" href="{{ route('login') }}">Klik disini untuk
                            Login</a>
                    </span>
                </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const sekolahGroup = document.getElementById('sekolahGroup');
            const cabdisGroup = document.getElementById('cabdisGroup');
            const binaanGroup = document.getElementById('binaanGroup');

            const sekolahSelect = document.getElementById('id_sekolah');
            const cabdisSelect = document.getElementById('cabdis');
            const binaanSelect = document.getElementById('binaan_kabkota');

            function hideAll() {
                sekolahGroup.classList.add('d-none');
                cabdisGroup.classList.add('d-none');
                binaanGroup.classList.add('d-none');

                sekolahSelect.removeAttribute('required');
                cabdisSelect.removeAttribute('required');
                binaanSelect.removeAttribute('required');
            }

            function show(element, input) {
                element.classList.remove('d-none');
                input.setAttribute('required', 'required');
            }

            roleSelect.addEventListener('change', function () {
                const role = this.value;
                hideAll();

                if ([2, 3, 8].includes(parseInt(role))) {
                    show(sekolahGroup, sekolahSelect);
                    $('.select2-sekolah').trigger('change.select2');
                }

                if (parseInt(role) === 4) {
                    show(cabdisGroup, cabdisSelect);
                }

                if (parseInt(role) === 6) {
                    show(binaanGroup, binaanSelect);
                    $('.select2-kabupaten').trigger('change.select2');
                }
            });

            // 🔁 Trigger ulang saat halaman reload (old value)
            if (roleSelect.value) {
                roleSelect.dispatchEvent(new Event('change'));
            }

            // Select2 init
            $('.select2-sekolah').select2({
                placeholder: 'Pilih Sekolah',
                allowClear: true,
                width: '100%'
            });

            $('.select2-kabupaten').select2({
                placeholder: 'Pilih Kabupaten',
                allowClear: true,
                width: '100%'
            });
        });
        // Password confirmation validation
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
        });

        // Trigger change event on page load if role is already selected
        document.addEventListener('DOMContentLoaded', function () {
            var roleSelect = document.getElementById('role');
            if (roleSelect.value) {
                roleSelect.dispatchEvent(new Event('change'));
            }

            // Initialize Select2
            $('.select2-sekolah').select2({
                placeholder: 'Pilih Sekolah',
                allowClear: true,
                width: '100%'
            });

            $('.select2-kabupaten').select2({
                placeholder: 'Pilih Kabupaten',
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    @section('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endsection

    @include('sweetalert::alert')
@endsection