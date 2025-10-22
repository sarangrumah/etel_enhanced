@extends('layouts.frontend.main')
<!-- @section('title', 'Permohonan Penomoran Baru') -->
@section('js')

    <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="global_assets/js/demo_pages/form_layouts.js"></script>

@endsection
@section('content')
    <!-- <x-perizinan /> -->

    <div class="card">
        <div class="card-header bg-indigo text-white header-elements-inline">
            <div class="row">
                <div class="col-lg">
                    <h6 class="card-title font-weight-semibold py-3">Pengajuan Kode Akses</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="#">
                <div class="row">
                    <div class="col-lg-12">
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Jenis Layanan</label>
                                <div class="col-lg-8">
                                    <select data-placeholder="Pilih Jenis Layanan" class="form-control form-control-select2"
                                        id="jenislayanan" name="jenislayanan" onchange="pilihjenislayanan()" data-fouc>
                                        <option></option>
                                        <option value="059000000064"> Jaringan Bergerak Seluler </option>
                                        <option value="059000000064"> Jaringan Tetap Lokal Berbasis Packet Switched melalui
                                            Media Non-Kabel (BWA) </option>
                                        {{-- @foreach ($lsjnslayanan as $lsjenislayanans)
                                    <option value="{{ $lsjenislayanans->kode_izin }}">
                                        {{ $lsjenislayanans->name }}
                                        -
                                        {{ $lsjenislayanans->nama_layanan }}</option>
                                    @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Jenis Penomoran</label>
                                <div class="col-lg-8">
                                    <select data-placeholder="-- Pilih Jenis Kode Akses --"
                                        class="form-control form-control-select2" id="jenisnomor" name="jenisnomor"
                                        data-fouc>
                                        <option selected disabled>-- Pilih Jenis Kode Akses --</option>
                                        <option value="4"> Public Land Mobile Network Identity - PLMNID </option>
                                        <option value="1"> National Destination Code - NDC </option>
                                        <option value="2"> Signalling Point Code - SPC </option>
                                        <option value="3"> International Signalling Point Code - ISPC </option>
                                        <option value="12"> Kode Akses Pusat Layanan Masyarakat - LAY.MASY
                                        </option>
                                        <option value="16"> Kode Akses Pesan Singkat Layanan Masyarakat - SMS.MASY
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Pilih Nomor</label>
                                <div class="col-lg-2">
                                    <select data-placeholder="Pilih Kode Akses" class="form-control form-control-select2"
                                        id="availno" name="availno" data-fouc>
                                        <option></option>
                                        <option value="011">011</option>
                                        <option value="012">012</option>
                                        <option value="013">013</option>
                                        <option value="014">014</option>
                                        <option value="015">015</option>
                                        <option value="016">016</option>
                                        <option value="017">017</option>
                                        <option value="018">018</option>
                                        <option value="019">019</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Pilih Kode Wilayah</label>
                                <div class="col-lg-2">
                                    <select data-placeholder="Pilih Kode Wilayah" class="form-control form-control-select2"
                                        data-fouc>
                                        <option></option>
                                        <option value="AK">021</option>
                                        <option value="HI">022</option>
                                        <option value="AK">031</option>
                                        <option value="HI">022</option>
                                        <option value="AK">024</option>
                                        <option value="HI">0264</option>
                                        <option value="AK">0255</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">No Prefix Awal</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" placeholder="Prefix Awal">
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Laporan Penggunaan Penomoran<span
                                        class="text-danger">*</span>: </label>
                                <div class="col-lg-8">
                                    <input type="file" class="form-control h-auto required" accept="application/pdf">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Produk brief baru untuk pengajuan kode akses konten:
                                </label>
                                <div class="col-lg-8">
                                    <input type="file" class="form-control h-auto" accept="application/pdf">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Surat dukungan dari calon pengguna untuk pengajuan
                                    kode akses call center:
                                </label>
                                <div class="col-lg-8">
                                    <input type="file" class="form-control h-auto" accept="application/pdf">
                                </div>
                            </div>


                            <div class="dropdown-divider"></div>
                            <div class="form-group row">
                                <label class="col-form-label">Dengan ini saya menyatakan bahwa seluruh data yang disampaikan
                                    adalah BENAR. Jika dikemudian hari data yang disampaikan terbukti
                                    tidak benar, maka kami siap menerima akibat hukum sesuai dengan ketentuan
                                    perundang-undangan.</label>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8">
                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" checked>
                                        <span class="custom-control-label">YA, Saya Setuju.</span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('/') }}" class="btn btn-secondary border-transparent"><i
                            class="icon-backward2 ml-2"></i> Kembali </a>
                    <button type="submit" class="btn btn-primary">Kirim Permohonan <i
                            class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>




    </div>



    @push('scripts')
        <script>
            function pilihjenislayanan() {
                let jenislayananval = $("#jenislayanan").val();
                $("#jenisnomor").children().remove()
                // $("#availno").prop('disabled', true)
                console.log(jenislayananval);
                if (jenislayananval != '' && jenislayananval != null) {
                    $.ajax({
                        url: "{{ url('') }}/jenisnomor/" + jenislayananval,
                        type: 'GET',
                        datatype: 'json',
                        success: function(res) {
                            var temp = res;
                            $("#jenisnomor").empty();
                            $("#jenisnomor").append('<option selected disabled>-- Pilih Nomor --</option>');
                        }

                    });
                }

            }

            function pilihjenisno() {
                let jenisno = $("#jenisnomor").val();
                $("#availno").children().remove()
                // $("#availno").prop('disabled', true)
                console.log(jenisno);
                if (jenisno != '' && jenisno != null) {
                    $.ajax({
                        url: "{{ url('') }}/ambilnomor/" + jenisno,
                        type: 'GET',
                        datatype: 'json',
                        success: function(res) {
                            var temp = res;
                            $("#availno").empty();
                            $("#availno").append('<option selected disabled>-- Pilih Nomor --</option>');
                            var len = 0;
                            console.log(res['datano']);
                            if (res['datano'] != null) {
                                len = res['datano'].length;
                            }
                            if (len > 0) {
                                for (var i = 0; i < len; i++) {
                                    var id = res['datano'][i].id;
                                    console.log(res['datano'][i].id);
                                    var name = res['datano'][i].list_nomor;

                                    var option = '<option value="' + id + '"">' + name + '</option>';

                                    $("#availno").append(option);

                                }
                            }

                        }

                    });
                }

            }

            function noselected() {
                $('#availno').on("change", function() {
                    var value = $(this).val();
                    var text = $(this).find('option:selected').text();
                    console.log(text);
                });
                // let nopilih = $("#availno").val();
                // console.log(nopilih)
            }
        </script>
    @endpush
@endsection
