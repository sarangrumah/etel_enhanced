@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
    <form method="post" id="formEvaluasi"
        action="{{ route('admin.evaluator.evaluasi-penomoran-post', [$id, $penomoran->id_kode_akses]) }}"
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
                                <h6 class="card-title font-weight-semibold py-3">Pencabutan Penetapan Penomoran </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col">
                                <legend class="text-uppercase font-size-sm font-weight-bold">Data Penomoran
                                </legend>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Jenis Penomoran </label>
                                            <div class="input-group col-lg-8">
                                                {{-- <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran_alokasi[''] }}" disabled> --}}
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
                                            <label class="col-lg-4 col-form-label">Kode Akses </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ $detailnib['npwp_perseroan'] }}</label> --}}
                                                {{-- <input type="text" class="form-control"
                                                    value="{{ $detailnib['npwp_perseroan'] }}" disabled> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Status </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                {{ $detailnib['nama_perseroan'] }}</label> --}}
                                                {{-- <input type="text" class="form-control"
                                                    value="{{ $detailnib['nama_perseroan'] }}" disabled> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <legend class="text-uppercase font-size-sm font-weight-bold">Data Penguna Penomoran</legend>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Jenis Pengguna </label>

                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                    {{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}
                                                </label> --}}
                                                {{-- <input type="text" class="form-control"
                                                    value="{{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}"
                                                    disabled> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Nama Pengguna </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                    {{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label> --}}

                                                {{-- <input type="text" class="form-control"
                                                    value="{{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}"
                                                    disabled> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">NIB </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                    {{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
                                                </label> --}}
                                                {{-- <input type="text" class="form-control"
                                                    value="{{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}"
                                                    disabled> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">No Penetapan </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                    {{ $detailnib['nomor_telpon_perseroan'] }}</label> --}}
                                                {{-- <input type="text" class="form-control"
                                                    value="{{ isset($detailnib['nomor_telpon_perseroan']) ? $detailnib['nomor_telpon_perseroan'] : '-' }}"
                                                    disabled> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Tanggal Penetapan </label>
                                            <div class="col-lg">
                                                {{-- <label class="col-lg col-form-label">:
                                                    {{ $detailnib['nomor_telpon_perseroan'] }}</label> --}}
                                                {{-- <input type="text" class="form-control"
                                                    value="{{ isset($detailnib['nomor_telpon_perseroan']) ? $detailnib['nomor_telpon_perseroan'] : '-' }}"
                                                    disabled> --}}
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

            {{-- <input type="hidden" name="id_izin" value="{{ $penomoran['id_izin'] }}"> --}}


            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Kelengkapan </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Dasar Pencabutan</legend>
                    <div class="col-6">
                        <div class="col-lg-12 row">
                            <div class="col-lg-4 form-group">
                                <label class="col-form-label">Dasar Pencabutan </label>
                            </div>
                            <div class="col-lg-8 form-group">
                                {{-- <label class="col-lg col-form-label">:
                                        {!! isset($penomoran['kode_akses']['jeniskodeakses']['full_name_html'])
                                            ? $penomoran['kode_akses']['jeniskodeakses']['full_name_html']
                                            : '' !!}</label> --}}
                                {{-- <input type="text" class="form-control"
                                    value="{{ isset($penomoran['kode_akses']['jeniskodeakses']['full_name'])
                                        ? $penomoran['kode_akses']['jeniskodeakses']['full_name']
                                        : '' }}"
                                    disabled> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-lg-12 row">
                            <div class="col-lg-4 form-group">
                                <label class="col-form-label">Pertimbangan Pencabutan </label>
                            </div>
                            <div class="col-lg-8 form-group">
                                {{-- <label class="col-lg col-form-label">:
                                        {!! isset($penomoran['kode_akses']['jeniskodeakses']['full_name_html'])
                                            ? $penomoran['kode_akses']['jeniskodeakses']['full_name_html']
                                            : '' !!}</label> --}}
                                {{-- <input type="text" class="form-control"
                                    value="{{ isset($penomoran['kode_akses']['jeniskodeakses']['full_name'])
                                        ? $penomoran['kode_akses']['jeniskodeakses']['full_name']
                                        : '' }}"
                                    disabled> --}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="row">
                                <label class="col-lg-2 col-form-label" for="berkas_tambahan">Data Dukung Pencabutan
                                    Penomoran</label>
                                <div class="col-lg-8">
                                    <input type="file" class="form-control" name="berkas_tambahan" id="berkas_tambahan"
                                        accept="application/pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-lg-12 row">
                            <div class="col-lg-4 form-group">
                                <label class="col-form-label">Catatan Pencabutan </label>
                            </div>
                            <div class="col-lg-8 form-group">
                                {{-- <label class="col-lg col-form-label">:
                                        {!! isset($penomoran['kode_akses']['jeniskodeakses']['full_name_html'])
                                            ? $penomoran['kode_akses']['jeniskodeakses']['full_name_html']
                                            : '' !!}</label> --}}
                                {{-- <input type="text" class="form-control"
                                    value="{{ isset($penomoran['kode_akses']['jeniskodeakses']['full_name'])
                                        ? $penomoran['kode_akses']['jeniskodeakses']['full_name']
                                        : '' }}"
                                    disabled> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="form-group text-right">
                <a href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i
                        class="icon-backward2 ml-2"></i> Kembali </a>
                {{-- <a href="{{ route('admin.sk.draftpenomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}" --}}
                {{-- target="_blank" class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a> --}}
                <a href="#" target="_blank" class="btn btn-success">Draf Penetapan <i
                        class="icon-file-pdf ml-2"></i></a>
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
        function submitdisposisi() {
            if ($('#status_sk').val() == 0 && $('#catatan_hasil_evaluasi').val() == '') {
                $('#submitModal').modal('toggle');
                alert('Silakan mengisi catatan hasil evaluasi');
            } else {
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
								class="btn btn-danger btn-small btn-delete-kodeakses" id="btn-delete-kodeakses"
								type="button"
							><i class="icon-minus3"></i></button>
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
