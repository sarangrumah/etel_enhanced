@extends('layouts.backend.main')
@section('js')

<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>

@endsection
@section('content')
<div class="form-group">

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
                                <label class="col-lg col-form-label">:
                                    {{ $detailnib['nib'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Nama </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ $detailnib['nama_perseroan'] }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">NPWP </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ $detailnib['npwp_perseroan'] }}</label>
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
                                    {{ isset($penanggungjawab['nama_user_proses']) ?
                                    $penanggungjawab['nama_user_proses'] : '-' }}
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
                                    {{ isset($penanggungjawab['email_user_proses']) ?
                                    $penanggungjawab['email_user_proses'] : '-' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">No Telp/Mobile </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] :
                                    '-' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Section Detail Perusahaan -->

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
                                <label class="col-lg col-form-label">:
                                    {{ $penomoran['id_izin'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penomoran['jenis_permohonan']) ? $penomoran['jenis_permohonan'] : '';
                                    }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                            <div class="col-lg">
                                @if($penomoran['updated_date'] == null)
                                <label class="col-lg col-form-label">: - </label>
                                @else
                                <label class="col-lg col-form-label">:
                                    {{ $date_reformat->date_lang_reformat_long($penomoran['updated_date']) }}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Status Permohonan </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penomoran['kode_izin']['name_status_bo']) ?
                                    $penomoran['kode_izin']['name_status_bo'] : ''; }}</label>
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
                    <h6 class="card-title font-weight-semibold py-3">Detil Penomoran </h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <div class="row">
                        <label class="col-lg-4 col-form-label">Jenis Kode Akses</label>
                        <div class="col-lg">
                            <label class="col-lg col-form-label">:
                                {!! isset($penomoran['kode_akses']['jeniskodeakses']['full_name_html']) ?
                                $penomoran['kode_akses']['jeniskodeakses']['full_name_html'] : ''; !!}</label>
                        </div>
                    </div>
                </div>
                {{-- <blade
                    if|(isset(penomoran%5B%26%2339%3Bkode_akses%26%2339%3B%5D%5B%26%2339%3Bkode_akses%26%2339%3B%5D))%0D>
                    --}}
                    @if(isset($penomoran['kode_akses']['kode_akses']))
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Kode Akses </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penomoran['kode_akses']['kode_akses']) ?
                                    $penomoran['kode_akses']['kode_akses'] : ''; }}</label>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Prefix </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penomoran['kode_akses']['prefix']) ? $penomoran['kode_akses']['prefix'] :
                                    ''; }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Kode Wilayah </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penomoran['kode_akses']['kode_wilayah']) ?
                                    $penomoran['kode_akses']['kode_wilayah'] : ''; }}</label>
                            </div>
                        </div>
                    </div>
                    @endif
            </div>
            <!-- <hr/> -->
            {{-- <blade
                if|(strtolower(%24penomoran%5B%26%2339%3Bjenis_permohonan%26%2339%3B%5D)%20%3D%3D%20%26%2339%3Bpermohonan%20penambahan%26%2339%3B)%0D>
                --}}
                @if(strtolower($penomoran['jenis_permohonan']) == 'permohonan penambahan')
                <div class="form-group ">
                    <?php
                        $file = explode("/",$penomoran['dok_pengguna_penomoran']);
                    ?>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-6">
                                <p class="font-weight-semibold">Laporan Penggunaan Penomoran</p>
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control border-right-0"
                                        placeholder="{{ $file[3] }}">
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($penomoran['dok_pengguna_penomoran']) }}"
                                            class="btn btn-teal" type="button">Lihat Dokumen</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(strtolower($penomoran['jenis_layanan']) == 'sertifikat penyelenggaraan jasa konten sms premium')

                <div
                    class="form-group <?= strtolower($penomoran['jenis_layanan']) == 'sertifikat penyelenggaraan jasa konten sms premium' ? 'd-blok' : 'd-none' ?>">
                    <?php
				if (isset($penomoran['dok_kode_akses_konten'])) {
					$_file2 = explode("/",$penomoran['dok_kode_akses_konten']);
					$file2 = $_file2[3];
				} else {
					$file2 = "";
				}
				
				$file2 = $file2;
			?>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-6">
                                <p class="font-weight-semibold">Produk brief baru untuk pengajuan kode akses konten
                                </p>
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control border-right-0"
                                        placeholder="{{ $file2 }}">
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($penomoran['dok_kode_akses_konten']) }}"
                                            class="btn btn-teal" type="button">Lihat Dokumen</a>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endif

                @if(strtolower($penomoran['jenis_layanan']) == 'izin penyelenggaraan jasa pusat panggilan informasi
                (call center)')
                <div class="form-group">
                    <?php
				if (isset($penomoran['dok_call_center'])) {
					$_file3 = explode("/",$penomoran['dok_call_center']);
					$file3 = $_file3[3];
				} else {
					$file3 = "";
				}
				
				$file3 = $file3;
			?>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-6">
                                <p class="font-weight-semibold">Surat dukungan dari calon pengguna untuk pengajuan
                                    kode akses call center</p>
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control border-right-0"
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
                <hr class="" />
                <div class="form-group ">
                    <div class="col-lg-12">
                        <?php
				$path_bkpm = explode("/",$penomoran['path_dok_evaluasi_tambahan']);
				?>

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
                <hr class="" />
                @elseif(strtolower($penomoran['jenis_permohonan']) == 'permohonan penyesuaian')
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <p class="font-weight-semibold">SK Penetapan Penomoran yang disesuaikan</p>
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control border-right-0"
                                        placeholder="{{ isset($penomoran['pe_dok_sk']) ? $penomoran['pe_dok_sk'] : ''; }}">
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($penomoran['pe_dok_sk']) }}"
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
                            <div class="col-12">
                                <p class="font-weight-semibold">Dokumen Perizinan Terakhir</p>
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control border-right-0"
                                        placeholder="{{ isset($penomoran['pe_dok_perizinan_terakhir']) ? $penomoran['pe_dok_perizinan_terakhir'] : ''; }}">
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($penomoran['pe_dok_perizinan_terakhir']) }}"
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
                            <div class="col-12">
                                <p class="font-weight-semibold">Dokumen Pendukung Lainnya</p>
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control border-right-0"
                                        placeholder="{{ isset($penomoran['pe_dok_pendukung']) ? $penomoran['pe_dok_pendukung'] : ''; }}">
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
                @endif

        </div>
    </div>
    <div class="card">

        <div class="card-body">
            <form method="post" id="formEvaluasi"
                action="{{ route('admin.pencabutanpost',[ $id,$penomoran['id_kode_akses'] ]) }}">
                @csrf
                <input type="hidden" name="id_izin" value="{{ $penomoran['id_izin'] }}">
                <div class="text-right">
                    <button type="button" class="btn btn-secondary border-transparent"><i
                            class="icon-backward2 ml-2"></i> Kembali </button>
                    <button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModal"
                        class="btn btn-indigo">Pencabutan Penomoran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="submitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Persetujuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin akan mencabut Penomoran ini ?</p>
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

@endsection
<script>
    $(document).ready(function () {

    })

    function submitdisposisi() {
        $('.notif-button').attr("hidden", true);
        $('.loading').attr("hidden", false);
        $('#formEvaluasi').submit();
        $("#btnSubmit").attr("disabled", true);
    }

</script>