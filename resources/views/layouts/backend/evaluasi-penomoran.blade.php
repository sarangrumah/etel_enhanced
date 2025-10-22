@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
@endsection
@section('content')
    <form method="post" id="formEvaluasi"
        action="{{ route('admin.koordinator.evaluasipenomoranpost', [$id, $penomoran['id_kode_akses']]) }}">
        @csrf
        <input type="hidden" name="id_izin" value="{{ $penomoran['id_izin'] }}" />
        <div class="form-group">


            <!-- Section Detail Perusahaan -->
            {{-- <div>
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Informasi Perusahaan </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Perusahaan/Instansi
                                    </legend>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab
                                    </legend>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NIB </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['nib'] }}</label>
                                    </div>
                                    <div class="col-lg">
                                        <span>
                                            <a target="_blank" href="{{ asset($detailnib->path_berkas_nib) }}"
                                                class="btn btn-teal" type="button">Lihat Dokumen</a>
                                        </span>
                                    </div>
                                </div>.
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NIK </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NPWP </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['npwp_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Email </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Nama </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Nama </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['nama_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Telp </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ $detailnib['nomor_telpon_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Telp/Mobile </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div>
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Informasi Pemohon </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col">
                                <legend class="text-uppercase font-size-sm font-weight-bold">Data Perusahaan/Instansi
                                </legend>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">NIB </label>
                                            <div class="input-group col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $detailnib['nib'] }}" disabled>
                                                <span class="input-group-append">
                                                    {{-- <button class="btn btn-light" type="button">Button</button>
                                                     --}}
                                                    <a target="_blank" href="{{ asset($detailnib->path_berkas_nib) }}"
                                                        class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">NPWP </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ $detailnib['npwp_perseroan'] }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ $detailnib['npwp_perseroan'] }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Nama </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ $detailnib['nama_perseroan'] }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ $detailnib['nama_perseroan'] }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">No Telp/Mobile </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}</label> --}}

                                                <input type="text" class="form-control"
                                                    value="{{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">NIK </label>

                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                    {{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}
                                                </label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Email </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                    {{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label> --}}

                                                <input type="text" class="form-control"
                                                    value="{{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Nama </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                    {{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
                                                </label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">No Telp </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                    {{ $detailnib['nomor_telpon_perseroan'] }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ isset($detailnib['nomor_telpon_perseroan']) ? $detailnib['nomor_telpon_perseroan'] : '-' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Detail Perusahaan -->

            {{-- <div>
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Informasi Permohonan </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Permohonan
                                    </legend>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Perizinan</legend>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $penomoran['id_izin'] }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Perizinan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['jenis_izin']) ? $penomoran['jenis_izin'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                                    <div class="col-lg">
                                        @if ($penomoran['updated_date'] == null)
                                            <label class="col-lg col-form-label">: - </label>
                                        @else
                                            <label class="col-lg col-form-label">:
                                                {{ $date_reformat->date_lang_reformat_long($penomoran['updated_date']) }}
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">KBLI</label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['full_kbli']) ? $penomoran['full_kbli'] : '' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['jenis_permohonan']) ? $penomoran['jenis_permohonan'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Layanan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['jenis_layanan']) ? $penomoran['jenis_layanan'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Status Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_izin']['name_status_bo']) ? $penomoran['kode_izin']['name_status_bo'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> --}}
            <div>
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Informasi Permohonan </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col">

                                <legend class="text-uppercase font-size-sm font-weight-bold">Data Permohonan
                                </legend>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">No Permohonan </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">: {{ $penomoran['id_izin'] }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ $penomoran['id_izin'] }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                                            <div class="col-lg">
                                                @if ($penomoran['updated_date'] == null)
                                                    <input type="text" class="form-control" value="-" disabled>
                                                @else
                                                    {{-- <label class="col-lg col-form-label">:
                                                    {{ $date_reformat->date_lang_reformat_long($penomoran['updated_date']) }}
                                                </label> --}}
                                                    <input type="text" class="form-control"
                                                        value="{{ $date_reformat->date_lang_reformat_long($penomoran['updated_date']) }}"
                                                        disabled>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['jenis_permohonan']) ? $penomoran['jenis_permohonan'] : '' }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ isset($penomoran['jenis_permohonan']) ? $penomoran['jenis_permohonan'] : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Status Permohonan </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['kode_izin']['name_status_bo']) ? $penomoran['kode_izin']['name_status_bo'] : '' }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ isset($penomoran['kode_izin']['name_status_bo']) ? $penomoran['kode_izin']['name_status_bo'] : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">

                                <legend class="text-uppercase font-size-sm font-weight-bold">Data Perizinan</legend>

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Perizinan </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['jenis_izin']) ? $penomoran['jenis_izin'] : '' }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ isset($penomoran['jenis_izin']) ? $penomoran['jenis_izin'] : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">KBLI</label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['full_kbli']) ? $penomoran['full_kbli'] : '' }}
                                            </label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ isset($penomoran['full_kbli']) ? $penomoran['full_kbli'] : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Jenis Layanan </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['jenis_layanan']) ? $penomoran['jenis_layanan'] : '' }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ isset($penomoran['jenis_layanan']) ? $penomoran['jenis_layanan'] : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Section Detail Permohonan -->



            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Evaluasi Permohonan </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Penomoran</legend>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="row">
                                <label class="col-lg-2 col-form-label">Jenis Kode Akses</label>
                                <div class="col-lg-8">
                                    {{-- <label class="col-lg col-form-label">: {!! isset($penomoran['kode_akses']['jeniskodeakses']['full_name_html'])
                                        ? $penomoran['kode_akses']['jeniskodeakses']['full_name_html']
                                        : '' !!}</label> --}}
                                    <input type="text" class="form-control" value="{!! isset($penomoran['kode_akses']['jeniskodeakses']['full_name_html'])
                                        ? $penomoran['kode_akses']['jeniskodeakses']['full_name_html']
                                        : '' !!}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($penomoran['kode_akses']['jeniskodeakses']['full_name_html'] == 'Blok Nomor')
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Daftar Blok Nomor </label>
                                    <div class="col-lg-8" id="PilihKodeWilayah">

                                        <table class="text-center table table-custom table-sm">
                                            <thead>
                                                <tr>
                                                    <th style="border-top: none;background: #fafafa;text-align: center;">
                                                        Wilayah</th>
                                                    <th style="border-top: none;background: #fafafa;text-align: center;">
                                                        Kode
                                                        Wilayah</th>
                                                    <th style="border-top: none;background: #fafafa;text-align: center;">
                                                        Blok Nomor
                                                    </th>
                                                    <th style="border-top: none;background: #fafafa;text-align: center;">
                                                        Status Evaluasi
                                                    </th>
                                                </tr>

                                            </thead>
                                            <tbody id="bloknomor-lists">
                                                @foreach ($penomoran_bloknomor as $item => $d)
                                                    <input type="hidden"
                                                        name="bloknomor[{{ $item }}][bn_kode_wilayah]"
                                                        value={{ $d['kode_wilayah'] }}>
                                                    <input type="hidden"
                                                        name="bloknomor[{{ $item }}][bn_prefix_awal]"
                                                        value={{ $d['prefix_awal'] }}>
                                                    <tr class="bloknomor-item">
                                                        <td style="width: 40%;">
                                                            <div class="font-size-sm">
                                                                {{ $d['nama_wilayah'] }}
                                                            </div>
                                                        </td>
                                                        <td style="width: 10%;">
                                                            <div class="font-size-sm">
                                                                {{ $d['kode_wilayah'] }}
                                                            </div>
                                                        </td>
                                                        <td style="width: 10%;">
                                                            <div class="font-size-sm">
                                                                {{ $d['prefix_awal'] }}
                                                            </div>
                                                        </td>
                                                        <td style="width: 15%;">
                                                            <div>
                                                                <select name="bloknomor[{{ $item }}][is_deleted]"
                                                                    id=""
                                                                    class="form-control bloknomor-isdeleted"
                                                                    data-placeholder="Silakan Pilih" disabled>
                                                                    {{-- <option value="" selected>Pilih Evaluasi</option> --}}
                                                                    <option value="1"
                                                                        @if ($d['status_evaluasi_bloknomor'] == '1') selected @endif>
                                                                        Setuju</option>
                                                                    <option value="2"
                                                                        @if ($d['status_evaluasi_bloknomor'] == '2') selected @endif>
                                                                        Ditolak</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Kode Akses </label>
                                    <div class="col-lg-8">
                                        {{-- <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}</label> --}}
                                        <input type="text" class="form-control"
                                            value="{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($penomoran['jenis_permohonan'] == 'Penetapan Nomor Tambahan')
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Kelengkapan</legend>
                        <div class="form-group row">
                            <?php
                            $file = explode('/', $penomoran['dok_pengguna_penomoran']);
                            if (isset($penomoran['dok_izin_penyelenggaraan'])) {
                                $_file4 = explode('/', $penomoran['dok_izin_penyelenggaraan']);
                                $file4 = $_file4[3];
                            } else {
                                $file4 = '';
                            }
                            
                            $file4 = $file4;
                            ?>
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="font-weight-semibold">Dokumen Perizinan Berusaha</p>
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ $file4 }}">
                                            <span class="input-group-append">
                                                <a target="_blank"
                                                    href="{{ asset($penomoran['dok_izin_penyelenggaraan']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="font-weight-semibold">Laporan Penggunaan Penomoran Eksisting</p>
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ $file[3] }}">
                                            <span class="input-group-append">
                                                <a target="_blank"
                                                    href="{{ asset($penomoran['dok_pengguna_penomoran']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($penomoran['kd_izin'] == '059000000033')
                            <div
                                class="form-group row <?= strtolower($penomoran['jenis_layanan']) == 'sertifikat penyelenggaraan jasa konten sms premium' ? 'd-blok' : 'd-none' ?>">
                                <?php
                                if (isset($penomoran['dok_kode_akses_konten'])) {
                                    $_file2 = explode('/', $penomoran['dok_kode_akses_konten']);
                                    $file2 = $_file2[3];
                                } else {
                                    $file2 = '';
                                }
                                
                                $file2 = $file2;
                                ?>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="font-weight-semibold">Penjelasan Singkat (Produk brief) Layanan Baru
                                            </p>
                                            <div class="input-group">
                                                <input disabled="disabled" type="text"
                                                    class="form-control border-right-0"
                                                    placeholder="{{ $file2 }}">
                                                <span class="input-group-append">
                                                    <a target="_blank"
                                                        href="{{ asset($penomoran['dok_kode_akses_konten']) }}"
                                                        class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($penomoran['kd_izin'] == '059000000052')
                            <div class="form-group row">
                                <?php
                                if (isset($penomoran['dok_call_center'])) {
                                    $_file3 = explode('/', $penomoran['dok_call_center']);
                                    $file3 = $_file3[3];
                                } else {
                                    $file3 = '';
                                }
                                
                                ?>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Surat dukungan dari calon pengguna untuk
                                                pengajuan kode
                                                akses call center</p>
                                            <div class="input-group">
                                                <input disabled="disabled" type="text"
                                                    class="form-control border-right-0"
                                                    placeholder="{{ $file3 }}">
                                                <span class="input-group-append">
                                                    <a target="_blank" href="{{ asset($penomoran['dok_call_center']) }}"
                                                        class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- <hr class="" />
                        <div class="form-group ">
                            <div class="col-lg-12">
                                <label for="berkas_tambahan">Berkas Hasil Evaluasi Permohonan Nomor Tambahan</label>
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control border-right-0"
                                        placeholder="{{ $path_bkpm[2] }}">
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($penomoran['path_dok_evaluasi_tambahan']) }}"
                                            class="btn btn-teal" type="button">Lihat Dokumen</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr class="" /> --}}
                    @elseif(strtolower($penomoran['jenis_permohonan']) == 'permohonan penyesuaian')
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">SK Penetapan Penomoran yang disesuaikan</p>
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ isset($penomoran['pe_dok_sk']) ? $penomoran['pe_dok_sk'] : '' }}">
                                            <span class="input-group-append">
                                                <a target="_blank" href="{{ asset($penomoran['pe_dok_sk']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 text-center">
                                        <p class="font-weight-semibold text-center" id="label4">Sesuai</p>
                                        <div
                                            class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                            <input type="checkbox" data="4" name="is_koreksi_dokumen_4"
                                                class="custom-control-input" id="c_upload_4">
                                            <label class="custom-control-label" for="c_upload_4"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <p class="font-weight-semibold">Catatan</p>
                                        <textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_4" name="catatan_pe_dok_sk"
                                            rows="2" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Dokumen Perizinan Terakhir</p>
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ isset($penomoran['pe_dok_perizinan_terakhir']) ? $penomoran['pe_dok_perizinan_terakhir'] : '' }}">
                                            <span class="input-group-append">
                                                <a target="_blank"
                                                    href="{{ asset($penomoran['pe_dok_perizinan_terakhir']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 text-center">
                                        <p class="font-weight-semibold text-center" id="label5">Sesuai</p>
                                        <div
                                            class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                            <input type="checkbox" data="5" name="is_koreksi_dokumen_5"
                                                class="custom-control-input" id="c_upload_5">
                                            <label class="custom-control-label" for="c_upload_5"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <p class="font-weight-semibold">Catatan</p>
                                        <textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_5"
                                            name="catatan_pe_dok_perizinan_terakhir" rows="2" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Dokumen Pendukung Lainnya</p>
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ isset($penomoran['pe_dok_pendukung']) ? $penomoran['pe_dok_pendukung'] : '' }}">
                                            <span class="input-group-append">
                                                <a target="_blank" href="{{ asset($penomoran['pe_dok_pendukung']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 text-center">
                                        <p class="font-weight-semibold text-center" id="label6">Sesuai</p>
                                        <div
                                            class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                            <input type="checkbox" data="6" name="is_koreksi_dokumen_6"
                                                class="custom-control-input" id="c_upload_6">
                                            <label class="custom-control-label" for="c_upload_6"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <p class="font-weight-semibold">Catatan</p>
                                        <textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_6" name="catatan_pe_dok_pendukung"
                                            rows="2" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="" />
                    @elseif($penomoran['jenis_permohonan'] == 'Pengembalian Penomoran')
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Kelengkapan</legend>
                        <div class="form-group row">
                            <?php
                            $file_sk = explode('/', $penomoran['pe_dok_sk']);
                            ?>
                            <div class="col-6">
                                <div class="col-12 row">
                                    <div class="col-lg-4 form-group">
                                        <label class="col-form-label">No SK Penetapan </label>
                                    </div>
                                    <div class="col-lg-8 form-group">
                                        <input disabled="disabled" type="text" class="form-control border-right-0"
                                            placeholder="{{ $penomoran['pe_no_sk'] }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 row">
                                    <div class="col-lg-4 form-group">
                                        <label class="col-form-label">Tanggal Penetapan </label>
                                    </div>
                                    <div class="col-lg-8 form-group">
                                        <input disabled="disabled" type="text" class="form-control border-right-0"
                                            placeholder="{{ $date_reformat->date_lang_reformat_long($penomoran['pe_date_sk']) }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 row">
                                    <div class="col-lg-4 form-group">
                                        <label class="col-form-label">SK Penetapan Penomoran </label>
                                    </div>
                                    <div class="col-lg-8 form-group">
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ $file_sk[3] }}">
                                            <span class="input-group-append">
                                                <a target="_blank" href="{{ asset($penomoran['pe_dok_sk']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-lg-4 col-form-label" id="lbl_kdakses">Kode Akses dalam
                                            Data Penetapan</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-8" id="PilihKodeWilayah">
                                            <table class="table table-custom table-sm">

                                                <tbody id="bloknomor-lists">
                                                    {{-- @for ($i = 0; $i < 1; $i++) --}}
                                                    <tr class="kodeakses_hapus-item">
                                                        <td style="width: 38%;">
                                                            {{-- <input type="hidden"
                                                                    name="kodeakses_hapus[{{ $i }}][kode_akses]"
                                                                    value={{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}>
                                                                <input type="hidden"
                                                                    name="kodeakses_hapus[{{ $i }}][status_pe_sk]"
                                                                    value="2"> --}}
                                                            <input disabled type="text"
                                                                class="form-control pilih-bloknomor" {{-- name="kodeakses_hapus[{{ $i }}][kode_akses]" --}}
                                                                placeholder="{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}"
                                                                value={{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }} />
                                                        </td>
                                                        <td style="width: 60%;">
                                                            <select {{-- name="kodeakses_hapus[{{ $i }}][status_pe_sk]" --}}
                                                                class="form-control pilih-status_pe_sk" disabled>
                                                                <option value="1">Penetapan Ulang</option>
                                                                <option value="2" selected>Pencabutan</option>
                                                            </select>
                                                        </td>
                                                        {{-- <td style="width: 2%;">
                                                                <button type="button"
                                                                    class="btn btn-success add-kodeakses"
                                                                    id="add-kodeakses"><i class="icon-plus3"></i></button>
                                                            </td> --}}
                                                    </tr>
                                                    @if (isset($vw_kodeakses_additional))
                                                        @foreach ($vw_kodeakses_additional as $item => $d)
                                                            <tr class="kodeakses_hapus-item">
                                                                <td style="width: 38%;">
                                                                    <input disabled type="text"
                                                                        class="form-control pilih-bloknomor"
                                                                        {{-- name="kodeakses_hapus[{{ $i }}][kode_akses]" --}}
                                                                        placeholder="{{ isset($d['kode_akses']) ? $d['kode_akses'] : '' }}"
                                                                        value={{ isset($d['kode_akses']) ? $d['kode_akses'] : '' }} />
                                                                </td>
                                                                <td style="width: 60%;">
                                                                    <select {{-- name="kodeakses_hapus[{{ $i }}][status_pe_sk]" --}}
                                                                        class="form-control pilih-status_pe_sk" disabled>
                                                                        <option value="1"
                                                                            @if ($d['status_permohonan'] == '302') selected @endif>
                                                                            Penetapan Ulang</option>
                                                                        <option value="2"
                                                                            @if ($d['status_permohonan'] == '301') selected @endif>
                                                                            Pencabutan</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    {{-- @endfor --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-lg-6 col-form-label">Alasan Pengembalian </label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea disabled="disabled" rows="4" cols="3" class="form-control" id="ReasonRemoval_SK"
                                            placeholder="{{ $penomoran['note'] }}" name="ReasonRemoval_SK" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <legend class="text-uppercase font-size-sm font-weight-bold">Proses Evaluasi</legend>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="row">
                                <label class="col-lg-2 col-form-label">Evaluator</label>
                                <div class="col-lg-4">
                                    {{-- <label class="col-lg col-form-label">:
                                        {!! isset($penomoran['evaluator_name']) ? $penomoran['evaluator_name'] : '' !!}</label> --}}
                                    <input type="text" class="form-control"
                                        value="{{ isset($penomoran['evaluator_name']) ? $penomoran['evaluator_name'] : '' }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($penomoran['jenis_permohonan'] == 'Penetapan Nomor Tambahan')
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <?php
                                $path_bkpm = explode('/', $penomoran['path_dok_evaluasi_tambahan']);
                                ?>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label for="berkas_tambahan">Berkas Hasil Evaluasi Permohonan Nomor
                                            Tambahan</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ $path_bkpm[2] }}">
                                            <span class="input-group-append">
                                                <a target="_blank"
                                                    href="{{ asset($penomoran['path_dok_evaluasi_tambahan']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                            </span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Status Hasil Evaluasi</label>
                                <div class="col-lg-4">
                                    <select name="status_sk" id="status_sk" data-placeholder="Silakan Pilih"
                                        class="form-control">
                                        <option selected disabled>-- Pilih Hasil Evaluasi --</option>
                                        <option value='1'>Disetujui</option>
                                        <option value='0'>Ditolak</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12" style="margin-top: 20px;">
                            <fieldset>
                                <textarea rows="3" cols="3" class="form-control" id="catatan_hasil_evaluasi"
                                    placeholder="Catatan Hasil Evaluasi" name="catatan_hasil_evaluasi"></textarea>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Riwayat Permohonan</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts/backend/historyperizinan/historypenomoran', [
                        'history_penomoran' => $penomoranlog,
                    ])
                </div>
            </div>

            <div class="text-right">
                <a type="button" href="{{ route('admin.koordinator') }}"
                    class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i> Kembali </a>

                {{-- <!-- <a target="_blank" href="{{ route('admin.historyperizinan', $penomoran['id_izin']) }}" class="btn btn-info">Riwayat Permohonan </a> --> --}}
                {{-- <a href="{{ route('admin.sk.draftpenomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}"
                    target="_blank" class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a> --}}


                <!-- <button type="submit" onclick="return false;" data-toggle="modal" data-target="#penolakanModal" class="btn btn-danger">Tolak Permohonan <i class="icon-cross2 ml-2"></i></button> -->
                <button type="button" id="btnSubmitModal" data-target="#submitModal" data-toggle="modal"
                    class="btn btn-indigo">Kirim Evaluasi <i class="icon-checkmark ml-2"></i></button>
                <button type="button" id="btnSubmitModalKoreksi" data-toggle="modal" data-target="#submitModalKoreksi"
                    class="btn btn-warning">Kirim Evaluasi Perbaikan <i class="icon-paperplane ml-2"></i></button>
            </div>
        </div>

    </form>

    <form method="post" id="formPenolakan" action="{{ route('admin.koordinator.evaluasipenomoran.penolakan', $id) }}">
        <!-- Form penolakan -->
        @csrf
        <input type="hidden" name="is_penolakan" value="1">
        <input type="hidden" id="catatan_evaluasi_penolakan" name="catatan_hasil_evaluasi">

    </form>
    <input type="hidden" id="id_izin" name="id_izin" value="{{ $id }}">

    <div class="modal" id="submitModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setujui Permohonan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menyetujui permohonan penomoran ini ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnSubmit" onclick="submitevaluasi();return false;"
                        class="btn btn-primary notif-button">Kirim</button>
                    <div class="spinner-border loading text-primary" role="status" hidden>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="submitModalKoreksi" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Evaluasi Perbaikan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-warning">Apakah anda yakin akan mengirim perbaikan evaluasi ini ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="submitdisposisi();return false;"
                        class="btn btn-primary">Kirim</button>
                    <div class="spinner-border loading text-primary" role="status" hidden>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="penolakanModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Persyaratan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menolak permohonan izin ini ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="submitpenolakan();return false;"
                        class="btn btn-primary notif-button">Kirim</button>
                    <div class="spinner-border loading text-primary" role="status" hidden>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="detailLog" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Riwayat Pemohonan</h5>
                    <hr />
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-log">
                    <?php
                    
                    ?>
                </div>

            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#btnSubmitModalKoreksi").hide();
            $("#btnSubmitModal").show();

            $('#formEvaluasi').on('change', ':checkbox', function() {

                // CekChek();
                var id = $(this).attr('data');

                if ($(this).is(':checked')) {
                    $("#label" + id).html("Tidak Sesuai")
                    $("#catatan_dokumen_" + id).attr("readonly", false);
                    $("#catatan_dokumen_" + id).focus();
                } else {
                    $("#label" + id).html("Sesuai")
                    $("#catatan_dokumen_" + id).attr("readonly", true);
                    $("#catatan_dokumen_" + id).val("");
                    setValue();
                }
            });
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function submitevaluasi() {
            if ($('#status_sk').val() == 0 && $('#catatan_hasil_evaluasi').val() == '') {
                $('#submitModal').modal('toggle');
                alert('Silakan mengisi catatan hasil evaluasi');
            } else {
                $('.notif-button').attr("hidden", true);
                $('.loading').attr("hidden", false);
                $('#formEvaluasi').submit();
                $("#btnSubmit").attr("disabled", true);
                $("#btnSubmitKoreksi").attr("disabled", true);
            }

        }

        function submitpenolakan() {
            $('.notif-button').attr("hidden", true);
            $('.loading').attr("hidden", false);
            $('#catatan_evaluasi_penolakan').val($('#catatan_hasil_evaluasi').val());
            $('#formPenolakan').submit();
        }

        function logPermohonan() {
            var innerhtml = '';
            var id_izin = $('#id_izin').val();
            $.ajax({
                /* the route pointing to the post function */
                url: ' {{ route('admin.koordinator.getlogizin') }} ',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    id_izin: id_izin
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function(data) {
                    if (data == 'is_empty') {
                        innerhtml += "<p>Belum ada Riwayat</p>";
                        $('#modal-body-log').html(innerhtml)
                        $('#detailLog').modal('show');
                    } else {
                        innerhtml += '<div class="timeline timeline-left" >';
                        innerhtml += '<div class="timeline-container" >';
                        $.each(data, function(index, value) {
                            innerhtml += '<div class="timeline-row" >';
                            innerhtml +=
                                '<div class="timeline-icon" style="text-align:center;padding-top:7px;">' +
                                (index + 1) + '</div>';
                            innerhtml += '<div class="card"><div class="card-body">' + value
                                .created_at + '</div></div>';
                            innerhtml += '<div class="card"><div class="card-body">Status : ' + value
                                .status_checklist + '</div></div>';
                            innerhtml += '</div>';
                        })
                        innerhtml += '</div>';
                        innerhtml += '</div>';


                        $('#modal-body-log').html(innerhtml)
                        $('#detailLog').modal('show');
                    };
                }
            });
        }
    </script>
@endpush
