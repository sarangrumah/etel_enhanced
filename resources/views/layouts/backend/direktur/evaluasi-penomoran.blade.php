@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
<div id="loadingSpinner" class="loading-spinner" style="display: none;">
    <img id="spinnerImage" src="/assets/kominfo/spinner-kominfo-trp.svg" alt="Loading Spinner">
</div>
<style>
    .loading-select {
        position: absolute;
        right: -75px;
        bottom: -60%;
        transform: translateY(-50%);
    }

    .loading-spinner {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        /* Semi-transparent white background */
        z-index: 9999;
        /* Ensures the spinner is on top of other content */
        justify-content: center;
        align-items: center;
        display: flex;
    }
</style>
    <form method="post" id="formEvaluasi"
        action="{{ route('admin.evaluator.evaluasi-penomoran-post', [$id, $penomoran['id_kode_akses']]) }}"
        enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <!-- Section Detail Permohonan -->


            <!-- Section Detail Perusahaan -->
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
                                        {{-- <div class="row">
                                            <label class="col-lg-4 col-form-label">NIB </label>
                                            <div class="col-lg">
                                                <label class="col-lg col-form-label">: {{ $detailnib['nib'] }}</label>
                                                <input type="text" class="form-control" value="{{ $detailnib['nib'] }}"
                                                    disabled>
                                            </div>
                                            <div class="col-lg">
                                                <input type="text" class="form-control border-right-0"
                                            value="{{ $detailnib->path_berkas_nib }}" placeholder="Dokumen NIB" disabled>
                                                <span>
                                                    <a target="_blank" href="{{ asset($detailnib->path_berkas_nib) }}"
                                                        class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                </span>
                                            </div>
                                        </div> --}}
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

            <input type="hidden" name="id_izin" value="{{ $penomoran['id_izin'] }}">
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
                                <label class="col-lg-4 col-form-label">Jenis Penomoran</label>
                                <div class="col-lg-8">
                                    {{-- <label class="col-lg col-form-label">:
                                        {!! isset($penomoran['kode_akses']['jeniskodeakses']['full_name_html'])
                                            ? $penomoran['kode_akses']['jeniskodeakses']['full_name_html']
                                            : '' !!}</label> --}}
                                    <input type="text" class="form-control"
                                        value="{{ isset($penomoran['kode_akses']['jeniskodeakses']['full_name'])
                                            ? $penomoran['kode_akses']['jeniskodeakses']['full_name']
                                            : '' }}"
                                        disabled>
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
                                                                    data-placeholder="Silakan Pilih" required>
                                                                    <option value="" selected>Pilih Evaluasi</option>
                                                                    <option value="1">Setuju</option>
                                                                    <option value="2">Ditolak</option>
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
                                    <label class="col-lg-4 col-form-label">Kode Akses </label>
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

                    {{-- <hr /> --}}

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

                        @if (strtolower($penomoran['kd_izin']) == '059000000033')
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
                                            <p class="font-weight-semibold">Penjelasan Singkat (Produk brief) Layanan
                                                Baru
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

                        @if (strtolower($penomoran['kd_izin']) == '059000000052')
                            <div class="form-group row">
                                <?php
                                if (isset($penomoran['dok_call_center'])) {
                                    $_file3 = explode('/', $penomoran['dok_call_center']);
                                    $file3 = $_file3[3];
                                } else {
                                    $file3 = '';
                                }
                                
                                $file3 = $file3;
                                
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
                    @elseif($penomoran['jenis_permohonan'] == 'Perubahan Penetapan')
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Kelengkapan</legend>
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
                                                @for ($i = 0; $i < 1; $i++)
                                                    <tr class="kodeakses_hapus-item">
                                                        <td style="width: 38%;">
                                                            <input type="hidden"
                                                                name="kodeakses_hapus[{{ $i }}][kode_akses]"
                                                                value={{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}>
                                                            <input type="hidden"
                                                                name="kodeakses_hapus[{{ $i }}][status_pe_sk]"
                                                                value="2">
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
                                                        <td style="width: 2%;">
                                                            <button type="button" class="btn btn-success add-kodeakses"
                                                                id="add-kodeakses"><i class="icon-plus3"></i></button>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
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
                                            @for ($i = 0; $i < 1; $i++)
                                                <tr class="kodeakses_hapus-item">
                                                    <td style="width: 38%;">
                                                        <input type="hidden"
                                                            name="kodeakses_hapus[{{ $i }}][kode_akses]"
                                                            value={{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}>
                                                        <input type="hidden"
                                                            name="kodeakses_hapus[{{ $i }}][status_pe_sk]"
                                                            value="2">
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
                                                    <td style="width: 2%;">
                                                        <button type="button" class="btn btn-success add-kodeakses"
                                                            id="add-kodeakses"><i class="icon-plus3"></i></button>
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">SK Perizinan Berusaha</p>
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
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Dokumen Pendukung Perubahan Penetapan Penomoran</p>
                                        <div class="input-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ isset($penomoran['pe_dok_pendukung']) ? $penomoran['pe_dok_pendukung'] : '' }}">
                                            <span class="input-group-append">
                                                <a target="_blank" href="{{ asset($penomoran['pe_dok_pendukung']) }}"
                                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                            </span>
                                        </div>
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
                                                    @for ($i = 0; $i < 1; $i++)
                                                        <tr class="kodeakses_hapus-item">
                                                            <td style="width: 38%;">
                                                                <input type="hidden"
                                                                    name="kodeakses_hapus[{{ $i }}][kode_akses]"
                                                                    value={{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}>
                                                                <input type="hidden"
                                                                    name="kodeakses_hapus[{{ $i }}][status_pe_sk]"
                                                                    value="2">
                                                                <input disabled type="text"
                                                                    class="form-control pilih-bloknomor"
                                                                    {{-- name="kodeakses_hapus[{{ $i }}][kode_akses]" --}}
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
                                                            <td style="width: 2%;">
                                                                <button type="button"
                                                                    class="btn btn-success add-kodeakses"
                                                                    id="add-kodeakses"><i class="icon-plus3"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endfor
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
                                <div class="col-lg-8">
                                    {{-- <label class="col-lg col-form-label">:
                                        {!! isset($penomoran['evaluator_name']) ? $penomoran['evaluator_name'] : '' !!}</label> --}}
                                    <input type="text" class="form-control" value="{!! isset($penomoran['evaluator_name']) ? $penomoran['evaluator_name'] : '' !!}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($penomoran['jenis_permohonan'] == 'Penetapan Nomor Tambahan')
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label" for="berkas_tambahan">Berita Acara
                                        Pemeriksaan Nomor Eksisting</label>
                                    <div class="col-lg-8">
                                        <input type="file" class="form-control" name="berkas_tambahan"
                                            id="berkas_tambahan" accept="application/pdf">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">

                        <div class="col-lg-12">
                            <div class="row">
                                <label class="col-lg-2 col-form-label">Hasil Evaluasi</label>
                                <div class="col-lg-8">
                                    <select name="status_sk" id="status_sk" data-placeholder="Silakan Pilih"
                                        class="form-control" required>
                                        <option value="" selected disabled>-- Silakan Pilih --</option>
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


            <div class="form-group text-right">
                <a href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i
                        class="icon-backward2 ml-2"></i> Kembali </a>
                <a href="{{ route('admin.sk.draftpenomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}"
                    target="_blank" class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a>
                <!-- <a target="_blank" href="{{ route('admin.historyperizinan', $penomoran['id_izin']) }}" class="btn btn-info">Riwayat Permohonan </a> -->
                <button type="button" id="" data-target="#submitModal" data-toggle="modal"
                    class="btn btn-indigo">Kirim
                    Evaluasi <i class="icon-paperplane ml-2"></i></button>
            </div>
        </div>

        <div class="modal" id="submitModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kirim Evaluasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin akan mengirim evaluasi ini ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSubmit" onclick="submitdisposisi();return false;"
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
                        <h5 class="modal-title">Kirim Perbaikan Evaluasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-warning">Apakah anda yakin akan mengirim perbaikan evaluasi ini ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSubmitKoreksi" onclick="submitdisposisiTolak();return false;"
                            class="btn btn-primary notif-button">Kirim</button>
                        <div class="spinner-border loading text-primary" role="status" hidden>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script>
        var loadingSpinner = document.getElementById('loadingSpinner');

        function showLoadingSpinner() {
            // loadingSpinner.style.display = 'block';
            var spinner = document.getElementById('loadingSpinner');
            spinner.style.display = 'flex';
        }
        function submitdisposisi() {
            if ($('#status_sk').val() == 0 && $('#catatan_hasil_evaluasi').val() == '') {
                $('#submitModal').modal('toggle');
                alert('Silakan mengisi catatan hasil evaluasi');
            } else {
                showLoadingSpinner();
                $('#formEvaluasi').submit();
                $('.notif-button').attr("hidden", true);
                $('.loading').attr("hidden", false);
                $('#formEvaluasi').submit();
                $("#btnSubmit").attr("disabled", true);
                $("#btnSubmitKoreksi").attr("disabled", true);
            }
        }

        function submitdisposisiTolak() {
            $('#formEvaluasiTolak').submit();
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#btnSubmitModalKoreksi").hide();
            $("#btnSubmitModal").show();

            $(document).on('click', '.btn-delete-kodeakses', function(e) {
                e.preventDefault();
                let row_item = $(this).parent().parent();
                $(row_item).remove();
            })
            $(".add-kodeakses").click(function(e) {
                e.preventDefault();
                // alert("Tambah");

                start = 0;
                totalBlokNomor = 0;
                options = ``;
                options += `<option value="1">Penetapan Ulang</option>`;
                options += `<option value="2">Pencabutan</option>`;


                // initSelect2();

                // function initSelect2() {
                //     $('.pilih-kodewilayah').each(function(index, element) {
                //         $(this).select2({
                //             placeholder: "Pilih Kode Wilayah"
                //         })
                //     })
                // }

                function countTotalKodeAkses() {
                    return document.querySelectorAll('.kodeakses_hapus-item').length;
                }

                this.totalKodeAkses = countTotalKodeAkses();
                const inputRow =
                    `
					<tr class="kodeakses_hapus-item">
						<td>
							<input type="text" class="form-control pilih-bloknomor" name="kodeakses_hapus[` + this
                    .totalKodeAkses + `][kode_akses]" />
						</td>
                        <td>
							<select
								name="kodeakses_hapus[` + this.totalKodeAkses + `][status_pe_sk]"
								class="form-control pilih-status_pe_sk"
							>` + options + ` </select>
						</td>
						
						<td>
							<button
								class="btn btn-danger btn-samll btn-delete-kodeakses" id="btn-delete-kodeakses"
								type="button"
							>&times;</button>
						</td>
					<tr>
				`;
                $('#bloknomor-lists').append(inputRow);
                initSelect2();
            })

            function CekChek() {
                let yourArray = []
                $("input:checkbox[class=custom-control-input]:checked").each(function() {
                    yourArray.push($(this).val());
                });
                // console.log(yourArray)
                if (yourArray.length > 1) {
                    $("#btnSubmitModalKoreksi").show();
                    $("#btnSubmitModal").hide();

                    // $("#submitModalKoreksi").modal("show");
                } else {

                    $("#btnSubmitModal").show();
                    $("#btnSubmitModalKoreksi").hide();

                    // $("#submitModal").modal("show");
                }
            }

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

            $('#status_sk').change(function() {
                let status_sk = $('#status_sk').val();
                if (status_sk == 0) {

                } else {

                }
            })
        });
    </script>
@endsection
