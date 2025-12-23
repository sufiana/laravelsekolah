@extends('layouts/authadmin')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12">
            <div id="login-box" style="background-color: black;">
                <div id="login-box-holder">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <header id="login-header">
                                <div id="login-logo" style="background-color: white">
                                    <img src="{{ asset('images') }}/flyer.png" alt="" style="width: 90%; height: 50%" />
                                </div>
                            </header>
                            <div id="login-box-inner">
                                <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                                    @csrf

                                    <!-- Nama Lengkap (Username) -->
                                    <div class="input-group @error('username') has-error @enderror">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-user mx-auto"></i>
                                            </div>
                                        </div>
                                        <input class="form-control form-sm" type="text" placeholder="Nama Lengkap"
                                            id="username" name="username" value="{{ old('username') }}" required
                                            autocomplete="name" autofocus>

                                        <div class="col-md-12">
                                            @error('username')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="input-group @error('email') has-error @enderror">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-envelope mx-auto"></i>
                                            </div>
                                        </div>
                                        <input class="form-control" type="email" placeholder="Email" id="email" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        <div class="col-md-12">
                                            @error('email')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="input-group @error('password') has-error @enderror">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key mx-auto"></i>
                                            </div>
                                        </div>
                                        <input id="password" name="password" required autocomplete="new-password"
                                            type="password" class="form-control" placeholder="Password">
                                        <div class="col-md-12">
                                            @error('password')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-key mx-auto"></i>
                                            </div>
                                        </div>
                                        <input id="password_confirmation" name="password_confirmation" required
                                            autocomplete="new-password" type="password" class="form-control"
                                            placeholder="Konfirmasi Password">
                                    </div>

                                    <!-- No HP -->
                                    <div class="input-group @error('no_hp') has-error @enderror">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-phone mx-auto"></i>
                                            </div>
                                        </div>
                                        <input class="form-control" type="text" placeholder="No HP" id="no_hp" name="no_hp"
                                            value="{{ old('no_hp') }}" required autocomplete="tel">

                                        <div class="col-md-12">
                                            @error('no_hp')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Role -->
                                    <div class="input-group @error('role') has-error @enderror">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users mx-auto"></i>
                                            </div>
                                        </div>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="">Pilih Role</option>
                                            @foreach($role as $r)
                                                <option value="{{ $r->id }}" {{ old('role') == $r->id ? 'selected' : '' }}>
                                                    {{ $r->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="col-md-12">
                                            @error('role')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Dropdown Sekolah (untuk role 2,3,8) -->
                                    <div class="input-group" id="sekolahGroup" style="display: none;">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-school mx-auto"></i>
                                            </div>
                                        </div>
                                        <select class="form-control" id="id_sekolah" name="id_sekolah">
                                            <option value="">Pilih Sekolah</option>
                                            @foreach($sekolah as $s)
                                                <option value="{{ $s->id }}" {{ old('id_sekolah') == $s->id ? 'selected' : '' }}>
                                                    {{ $s->nama }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="col-md-12">
                                            @error('id_sekolah')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Dropdown Cabdis (untuk role 4) -->
                                    <div class="input-group" id="cabdisGroup" style="display: none;">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-building mx-auto"></i>
                                            </div>
                                        </div>
                                        <select class="form-control" id="cabdis" name="cabdis">
                                            <option value="">Pilih Cabdis</option>
                                            @foreach($cabdis as $c)
                                                <option value="{{ $c->id }}" {{ old('cabdis') == $c->id ? 'selected' : '' }}>
                                                    {{ $c->nama }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="col-md-12">
                                            @error('cabdis')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Dropdown Binaan (untuk role 6) -->
                                    <div class="input-group" id="binaanGroup" style="display: none;">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-map-marker mx-auto"></i>
                                            </div>
                                        </div>
                                        <select class="form-control" id="binaan_kabkota" name="binaan_kabkota">
                                            <option value="">Pilih Binaan</option>
                                            @foreach($kabupaten as $k)
                                                <option value="{{ $k->kode_kabupaten }}" {{ old('binaan_kabkota') == $k->kode_kabupaten ? 'selected' : '' }}>
                                                    {{ $k->nama_kabupaten }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="col-md-12">
                                            @error('binaan_kabkota')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-sm col-12"
                                                style="color: #fff; background-color: #28a745;">{{ __('Daftar') }}</button>
                                        </div>
                                    </div>

                                    <div class="text-center my-3">
                                        <span style="font-style: italic;">Sudah punya akun? <a href="{{ route('login') }}"
                                                style="color: #3e5879">Login disini</a></span>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function () {
            var role = this.value;
            var sekolahGroup = document.getElementById('sekolahGroup');
            var cabdisGroup = document.getElementById('cabdisGroup');
            var binaanGroup = document.getElementById('binaanGroup');

            // Hide all groups first
            sekolahGroup.style.display = 'none';
            cabdisGroup.style.display = 'none';
            binaanGroup.style.display = 'none';

            // Remove required attribute
            document.getElementById('id_sekolah').removeAttribute('required');
            document.getElementById('cabdis').removeAttribute('required');
            document.getElementById('binaan_kabkota').removeAttribute('required');

            // Show relevant group based on role
            if (role == 2 || role == 3 || role == 8) {
                sekolahGroup.style.display = 'block';
                document.getElementById('id_sekolah').setAttribute('required', 'required');
            } else if (role == 4) {
                cabdisGroup.style.display = 'block';
                document.getElementById('cabdis').setAttribute('required', 'required');
            } else if (role == 6) {
                binaanGroup.style.display = 'block';
                document.getElementById('binaan_kabkota').setAttribute('required', 'required');
            }
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
        });
    </script>
@endsection