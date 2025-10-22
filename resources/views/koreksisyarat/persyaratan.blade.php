@extends('layouts.frontend.main')
<!-- @section('title', 'Pemenuhan Persyaratan') -->
@section('js')

@endsection
@section('content')
    {{--
<x-frm-jartup-fo-ter />
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
    @if (session()->has('success'))
        <div class="alert alert-success">
            Persyaratan telah dikirim harap menunggu proses verifikasi, Terimakasih.
        </div>
    @endif

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
                                <label class="col-lg col-form-label">: {{ $izin2['id_izin'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Jenis Layanan </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label text-capitalize">: {!! $izin2['jenis_layanan_html'] !!}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                            <div class="col-lg">
                                @if (!isset($izin2['submitted_at']))
                                    <td class="text-center"> - </td>
                                @else
                                    <label class="col-lg col-form-label text-capitalize">:
                                        {{ date('d F Y', strtotime($izin2['submitted_at'])) }}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Status Permohonan </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">: {{ $izin2['status_fo'] }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Section Detail Permohonan -->


    <!-- Section Detail Perusahaan -->
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
                            <label class="col-lg-4 col-form-label">NIB </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">: {{ $detailNib['nib'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Nama </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">: {{ $detailNib['nama_perseroan'] }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">NPWP </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">: {{ $detailNib['npwp_perseroan'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">No Telp </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">: {{ $detailNib['nomor_telpon_perseroan'] }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">NIK </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Nama </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">Email </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-4 col-form-label">No Telp/Mobile </label>
                            <div class="col-lg">
                                <label class="col-lg col-form-label">:
                                    {{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Section Detail Perusahaan -->



    <form id="form-koreksi" action="{{ url('/pb/submitkoreksi') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_izin" value="{{ $id_izin }}">
        <div class="card">
            <div class="card-header bg-indigo text-white header-elements-inline">
                <!-- <div class="row">
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
                                    </div> -->
                <div class="row">
                    <div class="col-lg">
                        <h6 class="card-title font-weight-semibold py-3">Form Perbaikan Persyaratan</h6>
                    </div>
                </div>
                @php
                    $i = 0;
                    $group = '';
                @endphp
            </div>

            <div class="card-body">
                @foreach ($datasyaratpdf as $syarat)
                    <div style="background: #fafafa;border-right: 1px solid #ddd;border-left: 1px solid #ddd;">
                        @if ($group != $syarat->group_by)
                            <div class="bg-info text-white">
                                <h4 class="m-0 p-2 h6"> {{ $syarat->group_by ? $syarat->group_by : ' Syarat Lainnya' }}
                                </h4>
                            </div>
                        @endif
                        @php
                            $group = $syarat->group_by;
                        @endphp
                        <div class="px-2" style="border-bottom: 1px solid #ddd;padding-top: 15px;padding-bottom: 15px;">
                            <div class="form-group mb-0">
                                {{-- <div class="form-label mb-2 font-weight-bold">
                                    {!! $syarat->persyaratan_html !!}
                                </div> --}}
                                @if ($syarat->file_type == 'table' && $syarat->component_name != null)
                                    @if(isset($syarat->filled_document))
                                    
                                    <div class="form-label mb-2 font-weight-bold">
                                        {!! $syarat->persyaratan_html !!}
                                    </div>
                                    <x-dynamic-component :triger="null" :component="$syarat->component_name" :datajson="$syarat->filled_document"
                                        :needcorrection="$syarat->need_correction ?? false" :correctionnote="$syarat->correction_note || ''" />
                                    @if (Illuminate\Support\Str::is('rencanausaha*', $syarat->component_name))
                                        <input type="hidden" name="id_maplist_rencanausaha"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif

                                    @if (Illuminate\Support\Str::is('daftar_perangkat*', $syarat->component_name))
                                        <input type="hidden" name="id_maplist_daftar_perangkat"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif
                                    @if ($syarat->component_name == 'komitmen_kinerja_layanan_lima_tahun')
                                        <input type="hidden" name="id_maplist_komitmen_kinerja_layanan_lima_tahun"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif
                                    @if (Illuminate\Support\Str::is('roll_out_plan*', $syarat->component_name))
                                        <input type="hidden" name="id_maplist_roll_out_plan"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif
                                    @if ($syarat->component_name == 'cakupanwilayahtelsus_skrd')
                                        <input type="hidden" name="id_maplist_cakupanwilayahtelsus_skrd"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif
                                    @if ($syarat->component_name == 'cakupanwilayahtelsus_mtk')
                                        <input type="hidden" name="id_maplist_cakupanwilayahtelsus_mtk"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif
                                    @if ($syarat->component_name == 'cakupanwilayahtelsus_skrk')
                                        <input type="hidden" name="id_maplist_cakupanwilayahtelsus_skrk"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif
                                    @if ($syarat->component_name == 'cakupanwilayahtelsus_skrt')
                                        <input type="hidden" name="id_maplist_cakupanwilayahtelsus_skrt"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif
                                    @if ($syarat->component_name == 'cakupanwilayahtelsus_sks')
                                        <input type="hidden" name="id_maplist_cakupanwilayahtelsus_sks"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif
                                    @if (Illuminate\Support\Str::is('cakupanwilayahtelsus_sks', $syarat->component_name))
                                        <input type="hidden" name="id_maplist_cakupanwilayahtelsus_sks_2"
                                            value="{{ $syarat->id_maplist }}">
                                    @endif
                                    @if ($syarat->need_correction == '1')
                                        <label for="" class="mb-0 mt-1 text-danger font-weight-bold">Pesan
                                            Perbaikan</label>
                                        <textarea type="text" class="form-control" value="{{ $syarat->correction_note }}" disabled>{{ $syarat->correction_note }}</textarea>
                                    @endif
                                    @if ($syarat->is_mandatory)
                                        <small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
                                        <small for="" class="text-danger">*Maksimum File : 5Mb</small>
                                    @else
                                        <label for="" class="text-success">(Opsional)</label>
                                    @endif
                                    
                                    @if ($syarat->download_link != null && $syarat->download_link != '')
                                        <small>Download Lampiran Template <a target="_blank"
                                                href="{{ $syarat->download_link }}">Disini</a></small>
                                    @endif
                                    @endif
                                    
                                @else
                                    <div class="form-label mb-2 font-weight-bold">
                                        {!! $syarat->persyaratan_html !!}
                                    </div>
                                    @if ($syarat->need_correction == '1')
                                        <input type="hidden" name="persyaratan[{{ $i }}]"
                                            value="{{ $syarat->persyaratan }}">
                                        <input type="hidden" name="id_maplist[{{ $i }}]"
                                            value="{{ $syarat->id_maplist }}">
                                        <input type="file" accept="application/pdf" class="form-control"
                                            name="syarat[{{ $i }}]" id="syarat_{{ $i }}"
                                            {{ $syarat->is_mandatory ? 'required' : '' }}>
                                        <label for="" class="mb-0 mt-1 text-danger font-weight-bold">Catatan Hasil
                                            Evaluasi</label>
                                        <textarea type="text" class="form-control" value="{{ $syarat->correction_note }}" disabled>{{ $syarat->correction_note }}</textarea>
                                        {{-- <p>klik <a href="{{ $syarat->filled_document }}">disini</a> untuk download
                                            file</p> --}}
                                        @if ($syarat->is_mandatory)
                                            <small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
                                            <small for="" class="text-danger">*Maksimum File : 5Mb</small>
                                        @else
                                            <label for="" class="text-success">(Opsional)</label>
                                        @endif
                                        @if ($syarat->download_link != null && $syarat->download_link != '')
                                            <small>Download Lampiran Template <a target="_blank"
                                                    href="{{ $syarat->download_link ? $syarat->download_link : '' }}">Disini</a></small>
                                        @endif
                                    @else
                                        @if (!isset($syarat->nama_file_asli))
                                            <input type="hidden" name="persyaratan[{{ $i }}]"
                                                value="{{ $syarat->persyaratan }}">
                                            <input type="hidden" name="id_maplist[{{ $i }}]"
                                                value="{{ $syarat->id_maplist }}">
                                            <input type="file" accept="application/pdf" class="form-control"
                                                name="syarat[{{ $i }}]" id="syarat_{{ $i }}"
                                                {{ $syarat->is_mandatory ? 'required' : '' }}>
                                            <label for="" class="mb-0 mt-1 text-danger font-weight-bold">Catatan Hasil
                                                Evaluasi</label>
                                            <textarea type="text" class="form-control" value="Mohon Upload Ulang Dokumen" disabled>Mohon Upload Ulang Dokumen</textarea>
                                            {{-- <p>klik <a href="{{ $syarat->filled_document }}">disini</a> untuk download
                                                file</p> --}}
                                            @if ($syarat->is_mandatory)
                                                <small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
                                                <small for="" class="text-danger">*Maksimum File : 5Mb</small>
                                            @else
                                                <label for="" class="text-success">(Opsional)</label>
                                            @endif
                                            @if ($syarat->download_link != null && $syarat->download_link != '')
                                                <small>Download Lampiran Template <a target="_blank"
                                                        href="{{ $syarat->download_link ? $syarat->download_link : '' }}">Disini</a></small>
                                            @endif
                                        @else
                                            <input type="text" class="form-control" name="syarat[{{ $i }}]"
                                            id="syarat_[{{ $i }}]" value="{{ $syarat->nama_file_asli }}"
                                            disabled >
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    </div>
                @endforeach
            </div>
        </div>
        <div class="text-right">
            <a type="button" href="/" class="btn btn-indigo mr-1"><i class="icon-backward2 ml-2"></i> Kembali</a>
            <button type="button" class="btn btn-secondary float-right" onclick="onSubmit()">Kirim Perbaikan Persyaratan
                <i class="icon-paperplane ml-2"></i></button>
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
                    <p>Apakah anda yakin persyaratan yang anda koreksi sudah sesuai ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="submitkoreksi();return false;"
                        class="btn btn-primary notif-button">Kirim</button>
                    <div class="spinner-border loading text-primary" role="status" hidden>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function onSubmit() {
            if ($("#form-koreksi")[0].checkValidity()) {
                $('#submitModal').modal('show');
            } else {
                $('#form-koreksi :input[required="required"]').each(function() {
                    if (!this.validity.valid) {
                        $(this).focus();
                        return false;
                    }
                });
            }
            return false;
        }

        function submitkoreksi() {
            // $('#form-koreksi').submit();
            // $('.notif-button').attr("hidden",true);
            // $('.loading').attr("hidden",false);	
            // console.log('ok')
            // sampe sini dlu
            $('.notif-button').attr("hidden", true);
            $('.loading').attr("hidden", false);
            if ($('#form-koreksi')[0].checkValidity()) {
                $('#form-koreksi').submit();
            }
        }

        $(document).on('click', '.btn-delete-removeperangkat', function() {
            $(this).find('.lokasi_perangkat').attr('name', 'daftar_perangkat[' + index + '][lokasi_perangkat]')
                .remove();
            $(this).find('.jenis_perangkat').attr('name', 'daftar_perangkat[' + index + '][jenis_perangkat]')
                .remove();
            $(this).find('.merk_perangkat').attr('name', 'daftar_perangkat[' + index + '][merk_perangkat]')
                .remove();
            $(this).find('.tipe_perangkat').attr('name', 'daftar_perangkat[' + index + '][tipe_perangkat]')
                .remove();
            $(this).find('.buatan_perangkat').attr('name', 'daftar_perangkat[' + index + '][buatan_perangkat]')
                .remove();
            $(this).find('.sn_perangkat').attr('name', 'daftar_perangkat[' + index + '][sn_perangkat]').remove();
            $(this).find('.sertifikat_perangkat').attr('name', 'daftar_perangkat[' + index +
                '][sertifikat_perangkat]').remove();
            $(this).find('.foto_perangkat').attr('name', 'daftar_perangkat[' + index + '][foto_perangkat]')
                .remove();
            $(this).find('.foto_sn_perangkat').attr('name', 'daftar_perangkat[' + index +
                '][foto_sn_perangkat]').remove();
        });

        function removeperangkat(index) {
            $(this).find('.lokasi_perangkat').attr('name', 'daftar_perangkat[' + index + '][lokasi_perangkat]').remove();
            $(this).find('.jenis_perangkat').attr('name', 'daftar_perangkat[' + index + '][jenis_perangkat]').remove();
            $(this).find('.merk_perangkat').attr('name', 'daftar_perangkat[' + index + '][merk_perangkat]').remove();
            $(this).find('.tipe_perangkat').attr('name', 'daftar_perangkat[' + index + '][tipe_perangkat]').remove();
            $(this).find('.buatan_perangkat').attr('name', 'daftar_perangkat[' + index + '][buatan_perangkat]').remove();
            $(this).find('.sn_perangkat').attr('name', 'daftar_perangkat[' + index + '][sn_perangkat]').remove();
            $(this).find('.sertifikat_perangkat').attr('name', 'daftar_perangkat[' + index +
                '][sertifikat_perangkat]').remove();
            $(this).find('.foto_perangkat').attr('name', 'daftar_perangkat[' + index + '][foto_perangkat]').remove();
            $(this).find('.foto_sn_perangkat').attr('name', 'daftar_perangkat[' + index +
                '][foto_sn_perangkat]').remove();

        }
    </script>

@endsection
