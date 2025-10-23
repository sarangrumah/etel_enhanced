@extends('layouts.frontend.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card pb-4">
                <div class="card-header bg-secondary text-center">
                    <h2 class="text-white mb-0">{{ __('Login') }}</h2>
                </div>
                <div class="alert alert-info border-0 alert-dismissible">
                    {{-- <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button> --}}
                    <span class="font-weight-semibold">Harap Diperhatikan!</span> Mohon ikuti panduan penggunaan aplikasi e-Telekomunikasi. <a href="/storage/guideline-etelekomunikasi.pdf" class="alert-link">Unduh Panduan</a>.
                </div>
                @if (Session::get('message'))
                    <div class="alert alert-warning alert-block">

                        <strong>{{Session::get('message')}}</strong>

                    </div>
                @endif
                @if (isset($message))
                    <div class="alert alert-warning alert-block">

                        <strong>{{isset($message) ? $message : '-'}}</strong>

                    </div>
                @endif
                @if ($errors->has('throttle'))
                    <div class="alert alert-danger">
                        {{ $errors->first('throttle') }}
                    </div>
                @endif
                @if (session('notification'))
                    <div class="alert alert-danger">
                        {{ session('notification') }}
                    </div>
                @endif
                @if (session('notification'))
                    <div class="alert alert-danger">
                        {{ session('notification') }}
                    </div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Alamat e-Mail')
                                }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Kata Sandi')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Captcha')
                                }}</label>

                            <div class="col-md-6">
                                <div id="captchaimgwrapper">
                                    <img id="captchaimg" src="{{ url('/generate') }}" alt="image captcha">
                                </div>
                                <input id="captcha" type="text"
                                    class="form-control mt-2 @error('captcha') is-invalid @enderror" name="captcha"
                                    required placeholder="Masukkan nama provinsi diatas">

                                @error('captcha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                        old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Ingatkan Saya') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-secondary">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Lupa kata Sandi?') }}
                        </a>
                        @endif

                        @if (Route::has('register'))
                        <a class="btn btn-link" href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>
                        @endif
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection


@section('custom-js')
<script>
    $('#captchaimgwrapper').click(function() {
            $('#captchaimg').attr('src',
                '{{ url('/generate') }}');
        });
</script>
@endsection
