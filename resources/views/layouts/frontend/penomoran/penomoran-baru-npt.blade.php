@extends('layouts.frontend.main')
<!-- @section('title', 'Permohonan Penomoran Baru') -->
@section('js')

    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="/global_assets/js/demo_pages/form_layouts.js"></script>
    {{-- <link href="/global_assets/css/extras/select2.min.css" rel="stylesheet" /> --}}

@endsection
@section('content')
    <div id="loadingSpinner" class="loading-spinner" style="display: none;">
        <img id="spinnerImage" src="/assets/kominfo/spinner-kominfo-trp.svg" alt="Loading Spinner">
    </div>
    @if (session()->has('error'))
        <div class="alert alert-danger">
            Blok Nomor tersebut sudah ada yang mengajukan silahkan input Blok Nomor Lain.
        </div>
    @endif
    {{--
<!-- <x-perizinan /> --> --}}
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
    <div>

    </div>
    <!-- End Section Detail Permohonan -->
    <div class="card">
        <form action="{{ url('penomoran/savepenomoranbaru') }}" id="frm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="id_jenislayanan" name="id_jenislayanan" value="">
            <input type="hidden" id="id_jeniskodeakses" name="id_jeniskodeakses" value="">
            <input type="hidden" id="id_kodeakses" name="id_kodeakses" value="">

            <div class="card-header bg-indigo text-white header-elements-inline">
                <div class="row">
                    <div class="col-lg">
                        @if ($penambahan)
                            <h6 class="card-title font-weight-semibold py-3">Permohonan Penetapan Nomor Tambahan</h6>
                        @elseif($pengembalian)
                            <h6 class="card-title font-weight-semibold py-3">Pengembalian Penomoran</h6>
                        @else
                            <h6 class="card-title font-weight-semibold py-3">Permohonan Penetapan Nomor Baru</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Jenis Penomoran</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="jeniskodeakses" id="jeniskodeakses" data-toggle="tooltip" data-placement="bottom" title="Pilih Jenis Penomoran" required>
                                        <option value="">Silakan Pilih..</option>
                                        @foreach ($kblinomor_pt as $items)
                                            <option value="{{ $items->short_name }}">{!! $items->full_name_html !!}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Kode Akses</label>
                                <div class="col-lg-2" id="availno_opt">
                                    {{-- <div style="position: relative;display: inline;"> --}}
                                    <select class="form-control form-control-select2" id="availno" name="availno" data-toggle="tooltip" data-placement="bottom" title="Pilih Kode Akses" required>
                                        <option value="" selected hidden>Pilih Jenis penomoran terlebih dulu
                                        </option>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row d-none" id="PilihKodeWilayah">
                                <label class="col-lg-2 col-form-label">Pilih Kode Wilayah</label>
                                <div class="col-lg-8">
                                    <div style="position: relative;display: inline;">
                                        <select class="form-control form-control-select2" id="iPilihKodeWilayah"
                                            name="kode_wilayah" onselect="setpilihnomor()">
                                            <option value="" selected hidden>Pilih Kode Wilayah terlebih dulu</option>
                                        </select>
                                        <div class="mt-1 spinner-border loading text-primary" role="status"
                                            id="iPilihKodeWilayah-loading">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row d-none" id="NoPrefixAwal">
                                <label class="col-lg-2 col-form-label">No Prefix Awal</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" id="iNoPrefixAwal" placeholder="Prefix Awal"
                                        name="prefix">
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="card-header bg-indigo text-white header-elements-inline">
                <div class="row">
                    <div class="col-lg">
                        @if ($penambahan)
                            <h6 class="card-title font-weight-semibold py-3">Kelengkapan dan Pernyataan</h6>
                        @elseif($pengembalian)
                            <h6 class="card-title font-weight-semibold py-3">Kelengkapan dan Pernyataan</h6>
                        @else
                            <h6 class="card-title font-weight-semibold py-3">Pernyataan</h6>
                        @endif

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @if ($penambahan)
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label class="col-lg-12 col-form-label">Laporan Penggunaan Penomoran Yang
                                            Pernah
                                            Ditetapkan<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-12">
                                        <div>
                                            <input type="file" name="LaporanPenggunaanPenomoran"
                                                id="LaporanPenggunaanPenomoran" class="form-control h-auto required"
                                                accept="application/pdf" data-toggle="tooltip" data-placement="bottom" title="Unggah Dokumen Laporan Penggunaan Penomoran" required>
                                        </div>
                                        <div>
                                            {{-- <small>Unduh Format Laporan Penggunaan Penomoran <a target="_blank"
                                                    href="?">Disini</a></small> --}}
                                            <small>Unduh Format Laporan Penggunaan Penomoran <a target="_blank"
                                                    id="downloadLink" href="#">Disini</a></small>

                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label class="col-lg-12 col-form-label">Dokumen Perizinan Berusaha<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="file" name="DokumenIzin" id="DokumenIzin"
                                            class="form-control h-auto required" accept="application/pdf" required>
                                    </div>
                                </div> --}}
                                <div class="form-group row d-none" id="RProdukBriefBaru">
                                    <div class="col-lg-12">
                                        <label class="col-lg-6 col-form-label">Penjelasan Singkat (<i>Product
                                                Brief</i>)
                                            Layanan Baru<span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="file" name="ProdukBriefBaru" id="ProdukBriefBaru"
                                            class="form-control h-auto" accept="application/pdf" data-toggle="tooltip" data-placement="bottom" title="Unggah Dokumen Product Brief" required>
                                    </div>
                                </div>
                                <div class="form-group row d-none" id="RSuratDukungan">
                                    <div class="col-lg-12">
                                        <label class="col-lg-12 col-form-label">Surat Dukungan Dari Calon Pengguna untuk
                                            Pengajuan
                                            Kode Akses Call Center
                                        </label>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="file" name="SuratDukungan" id="SuratDukungan"
                                            class="form-control h-auto" accept="application/pdf" data-toggle="tooltip" data-placement="bottom" title="Unggah Dokumen Surat Dukungan Dari Calon Pengguna" required>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                {{-- <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label class="col-lg-12 col-form-label">Laporan Penggunaan Penomoran Yang
                                            Pernah
                                            Ditetapkan<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-12">
                                        <div>
                                            <input type="file" name="LaporanPenggunaanPenomoran"
                                                id="LaporanPenggunaanPenomoran" class="form-control h-auto required"
                                                accept="application/pdf" required>
                                        </div>
                                        <div>
                                            <small>Unduh Format Laporan Penggunaan Penomoran <a target="_blank"
                                                    id="downloadLink" href="#">Disini</a></small>

                                        </div>
                                    </div>
                                </div> --}}
                            </fieldset>
                        </div>
                    @endif

                    @if ($pengembalian)
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-lg-6 col-form-label">SK Penetapan Penomoran<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input type="file" name="SKPenetapanPenomoran" id="SKPenetapanPenomoran"
                                            class="form-control h-auto required" accept="application/pdf" data-toggle="tooltip" data-placement="bottom" title="Unggah SK Penetapan" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-lg-6 col-form-label">Alasan Pengembalian<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea rows="3" cols="3" class="form-control" id="ReasonRemoval_SK"
                                            placeholder="Alasan Pengembalian" name="ReasonRemoval_SK" data-toggle="tooltip" data-placement="bottom" title="Masukkan Alasan Pengembalian" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <fieldset>
                            <div class="dropdown-divider"></div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Dengan ini saya menyatakan bahwa seluruh data yang
                                    disampaikan adalah BENAR. Jika dikemudian hari data yang disampaikan terbukti
                                    tidak benar, maka kami siap menerima akibat hukum sesuai dengan ketentuan
                                    perundang-undangan.</label>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8">
                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" data-toggle="tooltip" data-placement="bottom" title="Harap Centang Pernyataan" required>
                                        <span class="custom-control-label">YA, Saya Setuju.</span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <a onclick="history.back();" class="btn btn-light"><i class="icon-backward2 ml-2"></i>
                                Kembali
                            </a>
                            <button id="submitButton" type="submit" class="btn btn-indigo">Kirim Permohonan <i
                                    class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

@endsection


@section('custom-js')
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var submitButton = document.getElementById('submitButton');
            var loadingSpinner = document.getElementById('loadingSpinner');
            var myForm = document.getElementById('frm');

            function showLoadingSpinner() {
                // loadingSpinner.style.display = 'block';
                var spinner = document.getElementById('loadingSpinner');
                spinner.style.display = 'flex';
            }
            submitButton.addEventListener('click', function(event) {
                event.preventDefault();
                if ($("#frm")[0].checkValidity()) {
                        showLoadingSpinner();
                        submitForm();                    
                } else {
                    $('#frm :input[required="required"]').each(function() {
                        if (!this.validity.valid) {
                            $(this).focus();
                            $(this).tooltip();
                            $(this).tooltip('show');
                            // alert(
                            //     'Mohon lengkapi persyaratan yang dibutuhkan dan lakukan checklist setelah melengkapi persyaratan.'
                            // );
                            return false;
                        }
                    });
                }
                return false;
            });

            function hideLoadingSpinner() {
                loadingSpinner.style.display = 'none';
            }

            function submitForm() {
                myForm.submit();
            }
            $('select[name="kbli"]').on('change', function() {
                var kbli = $(this).val();
                console.log(kbli)
                if (kbli) {
                    $.ajax({
                        url: 'api/getjenislayanan/' + kbli,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);

                            $('select[name="jenislayanan"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="jenislayanan"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });


                        }
                    });
                } else {
                    $('select[name="jenislayanan"]').empty();
                }
            });
            $('select[name="jeniskodeakses"]').on('change', function() {
                var jenis_kodeakses = $(this).val();
                $(this).tooltip('dispose');
                var id_jeniskodeakses_var = document.getElementById("id_jeniskodeakses");
                id_jeniskodeakses_var.value = $(this).val();
                // alert(jenis_kodeakses);
                // alert($(this).val());
                // console.log(id_jeniskodeakses_var.value);
                // GetKodeWilayah(id_jeniskodeakses_var.value);
                var downloadLink = document.getElementById('downloadLink');
                if (downloadLink !== null) {
                    downloadLink.href = '/storage/lampiran/penomoran/' + jenis_kodeakses + '.docx';
                }
                if (jenis_kodeakses) {
                    if (id_jeniskodeakses_var.value == 'Blok Nomor') {
                        console.log(id_jeniskodeakses_var.value);

                        $('#availno_opt').addClass("d-none");
                        $('#lbl_kdakses').removeClass("d-none");
                        $("#PilihKodeWilayah").removeClass("d-none");
                        $("#NoPrefixAwal").removeClass("d-none");
                        // $("#availno").prop('required', false);
                        // $(this).parents("#availno").remove();

                        var x = document.getElementById("lbl_kdakses");
                        x.innerHTML = "Daftar Blok Nomor";
                    } else {
                        if (jenis_kodeakses ==
                            'NONKONTEN' || jenis_kodeakses ==
                            'USSD') {
                            $('#RProdukBriefBaru').removeClass("d-none");
                            $("#ProdukBriefBaru").prop('required', true);
                            $('#RSuratDukungan').addClass("d-none");
                            $("#SuratDukungan").prop('required', false);
                        } else {
                            $('#RProdukBriefBaru').addClass("d-none");
                            $("#ProdukBriefBaru").prop('required', false);
                            $('#RSuratDukungan').addClass("d-none");
                            $("#SuratDukungan").prop('required', false);
                        }
                        $('select[name="availno"]').html('<option value="" disabled>Loading...</option>');
                        $.ajax({
                            url: '/api/getkodeakses_nomor_npt/' + jenis_kodeakses,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                // console.log(data);
                                $('select[name="availno"]').prop('disabled', false);

                                $('select[name="availno"]').empty();
                                $('select[name="availno"]').append(
                                    '<option value="">-- Pilih Kode Akses --</option>'
                                );
                                $.each(data, function(key, value) {

                                    $('select[name="availno"]').append(
                                        '<option value="' + value.id + '">' + value
                                        .kode_akses + '</option>');
                                });


                            }
                        });
                    }

                } else {
                    $('select[name="availno"]').empty();
                }
            });
            $('select[name="availno"]').on('change', function() {
                var id_kodeakses = $(this).val();
                
                $(this).tooltip('dispose');
                var id_kodeakses_var = document.getElementById("id_kodeakses");
                id_kodeakses_var.value = $(this).val();
                console.log(id_kodeakses_var.value);

            });

        });
    </script>

@endsection
