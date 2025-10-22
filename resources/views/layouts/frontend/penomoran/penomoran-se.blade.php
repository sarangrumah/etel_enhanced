@extends('layouts.frontend.main')
<!-- @section('title', 'Permohonan Penyesuaian Penomoran') -->
@section('js')

<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="global_assets/js/demo_pages/form_layouts.js"></script>

@endsection
@section('content')
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
                            <label class="col-lg col-form-label">: {{ $id_izin }}</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                        <div class="col-lg">
                            <label class="col-lg col-form-label">:
                                {{ isset($data->full_name) ? $data->full_name : '' }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <div class="row">
                        <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                        <div class="col-lg">
                            @if ($data->updated_date == null)
                            <label class="col-lg col-form-label">: - </label>
                            @else
                            <label class="col-lg col-form-label">:
                                {{ Carbon\Carbon::parse($data->updated_date)->isoFormat('D MMMM Y') }}</label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <label class="col-lg-4 col-form-label">Status Permohonan </label>
                        <div class="col-lg">
                            <label class="col-lg col-form-label">:
                                Permohonan Penyesuaian
                            </label>
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
                <h6 class="card-title font-weight-semibold py-3">Penyesuaian Penomoran</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ url('penomoran/savepenyesuaian') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <fieldset>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Dokumen Penetapan Penomoran yang disesuaikan<span
                                    class="text-danger">*</span>: </label>
                            <div class="col-lg-8">
                                <input type="file" class="form-control h-auto required" required
                                    accept="application/pdf" name="sk">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Dokumen Perizinan terakhir<span
                                    class="text-danger">*</span>:
                            </label>
                            <div class="col-lg-8">
                                <input type="file" class="form-control h-auto" accept="application/pdf" required
                                    name="izin_akhir">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Dokumen pendukung lainnya:
                            </label>
                            <div class="col-lg-8">
                                <input type="file" class="form-control h-auto" accept="application/pdf" required
                                    name="pendukung">
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
                                    <input type="checkbox" class="custom-control-input" checked required>
                                    <span class="custom-control-label">YA, Saya Setuju.</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <input type="hidden" name="id_proyek" value="{{ $id_proyek }}">
            <input type="hidden" name="id_izin" value="{{ $id_izin }}">
            <input type="hidden" name="id_trx" value="{{ $id_trx }}">
            <div class="text-right">
                <button onclick="history.back()" class="btn btn-light"><i class="icon-backward2 ml-2"></i> Kembali
                </button>
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