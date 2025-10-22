@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
    <div id="loadingSpinner" class="loading-spinner" style="display: none;">
        <img id="spinnerImage" src="/assets/kominfo/spinner-kominfo-trp.svg" alt="Loading Spinner">
    </div>
    {{-- @if (Session::get('message') != '')
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ Session::get('message') }}</strong>
        </div>
    @endif --}}
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
    <form method="post" id="formEvaluasi" action="{{ route('admin.evaluator.evaluasi-pencabutanpenomoranPost', [$id]) }}"
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
                                <legend class="text-uppercase font-size-sm font-weight-bold">Data Penomoran
                                </legend>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Jenis Penomoran </label>
                                            <div class="input-group col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->jenis_penomoran }}" disabled>
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
                                            <div class="col-lg-8">
                                                <input type="text" class="col-lg form-control"
                                                    value="{{ $penomoran->kode_akses }}" disabled>
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
                                                    value="{{ $penomoran->status }}" disabled>
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
                                                    value="{{ $penomoran->nama_perseroan }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($penomoran->nib == 'Penyelenggara Telekomunikasi')
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <label class="col-lg-4 col-form-label">NIB </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="col-lg form-control"
                                                        value="{{ $penomoran->nib }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                    {{-- <legend class="text-uppercase font-size-sm font-weight-bold">Dasar Pencabutan</legend> --}}
                    <div class="col-lg-12 form-group row">
                        <div class="col-lg-6">
                            <div class="col-lg-12">
                                <label class="col-lg-4 col-form-label">Dasar Pencabutan </label>
                                <textarea rows="6" cols="6" class="form-control dasarpencabutan" id="dasarpencabutan" placeholder=""
                                    name="dasarpencabutan" required></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="col-lg-12">
                                <label class="col-lg-4 col-form-label">Pertimbangan Pencabutan </label>
                                <textarea rows="6" cols="6" class="form-control pertimbanganpencabutan" id="pertimbanganpencabutan"
                                    placeholder="" name="pertimbanganpencabutan" required></textarea>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-12 row">
                        <div class="col-lg-6">
                            <div class="col-lg-4 form-group">
                                <label class="col-form-label">Data Dukung Pencabutan
                                    Penomoran </label>
                            </div>
                            <div class="col-lg-8 form-group">
                                <input type="file" class="form-control" name="berkas_tambahan" id="berkas_tambahan"
                                    accept="application/pdf">
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-12 row">
                        <label class="col-lg-2 col-form-label" for="berkas_tambahan">Data Dukung Pencabutan
                            Penomoran</label>
                        <div class="col-lg-10">
                            <input type="file" class="form-control h-auto" name="berkas_tambahan"
                                id="berkas_tambahan" accept="application/pdf">
                        </div>
                    </div>
                    {{-- <div class="col-6">
                        <div class="col-lg-12 row">
                            <div class="col-lg-4 form-group">
                                <label class="col-form-label">Catatan Pencabutan </label>
                            </div>
                            <div class="col-lg-8 form-group">
                                <textarea rows="6" cols="6" class="form-control" id="catatan_hasil_evaluasi" placeholder=""
                                    name="catatan_hasil_evaluasi" required></textarea>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-12 form-group row">

                        <div class="col-lg-12">
                            <label class="col-lg-4 col-form-label">Catatan Pencabutan </label>
                            <textarea rows="3" cols="3" class="form-control" id="catatan_hasil_evaluasi"
                                placeholder="Catatan Hasil Evaluasi" name="catatan_hasil_evaluasi"></textarea>
                        </div>
                    </div>
                </div>
            </div>



            <div class="form-group text-right">
                <a href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i
                        class="icon-backward2 ml-2"></i> Kembali </a>
                {{-- <a href="{{ route('admin.sk.draftpenomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}" --}}
                {{-- target="_blank" class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a> --}}
                <a href="{{ route('admin.sk.draftpenomoranpencabutan', [$id]) }}" target="_blank"
                    class="btn btn-success" id='draftpenomoran'>Draf Penetapan <i class="icon-file-pdf ml-2"></i></a>
                {{-- <button type="submit" id="btn_draft" name="btn_draft" class="btn btn-indigo btn_draft">Draf Penetapan
                    <i class="icon-file-pdf ml-2"></i></button> --}}
                <button type="button" id="btn_submit" name="btn_submit" data-target="#submitModal" data-toggle="modal"
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

    </form>

    <script>
        var loadingSpinner = document.getElementById('loadingSpinner');

        function showLoadingSpinner() {
            // loadingSpinner.style.display = 'block';
            var spinner = document.getElementById('loadingSpinner');
            spinner.style.display = 'flex';
        }
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
        $(document).ready(function() {

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
