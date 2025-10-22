@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
    <script src="//cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
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
        action="{{ route('admin.direktur.evaluasi-pencabutanpenomoranPost', [$penomoran->id_izin]) }}"
        enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="hidden" id="id" name="id" value="{{ $id }}">
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
                                <legend class="text-uppercase font-size-sm font-weight-bold">Data Permohonan
                                </legend>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Nomor Permohonan </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->id_izin }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $date_reformat->date_lang_reformat_long($penomoran->tgl_permohonan) }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->jenis_permohonan }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Status </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->name_status_bo }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Kode Akses </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->kode_akses }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="col">
                                <legend class="text-uppercase font-size-sm font-weight-bold">Data Penguna Penomoran</legend>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Jenis Pengguna </label>
                                            <div class="input-group col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->jenis_pengguna }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Nama Pengguna </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->nama_perseroan_alokasi }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">NIB </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->nib_alokasi }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">No Penetapan </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->nomor_penetapan }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Tanggal Penetapan </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $date_reformat->date_lang_reformat_long($penomoran->tanggal_penetapan) }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
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
                                <h6 class="card-title font-weight-semibold py-3">Evaluasi Permohonan </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Penomoran</legend>
                        <div class="form-group row">
                            <div class="col">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Jenis Penomoran </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->jenis_kode_akses_nonhtml }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Kode Akses </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->kode_akses }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Nomor Penetapan </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->nomor_penetapan }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Tanggal Penetapan </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $date_reformat->date_lang_reformat_long($penomoran->tanggal_penetapan) }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <legend class="text-uppercase font-size-sm font-weight-bold">Kelengkapan </legend>
                        <div class="form-group row">
                            <div class="col-lg-12 form-group row">
                                <div class="col-lg-6">
                                    <div class="col-lg-12">
                                        <label class="col-lg-4 col-form-label">Dasar Pencabutan </label>
                                        <textarea rows="6" cols="6" class="form-control dasarpencabutan" id="dasarpencabutan" placeholder=""
                                            name="dasarpencabutan" disabled>{{ $penomoran->dasar_pencabutan }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="col-lg-12">
                                        <label class="col-lg-4 col-form-label">Pertimbangan Pencabutan </label>
                                        <textarea rows="6" cols="6" class="form-control pertimbanganpencabutan" id="pertimbanganpencabutan"
                                            placeholder="" name="pertimbanganpencabutan" disabled>{{ $penomoran->pertimbangan_pencabutan }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($penomoran->path_dok_evaluasi_tambahan) && $penomoran->path_dok_evaluasi_tambahan != '') {
                            $_file = explode('/', $penomoran->path_dok_evaluasi_tambahan);
                            $file4 = $_file[3];
                        } else {
                            $file4 = '';
                        }
                        
                        // $file4 = $file4;
                        
                        ?>
                        @if (isset($penomoran->path_dok_evaluasi_tambahan) && $penomoran->path_dok_evaluasi_tambahan != '')
                            <div class="col-lg-12 row">
                                <div class="col-lg-2">
                                    <p class="col-form-label">Data Dukung Pencabutan Penomoran</p>
                                </div>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input disabled="disabled" type="text"
                                            class="form-control border-right-0"name="berkas_tambahan"
                                            placeholder="{{ $file4 }}">
                                        <span class="input-group-append">
                                            <a target="_blank" href="{{ asset($penomoran->path_dok_evaluasi_tambahan) }}"
                                                class="btn btn-teal" type="button">Lihat Dokumen</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-12 form-group row">

                            <div class="col-lg-12">
                                <label class="col-lg-4 col-form-label">Catatan Pencabutan </label>
                                <textarea rows="3" cols="3" class="form-control" id="catatan_hasil_evaluasi"
                                    placeholder="Catatan Hasil Evaluasi" name="catatan_hasil_evaluasi" disabled>{!! $penomoran->note !!}</textarea>
                            </div>
                        </div>
                        <legend class="text-uppercase font-size-sm font-weight-bold">Proses Evaluasi</legend>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Evaluator</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="{!! isset($penomoran->evaluator_name) ? $penomoran->evaluator_name : '' !!}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Hasil Evaluasi</label>
                                    <div class="col-lg-8">
                                        <select name="status_sk" id="status_sk" data-placeholder="Silakan Pilih"
                                            class="form-control" disabled>
                                            {{-- <option value=""  disabled>-- Silakan Pilih --</option> --}}
                                            <option value='1' selected>Disetujui</option>
                                            <option value='0'>Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-lg-12 form-group row">
                                <div class="col-lg-12">
                                    <label class="col-lg-4 col-form-label">Catatan Evaluasi </label>
                                    <textarea rows="3" cols="3" class="form-control" id="catatan_hasil_evaluasi"
                                        placeholder="Catatan Hasil Evaluasi" name="catatan_hasil_evaluasi" disabled hidden>{{ $penomoran->catatan_hasil_evaluasi }}</textarea>
                                </div>
                            </div> --}}
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
                    {{-- <a href="{{ route('admin.sk.draftpenomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}" --}}
                    {{-- target="_blank" class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a> --}}
                    <a href="{{ route('admin.sk.draftpenomoranpencabutan', [$penomoran->id_mst_kode_akses]) }}"
                        target="_blank" class="btn btn-success" id='draftpenomoran'>Draf Penetapan <i
                            class="icon-file-pdf ml-2"></i></a>
                    {{-- <button type="submit" id="btn_draft" name="btn_draft" class="btn btn-indigo btn_draft">Draf Penetapan
                    <i class="icon-file-pdf ml-2"></i></button> --}}
                    <button type="button" id="btn_submit" name="btn_submit" data-target="#submitModal"
                        data-toggle="modal" class="btn btn-indigo">Kirim
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
                            <button type="button" class="btn btn-secondary notif-button"
                                data-dismiss="modal">Batal</button>
                            <button type="button" id="btnSubmit" onclick="submitdisposisi();return false;"
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
        // document.getElementById('btn_draft').addEventListener('click', function() {
        //     // Open the form in a new tab
        //     window.open('', '_blank').location.href =
        //         '{{ route('admin.evaluator.evaluasi-pencabutanpenomoranPost', [$id, $penomoran->id_mst_kode_akses]) }}?btn_draft=true';
        // });

        function draftpencabutan(kode_akses) {
            // var selectedvalue = document.getElementById('kodeakses_hapus[' + selectElement + '][status_pe_sk]').value;
            // var kode_akses = document.getElementById('kodeakses_hapus[' + selectElement + '][kode_akses]').value;
            // var kode_wilayah = document.getElementById('kode_wilayah[' + selectElement + ']').value;
            // var prefix_awal = document.getElementById('prefix_awal[' + selectElement + ']').value;
            var id_izin = document.getElementById('id_izin').value;
            // console.log('Selected Element:', selectedElement.value, selectedElement2.value);
            // var selectedValue = selectElement.value;
            // console.log(selectedValue);
            // document.getElementById('otherInput').value;

            // Make an AJAX request to Laravel backend
            $.ajax({
                type: "POST",
                url: "/admin/disactivated-kodeakses",
                // dataType: "json",
                data: {
                    // value: selectedvalue,
                    kode_akses: kode_akses,
                    // prefix_awal: prefix_awal,
                    id_izin: id_izin,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    // Handle success response
                    console.log(data);
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    // Handle error response
                    console.log(errors);
                }
            });
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
                showLoadingSpinner();
            $('#formEvaluasiTolak').submit();
        }

        function updateskpencabutan() {
            var id = document.getElementById('id').value;
            // var id_kodeakses = document.getElementById('id_kodeakses').value;
            var dasarpencabutan = document.getElementById('dasarpencabutan').value;
            var pertimbanganpencabutan = document.getElementById('pertimbanganpencabutan').value;
            // alert(id_kodeakses);
            // Make an AJAX request to Laravel backend
            $.ajax({
                type: "POST",
                url: "/admin/updateskpencabutan-kodeakses",
                // dataType: "json",
                data: {
                    id: id,
                    dasarpencabutan: dasarpencabutan,
                    pertimbanganpencabutan: pertimbanganpencabutan,
                    // no_sk: no_sk,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    // Handle success response
                    console.log(data);
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    // Handle error response
                    console.log(errors);
                }
            });
        }
        $(document).ready(function() {


            // $(document).on('click', '.btn_draft', function(e) {
            //     e.preventDefault();
            //     var id = document.getElementById('id').value;
            //     alert(id);
            //     // disactivatedKodeakses(inputValue);
            //     // $(row_item).remove();
            // })

        });
    </script>
    <script type="text/javascript">
            var loadingSpinner = document.getElementById('loadingSpinner');
        
            function showLoadingSpinner() {
                // loadingSpinner.style.display = 'block';
                var spinner = document.getElementById('loadingSpinner');
                spinner.style.display = 'flex';
            }
        $(document).ready(function() {
            CKEDITOR.replace('catatan_hasil_evaluasi');
            // CKEDITOR.replace('catatan_hasil_evaluasi_previous');
            $("#btnSubmitModalKoreksi").hide();
            $("#btnSubmitModal").show();
            $('#dasarpencabutan').blur(function(e) {
                // Get value from the input box
                e.preventDefault();
                // let row_item = $(this).parent().parent();

                // let inputValue = row_item.find('.pilih-bloknomor').val();
                // alert(inputValue);
                updateskpencabutan();
            });

            $('#pertimbanganpencabutan').blur(function(e) {
                // Get value from the input box
                e.preventDefault();
                // let row_item = $(this).parent().parent();

                // let inputValue = row_item.find('.pilih-bloknomor').val();
                // alert(inputValue);
                updateskpencabutan();
            });
        });
    </script>
@endsection
