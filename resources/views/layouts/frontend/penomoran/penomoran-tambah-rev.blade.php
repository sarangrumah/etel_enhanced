@extends('layouts.frontend.main')
<!-- @section('title', 'Permohonan Penomoran Baru') -->
@section('js')

    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="/global_assets/js/demo_pages/form_layouts.js"></script>
    {{-- <link href="/global_assets/css/extras/select2.min.css" rel="stylesheet" /> --}}

@endsection
@section('content')

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
    </style>
    <div>

    </div>
    <!-- End Section Detail Permohonan -->
    <div class="card">
        <form
            action="{{ url('penomoran/savepenomoranbaru') }}"
            id="frm" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-header bg-indigo text-white header-elements-inline">
                <div class="row">
                    <div class="col-lg">
                        <h6 class="card-title font-weight-semibold py-3">Permohonan Penetapan Penomoran</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Perizinan</label>
                                <div class="col-lg-4">
                                    <select name="perizinan" class="form-control">
                                        <option value="">Silakan Pilih..</option>
                                        <option value="jasa">Izin Penyelenggaraan Jasa</option>
                                        <option value="jaringan">Izin Penyelenggaraan Jaringan</option>
                                    </select>   
                                </div>
                                <!-- <label class="col-lg-2 col-form-label">Jenis Permohonan</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="jenispermohonan">
                                    <option value="">Silakan Pilih..</option>
                                        <option value="new">Nomor Baru</option>
                                        <option value="add">Nomor Tambahan</option>
                                    </select>
                                </div> -->
                                <label class="col-lg-2 col-form-label">Jenis Penomoran</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="jenislayanan">
                                        <option value="">Silakan Pilih..</option>
                                        {{-- @foreach ($kblinomor_pt as $kblinomor_pt)
                                            <option value="{{ $kblinomor_pt->id }}">{{ $kblinomor_pt->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">KBLI</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="jeniskbli">
                                        <option value="">Silakan Pilih..</option>
                                        {{-- @foreach ($kblinomor_pt as $kblinomor_pt)
                                            <option value="{{ $kblinomor_pt->id }}">{{ $kblinomor_pt->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                
                                <!-- <label class="col-lg-2 col-form-label">Jenis Penomoran</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="jenislayanan">
                                        <option value="">Silakan Pilih..</option>
                                        {{-- @foreach ($kblinomor_pt as $kblinomor_pt)
                                            <option value="{{ $kblinomor_pt->id }}">{{ $kblinomor_pt->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div> -->
                                <label class="col-lg-2 col-form-label">Kode Akses</label>
                                <div class="col-lg-2">
                                    {{-- <div style="position: relative;display: inline;"> --}}
                                    <select class="form-control form-control-select2" id="availno" name="availno">
                                        <option value="" selected hidden>Pilih Jenis penomoran terlebih dulu
                                        </option>
                                    </select>
                                    <!-- <div class="mt-1 spinner-border loading text-primary" role="status"
                                        id="availno-loading">
                                        <span class="sr-only">Loading...</span>
                                    </div> -->
                                </div>
                            </div>
                            <div class="form-group row" id="PilihNomor">
                                <label class="col-lg-2 col-form-label">Jenis Layanan</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="jenislayanan">
                                        <option value="">Silakan Pilih..</option>
                                        {{-- @foreach ($kblinomor_pt as $kblinomor_pt)
                                            <option value="{{ $kblinomor_pt->id }}">{{ $kblinomor_pt->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row d-none" id="PilihKodeWilayah">

                                <!-- <label class="col-lg-2 col-form-label">Pilih Kode Wilayah</label>
                                                                <div class="col-lg-2">
                                                                    <input type="text" class="form-control" id="iPilihKodeWilayah"
                                                                        placeholder="Kode Wilayah" name="kode_wilayah">
                                                                </div> -->

                                <label class="col-lg-2 col-form-label">Pilih Kode Wilayah</label>
                                <div class="col-lg-8">
                                    <div style="position: relative;display: inline;">
                                        <select class="form-control form-control-select2" id="iPilihKodeWilayah"
                                            name="kode_wilayah" onselect="setpilihnomor()">
                                            <option value="" selected hidden>Pilih Kode Wilayah terlebih dulu</option>
                                        </select>
                                        <div class="mt-1 spinner-border loading text-primary" role="status"
                                            id="iPilihKodeWilayah-loading">
                                            <!-- <span class="sr-only">Loading...</span> -->
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
                        <h6 class="card-title font-weight-semibold py-3">Persyaratan</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <fieldset>
                            
                                <div class="form-group row">
                                    <label class="col-lg-6 col-form-label">Laporan Penggunaan Penomoran<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="file" name="LaporanPenggunaanPenomoran"
                                            id="LaporanPenggunaanPenomoran" class="form-control h-auto required"
                                            accept="application/pdf" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-6 col-form-label">Dokumen Izin Penyelenggaraan Telekomunikasi<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="file" name="DokumenIzin" id="DokumenIzin"
                                            class="form-control h-auto required" accept="application/pdf" required>
                                    </div>
                                </div>
                                <div class="form-group row d-none" id="RProdukBriefBaru">
                                    <label class="col-lg-6 col-form-label">Produk brief baru untuk pengajuan kode akses
                                        konten
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="file" name="ProdukBriefBaru" id="ProdukBriefBaru"
                                            class="form-control h-auto" accept="application/pdf">
                                    </div>
                                </div>
                                <div class="form-group row d-none" id="RSuratDukungan">
                                    <label class="col-lg-6 col-form-label">Surat dukungan dari calon pengguna untuk
                                        pengajuan
                                        kode akses call center
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="file" name="SuratDukungan" id="SuratDukungan"
                                            class="form-control h-auto" accept="application/pdf">
                                    </div>
                                </div>
                            
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
                                        <input type="checkbox" class="custom-control-input" required>
                                        <span class="custom-control-label">YA, Saya Setuju.</span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <a onclick="history.back();" class="btn btn-light"><i class="icon-backward2 ml-2"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-indigo">Kirim Permohonan <i
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


            // GetKodeWilayah(short_name);

            // if (jenislayanan == 'Izin Penyelenggaraan Jasa Pusat Panggilan Informasi (Call Center)') {
            //     $('#RSuratDukungan').removeClass("d-none");
            //     $("#SuratDukungan").prop('required', true);
            // } else if (jenislayanan == 'Sertifikat Penyelenggaraan Jasa Konten SMS Premium') {
            //     $('#RProdukBriefBaru').removeClass("d-none");
            //     $("#ProdukBriefBaru").prop('required', true);
            // }


            // $('#iPilihKodeWilayah').on('change', function() {
            //     $("#iNoPrefixAwal").prop('readonly', false);
            //     $("#iNoPrefixAwal").val("");
            // });

            // $('#iNoPrefixAwal').on("input", function() {
            //     var iPilihKodeWilayah = $("#iPilihKodeWilayah").val().length;
            //     var iNoPrefixAwal = $("#iNoPrefixAwal").val().length;
            //     var viNoPrefixAwal = $("#iNoPrefixAwal").val().length;

            //     console.log(iPilihKodeWilayah)

            //     if (iPilihKodeWilayah == 4) {
            //         if (iNoPrefixAwal > 3) {
            //             Swal.fire({
            //                 type: 'warning',
            //                 text: "No Prefix Awal Tidak Boleh Lebih Dari 3 Karakter",
            //             });
            //         }

            //         if (iNoPrefixAwal == 3) {
            //             $("#iNoPrefixAwal").prop('readonly', true);
            //             $("#iNoPrefixAwal").val(viNoPrefixAwal.substring(0, 3));

            //         }
            //     } else if (iPilihKodeWilayah == 3) {
            //         if (iNoPrefixAwal > 4) {
            //             Swal.fire({
            //                 type: 'warning',
            //                 text: "No Prefix Awal Tidak Boleh Lebih Dari 4 Karakter",
            //             });
            //         }

            //         if (iNoPrefixAwal == 4) {
            //             $("#iNoPrefixAwal").prop('readonly', true);
            //             $("#iNoPrefixAwal").val(viNoPrefixAwal.substring(0, 4));

            //         }
            //     } else {
            //         Swal.fire({
            //             type: 'errpr',
            //         });
            //     }

            // });

            // function GetKodeWilayah(short_name) {
            //     var jenispenomoran = short_name;
            //     var jenislayanan = $("#JenisLayanan").val();
            //     if (jenispenomoran == "Blok Nomor") {

            //         $.ajax({
            //             type: "POST",
            //             url: "{{ url('penomoran') }}/getKodeWeilayah",
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //             data: JSON.stringify({
            //                 data: jenispenomoran
            //             }),
            //             contentType: "application/json; charset=utf-8",
            //             dataType: "json",
            //             beforeSend: function() {
            //                 $('#iPilihKodeWilayah-loading').show();
            //             },
            //             success: function(e) {
            //                 var tempoption = "";
            //                 var tempoption = "<option>-- Pilih Kode Wilayah --</option>";
            //                 $.each(e, function(key, value) {
            //                     tempoption += "<option value='" + value.kode_wilayah + "'>" +
            //                         value.kode_wilayah + " - " + value.nama_wilayah +
            //                         "</option>";
            //                 });
            //                 $("#iPilihKodeWilayah").html(tempoption);
            //                 $("#iPilihKodeWilayah").removeAttr("disabled");
            //                 $('#iPilihKodeWilayah-loading').hide();
            //                 $('#iPilihKodeWilayah').select2();
            //                 $('#iPilihKodeWilayah').addClass("select2");
            //                 $("#PilihKodeWilayah").removeClass("d-none");
            //                 $("#NoPrefixAwal").removeClass("d-none");
            //                 $("#PlilihNomor").addClass("d-none");
            //             },
            //             failure: function(errMsg) {
            //                 alert(errMsg);
            //             }
            //         });
            //     } else {
            //         $("#PlilihNomor").removeClass("d-none");
            //         $("#PilihKodeWilayah").addClass("d-none");
            //         $("#NoPrefixAwal").addClass("d-none");
            //         $('#availno-loading').show();
            //         $.ajax({
            //             type: "POST",
            //             url: "{{ url('penomoran') }}/getnomor",
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //             data: JSON.stringify({
            //                 data: jenispenomoran,
            //                 datajenislayanan: jenislayanan
            //             }),
            //             contentType: "application/json; charset=utf-8",
            //             dataType: "json",
            //             success: function(e) {
            //                 var tempoption = "";
            //                 var tempoption = "<option>-- Pilih Kode Akses --</option>";
            //                 $.each(e, function(key, value) {
            //                     tempoption += "<option value='" + value.kode_akses +
            //                         "'> " + value.kode_akses + " </option>";
            //                 });
            //                 $("#availno").html(tempoption);
            //                 $("#availno").removeAttr("disabled");
            //                 $('#availno-loading').hide();
            //             },
            //             failure: function(errMsg) {
            //                 alert(errMsg);
            //             }
            //         });
            //     }
            // };

            $('select[name="kbli"]').on('change', function() {
                var izin = $(this).val();
                console.log(izin); 
                if(izin == '61914') {
                    $('select[name="jenislayanan"]').find('option').remove();
                    $('select[name="jenislayanan"]').val('Silakan Pilih...');
                    $('select[name="jenislayanan"]').append('<option value="059000000032">Sertifikat Penyelenggaraan Jasa Panggilan Terkelola (Calling Card)</option>');
                }else if(izin == '61912'){
                    $('select[name="jenislayanan"]').append('<option value="059000000033">Sertifikat Penyelenggaraan Jasa Konten SMS Premium</option>');
                }else if(izin == '82200'){
                    $('select[name="jenislayanan"]').append('<option value="059000000052">Izin Penyelenggaraan Jasa Pusat Panggilan Informasi (Call Center)</option>');
                }else if(izin == '61912'){                
                    $('select[name="jenislayanan"]').append('<option value="059000000058">Izin Penyelenggaraan Jasa Internet Teleponi untuk Keperluan Publik (ITKP)</option>');
                }else if(izin == '61100'){
                    $('select[name="jenislayanan"]').find('option').remove();
                    $('select[name="jenislayanan"]').val('Silakan Pilih...');
                    $('select[name="jenislayanan"]').append('<option value="059000000043">Izin Penyelenggaraan Jaringan Tetap Sambungan Langsung Jarak Jauh</option>');
                    $('select[name="jenislayanan"]').append('<option value="059000000044">Izin Penyelenggaraan Jaringan Tetap Sambungan Internasional</option>');
                }else if(izin == '61300'){    
                    $('select[name="jenislayanan"]').append('<option value="059000000046">Izin Penyelenggaraan Jaringan Bergerak Satelit </option>');
                }else if(izin == '61200'){        
                    $('select[name="jenislayanan"]').append('<option value="059000000063">Izin Penyelenggaraan Jaringan Tetap Lokal Berbasis Packet Switched melalui Media Non-Kabel (BWA)</option>');
                    $('select[name="jenislayanan"]').append('<option value="059000000064">Izin Penyelenggaraan Jaringan Bergerak Seluler (ITKP)</option>');
                }else{
                }
                // if(izin) {
                //     $.ajax({
                //         url: 'api/getjenislayanan/'+izin,
                //         type: "GET",
                //         dataType: "json",
                //         success:function(data) {
                //             console.log(data);
                            
                //             $('select[name="jenislayanan"]').empty();
                //             $.each(data, function(key, value) {
                //                 $('select[name="jenislayanan"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                //             });


                //         }
                //     });
                // }else{
                //     $('select[name="jenislayanan"]').empty();
                // }
            });
            $('select[name="perizinan"]').on('change', function() {
                var izin = $(this).val();
                console.log(izin); 
                if(izin == 'jasa') {
                    $('select[name="jeniskbli"]').find('option').remove();
                    $('select[name="jeniskbli"]').val('Silakan Pilih...');
                    $('select[name="jeniskbli"]').append('<option value="61300">61300 - Aktivitas Telekomunikasi Satelit</option>');
                    $('select[name="jeniskbli"]').append('<option value="61912">61912 - Jasa Konten SMS Premium</option>');
                    $('select[name="jeniskbli"]').append('<option value="61913">61913 - Jasa Internet Teleponi Untuk Keperluan Publik (ITKP)</option>');
                    $('select[name="jeniskbli"]').append('<option value="61914">61914 - Jasa Panggilan Terkelola (Calling Card)</option>');
                    $('select[name="jeniskbli"]').append('<option value="82200">82200 - Aktivitas Call Centre</option>');
                }else if(izin == 'jaringan'){
                    $('select[name="jeniskbli"]').find('option').remove();
                    $('select[name="jeniskbli"]').val('Silakan Pilih...');
                    $('select[name="jeniskbli"]').append('<option value="61110">61110 - Aktivitas Telekomunikasi dengan Kabel</option>');
                    $('select[name="jeniskbli"]').append('<option value="61200">61200 - Aktivitas Telekomunikasi Tanpa Kabel</option>');
                }else{
                }
            });


        });
    </script>

@endsection
