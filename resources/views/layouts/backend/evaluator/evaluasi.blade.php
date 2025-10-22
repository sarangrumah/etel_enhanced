@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
    <form method="post" id="formEvaluasi" action="{{ route('admin.evaluator.evaluasipost', $id) }}">
        <div class="form-group">
            <!-- Section Detail Permohonan -->
            <h3>Evaluasi Persyaratan</h3>
            <hr />
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
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $izin['id_izin'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {!! $izin['jenis_layanan_html'] !!}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $izin['tgl_izin'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Status Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $izin['status_bo'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Detail Permohonan -->

            <!-- Section Detail Perusahaan -->
            <div>
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Informasi Perusahaan </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Perusahaan</legend>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NIB </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['nib'] }}</label>
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
                                    <label class="col-lg-4 col-form-label">NPWP </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['npwp_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Telp </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ $detailnib['nomor_telpon_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>
                        <div class="form-group row">
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
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Email </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label>
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
            </div>
            <!-- End Section Detail Perusahaan -->

            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Evaluasi Registrasi Perusahaan/Instansi </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>

                        @csrf
                        <input type="hidden" name="id_izin" value="{{ $izin['id_izin'] }}">
                        <fieldset>
                            <div class="form-group">
                                <div class="col-lg">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="font-weight-semibold">Nomor Izin Berusaha (NIB)</p>
                                            <input type="text" value="{{ $izin['nib'] }}" readonly="readonly"
                                                class="form-control">
                                        </div>
                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" name="is_koreksi_nib" class="custom-control-input"
                                                    id="c_nib">
                                                <label class="custom-control-label" for="c_nib"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" name="catatan_nib" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Dokumen NIB</p>
                                            <div class="input-group">
                                                <input disabled="disabled" type="text"
                                                    class="form-control border-right-0" placeholder="Dokumen NIB">
                                                <span class="input-group-append">
                                                    <button class="btn btn-teal" type="button">Lihat Dokumen</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" name="is_koreksi_dokumen_nib"
                                                    class="custom-control-input" id="c_uploadnib">
                                                <label class="custom-control-label" for="c_uploadnib"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" name="catatan_dokumen_nib" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Nama Perusahaan/Instansi Pemerintah</p>
                                            <input type="text" class="form-control" readonly="readonly" required
                                                placeholder="Nama Lengkap Perusahaan"
                                                value="{{ $detailnib['nama_perseroan'] }}">
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <!-- <input type="checkbox" class="custom-control-input" id="c_namaperusahaan" checked> -->
                                                <input type="checkbox" name="is_koreksi_instansi"
                                                    class="custom-control-input" id="c_namaperusahaan">
                                                <label class="custom-control-label" for="c_namaperusahaan"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_instansi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Jenis Perusahaan/Instansi Pemerintah</p>
                                            <input type="text" class="form-control" required
                                                placeholder="Nama Lengkap Perusahaan"
                                                value="{{ $detailnib['jenis_perseroan'] }}">
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="c_jenisperusahaan" name="is_koreksi_jenis_instansi">
                                                <label class="custom-control-label" for="c_jenisperusahaan"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_jenis_instansi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Alamat</p>
                                                            <input type="text" class="form-control"
                                                                value="{{ $detailnib['alamat_perseroan'] }}"
                                                                readonly="readonly">
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Provinsi</p>
                                                            <input type="text" class="form-control"
                                                                value="{{ $detailnib['provinsi_name'] }}"
                                                                readonly="readonly">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Kota/Kabupaten</p>
                                                            <div class="col-6">
                                                                <p class="font-weight-semibold">Provinsi</p>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $detailnib['kabupaten_name'] }}"
                                                                    readonly="readonly">

                                                            </div>

                                                        </div>
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Kecamatan</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Kelurahan/Desa</p>
                                                            <input type="text" class="form-control"
                                                                value="{{ $detailnib['kelurahan_perseroan'] }}"
                                                                readonly="readonly">
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Kode Pos</p>
                                                            <input type="text" class="form-control"
                                                                value="{{ $detailnib['kode_pos_perseroan'] }}"
                                                                readonly="readonly">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer d-flex justify-content-between">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div
                                                            class="custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="c_alamatperusahaan" name="is_koreksi_alamat_instansi">
                                                            <label class="custom-control-label"
                                                                for="c_alamatperusahaan">Sesuai</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control"
                                                            name="catatan_alamat_instansi">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">No Telepon Perusahaan/Instansi Pemerintah</p>
                                            <input type="text" class="form-control">
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_telpperusahaan"
                                                    name="is_koreksi_notelp_instansi">
                                                <label class="custom-control-label" for="c_telpperusahaan"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_notelp_instansi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Nomor NPWP Perusahaan/Instansi Pemerintah</p>
                                            <input type="text" class="form-control">
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_npwp"
                                                    name="is_koreksi_npwp_instansi">
                                                <label class="custom-control-label" for="c_npwp"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_npwp_instansi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Dokumen NPWP</p>
                                            <div class="input-group">
                                                <input type="text" class="form-control border-right-0"
                                                    placeholder="Dokumen NPWP">
                                                <span class="input-group-append">
                                                    <button class="btn btn-teal" type="button">Lihat Dokumen</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_uploadnpwp"
                                                    name="is_koreksi_dokumen_npwp">
                                                <label class="custom-control-label" for="c_uploadnpwp"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_dokumen_npwp">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Akta Terakhir Perusahaan/Instansi Pemerintah
                                            </p>
                                            <input type="text" class="form-control">
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_aktaperusahaan"
                                                    name="is_koreksi_akta_instansi">
                                                <label class="custom-control-label" for="c_aktaperusahaan"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_akta_instansi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Dokumen SK Kemenkumham</p>
                                            <div class="input-group">
                                                <input type="text" class="form-control border-right-0"
                                                    placeholder="Dokumen SK Kemenkumham">
                                                <span class="input-group-append">
                                                    <button class="btn btn-teal" type="button">Lihat Dokumen</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_uploadsk"
                                                    name="is_koreksi_dokumen_sk_kemenkumham">
                                                <label class="custom-control-label" for="c_uploadsk"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control"
                                                name="catatan_dokumen_sk_kemenkumham">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>


                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Evaluasi Registrasi Penanggung Jawab </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>

                        <fieldset>
                            <div class="form-group">
                                <div class="col-lg">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="font-weight-semibold">Nama Penanggung Jawab</p>
                                            <input type="text" class="form-control" required
                                                placeholder="Nama Lengkap">
                                        </div>
                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_namapj"
                                                    name="is_koreksi_nama_penanggungjawab">
                                                <label class="custom-control-label" for="c_namapj"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control"
                                                name="catatan_nama_penanggungjawab">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">E-Mail Penanggung Jawab</p>
                                            <input type="text" class="form-control" required placeholder="E-Mail">
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_emailpj"
                                                    name="is_koreksi_email_penanggungjawab">
                                                <label class="custom-control-label" for="c_emailpj"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control"
                                                name="catatan_email_penanggungjawab">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">No. Telp/Handphone Penanggung Jawab</p>
                                            <input type="text" class="form-control" required
                                                placeholder="No. Telp/Handphone">
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_telppj"
                                                    name="is_koreksi_telp_penanggungjawab">
                                                <label class="custom-control-label" for="c_telppj"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control"
                                                name="catatan_telp_penanggungjawab">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Dokumen Surat Tugas</p>
                                            <div class="input-group">
                                                <input type="text" class="form-control border-right-0"
                                                    placeholder="Dokumen Surat Tugas">
                                                <span class="input-group-append">
                                                    <button class="btn btn-teal" type="button">Lihat Dokumen</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_surattugas"
                                                    name="is_koreksi_dokumen_surattugas">
                                                <label class="custom-control-label" for="c_surattugas"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_dokumen_surattugas">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Alamat</p>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Provinsi</p>
                                                            <select data-placeholder="Select your state"
                                                                class="form-control form-control-select2" data-fouc>
                                                                <option></option>
                                                                <option value="AK">Alaska</option>
                                                                <option value="HI">Hawaii</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Kota/Kabupaten</p>
                                                            <select data-placeholder="Select your state"
                                                                class="form-control form-control-select2" data-fouc>
                                                                <option></option>
                                                                <option value="AK">Alaska</option>
                                                                <option value="HI">Hawaii</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Kecamatan</p>
                                                            <select data-placeholder="Select your state"
                                                                class="form-control form-control-select2" data-fouc>
                                                                <option></option>
                                                                <option value="AK">Alaska</option>
                                                                <option value="HI">Hawaii</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Kelurahan/Desa</p>
                                                            <select data-placeholder="Select your state"
                                                                class="form-control form-control-select2" data-fouc>
                                                                <option></option>
                                                                <option value="AK">Alaska</option>
                                                                <option value="HI">Hawaii</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="font-weight-semibold">Kode Pos</p>
                                                            <select data-placeholder="Select your state"
                                                                class="form-control form-control-select2" data-fouc>
                                                                <option></option>
                                                                <option value="AK">Alaska</option>
                                                                <option value="HI">Hawaii</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer d-flex justify-content-between">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div
                                                            class="custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="c_alamatpj" name="is_koreksi_alamat_penanggungjawab">
                                                            <label class="custom-control-label"
                                                                for="c_alamatpj">Sesuai</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control"
                                                            name="catatan_alamat_penanggungjawab">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Nomor KTP/Paspor Penanggung Jawab</p>
                                            <input type="text" class="form-control">
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_ktppj"
                                                    name="is_koreksi_no_ktp">
                                                <label class="custom-control-label" for="c_ktppj"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_no_ktp">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Dokumen KTP Penanggung Jawab</p>
                                            <div class="input-group">
                                                <input type="text" class="form-control border-right-0"
                                                    placeholder="Dokumen KTP Penanggung Jawab">
                                                <span class="input-group-append">
                                                    <button class="btn btn-teal" type="button">Lihat Dokumen</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_uploadktp"
                                                    name="is_koreksi_dokumen_ktp">
                                                <label class="custom-control-label" for="c_uploadktp"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_dokumen_ktp">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Jabatan</p>
                                            <input type="text" class="form-control" required placeholder="Jabatan">
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_jabatanpj"
                                                    name="is_koreksi_jabatan">
                                                <label class="custom-control-label" for="c_jabatanpj"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_jabatan">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Kartu Pegawai/Surat Keterangan Bekerja</p>
                                            <div class="input-group">
                                                <input type="text" class="form-control border-right-0"
                                                    placeholder="Kartu Pegawai/Surat Keterangan Bekerja">
                                                <span class="input-group-append">
                                                    <button class="btn btn-teal" type="button">Lihat Dokumen</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-lg-1 text-center">
                                            <p class="font-weight-semibold text-center">Sesuai</p>
                                            <div
                                                class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                                <input type="checkbox" class="custom-control-input" id="c_surattugaspj"
                                                    name="is_koreksi_kartu_pegawai">
                                                <label class="custom-control-label" for="c_surattugaspj"></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <p class="font-weight-semibold">Catatan</p>
                                            <input type="text" class="form-control" name="catatan_kartu_pegawai">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Catatan Hasil Evaluasi </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <fieldset>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Disposisi ke : </label>
                                    <div class="col-lg">
                                        <select name="id_user_disposisi" data-placeholder="Silakan Pilih"
                                            class="form-control form-control-select2" data-fouc>
                                            <option>-- Silakan Pilih --</option>
                                            @if (count($user) > 0)
                                                @foreach ($user as $users)
                                                    <option value="{{ $users['id'] }}">{{ $users['nama'] }} |
                                                        {{ $users['short_desc'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <textarea rows="3" cols="3" class="form-control" placeholder="Hasil Evaluasi"
                                    name="catatan_hasil_evaluasi"></textarea>

                            </fieldset>
                        </div>
                    </div>


                </div>
            </div>
            <div class="form-group text-right">
                <a href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i
                        class="icon-backward2 ml-2"></i> Kembali </a>
                <!-- <button type="submit" class="btn btn-primary">Kirim Evaluasi Pendaftaran <i class="icon-paperplane ml-2"></i></button> -->
                <button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModal"
                    class="btn btn-indigo">Kirim Evaluasi Pendaftaran <i class="icon-paperplane ml-2"></i></button>
            </div>
        </div>

        <div class="modal" id="submitModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kirim Disposisi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin akan mengirim disposisi ini ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                        <button type="button" onclick="submitdisposisi();return false;"
                            class="btn btn-primary notif-button">Kirim</button>
                        <div class="spinner-border loading text-primary" role="status" hidden>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
<script>
    $(document).ready(function() {

    })

    function submitdisposisi() {
        $('.notif-button').attr("hidden", true);
        $('.loading').attr("hidden", false);
        $('#formEvaluasi').submit();
    }
</script>
