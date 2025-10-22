<!DOCTYPE html>
<html>

<head>
    <title>Surat Ketetapan Izin Prinsip Telekomunikasi Khusus Instansi Pemerintah</title>

    <style type="text/css">
        .page-break {
            page-break-after: always;
        }

        .table-inner tr td,
        .table-inner tr th {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }

        .bordered {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .watermark {
            position: fixed;

            /**
   Set a position in the page for your image
   This should center it vertically
  **/
            bottom: 10cm;
            left: 3cm;

            /** Change image dimensions**/
            width: 8cm;
            height: 8cm;

            /** Your watermark should be behind every content**/
            z-index: -1000;

            color: lightgrey;
            font-size: 200px;

            opacity: 0.8;

            transform: rotate(-45deg);
        }
    </style>
</head>

<body>
    <div class="watermark">
        DRAF
    </div>

    <div style="text-align:center !important;"><img style="width:350px;"
            src="{{ asset('global_assets/images/logo_kominfo_textunder.png') }}"></div>
    <div style="text-align:center !important;">
        <p>
            KEPUTUSAN MENTERI KOMUNIKASI DAN INFORMATIKA<br />REPUBLIK INDONESIA
            <br />
            NOMOR : {{ $nomor_sklo }}
        </p>
        <p>
            TENTANG
            <br />
            IZIN PRINSIP PENYELENGGARAAN TELEKOMUNIKASI KHUSUS<br /> UNTUK KEPERLUAN INSTANSI PEMERINTAH
            <br />
            {{ $data['nama_perseroan'] }}
        </p>
        <p>
            MENTERI KOMUNIKASI DAN INFORMATIKA<br />
            REPUBLIK INDONESIA,
        </p>
    </div>

    <div>
        <table style="text-align: justify !important;">
            <tr style="vertical-align:top !important;">
                <td width="12%">Menimbang</td>
                <td width="1%">:</td>
                <td width="7%">a.</td>
                <td width="69%">
                    bahwa {{ $data['nama_perseroan'] }} telah mengajukan permohonan izin prinsip penyelenggaraan
                    telekomunikasi khusus untuk keperluan instansi pemerintah dengan nomor permohonan
                    {{ $data['id_izin'] }}
                    tanggal
                    {{ isset($data['updated_date']) ? $date_reformat->date_lang_reformat_long($data['updated_date']) : '' }};
                </td>
            </tr>

            <tr style="vertical-align:top !important;">
                <td width="12%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="7%">b.</td>
                <td width="69%">bahwa {{ $data['nama_perseroan'] }} telah memenuhi persyaratan sesuai dengan
                    ketentuan
                    peraturan perundang-undangan;</td>
            </tr>

            <tr style="vertical-align:top !important;">
                <td width="12%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="7%">c.</td>
                <td width="69%">berdasarkan pertimbangan huruf a dan huruf b, perlu menetapkan Keputusan Menteri
                    Komunikasi dan Informatika tentang Izin Prinsip Penyelenggaraan Telekomunikasi Khusus untuk
                    Keperluan Instansi Pemerintah {{ $data['nama_perseroan'] }}.</td>
            </tr>
        </table>
    </div>

    <div style="text-align:center !important;">
        <p>MEMUTUSKAN :</p>
    </div>

    <div>
        <table style="text-align: justify !important;">
            <tr style="vertical-align:top !important;">
                <td width="12%">Menetapkan</td>
                <td width="1%">:</td>
                <td width="69%">
                    KEPUTUSAN MENTERI KOMUNIKASI DAN INFORMATIKA TENTANG IZIN PRINSIP PENYELENGGARAAN TELEKOMUNIKASI
                    KHUSUS UNTUK KEPERLUAN INSTANSI PEMERINTAH {{ $data['nama_perseroan'] }}.
                </td>
            </tr>

            <tr style="vertical-align:top !important;">
                <td width="12%">KESATU</td>
                <td width="1%">:</td>
                <td width="69%">
                    bahwa {{ $data['nama_perseroan'] }} telah memenuhi persyaratan sesuai dengan ketentuan peraturan
                    perundang-undangan;
                </td>
            </tr>

            <tr style="vertical-align:top !important;">
                <td width="12%">KEDUA</td>
                <td width="1%">:</td>
                <td width="69%">
                    Izin Prinsip ini berlaku untuk 1(satu) tahun terhitung sejak tanggal ditetapkan.
                </td>
            </tr>

            <tr style="vertical-align:top !important;">
                <td width="12%">KETIGA</td>
                <td width="1%">:</td>
                <td width="69%">
                    Keputusan ini mulai berlaku pada tanggal ditetapkan.
                </td>
            </tr>
        </table>
    </div>

    <div>
        <table>
            <tr>
                <td></td>
                <td>
                    Ditetapkan di Jakarta pada
                    <br />
                    tanggal
                    {{ isset($data['updated_date']) ? $date_reformat->date_lang_reformat_long($data['updated_date']) : '' }}
                </td>
            </tr>
            <tr>
                <td width="300px;">&nbsp;</td>
                <td style="text-align:center;">
                    a.n MENTERI KOMUNIKASI DAN INFORMATIKA
                    <br />REPUBLIK INDONESIA
                    <br />DIREKTUR JENDERAL
                    <br />PENYELENGGARAAN POS DAN INFORMATIKA
                    <br /> u.b
                    <br /> DIREKTUR TELEKOMUNIKASI,
                </td>
            </tr>

            <tr>
                <td></td>
                <td>PENYELENGGARAAN POS DAN INFORMATIKA</td>
            </tr>


        </table>
    </div>

    <div>
        <p style="margin-top:130px;">
            Salinan Keputusan ini disampaikan kepada Yth. :<br />
            1. Menteri Komunikasi dan Informatika (sebagai laporan); dan<br />
            2. Direktur Jenderal Penyelenggaraan Pos dan Informatika (sebagai laporan).
        </p>
    </div>

    <div style="font-size:8pt;border:1px solid black;">
        UNTUK MENJADI PERHATIAN:
        <br />
        1. Dokumen ini merupakan dokumen asli yang berbentuk elektronik dan menggunakan tanda tangan elektronik yang sah
        dan memiliki kekuatan hukum.<br />
        2. Dokumen ini tidak membutuhkan legalisir.<br />
        3. Dokumen ini dilindungi berdasarkan UU No. 36/1999 tentang Telekomunikasi dan UU No. 11/2008 tentang Informasi
        dan Transaksi Elektronik, dan Peraturan Pelaksananya.<br />
        4. Segala Penyalahgunaan terhadap Dokumen ini akan ditindak Sesuai dengan Ketentuan Peraturan
        Perundang-undangan.
    </div>
    <div class="page-break"></div>

    <div style="margin-left:35%;">
        LAMPIRAN<br />
        KEPUTUSAN MENTERI KOMUNIKASI DAN INFORMATIKA<br />
        REPUBLIK INDONESIA<br />
        NOMOR : {{ $nomor_sklo }}<br />
        TENTANG IZIN PRINSIP PENYELENGGARAAN TELEKOMUNKASI KHUSUS UNTUK KEPERLUAN INSTANSI PEMERINTAH <br />
        {{ $data['nama_perseroan'] }}
    </div>

    <div style="text-align:center !important;margin-top:30px;">
        RENCANA CAKUPAN WILAYAH LAYANAN <br />
        PENYELENGGARAAN TELEKOMUNIKASI KHUSUS UNTUK KEPERLUAN INSTANSI PEMERINTAH<br />
        {{ $data['nama_perseroan'] }}
    </div>

    @if (count($map_izin) > 0)
        @foreach ($map_izin as $key => $mi)
            @if ($mi->file_type == 'table' && $mi->component_name != null)
                @if (isset($mi->form_isian))
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-12">

                                    @if ($mi->component_name == 'cakupanwilayahtelsus_mtk')
                                        <?php
                                        $key2 = 1;
                                        $datajson = json_decode($mi->form_isian, true);
                                        ?>
                                        <p>Media Transmisi : Kawat/Serat Optik</p>
                                        <table class='table-inner' style="border-spacing:0px !important;width:100%;">
                                            <tr>
                                                <td>No</td>
                                                <td>Rute</td>
                                                <td>Panjang Rute (Km)</td>
                                                <td>Kapasitas (Core)</td>
                                                <td>Cakupan Wilayah Layanan</td>
                                            </tr>
                                            @foreach ($datajson as $keydata => $datajson)
                                                <tr>
                                                    <td>{{ $key2++ }}</td>
                                                    <td>{{ isset($datajson['rute']) ? $datajson['rute'] : '' }}</td>
                                                    <td>{{ isset($datajson['panjang-rute']) ? $datajson['panjang-rute'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['kapasitas']) ? $datajson['kapasitas'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['CWL']) ? $datajson['CWL'] : '' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif

                                    @if ($mi->component_name == 'cakupanwilayahtelsus_skrk')
                                        <?php
                                        $key2 = 1;
                                        $datajson = json_decode($mi->form_isian, true);
                                        ?>
                                        <p>Media Transmisi Spektrum Frekuensi Radio untuk Sistem Komunikasi Radio
                                            Konvensional</p>
                                        <table class='table-inner' style="border-spacing:0px !important;width:100%;">
                                            <tr>
                                                <td>No</td>
                                                <td>Lokasi</td>
                                                <td>Jenis Perangkat</td>
                                                <td>Jumlah Perangkat</td>
                                                <td>Cakupan Wilayah Layanan</td>
                                            </tr>
                                            @foreach ($datajson as $keydata => $datajson)
                                                <tr>
                                                    <td>{{ $key2++ }}</td>
                                                    <td>{{ isset($datajson['kota']) ? $datajson['kota'] : '' }}</td>
                                                    <td>{{ isset($datajson['jenis-perangkat']) ? $datajson['jenis-perangkat'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['jumlah-perangkat']) ? $datajson['jumlah-perangkat'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['CWL']) ? $datajson['CWL'] : '' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif

                                    @if ($mi->component_name == 'cakupanwilayahtelsus_skrt')
                                        <?php
                                        $key2 = 1;
                                        $datajson = json_decode($mi->form_isian, true);
                                        ?>
                                        <p>Media Transmisi Spektrum Frekuensi Radio untuk Sistem Komunikasi Radio
                                            Trunking</p>
                                        <table class='table-inner' style="border-spacing:0px !important;width:100%;">
                                            <tr>
                                                <td>No</td>
                                                <td>Lokasi</td>
                                                <td>Jenis Perangkat</td>
                                                <td>Jumlah Perangkat</td>
                                                <td>Cakupan Wilayah Layanan</td>
                                            </tr>
                                            @foreach ($datajson as $keydata => $datajson)
                                                <tr>
                                                    <td>{{ $key2++ }}</td>
                                                    <td>{{ isset($datajson['kota']) ? $datajson['kota'] : '' }}</td>
                                                    <td>{{ isset($datajson['jenis-perangkat']) ? $datajson['jenis-perangkat'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['jumlah-perangkat']) ? $datajson['jumlah-perangkat'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['CWL']) ? $datajson['CWL'] : '' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif

                                    @if ($mi->component_name == 'cakupanwilayahtelsus_skrd')
                                        <?php
                                        $key2 = 1;
                                        $datajson = json_decode($mi->form_isian, true);
                                        ?>
                                        <p>Media Transmisi Spektrum Frekuensi Radio untuk Sistem Komunikasi Radio untuk
                                            Data</p>
                                        <table class='table-inner' style="border-spacing:0px !important;width:100%;">
                                            <tr>
                                                <td>No</td>
                                                <td>Lokasi</td>
                                                <td>Jenis Perangkat</td>
                                                <td>Jumlah Perangkat</td>
                                                <td>Cakupan Wilayah Layanan</td>
                                            </tr>
                                            @foreach ($datajson as $keydata => $datajson)
                                                <tr>
                                                    <td>{{ $key2++ }}</td>
                                                    <td>{{ isset($datajson['kota']) ? $datajson['kota'] : '' }}</td>
                                                    <td>{{ isset($datajson['jenis-perangkat']) ? $datajson['jenis-perangkat'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['jumlah-perangkat']) ? $datajson['jumlah-perangkat'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['CWL']) ? $datajson['CWL'] : '' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif

                                    @if ($mi->component_name == 'cakupanwilayahtelsus_sks')
                                        <?php
                                        $key2 = 1;
                                        $datajson = json_decode($mi->form_isian, true);
                                        
                                        ?>
                                        <p>Media Transmisi Spektrum Frekuensi Radio untuk Sistem Komunikasi Satelit</p>
                                        <p>
                                            Nama Satelit :
                                            {{ isset($datajson['satelit']['name']) ? $datajson['satelit']['name'] : '' }}<br />
                                            Slot Orbit :
                                            {{ isset($datajson['satelit']['orbit']) ? $datajson['satelit']['orbit'] : '' }}
                                        </p>
                                        <table class='table-inner' style="border-spacing:0px !important;width:100%;">
                                            <tr>
                                                <td>No</td>
                                                <td>Jumlah Transponderdan Band Frekuensi yang Digunakan</td>
                                                <td>Kapasitas Transponder</td>
                                                <td>Jumlah Hub</td>
                                                <td>Lokasi Hub</td>
                                                <td>Cakupan Wilayah Layanan</td>
                                            </tr>
                                            @foreach ($datajson['table'] as $keydata => $datajson)
                                                <tr>
                                                    <td>{{ $key2++ }}</td>
                                                    <td>{{ isset($datajson['jumlah-transponder']) ? $datajson['jumlah-transponder'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['kapasitas-transponder']) ? $datajson['kapasitas-transponder'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['jumlah-hub']) ? $datajson['jumlah-hub'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['lokasi-hub']) ? $datajson['lokasi-hub'] : '' }}
                                                    </td>
                                                    <td>{{ isset($datajson['CWL']) ? $datajson['CWL'] : '' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    @endif

</body>

</html>
