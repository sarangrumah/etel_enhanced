@extends('layouts.frontend.main')
@section('js')
<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
<script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
<form>
    <div class="form-group">
        <!-- Section Detail Permohonan -->
        <div>
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Status Tanda Tangan </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Ditandatangani oleh</label>
                                <div class="col-lg">
                                    <!-- <label class="col-lg col-form-label">: {{ $izin['id_izin'] }}</label> -->
                                    @if ($datavalidasi->status_ulo != '50')
                                    <label class="col-lg col-form-label">: - </label>
                                    @else
                                    <label class="col-lg col-form-label">:
                                        Aju Widya Sari</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Ditandatangani pada </label>
                                <div class="col-lg">
                                    @if ($datavalidasi->tgl_berlaku_ulo == null)
                                    <label class="col-lg col-form-label">: - </label>
                                    @else
                                    <label class="col-lg col-form-label">:
                                        {{ $date_reformat->dateday_lang_reformat_long($datavalidasi->tgl_berlaku_ulo) }}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Status Permohonan </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">: {{ $izin2['status_bo'] }}</label>
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
                            <h6 class="card-title font-weight-semibold py-3">Informasi Dokumen </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Validasi Surat Ketetapan</legend>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg">
                                    @if ($datavalidasi->status_pemenuhan_check == 1)
                                    <label class="col-lg col-form-label"> <i class="icon-file-check mr-2"></i> {{ $datavalidasi->status_pemenuhan }}</label>
                                    @else
                                    <label class="col-lg col-form-label"> <i class="icon-stack-cancel mr-2"></i> {{ $datavalidasi->status_pemenuhan }}</label>


                                    @endif

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg">
                                    @if ($datavalidasi->status_ulo_vw_checked == 1)
                                    <label class="col-lg col-form-label"><i class="icon-file-check mr-2"></i> {{ $datavalidasi->status_ulo_vw }}</label>
                                    @else
                                    <label class="col-lg col-form-label"><i class="icon-stack-cancel mr-2"></i> {{ $datavalidasi->status_ulo_vw }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg">
                                    @if ($datavalidasi->tgl_berlaku_ulo == null)
                                    <label class="col-lg col-form-label"><i class="icon-stack-cancel mr-2"></i> Sertifikat tidak valid.</label>
                                    @else
                                    <label class="col-lg col-form-label"><i class="icon-file-check mr-2"></i> Sertifikat valid.</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">

                        </div>
                    </div>
                    <legend class="text-uppercase font-size-sm font-weight-bold">Informasi Permohonan Penyelenggaraan
                        Izin</legend>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">No. Permohonan Izin </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">:
                                        {{ isset($datavalidasi->id_izin) ? $datavalidasi->id_izin : '-' }}
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Nama Badan Hukum / Instansi </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">:
                                        {{ isset($detailNib['nama_perseroan']) ? $detailNib['nama_perseroan'] : '-' }}
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Pemohon </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">:
                                        {{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-lg-4 col-form-label">KBLI </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">:
                                        {{ isset($izin2['kbli']) ? $izin2['kbli'] : '-' }} - {{ isset($izin2['kbli_name']) ? $izin2['kbli_name'] : '-' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Jenis Layanan </label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">:
                                        {{ isset($izin2['jenis_layanan']) ? $izin2['jenis_layanan'] : '-' }}</label>
                                </div>
                            </div>
                            <div style="text-align: center">Tabel Komitmen Kewajiban Pembangunan dan/atau Penyediaan</div>
                            <br />{{ $mst_kode_izin->name }}<br />
                            @foreach ($map_izin_perubahan as $mi)
                                @if ($mi->component_name == 'roll_out_plan_jartup_fo_ter')
                                    <table class="table table-custom table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Periode</th>
                                                <th style="text-align: center;">Jumlah Node</th>
                                                <th style="text-align: center;">Lokasi Node (Kab/Kota)</th>
                                                <th style="text-align: center;">Cakupan Wilayah Layanan (Kab/Kota)</th>
                                                <th style="text-align: center;">Jumlah Kabel Fiber Optik (core)</th>
                                                <th style="text-align: center;">Kapasitas <i>Bandwidth</i> (Gbps)</th>
                                                <th style="text-align: center;">Panjang Rute Kabel Fiber Optik (km)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rolloutplan-lists">
                                            @if ($mi->form_isian !== 'kosong')
                                                <?php $mi->form_isian = json_decode($mi->form_isian, true); ?>
                                                
                                                @foreach ($mi->form_isian as $key => $d)
                                                    <tr class="rolloutplan-item">
                                                        <td style="width: 5%; text-align: center;">
                                                            {{ $d['periode'] }}
                                                        </td>
                                                        <td style="width: 5%; text-align: center;">
                                                            {{ $d['jumlah_node'] }}
                                                
                                                        </td>
                                                        <td style="width: 15%;">
                                                            @foreach ($cities as $city)
                                                                @foreach ($d['lokasi_node'] as $item)
                                                                    @if ($city->id == $item)
                                                                        {{ $city->name }} 
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                        <td style="width: 15%;">
                                                            @foreach ($cities as $city)
                                                                @foreach ($d['cakupan_wilayah_layanan'] as $item)
                                                                    @if ($city->id == $item)
                                                                        {{ $city->name }} 
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                        <td style="width: 10%; text-align: center;">
                                                            {{ $d['jumlah_kabel_fiber_optik'] }}
                                                        </td>
                                                        <td style="width: 10%; text-align: center;">
                                                            {{ $d['kapasitas_bandwidth'] }}
                                                        </td>
                                                        <td style="width: 10%; text-align: center;">
                                                            {{ $d['panjang_rute_kabel_fiber_optik'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @elseif($mi->component_name == 'roll_out_plan_jartup_satelit')
                                    <table class="table table-custom table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Periode</th>
                                                <th style="text-align: center;">Kapasitas Transponder Satelit</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rolloutplan-lists">
                                            @if ($mi->form_isian !== 'kosong')
                                                <?php
                                                $mi->form_isian = json_decode($mi->form_isian, true);
                                                ?>
            
                                                @foreach ($mi->form_isian as $d)
                                                    <tr class="rolloutplan-item">
                                                        <td style="width: 10%;">
                                                            {{ $d['periode'] }}
                                                        </td>
                                                        <td style="width: 90%;">
                                                            {{ $d['kapasitas_transponder_satelit'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @elseif($mi->component_name == 'roll_out_plan_jarber_radio_trunking')
                                    <table class="table table-custom table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Periode</th>
                                                <th style="text-align: center;">Jumlah Kanal</th>
                                                <th style="text-align: center;">Kapasitas Pelanggan yang dilayani</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rolloutplan-lists">
                                            @if ($mi->form_isian !== 'kosong')
                                                <?php
                                                $mi->form_isian = json_decode($mi->form_isian, true);
                                                ?>
            
                                                @foreach ($mi->form_isian as $key => $d)
                                                    <tr class="rolloutplan-item">
                                                        <td style="width: 20%;">
                                                            {{ $d['periode'] }}
                                                        </td>
                                                        <td style="width: 40%;">
                                                            {{ $d['jumlah_kanal'] }}
                                                        </td>
                                                        <td style="width: 40%;">
                                                            {{ $d['kapasitas_pelanggan'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @elseif($mi->component_name == 'roll_out_plan_jartaplok_packet_switched')
                                    <table class="table table-custom table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Periode</th>
                                                <th style="text-align: center;">Cakupan Layanan (Kab/Kota)</th>
                                                <th style="text-align: center;">Port FTTx (jumlah port perangkat yang disediakan)
                                                </th>
                                                <th style="text-align: center;">Kapasitas <i>Bandwidth</i> FTTx (Gbps)</th>
                                                <th style="text-align: center;">Kapasitas Jumlah Pelanggan FTTx</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rolloutplan-lists">
                                            @if ($mi->form_isian !== 'kosong')
                                                <?php
                                                $mi->form_isian = json_decode($mi->form_isian, true);
                                                // var_dump($mi->form_isian);
                                                // dd($mi->form_isian);
                                                ?>
            
                                                @foreach ($mi->form_isian as $key => $d)
                                                    <tr class="rolloutplan-item">
                                                        <td style="width: 10%;">
                                                            {{ $d['periode'] }}
                                                        </td>
                                                        <td style="width: 25%;">
                                                            @foreach ($cities as $city)
                                                                @foreach ($d['cakupan_layanan'] as $item)
                                                                    @if ($city->id == $item)
                                                                        {{ $city->name }} 
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                        <td style="width: 10%;">
                                                            {{ $d['port_fttx'] }}
                                                        </td>
                                                        <td style="width: 10%;">
                                                            {{ $d['kapasitas_bandwidth_fttx'] }}
                                                        </td>
                                                        <td style="width: 15%;">
                                                            {{ $d['kapasitas_jumlah_pelanggan'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @elseif($mi->component_name == 'roll_out_plan_jartaplok_bwa')
                                    <table class="table table-custom table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Periode</th>
                                                <th style="text-align: center;">Jumlah <i>Site</i> (Unit)</th>
                                                <th style="text-align: center;">Lokasi <i>Site</i> (Kab/Kota)</th>
                                                <th style="text-align: center;">Minimal Cakupan Layanan (Kab/Kota)</th>
                                                <th style="text-align: center;">Kapasitas <i>Bandwidth</i> (Mbps)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rolloutplan-lists">
                                            @if ($mi->form_isian !== 'kosong')
                                                <?php
                                                $mi->form_isian = json_decode($mi->form_isian, true);
                                                ?>
            
                                                @foreach ($mi->form_isian as $key => $d)
                                                    <tr class="rolloutplan-item">
                                                        <td style="width: 10%;">
                                                            {{ $d['periode'] }}
                                                        </td>
                                                        <td style="width: 10%;">
                                                            {{ $d['jumlah_site'] }}
                                                        </td>
                                                        <td>
                                                            @foreach ($cities as $city)
                                                                @foreach ($d['lokasi_site'] as $item)
                                                                    @if ($city->id == $item)
                                                                        {{ $city->name }} 
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($cities as $city)
                                                                @foreach ($d['minimal_cakupan_layanan'] as $item)
                                                                    @if ($city->id == $item)
                                                                        {{ $city->name }} 
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            {{ $d['kapasitas_bandwidth'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @elseif($mi->component_name == 'roll_out_plan_jartup_skkl')
                                    <table class="table table-custom table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Periode</th>
                                                <th style="text-align: center;">Jumlah <i>Cable Landing Station</i></th>
                                                <th style="text-align: center;">Lokasi <i>Cable Landing Station</i> (Kab/Kota)</th>
                                                <th style="text-align: center;">Rute Jaringan Sistem Komunikasi Kabel Laut</th>
                                                <th style="text-align: center;">Jumlah Kabel Fiber Optik (core)</th>
                                                <th style="text-align: center;">Kapasitas <i>Bandwidth</i> (Gbps)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rolloutplan-lists">
                                            @if ($mi->form_isian != 'kosong')
                                                <?php
                                                $mi->form_isian = json_decode($mi->form_isian, true);
                                                ?>
                                                @foreach ($mi->form_isian as $key => $d)
                                                    <tr class="rolloutplan-item">
                                                        <td style="width: 5%;">
                                                            {{ $d['periode'] }}
                                                        </td>
                                                        <td style="width: 10%;">
                                                            {{ $d['jumlah_cable_landing_station'] }}
                                                        </td>
                                                        <td style="width: 25%;">
                                                            @foreach ($cities as $city)
                                                                @foreach ($d['lokasi_cable_landing_station'] as $item)
                                                                    @if ($city->id == $item)
                                                                        {{ $city->name }} 
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                        <td style="width: 30%;">
                                                            @foreach ($cities as $city)
                                                                @foreach ($d['rute_jaringan_sistem_komunikasi_kabel_laut'] as $item)
                                                                    @if ($city->id == $item)
                                                                        {{ $city->name }} 
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                        <td style="width: 30%;">
                                                            {{ $d['jumlah_kabel_fiber_optik'] }}
                                                        </td>
                                                        <td style="width: 15%;">
                                                            {{ $d['kapasitas_bandwidth'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @elseif($mi->component_name == 'roll_out_plan_jartup_mw_link')
                                    <table class="table table-custom table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Periode</th>
                                                <th style="text-align: center;">Minimal Jumlah Hop</th>
                                                <th style="text-align: center;">Minimal Kapasitas <i>Bandwidth</i> (Mbps)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rolloutplan-lists">
                                            @if ($mi->form_isian !== 'kosong')
                                                <?php
                                                $mi->form_isian = json_decode($mi->form_isian, true);
                                                ?>
            
                                                @foreach ($mi->form_isian as $d)
                                                    <tr class="rolloutplan-item">
                                                        <td style="width: 5%;">
                                                            {{ $d['periode'] }}
                                                        </td>
                                                        <td style="width: 5%;">
                                                            {{ $d['minimal_jumlah_hop'] }}
                                                        </td>
                                                        <td style="width: 10%;">
                                                            {{ $d['minimal_kapasitas_bandwidth'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @elseif($mi->component_name == 'roll_out_plan_jarber_satelit')
                                    <table class="table table-custom table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Periode</th>
                                                <th style="text-align: center;">Kapasitas Transponder Satelit yang disewakan
                                                    (MHz/Mbps)</th>
                                                <th style="text-align: center;">Kapasitas Sistem (SSM)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rolloutplan-lists">
                                            @if ($mi->form_isian !== 'kosong')
                                                <?php
                                                $mi->form_isian = json_decode($mi->form_isian, true);
                                                ?>
            
                                                @foreach ($mi->form_isian as $key => $d)
                                                    <tr class="rolloutplan-item">
                                                        <td style="width: 20%;">
                                                            {{ $d['periode'] }}
                                                        </td>
                                                        <td style="width: 40%;">
                                                            {{ $d['kapasitas_transponder_satelit'] }}
                                                        </td>
                                                        <td style="width: 40%;">
                                                            {{ $d['kapasitas_sistem'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @elseif($mi->component_name == 'roll_out_plan_jartup_visat')
                                    <table class="table table-custom table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Periode</th>
                                                <th style="text-align: center;">Kapasitas Transponder yang disewa/disediakan
                                                    (MHz/Mbps)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rolloutplan-lists">
                                            @if ($mi->form_isian !== 'kosong')
                                                <?php
                                                $mi->form_isian = json_decode($mi->form_isian, true);
                                                ?>
            
                                                @foreach ($mi->form_isian as $d)
                                                    <tr class="rolloutplan-item">
                                                        <td style="width: 10%;">
                                                            {{ $d['periode'] }}
                                                        </td>
                                                        <td style="width: 90%;">
                                                            {{ $d['kapasitas_transponder'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @endif
                            @endforeach
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section Detail Perusahaan -->


        <div class="form-group text-right">
            {{-- <a href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i> Kembali </a> --}}
            <!-- <button type="submit" class="btn btn-primary">Kirim Evaluasi Pendaftaran <i class="icon-paperplane ml-2"></i></button> -->
            {{-- <a target="_blank" href="{{ route('admin.historyperizinan', $izin['id_izin']) }}"
            class="btn btn-info">Riwayat Permohonan <i class="icon-history ml-2"></i></a> --}}
        </div>
    </div>

</form>
@endsection