@extends('layouts.frontend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
    <form>
        <div class="form-group">
            <!-- Section Detail Permohonan -->
            <div>
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Status Tanda Tangan </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Ditandatangani oleh</label>
                                    <div class="col-lg">
                                        @if ($datavalidasi->status_group = '2' || ($datavalidasi->status_group = '3'))
                                            <label class="col-lg col-form-label">: {{ $datavalidasi->direktur }}</label>
                                        @else
                                            <label class="col-lg col-form-label">: -</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Ditandatangani pada </label>
                                    <div class="col-lg">
                                        @if ($datavalidasi->tgl_sk == null)
                                            <label class="col-lg col-form-label">: - </label>
                                        @else
                                            <label class="col-lg col-form-label">:
                                                {{ $date_reformat->dateday_lang_reformat_long($datavalidasi->tgl_sk) }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Status Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $datavalidasi->status_izin }}</label>
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
                                <h6 class="card-title font-weight-semibold py-3">Informasi Dokumen </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Validasi Surat Ketetapan</legend>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg">
                                        @if ($datavalidasi->status_group = '2' || ($datavalidasi->status_group = '3'))
                                            <label class="col-lg col-form-label"> <i class="icon-file-check mr-2"></i>
                                                {{ $datavalidasi->status_pemenuhan }}</label>
                                        @else
                                            <label class="col-lg col-form-label"> <i class="icon-stack-cancel mr-2"></i>
                                                {{ $datavalidasi->status_pemenuhan }}</label>
                                        @endif

                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-lg">
                                        @if ($datavalidasi->status_ulo_vw_checked == 1)
                                            <label class="col-lg col-form-label"><i class="icon-file-check mr-2"></i>
                                                {{ $datavalidasi->status_ulo_vw }}</label>
                                        @else
                                            <label class="col-lg col-form-label"><i class="icon-stack-cancel mr-2"></i>
                                                {{ $datavalidasi->status_ulo_vw }}</label>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-lg">
                                        @if ($datavalidasi->tgl_sk == null)
                                            <label class="col-lg col-form-label"><i class="icon-stack-cancel mr-2"></i>
                                                Sertifikat tidak valid.</label>
                                        @else
                                            <label class="col-lg col-form-label"><i class="icon-file-check mr-2"></i>
                                                Sertifikat valid.</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">

                            </div>
                        </div>
                        <legend class="text-uppercase font-size-sm font-weight-bold">Informasi Permohonan Penyelenggaraan
                            Izin</legend>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No. Permohonan Izin </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($datavalidasi->id_izin) ? $datavalidasi->id_izin : '-' }}
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Nama Badan Hukum / Instansi </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($detailNib['nama_perseroan']) ? $detailNib['nama_perseroan'] : '-' }}
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Pemohon </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">KBLI </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($izin2['kbli']) ? $izin2['kbli'] : '-' }} -
                                            {{ isset($izin2['kbli_name']) ? $izin2['kbli_name'] : '-' }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Layanan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($izin2['jenis_layanan']) ? $izin2['jenis_layanan'] : '-' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Detail Perusahaan -->


            <div class="form-group text-right">
                {{-- <a href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i> Kembali </a> --}}
                <!-- <button type="submit" class="btn btn-primary">Kirim Evaluasi Pendaftaran <i class="icon-paperplane ml-2"></i></button> -->
                {{-- <a target="_blank" href="{{ route('admin.historyperizinan', $izin['id_izin']) }}"
            class="btn btn-info">Riwayat Permohonan <i class="icon-history ml-2"></i></a> --}}
            </div>
        </div>

    </form>
@endsection
