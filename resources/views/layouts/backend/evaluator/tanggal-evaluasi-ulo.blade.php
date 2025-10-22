@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
    <script src="//cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
@endsection
@section('content')
    <div class="form-group">
        <!-- Section Detail Permohonan -->
        <!-- <h3>Evaluasi Uji Laik Operasi</h3>
        <hr/> -->


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
                                    <label class="col-lg col-form-label">: {{ $ulo['id_izin'] }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">: {!! $ulo['jenis_layanan_html'] !!}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                                <div class="col-lg">
                                    @if ($ulo['updated_date'] == null)
                                        <label class="col-lg col-form-label">: - </label>
                                    @else
                                        <label class="col-lg col-form-label">:
                                            {{ $date_reformat->dateday_lang_reformat_long($ulo['updated_date']) }}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Status Permohonan </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">: {{ $ulo['kode_izin']['name_status_bo'] }}</label>
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
                                        {{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }} </label>
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
                        <h6 class="card-title font-weight-semibold py-3">Perubahan Tanggal Ulo</h6>
                    </div>
                </div>
            </div>
            <form method="post" id="hasil_evaluasi" action="{{ route('admin.evaluator.tglevaluasiulopost', [$id,$ulo['id']]) }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_izin" value="{{ $izin['id_izin'] }}">
                <input type="hidden" name="status_hasil_evaluasi"
                    value="{{ isset($ulo['status_hasil_evaluasi']) ? null : 1 }}">
                <div class="card-body">
                    {{-- <div class="form-group">
					<label for="AlamatPelaksanaanUlo">Alamat Pelaksanaan ULO</label>
					<textarea class="form-control" disabled name="AlamatPelaksanaanUlo" id="AlamatPelaksanaanUlo" rows="3" {{ $ulo['status_hasil_evaluasi'] == 1 ? 'disabled' : ''; }} required>{{ isset($ulo['alamat_pelaksanaan_ulo']) ? $ulo['alamat_pelaksanaan_ulo'] : ''; }}</textarea>
				</div> --}}
                    <div class="form-group">
                        <label for="TanggalEvaluasiPelaksanaanUlo">Tanggal Pelaksanaan ULO </label>
                        <input readonly type="text" class="form-control" name="TanggalEvaluasiPelaksanaanUlo"
                            id="TanggalEvaluasiPelaksanaanUlo" placeholder="dd-mm-yyyy"
                            value="{{ isset($ulo['tanggal_evaluasi_pelaksanaan_ulo']) ? date('d-m-Y', strtotime($ulo['tanggal_evaluasi_pelaksanaan_ulo'])) : '' }}"
                            required>
                    </div>

                </div>
            </form>
        </div>

        <div class="form-group text-right">
            <a href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i
                    class="icon-backward2 ml-2"></i> Kembali </a>
            <a target="_blank" href="{{ route('admin.historyperizinan', $ulo['id_izin']) }}"
                class="btn btn-info">Riwayat Permohonan <i class="icon-history ml-2"></i></a>
            @if (isset($ulo['status_hasil_evaluasi']))
                <a href="{{ route('admin.sk.draft',  [$ulo['id_izin'],$ulo['id']]) }}" target="_blank" class="btn btn-success">Draf
                    SKLO <i class="icon-file-pdf ml-2"></i></a>
            @endif
            {{-- <button type="button" id="" data-target="#submitModalKoreksi" data-toggle="modal" class="btn btn-warning">Tolak <i class="icon-blocked ml-2"></i></button> --}}
            <button type="button" id="" data-target="#submitModal" data-toggle="modal"
                class="btn btn-indigo">Simpan Perubahan Tanggal <i class="icon-paperplane ml-2"></i></button>
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
                    <p>Apakah anda yakin akan mengirim tanggal perubahan untuk permohonan ULO ini ?</p>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="submitdisposisiTolak();return false;"
                        class="btn btn-primary">Kirim</button>
                    <div class="spinner-border loading text-primary" role="status" hidden>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        function submitdisposisi() {
            $('.notif-button').attr("hidden", true);
            $('.loading').attr("hidden", false);
            $('#hasil_evaluasi').submit();
            $("#btnSubmit").attr("disabled", true);
        }

        function submitdisposisiTolak() {
            $('.notif-button').attr("hidden", true);
            $('.loading').attr("hidden", false);
            $('#formEvaluasiTolak').submit();
            $("#btnSubmitKoreksi").attr("disabled", true);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            CKEDITOR.replace('alamatPusatLayananPelangan');
            CKEDITOR.replace('AlamatPelaksanaanUlo');

            $('#TanggalEvaluasiPelaksanaanUlo').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy'
            });
            $('#TanggalSuratPerintahTugas').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy'
            });

            $("#btnSubmitModalKoreksi").hide();
            $("#btnSubmitModal").show();



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


            $('#c_upload_surat_permohonan').on('change', function() {
                CekChek();
                // var id=$(this).attr('data');
                if ($(this).is(':checked')) {
                    // console.log(id + ' is now checked');
                    $("#label1").html("Tidak Sesuai")
                    $("#catatan_surat_permohonan").attr("readonly", false);
                    $("#catatan_surat_permohonan").focus();

                } else {
                    $("#label1").html("Sesuai")
                    $("#catatan_surat_permohonan").attr("readonly", true);
                }
            });
            $('#c_upload_surat_tugas').on('change', function() {
                CekChek();
                // var id=$(this).attr('data');
                if ($(this).is(':checked')) {
                    // console.log(id + ' is now checked');
                    $("#label2").html("Tidak Sesuai")
                    $("#catatan_surat_tugas").attr("readonly", false);
                    $("#catatan_surat_tugas").focus();

                } else {
                    $("#label1").html("Sesuai")
                    $("#catatan_surat_tugas").attr("readonly", true);
                }
            });
            $('#c_upload_hasil_pengujian').on('change', function() {
                CekChek();
                // var id=$(this).attr('data');
                if ($(this).is(':checked')) {
                    // console.log(id + ' is now checked');
                    $("#label3").html("Tidak Sesuai")
                    $("#catatan_hasil_pengujian").attr("readonly", false);
                    $("#catatan_hasil_pengujian").focus();

                } else {
                    $("#label1").html("Sesuai")
                    $("#catatan_hasil_pengujian").attr("readonly", true);
                }
            });
        });
    </script>
@endsection
