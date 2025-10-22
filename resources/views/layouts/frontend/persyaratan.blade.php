@extends('layouts.frontend.main')
<!-- @section('title', 'Pemenuhan Persyaratan') -->
@section('js')

@endsection
@section('content')
    <x-frm-jartup-fo-ter />
    <x-frm-komittahun />
    <x-frm-kinerjalayanan />
    <x-frm-dataalatperangkat />
    <x-frm-jar-persyaratan />

    <a href="{{ route('/') }}" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i> Kembali </a>
    <button type="submit" class="btn btn-secondary float-right">Proses Permohonan Persyaratan <i
            class="icon-paperplane ml-2"></i></button>

    <div id="modal_theme_primary" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-indigo text-white justify-content-center">
                    <h6 class="modal-title self-align-center"> PERNYATAAN KESANGGUPAN PEMENUHAN PERSYARATAN <br /> LAYANAN
                        IZIN PENYELENGGARAAN JASA TELEKOMUNIKASI</h6>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <div class="form-group text-center row">
                            <label class="col-form-label">Dengan ini saya menyatakan bahwa seluruh data yang disampaikan
                                dalam SURAT PERNYATAAN adalah BENAR dan VALID. Jika dikemudian hari data yang disampaikan
                                terbukti tidak benar, maka kami siap menerima akibat hukum sesuai dengan ketentuan
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
                    </div>
                </div>

                <div class="modal-footer float-right">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-secondary">Kirim Persyaratan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
