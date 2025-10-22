<!-- @extends('layouts.frontend.main') -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 font-weight-semibold text-center">
            <h4>Selamat Datang Di Portal Perizinan Telekomunikasi</h4>
        </div>
        <div class="col-md-8 font-weight-semibold text-center">
            <h4>DIREKTORAT JENDERAL PENYELENGGARAAN POS DAN INFORMATIKA</h4>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header  bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
				            <h6 class="card-title font-weight-semibold py-3">Pendaftaran Akun KOMINFO</h6>
			            </div>
		            </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="nib" class="col-md-4 col-form-label text-md-end">{{ __('NIB') }}</label>

                            <div class="col-md-8">
                                <input id="nib" type="text" class="form-control @error('nib') is-invalid @enderror" placeholder = "Masukkan NIB Perusahaan Anda" name="nib" value="{{ old('nib') }}" required autocomplete="name" autofocus>

                                @error('nib')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama Penanggung Jawab') }}</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder = "Masukkan Nama Lengkap Anda" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Alamat e-Mail') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" placeholder = "Masukkan alamat e-Mail Anda" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Kata Sandi') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" placeholder = "Masukkan Kata Sandi" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Konfirmasi kata Sandi') }}</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" placeholder = "Konfirmasi Kata Sandi Anda" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-10 float-right">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Daftar') }}
                                </button>
                            </div>
                        </div>

                        <p style="margin-bottom:2px; text-muted">Ini adalah e-mail otomatis yang dikirim oleh layanan e-Telekomunikasi, Harap tidak membalas e-mail berikut.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
