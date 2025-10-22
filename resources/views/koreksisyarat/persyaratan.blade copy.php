@extends('layouts.frontend.main')
<!-- @section('title', 'Pemenuhan Persyaratan') -->
@section('js')

@endsection
@section('content')
{{-- <x-frm-jartup-fo-ter />
    <x-frm-komittahun />
    <x-frm-kinerjalayanan />
    <x-frm-dataalatperangkat />
    <x-frm-jar-persyaratan /> --}}
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Sorry!</strong> There were more problems with your HTML input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(session()->has('success'))
<div class="alert alert-success">
    Persyaratan telah dikirim harap menunggu proses verifikasi, Terima kasih.
</div>
@endif
<form action="{{ url('/pb/submitpersyaratan') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_izin" value="{{ $id_izin }}">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table>
                        <tr>
                            <td>Kode Izin</td>
                            <td> : </td>
                            <td> {{ $izin->kd_izin }} </td>
                        </tr>
                        <tr>
                            <td>Nama Izin</td>
                            <td> : </td>
                            <td> {{ $izin->nama_izin }} </td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>
            Form Pesrsyaratan
            <hr>
            @php
            $i = 0;
            @endphp
            <table class="table table-striped">
                <tbody>
                    @foreach ($datasyaratpdf as $syarat)
                    <tr>
                        <td>
                            {{ $syarat->persyaratan }}
                        </td>
                        <td>
                            :
                        </td>
                        <td class="col-7">
                            <input type="hidden" name="persyaratan[{{ $i }}]" value="{{ $syarat->persyaratan }}">
                            @if ($syarat->file_type == 'text')
                            <input type="text" name="syarat[{{ $i }}" id="" class="form-control">
                            @elseif($syarat->file_type == 'textarea')
                            <textarea rows="5" cols="5" class="form-control" placeholder=""></textarea>
                            @elseif($syarat->file_type == 'pdf')
                            <input type="file"  accept="application/pdf" class="form-control" name="syarat[{{ $i }}]" id="syarat_{{$i}}" {{ ($syarat->is_mandatory)?'required':'' }}>
                            @if ($syarat->download_link != null && $syarat->download_link != '')
                            {{-- Download Lampiran Template <a target="_blank" href="{{ url("/download/syarat/lampiran/$syarat->id") }}">Disini</a> --}}
                            Download Lampiran Template <a target="_blank" href="{{ $syarat->download_link }}">Disini</a>
                            @endif
                            @elseif($syarat->file_type == 'template')
                            <x-frm-komittahun />
                            @endif
                        </td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <div class="text-right">
        <button type="button" onclick="history.back()" class="btn btn-indigo"><i class="icon-backward2 ml-2"></i> Kembali</button>
        <button type="submit" class="btn btn-secondary float-right">Proses Permohonan Persyaratan <i class="icon-paperplane ml-2"></i></button>
    </div>
    

</form>

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