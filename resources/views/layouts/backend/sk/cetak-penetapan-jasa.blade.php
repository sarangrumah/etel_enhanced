<!DOCTYPE html>
<html>

<head>
    <title>Surat Penetapan Komitmen</title>

    <style type="text/css">
        .page-break {
            page-break-after: always;
        }
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        
        * {
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 12px;
            font-family: Cardo;
        }

        h2 {
            font-weight: normal;
        }
    </style>
</head>

<body>

    <div style="text-align:center !important;"><img style="width:120px;"
            src="{{ public_path('global_assets/images/logo_kominfo.png') }}"></div>
    <div style="text-align:center !important;">
        <br />
        <font size="3">PENETAPAN KOMITMEN LAYANAN<br>
            {!! Str::upper($mst_kode_izin->short_name) !!}</font><br />

        <font size="3">{{ Str::upper($nama_perseroan) }}</font><br />

        <font size="3">NOMOR : {{ $latest_nokomitmen }}</font><br />
    </div>
    <div>
        <ol>
            <li>
            <p style="text-align: justify !important;">Menetapkan komitmen layanan selama 5 (lima) tahun bagi {{ Str::upper($nama_perseroan) }}
                sebagai penyelenggara Jasa
                Telekomunikasi {{ $mst_kode_izin->name }}. Paling sedikit sebagai berikut:</p>
                <div style="text-align: center">Tabel Komitmen Layanan</div>
                <div class="row d-flex justify-content-center" style="text-align: center;">
                    <div class="col-md-12">
                        @foreach ($map_izin_perubahan as $mi)
                    @if ($mi->component_name == 'komitmen_kinerja_layanan_lima_tahun')
                        <table class="table table-sm table-custom" style="width: 100%" style="text-align: justify !important;">
                            <thead>
                                <tr>
                                    <th class="text-center"
                                        style="vertical-align : middle;text-align:center; width:30%">Tahun</th>
                                    <th class="text-center">Tahun I</th>
                                    <th class="text-center">Tahun II</th>
                                    <th class="text-center">Tahun III</th>
                                    <th class="text-center">Tahun IV</th>
                                    <th class="text-center">Tahun V</th>
                                </tr>
                            </thead>

                            @if ($mi->form_isian !== 'kosong')
                                <?php
                                $mi->form_isian = json_decode($mi->form_isian, true);
                                ?>

                                <tbody id="komitmen-kinerja-lists">
                                    <tr>
                                        <td style="width: 40%;">
                                            <i>Network Availability </i> (%)
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['network_availbility']['I'] }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['network_availbility']['II'] }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['network_availbility']['III'] }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['network_availbility']['IV'] }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['network_availbility']['V'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%;">
                                            Pencapaian <i>Mean Time To Restore</i> (Jam)
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['mean_time_to_restore']['I'] }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['mean_time_to_restore']['II'] }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['mean_time_to_restore']['III'] }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['mean_time_to_restore']['IV'] }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $mi->form_isian['mean_time_to_restore']['V'] }}
                                        </td>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    @elseif($mi->component_name == 'rencanausaha')
                        <table class="table table-custom table-sm" style="width: 100%" style="text-align: justify !important;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center;">Tahun</th>
                                    <th colspan="2" style="text-align: center;border: none;">Pusat Pelayanan
                                        Pelanggan</th>
                                    <th rowspan="2" style="text-align: center;">Kapasitas Layanan dalam E1 (atau
                                        Setara)</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">(Kota/Kab)</th>
                                    <th style="text-align: center;">Jumlah</th>
                                </tr>
                                
                            </thead>
                            <tbody id="rencanausaha-lists">
                                @if ($mi->form_isian !== 'kosong')
                                    <?php
                                    $mi->form_isian = json_decode($mi->form_isian, true);
                                    ?>
                                    @foreach ($mi->form_isian as $key => $d)
                                        <tr class="rencanausaha-item">
                                            <td style="text-align: center; width: 15%;">
                                                {{ $d['tahun'] }}
                                            </td>
                                            <td style="text-align: center; width: 35%;">
                                                @foreach ($cities as $city)
                                                    @if ($city->id == $d['kota'])
                                                        {{ $city->name }} 
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td style="text-align: center;">
                                                {{ $d['jumlah'] }}
                                            </td>
                                            <td style="text-align: center;">
                                                {{ $d['kapasitas_e1'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    @elseif($mi->component_name == 'rencanausaha_v2')
                        <table class="table table-custom table-sm" style="width: 100%" style="text-align: justify !important;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center;">Tahun</th>
                                    <th colspan="2" style="text-align: center;border: none;">Pusat Pelayanan
                                        Pelanggan</th>
                                    <th rowspan="2" style="text-align: center;">Jumlah Perjanjian Kerjasama (PKS)
                                        dengan Penyedia Konten
                                        Independen</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">(Kota/Kab)</th>
                                    <th style="text-align: center;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="rencanausaha-lists">
                                @if ($mi->form_isian !== 'kosong')
                                    <?php $mi->form_isian = json_decode($mi->form_isian, true); ?>
                                    @foreach ($mi->form_isian as $key => $d)
                                        <tr class="rencanausaha-item">
                                            <td style="text-align: center; width: 15%;">
                                                {{ $d['tahun'] }}
                                            </td>
                                            <td style="text-align: center; width: 35%;">
                                                @foreach ($cities as $city)
                                                    @if ($city->id == $d['kota'])
                                                        {{ $city->name }} 
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td style="text-align: center;">
                                                {{ $d['jumlah'] }}
                                            </td>
                                            <td style="text-align: center;">
                                                {{ $d['pks'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    @elseif($mi->component_name == 'rencanausaha_v3')
                        <table class="table table-custom table-sm" style="width: 100%" style="text-align: justify !important;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center;width: 10%;">Tahun</th>
                                    <th colspan="2" style="text-align: center;border: none;width: 30%;">Pusat
                                        Pelayanan Pelanggan</th>
                                    <th rowspan="2" style="text-align: center;width: 30%;">Cakupan Wilayah Layanan
                                        (Kota/Kab)</th>
                                    <th rowspan="2" style="text-align: center;">Kapasitas Bandwidth Internasional
                                        (Mbps)</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">Kota/Kab</th>
                                    <th style="text-align: center;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="rencanausaha-lists">
                                @if ($mi->form_isian !== 'kosong')
                                    <?php
                                    $mi->form_isian = json_decode($mi->form_isian, true);
                                    ?>
                                    @foreach ($mi->form_isian as $key => $d)
                                        <tr class="rencanausaha-item">
                                            <td style="text-align: center; width: 15%;">
                                                {{ $d['tahun'] }}
                                            </td>
                                            <td style="text-align: center; width: 20%;">
                                                @foreach ($cities as $city)
                                                    @if ($city->id == $d['kota'])
                                                        {{ $city->name }} 
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td style="text-align: center;">
                                                {{ $d['jumlah'] }}
                                            </td>
                                            <td style="text-align: center;" style="width: 20%;">
                                                @foreach ($cities as $city)
                                                    @if ($city->id == $d['wilayah_layanan'])
                                                        {{ $city->name }} 
                                                    @endif
                                                @endforeach
                                                </td>
                                                <td style="text-align: center;">
                                                    {{ $d['kapasitas_e1'] }}
                                                </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    @elseif($mi->component_name == 'rencanausaha_v4')
                        <table class="table table-sm table-custom" style="width: 100%" style="text-align: justify !important;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center;">Tahun</th>
                                    <th colspan="2" style="text-align: center;border: none;">Pusat Pelayanan
                                        Pelanggan</th>
                                    <th class="text-center" rowspan="2">Lokasi Ketersambungan Simpul Jasa (Node)
                                        (Kota / Kabupaten)</th>
                                    <th class="text-center" rowspan="2">Kapasitas Bandwidth Domestik (Mbps)</th>
                                    <th class="text-center" rowspan="2">Kapasitas Bandwidth Internasional (Mbps)</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">(Kota/Kab)</th>
                                    <th style="text-align: center;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="rencanausaha-lists">
                                @if ($mi->form_isian !== 'kosong')
                                    <?php
                                    $mi->form_isian = json_decode($mi->form_isian, true);
                                    ?>
                                    @foreach ($mi->form_isian as $key => $d)
                                        <tr class="rencanausaha-item">
                                            <td style="text-align: center; width: 10%;">
                                                {{ $d['tahun'] }}
                                            </td>
                                            <td style="text-align: center; width: 30%;">
                                                @foreach ($cities as $city)
                                                    @if ($city->id == $d['kota'])
                                                        {{ $city->name }},
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $d['jumlah'] }}
                                            </td>
                                            <td style="text-align: center; width: 30%;">
                                                @foreach ($cities as $city)
                                                    @if ($city->id == $d['node'])
                                                        {{ $city->name }} 
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $d['band_domestik'] }}
                                            </td>
                                            <td>
                                                {{ $d['band_inter'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    @elseif($mi->component_name == 'rencanausaha_v5')
                        <table class="table table-sm table-custom" style="width: 100%" style="text-align: justify !important;">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2"
                                        style="vertical-align : middle;text-align:center;">Tahun</th>
                                    <th class="text-center" colspan="2">Pusat Pelayanan Pelanggan</th>
                                    {{-- <th class="text-center" rowspan="2" style="vertical-align : middle;text-align:center;">Jenis Layanan
								Siskomdat</th> --}}
                                </tr>
                                <tr>
                                    <th>(Kota/Kab)</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="rencanausaha-lists">

                                @if ($mi->form_isian !== 'kosong')
                                    <?php
                                    $mi->form_isian = json_decode($mi->form_isian, true);
                                    ?>
                                    @foreach ($mi->form_isian as $key => $d)
                                        <tr class="rencanausaha-item">
                                            <td style="text-align: center; width: 10%;">
                                                {{ $d['tahun'] }}
                                            </td>
                                            <td style="text-align: center; width: 50%;">
                                                @foreach ($cities as $city)
                                                    @if ($city->id == $d['kota'])
                                                        {{ $city->name }} 
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td style="text-align: center; width: 20%;">
                                                {{ $d['jumlah'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    @endif
                    @endforeach
                    </div>
                    
                </div>
                <div>
                    Keterangan:
                    <ol type="a">
                        {{-- <li>Periode tahun pertama terhitung {{ date('Y') }}. sampai dengan akhir tahun buku; dan --}}
                        <li>Periode tahun pertama terhitung sejak tanggal ditetapkan sampai dengan akhir tahun buku; dan
                        </li>
                        <li>Periode tahun kedua dan seterusnya terhitung sesuai dengan tahun buku (1 Januari sampai
                            dengan 31 Desember).</li>
                    </ol>
                </div>
            </li>
            <li>
            <p style="text-align: justify !important;">Pelaksanaan evaluasi penyelenggaraan {{ $mst_kode_izin->name }} tahunan dan 5 (lima) tahunan atas
                komitmen layanan mengacu pada penetapan ini.</p>
            </li>
        </ol>

    </div>
    <div style="text-align:left; float:right">
        Ditetapkan di Jakarta<br>
        Pada tanggal {{ isset($ulos->tgl_berlaku_ulo) ? $date_reformat->date_lang_reformat_long($ulos->tgl_berlaku_ulo) : '' }}<br>
    {{-- </div> --}}
    <div style="text-align:center">
        a.n MENTERI KOMUNIKASI DAN INFORMATIKA<br>
        DIREKTUR JENDERAL<br>
        PENYELENGGARAAN POS DAN INFORMATIKA<br>
        u.b<br>
        DIREKTUR TELEKOMUNIKASI<br /> <br /> <br />
                    <img style="width:70px;" src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(100)->generate('https://e-telekomunikasi.kominfo.go.id/validasi-sk/'.$idizin)) !!} ">
                    <img style="width:210px;" src="{{ public_path('global_assets/images/TTE Direktur.png') }}">
    </div>            
    </div>
</body>

</html>
