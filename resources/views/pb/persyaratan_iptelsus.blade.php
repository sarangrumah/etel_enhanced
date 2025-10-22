@extends('layouts.frontend.main')
@section('js')
@endsection

@section('content')
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
            Persyaratan telah dikirim harap menunggu proses verifikasi, Terima kasih.
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
                                <label class="col-lg col-form-label">:
                                    @if ($izin2['tgl_izin'] == null)
                                        {{ $date_reformat->dateday_lang_reformat_long($datenow) }}
                                    @else
                                        {{ $date_reformat->dateday_lang_reformat_long($izin2['tgl_izin']) }}
                                    @endif

                                </label>
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

    <form id="form-persyaratan" action="{{ url('/pb/submitpersyarataniptelsus') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        {{-- <input type="hidden" name="id_izin" value="{{ $id_izin }}"> --}}
        <div class="card">
            <div class="card-header bg-indigo text-white header-elements-inline">
                <div class="row">
                    <div class="col-lg">
                        <h6 class="card-title font-weight-semibold py-3">Form Persyaratan</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div style="background: #fafafa;border-right: 1px solid #ddd;border-left: 1px solid #ddd;">
                    <div class="bg-info text-white">
                        <h4 class="m-0 p-2 h6"> {{ $syarat->group_by ? $syarat->group_by : ' Syarat Lainnya' }}</h4>
                    </div>
                </div>

                <<<<<<< HEAD @foreach ($datasyaratpdf as $keys => $syarat)
                    <div style="background: #fafafa;border-right: 1px solid #ddd;border-left: 1px solid #ddd;">
                        @if ($group != $syarat->group_by)
                            <div class="bg-info text-white">
                                <h4 class="m-0 p-2 h6"> {{ $syarat->group_by ? $syarat->group_by : ' Syarat Lainnya' }}
                                </h4>
                            </div>
                        @endif
                        =======
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
                                                    <label class="col-lg col-form-label">:
                                                        {{ $detailNib['nama_perseroan'] }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <label class="col-lg-4 col-form-label">NPWP </label>
                                                <div class="col-lg">
                                                    <label class="col-lg col-form-label">:
                                                        {{ $detailNib['npwp_perseroan'] }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <label class="col-lg-4 col-form-label">No Telp </label>
                                                <div class="col-lg">
                                                    <label class="col-lg col-form-label">:
                                                        {{ $detailNib['nomor_telpon_perseroan'] }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab
                                    </legend>
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

                        <form id="form-persyaratan" action="{{ url('/pb/submitpersyarataniptelsus') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- <input type="hidden" name="id_izin" value="{{ $id_izin }}"> --}}
                            <div class="card">
                                <div class="card-header bg-indigo text-white header-elements-inline">
                                    <div class="row">
                                        <div class="col-lg">
                                            <h6 class="card-title font-weight-semibold py-3">Form Persyaratan</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div
                                        style="background: #fafafa;border-right: 1px solid #ddd;border-left: 1px solid #ddd;">
                                        <div class="bg-info text-white">
                                            <h4 class="m-0 p-2 h6">
                                                {{ $syarat->group_by ? $syarat->group_by : ' Syarat Lainnya' }}</h4>
                                        </div>
                                    </div>

                                    @foreach ($datasyaratpdf as $keys => $syarat)
                                        <div
                                            style="background: #fafafa;border-right: 1px solid #ddd;border-left: 1px solid #ddd;">
                                            @if ($group != $syarat->group_by)
                                                <div class="bg-info text-white">
                                                    <h4 class="m-0 p-2 h6">
                                                        {{ $syarat->group_by ? $syarat->group_by : ' Syarat Lainnya' }}
                                                    </h4>
                                                </div>
                                            @endif
                                            @php
                                                $group = $syarat->group_by;
                                            @endphp
                                            <div class="px-2"
                                                style="border-bottom: 1px solid #ddd;padding-top: 15px;padding-bottom: 15px;">
                                                <div class="form-group mb-0">
                                                    <div class="form-label mb-2 font-weight-bold">
                                                        {!! $syarat->persyaratan_html !!}
                                                    </div>
                                                    @if ($syarat->file_type == 'pdf')
                                                        <input type="hidden" name="persyaratan[{{ $keys }}]"
                                                            value="{{ $syarat->persyaratan }}">
                                                        <input type="hidden" name="id_maplist[{{ $keys }}]"
                                                            value="{{ $syarat->id_maplist }}">
                                                        <input type="hidden" name="id_syarat[{{ $keys }}]"
                                                            value="{{ $syarat->file_type }}">
                                                        <input type="file" name="syarat[{{ $keys }}]"
                                                            accept="application/pdf" class="form-control"
                                                            id="syarat_{{ $keys }}"
                                                            {{ $syarat->is_mandatory ? 'required' : '' }}>

                                                        @if ($syarat->is_mandatory)
                                                            <small for="" class="text-danger mr-2">*Wajib Diisi
                                                                Format PDF</small>
                                                            <small for="" class="text-danger">*Maksimum File :
                                                                5Mb</small>
                                                        @else
                                                            <label for="" class="text-success">(Opsional)</label>
                                                        @endif
                                                        @if ($syarat->download_link != null && $syarat->download_link != '')
                                                            <small>Download Lampiran Template <a target="_blank"
                                                                    href="{{ $syarat->download_link }}">Disini</a></small>
                                                        @endif
                                                    @elseif($syarat->file_type == 'integration')
                                                        <div class="integration">
                                                            <div class="input-group">
                                                                <div class="input-group-icon"><i class="icon-cross"></i>
                                                                </div>
                                                                <div class="input-group-area"><input type="text"
                                                                        placeholder="Masukan Nomor NIB"
                                                                        data-type="{{ $syarat->persyaratan }}"
                                                                        name="persyaratan[{{ $keys }}]"
                                                                        value="">
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <button class="btn btn-success verify">Verify</button>
                                                        </div>
                                                    @else
                                                        >>>>>>> 65683d0e4321556515821f35e7b8097173835145
                                                        @php
                                                            $group = $syarat->group_by;
                                                        @endphp
                                                        <div class="px-2"
                                                            style="border-bottom: 1px solid #ddd;padding-top: 15px;padding-bottom: 15px;">
                                                            <div class="form-group mb-0">
                                                                <div class="form-label mb-2 font-weight-bold">
                                                                    {!! $syarat->persyaratan_html !!}
                                                                </div>
                                                                @if ($syarat->file_type == 'pdf')
                                                                    <input type="hidden"
                                                                        name="persyaratan[{{ $keys }}]"
                                                                        value="{{ $syarat->persyaratan }}">
                                                                    <input type="hidden"
                                                                        name="id_maplist[{{ $keys }}]"
                                                                        value="{{ $syarat->id_maplist }}">
                                                                    <input type="hidden"
                                                                        name="id_syarat[{{ $keys }}]"
                                                                        value="{{ $syarat->file_type }}">
                                                                    <input type="file"
                                                                        name="syarat[{{ $keys }}]"
                                                                        accept="application/pdf" class="form-control"
                                                                        id="syarat_{{ $keys }}"
                                                                        {{ $syarat->is_mandatory ? 'required' : '' }}>

                                                                    @if ($syarat->is_mandatory)
                                                                        <small for=""
                                                                            class="text-danger mr-2">*Wajib Diisi Format
                                                                            PDF</small>
                                                                        <small for=""
                                                                            class="text-danger">*Maksimum File :
                                                                            5Mb</small>
                                                                    @else
                                                                        <label for=""
                                                                            class="text-success">(Opsional)</label>
                                                                    @endif
                                                                    @if ($syarat->download_link != null && $syarat->download_link != '')
                                                                        <small>Download Lampiran Template <a
                                                                                target="_blank"
                                                                                href="{{ $syarat->download_link }}">Disini</a></small>
                                                                    @endif
                                                                @else
                                                                    @php
                                                                        $datajson = 'kosong';
                                                                    @endphp


                                                                    <x-dynamic-component :triger="null" :component="$syarat->component_name"
                                                                        :datajson="$datajson" :needcorrection="false" />
                                                                    {{-- <input type="hidden" name="id_maplist_rencanausaha" value="{{ $syarat->id_maplist }}"> --}}

                                                                    @if (Illuminate\Support\Str::is('cakupanwilayahtelsus_mtk', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_cakupanwilayahtelsus_mtk"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif
                                                                    @if (Illuminate\Support\Str::is('cakupanwilayahtelsus_skrd', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_cakupanwilayahtelsus_skrd"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif
                                                                    @if (Illuminate\Support\Str::is('cakupanwilayahtelsus_skrk', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_cakupanwilayahtelsus_skrk"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif
                                                                    @if (Illuminate\Support\Str::is('cakupanwilayahtelsus_skrt', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_cakupanwilayahtelsus_skrt"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif
                                                                    @if (Illuminate\Support\Str::is('cakupanwilayahtelsus_sks', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_cakupanwilayahtelsus_sks"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif

                                                                    @if (Illuminate\Support\Str::is('rencanausaha*', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_rencanausaha"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif
                                                                    @if (Illuminate\Support\Str::is('daftar_perangkat*', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_daftar_perangkat"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif
                                                                    @if (Illuminate\Support\Str::is('daftar_perangkat_telsus*', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_daftar_perangkat_telsus"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif
                                                                    @if (Illuminate\Support\Str::is('daftar_ket_konfigurasiteknis*', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_daftar_ket_konfigurasiteknis"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif
                                                                    @if ($syarat->component_name === 'komitmen_kinerja_layanan_lima_tahun')
                                                                        <input type="hidden"
                                                                            name="id_maplist_komitmen_kinerja_layanan_lima_tahun"
                                                                            value="{{ $syarat->id_maplist }}">
                                                                    @endif
                                                                    @if (Illuminate\Support\Str::is('roll_out_plan*', $syarat->component_name))
                                                                        <input type="hidden"
                                                                            name="id_maplist_roll_out_plan"
                                                                            value="{{ $syarat->id_maplist }}">
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

                            <?php
                            if ($izin2['nama_master_izin'] == 'JASA') {
                                $url = 'pb/permohonan/jasa';
                            } elseif ($izin2['nama_master_izin'] == 'JARINGAN') {
                                $url = 'pb/permohonan/jaringan';
                            } elseif ($izin2['nama_master_izin'] == 'TELSUS') {
                                $url = 'pb/permohonan/telsus';
                            } elseif ($izin2['nama_master_izin'] == 'TELSUS_INSTANSI') {
                                $url = 'pb/permohonan/telsus_instansi';
                            }
                            ?>
                            <div class="text-right">
                                <a href="{{ url($url) }}" class="btn btn-indigo mr-1"><i
                                        class="icon-backward2 ml-2"></i> Kembali </a>

                                {{-- <button type="submit" class="btn btn-secondary float-right" onclick="return false;" data-toggle="modal"
            data-target="#submitModal">Permohonan Persyaratan <i class="icon-paperplane ml-2"></i></button> --}}
                                <button type="button" class="btn btn-secondary float-right"
                                    onclick="onSubmit()">Permohonan Persyaratan <i
                                        class="icon-paperplane ml-2"></i></button>

                            </div>
                        </form>
                        <!-- End Section Detail Perusahaan -->
                        <script>
                            $("button.verify").click(function(e) {
                                let integration = $(this).parents('.integration')
                                let type = integration.find('input').data('type')
                                let endpointToken
                                let uname
                                let pass
                                let endpoint
                                let method = 'GET'

                                if (type == 'ISR') {
                                    endpointToken = "https://dev-middleware.ditfrek.postel.go.id/middleware_sdppi/get_token"
                                    uname = "telecomunication"
                                    pass = "tele324"
                                    endpoint = "https://dev-middleware.ditfrek.postel.go.id/middleware_sdppi/isr_telecomunication/index"
                                } else {
                                    endpointToken = "/api/v1/get-token"
                                    endpoint = "/api/v1/izin-terbit"
                                }

                                let val = integration.find('input').val()
                                let token
                                e.preventDefault();
                                $.ajax({
                                    type: method,
                                    url: endpointToken,
                                    dataType: "json",
                                    data: {
                                        username: uname, // < note use of 'this' here
                                        password: pass, // < note use of 'this' here
                                    },
                                    async: false,
                                    success: function(result) {
                                        token = result.tokens
                                    },
                                    error: function(error) {
                                        // alert(error)
                                    }
                                });
                                $.ajax({
                                    type: "GET",
                                    url: endpoint,
                                    dataType: "json",
                                    headers: {
                                        "Authorization": "Bearer " + token
                                    },
                                    data: {
                                        search: val
                                    },
                                    success: function(result) {
                                        // alert(JSON.stringify(result));
                                        if (result.data) {
                                            alert(type + ' Ditemukan!')
                                            integration.find('i').removeClass('icon-cross')
                                            integration.find('i').addClass('icon-check')
                                            integration.find('input').attr('readonly', true)
                                            integration.find('button').attr('disabled', true)
                                        } else {
                                            alert('ISR Tidak Ditemukan!')
                                            integration.find('i').addClass('icon-cross')
                                            integration.find('i').removeClass('icon-check')
                                            integration.find('input').removeAttr('readonly')
                                            integration.find('button').removeAttr('disabled')
                                        }
                                    },
                                    error: function(error) {
                                        alert(error)
                                    }
                                });
                            });
                        </script>
                    @endsection
