@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
@endsection
@section('content')
    <div class="form-group">

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
                                <label class="col-lg-4 col-form-label">NIB : </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">{{ $detailnib['nib'] }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Nama: </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">{{ $detailnib['nama_perseroan'] }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">NPWP : </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">{{ $detailnib['npwp_perseroan'] }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">No Telp: </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">{{ $detailnib['nomor_telpon_perseroan'] }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">NIK : </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">NIK </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Nama : </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">Nama </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Email: </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">No Telp/Mobile : </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">No Telp/Mobile</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

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
                                <label class="col-lg-4 col-form-label">No Permohonan : </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">No Permohonan</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Jenis Permohonan: </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">Jenis Permohonan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Tanggal Permohonan : </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">Tanggal Permohonan</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Status Permohonan: </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">Status Permohonan</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Kode Akses : </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">Kode Akses</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Kode Wilayah : </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">Kode Wilayah</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Nomor Yang Diajukan: </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">Nomor Yang Diajukan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="card">
            <div class="card-header bg-indigo text-white header-elements-inline">
                <div class="row">
                    <div class="col-lg">
                        <h6 class="card-title font-weight-semibold py-3">Catatan Evaluasi </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" id="formEvaluasi" action="{{ route('admin.direktur.evaluasipost', $id) }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <fieldset>

                                <div class="form-group row">
                                    <textarea rows="3" cols="3" class="form-control" name="catatan_evaluasi"
                                        placeholder="Catatan Evaluasi"></textarea>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="text-right">
                        {{-- <button type="button" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i> Kembali </button> --}}
                        <a href="{{ URL::previous() }}" class="btn btn-secondary border-transparent"><i
                                class="icon-backward2 ml-2"></i> Kembali </a>
                        <a target="_blank" href="{{ route('admin.historyperizinan', $izin['id_izin']) }}"
                            class="btn btn-info">Riwayat Permohonan <i class="icon-history ml-2"></i></a>
                        <button type="button" class="btn btn-success">Draf Lampiran <i
                                class="icon-file-pdf ml-2"></i></button>
                        <button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModal"
                            class="btn btn-indigo">Kirim Hasil Evaluasi <i class="icon-paperplane ml-2"></i></button>
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
                    <p>Apakah anda yakin akan menyetujui Permohonan Penomoran ini ?</p>
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
@endsection
<script>
    $(document).ready(function() {

    })

    function submitdisposisi() {
        $('.notif-button').attr("hidden", true);
        $('.loading').attr("hidden", false);
        $('#formEvaluasi').submit();
    }
</script>
