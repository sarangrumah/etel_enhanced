<!-- @extends('layouts.frontend.main') -->
@section('js')
    <script src="../global_assets/js/plugins/extensions/jquery_ui/jquery-ui.min.js"></script>
    <script src="../global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="../global_assets/js/demo_pages/form_select2.js"></script>
    <script src="../global_assets/js/plugins/notifications/bootbox.min.js"></script>

    <script src="../global_assets/js/demo_pages/components_modals.js"></script>
@endsection

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
                                <h6 class="card-title font-weight-semibold py-3">Pendaftaran Akun e-Licensing KOMINFO</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->has('nib') || $errors->has('name_pt') || $errors->has('email'))
                            <div class="alert alert-danger" role="alert">
                                @error('nib')
                                    <strong>NIB:</strong> {{ $message }}<br>
                                @enderror
                                @error('name_pt')
                                    <strong>Nama Perusahaan:</strong> {{ $message }}<br>
                                @enderror
                                @error('email')
                                    <strong>Email:</strong> {{ $message }}
                                @enderror
                            </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="jenispelakuusaha"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Jenis  Pelaku Usaha') }}</label>
                                <!-- <i class="icon-question3 mr-3"></i> -->

                                <div class="col-md-8">
                                    <select data-placeholder="Pilih Jenis Pelaku Usaha" class="form-control select"
                                        name="jenis_pu" id="jenis_pu">
                                        <option></option>
                                        <optgroup
                                            label="Penyelenggara
                                            Telekomunikasi">
                                            <option value="PTB" {{ old('jenis_pu') == 'PTB' ? 'selected' : '' }}>
                                                Penyelenggara
                                                Telekomunikasi - Badan Hukum
                                            </option>
                                        </optgroup>
                                        <optgroup
                                            label="Telekomunikasi
                                                Khusus">
                                            <option value="TKB" {{ old('jenis_pu') == 'TKB' ? 'selected' : '' }}>
                                                Telekomunikasi
                                                Khusus - Badan Hukum</option>
                                            <option value="TKI" {{ old('jenis_pu') == 'TKI' ? 'selected' : '' }}>
                                                Telekomunikasi
                                                Khusus - Instansi Pemerintah</option>
                                        </optgroup>
                                        <optgroup label="Penomoran">
                                            {{-- <option value="PTP" {{ old('jenis_pu') == 'PTP' ? 'selected' : '' }}>
                                                Penyelenggara
                                                Telekomunikasi - Penomoran
                                            </option> --}}

                                            <option value="NPT" {{ old('jenis_pu') == 'NPT' ? 'selected' : '' }}>
                                                Non
                                                Penyelenggara Telekomunikasi - Penomoran</option>
                                        </optgroup>

                                    </select>
                                    @error('jenis_pu')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nib" class="col-md-3 col-form-label text-md-end" hidden
                                    id="labelNIB">{{ __('NIB') }}</label>
                                <label for="nama_perseroan" class="col-md-3 col-form-label text-md-end" hidden
                                    id="labelnama_perseroan">{{ __('Nama Perusahaan') }}</label>
                                <label for="nama_instansi" class="col-md-3 col-form-label text-md-end" hidden
                                    id="labelnama_instansi">{{ __('Nama K/L/D/I') }}</label>

                                <div class="col-md-8">

                                    <div class="input-group">
                                        <input id="nib" name="nib" type="text" hidden
                                            class="form-control border-right-0 @error('nib') is-invalid @enderror"
                                            value="{{ Session::has('valet') ? Session::get('valet')->data_nib[0] : old('nib') }}"
                                            placeholder="Masukkan NIB Anda">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-indigo" id="bootbox_custom_kominfo"
                                                hidden><i class="icon-question3"></i></button>
                                        </span>
                                        <input id="name_pt" name="name_pt" type="text" hidden class="form-control"
                                            placeholder="Masukkan Entitas Anda">
                                        <small id="catatan_kdli" for="" class="text-danger mr-2" hidden>*Harap diisi
                                            sesuai nama K/D/L/I (Kementerian/Lembaga/Satuan Kerja Perangkat
                                            Daerah/Instansi)</small>

                                    </div>
                                    <!-- <input id="nib" type="text" class="form-control @error('nib') is-invalid @enderror" placeholder = "Masukkan NIB Perusahaan Anda" name="nib" value="{{ old('nib') }}" required autocomplete="name" autofocus> -->

                                    @error('nib')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- <div class="col-md-8">

                                    <div class="input-group">
                                        <input id="name_pt" name="name_pt" type="text" hidden
                                            class="form-control"
                                            required autocomplete="name" autofocus
                                            placeholder="Masukkan Entitas Anda">

                                    </div>
                                    <!-- <input id="nib" type="text" class="form-control @error('nib') is-invalid @enderror" placeholder = "Masukkan NIB Perusahaan Anda" name="nib" value="{{ old('nib') }}" required autocomplete="name" autofocus> -->

                                    @error('nib')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}
                            </div>
                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Nama Penanggung Jawab') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Masukkan Nama Lengkap Anda" name="name" value="{{ old('name') }}"
                                        required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Alamat e-Mail') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" placeholder="Masukkan alamat e-Mail Anda"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ Session::has('valet') ? Session::get('valet')->email : old('email') }}"
                                        required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Kata Sandi') }}</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" placeholder="Masukkan Kata Sandi"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}"
                                        title="Kata sandi harus mengandung minimal 8 karakter, termasuk 1 huruf besar, 1 huruf kecil, 1 angka, and 1 karakter spesial.">

                                    <div id="password-strength" class="form-text mt-1" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small id="length" class="text-danger">Minimal 8 karakter</small>
                                            </div>
                                            <div class="col-md-6">
                                                <small id="capital" class="text-danger">Minimal 1 huruf besar (A-Z)</small>
                                            </div>
                                            <div class="col-md-6">
                                                <small id="lowercase" class="text-danger">Minimal 1 huruf kecil (a-z)</small>
                                            </div>
                                            <div class="col-md-6">
                                                <small id="number" class="text-danger">Minimal 1 angka (0-9)</small>
                                            </div>
                                            <div class="col-md-6">
                                                <small id="special" class="text-danger">Minimal 1 karakter spesial</small>
                                            </div>
                                        </div>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Konfirmasi
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                kata Sandi') }}</label>

                                <div class="col-md-8">
                                    <input id="password-confirm" type="password" placeholder="Konfirmasi Kata Sandi Anda"
                                        class="form-control" name="password_confirmation" required
                                        autocomplete="new-password">
                                    <small id="password-match" class="text-danger" style="display:none;">Kata sandi tidak cocok</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 float-right">
                                    <button type="submit" class="btn btn-indigo">
                                        {{ __('Daftar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#jenis_pu").change(function() {
                var nilai = $(this).val();
                if (nilai == "PTB" || nilai == "TKB") {
                    $('#labelNIB').attr('hidden', false);
                    $('#labelnama_perseroan').attr('hidden', true);
                    $('#labelnama_instansi').attr('hidden', true);
                    $('#catatan_kdli').attr('hidden', true);
                    $('#nib').attr('hidden', false);
                    $('#nib').attr('required', true);
                    $('#name_pt').attr('hidden', true);
                    $('#name_pt').removeAttr('required')
                    $('#bootbox_custom_kominfo').attr('hidden', false);
                }
                if (nilai == "TKI") {
                    $('#labelNIB').attr('hidden', true);
                    $('#labelnama_perseroan').attr('hidden', true);
                    $('#labelnama_instansi').attr('hidden', false);
                    $('#catatan_kdli').attr('hidden', false);
                    $('#nib').attr('hidden', true);
                    $('#nib').removeAttr('required');
                    $('#name_pt').attr('hidden', false);
                    $('#name_pt').attr('required', true);
                    $('#bootbox_custom_kominfo').attr('hidden', true);
                }
                if (nilai == "NPT") {
                    $('#labelNIB').attr('hidden', true);
                    $('#labelnama_perseroan').attr('hidden', false);
                    $('#labelnama_instansi').attr('hidden', true);
                    $('#catatan_kdli').attr('hidden', true);
                    $('#nib').removeAttr('required');
                    $('#nib').attr('required', false);
                    $('#nib').attr('hidden', true);
                    $('#name_pt').attr('hidden', false);
                    $('#name_pt').attr('required', true);
                    $('#bootbox_custom_kominfo').attr('hidden', true);
                }
                console.log(nilai);
            });

            $('#password').on('focus', function() {
                $('#password-strength').show();
            });

            function validatePassword() {
                var password = $('#password').val();
                var confirmPassword = $('#password-confirm').val();

                // Validate length
                if (password.length >= 8) {
                    $('#length').removeClass('text-danger').addClass('text-success').html('✔️ Minimal 8 karakter');
                } else {
                    $('#length').removeClass('text-success').addClass('text-danger').html('❌ Minimal 8 karakter');
                }

                // Validate capital letter
                if (password.match(/[A-Z]/)) {
                    $('#capital').removeClass('text-danger').addClass('text-success').html(
                        '✔️ Minimal 1 huruf besar (A-Z)');
                } else {
                    $('#capital').removeClass('text-success').addClass('text-danger').html(
                        '❌ Minimal 1 huruf besar (A-Z)');
                }

                // Validate lowercase letter
                if (password.match(/[a-z]/)) {
                    $('#lowercase').removeClass('text-danger').addClass('text-success').html(
                        '✔️ Minimal 1 huruf kecil (a-z)');
                } else {
                    $('#lowercase').removeClass('text-success').addClass('text-danger').html(
                        '❌ Minimal 1 huruf kecil (a-z)');
                }

                // Validate number
                if (password.match(/[0-9]/)) {
                    $('#number').removeClass('text-danger').addClass('text-success').html(
                        '✔️ Minimal 1 angka (0-9)');
                } else {
                    $('#number').removeClass('text-success').addClass('text-danger').html(
                        '❌ Minimal 1 angka (0-9)');
                }

                // Validate special character
                if (password.match(/[^a-zA-Z0-9]/)) {
                    $('#special').removeClass('text-danger').addClass('text-success').html(
                        '✔️ Minimal 1 karakter spesial');
                } else {
                    $('#special').removeClass('text-success').addClass('text-danger').html(
                        '❌ Minimal 1 karakter spesial');
                }

                // Validate password match
                if (password === confirmPassword && confirmPassword.length > 0) {
                    $('#password-match').hide();
                } else if (confirmPassword.length > 0) {
                    $('#password-match').show();
                } else {
                    $('#password-match').hide();
                }
            }

            $('#password').on('keyup', validatePassword);
            $('#password-confirm').on('keyup', validatePassword);
        });
    </script>
@endsection
