@extends('layouts.frontend.main')
<!-- @section('title', 'Penilaian Mandiri') -->
@section('js')

@endsection
@section('content')
    <form id="form-mandiri" action="{{ url('/ulo/submitmandiri') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <hr>
                    Form Penilaian Mandiri
                <hr>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset>
                                <input type="hidden" name="id_izin" value="{{ $id_izin }}">
                                <input type="hidden" name="nama_master_izin" value="{{$izin['nama_master_izin']}}">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Surat Tugas Pelaksanaan ULO Mandiri<span class="text-danger">*</span> <span class="text-danger" data-toggle="tooltip" data-placement="top" title="Pastikan upload dokumen sebelum tanggal pelaksanaan ulo"><i class="icon-question3"></i></span></label>
                                    <div class="col-lg-3">
                                        <input type="file" name="stp_ulo_mandiri" id=""  accept="application/pdf">
                                        <input type="hidden" name="status" value="20">
                                        <span class="text-danger">Maksimum File: 5Mb</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Hasil Pengujian ULO Mandiri<span class="text-danger">*</span> <span class="text-danger" data-toggle="tooltip" data-placement="top" title="Pastikan upload dokumen sebelum tanggal pelaksanaan ulo"><i class="icon-question3"></i></span></label>
                                    <div class="col-lg-3">
                                        <input type="file" name="hp_ulo_mandiri" id=""  accept="application/pdf">
                                        <span class="text-danger">Maksimum File: 5Mb</span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
       <div class="text-right">
            <a href="{{ URL::previous() }}" class="btn btn-indigo"><i class="icon-backward2 ml-2"></i> Kembali </a>
            <button type="submit" class="btn btn-secondary " onclick="return false;" data-toggle="modal" data-target="#submitModal">
                Kirim Permohonan
            <i class="icon-paperplane ml-2"></i></button>
        </div>
    </form>

    <div class="modal" id="submitModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Uji Laik Operasi Mandiri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin permohonan yang akan dikirim sudah sesuai?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                <button type="button" onclick="submitulo();return false;" class="btn btn-primary notif-button">Kirim</button>
                <div class="spinner-border loading text-primary" role="status" hidden>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            </div>
        </div>
    </div>

@endsection
@section('custom-js')
<script>

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function submitulo(){
        $('.notif-button').attr("hidden",true);
		$('.loading').attr("hidden",false);
        $('#form-mandiri').submit();
    }
</script>
@endsection
