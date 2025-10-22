<!DOCTYPE html>
<html>

<head>
	<title>Surat Penetapan Penomoran</title>

	<style type="text/css">
		@page {
			size: legal;
			margin-top: 1.5cm;
			/* Adjust the top margin as needed */
			margin-right: 2cm;
			/* Adjust the right margin as needed */
			margin-bottom: 2cm;
			/* Adjust the bottom margin as needed */
			margin-left: 2.5cm;
			/* Adjust the left margin as needed */
		}

		.page-break {
			page-break-after: always;
		}

		.table-inner tr td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
		}

		.watermark {
			position: fixed;
			bottom: 10cm;
			left: 3cm;
			width: 8cm;
			height: 8cm;
			z-index: -1000;
			color: lightgrey;
			font-size: 200px;
			opacity: 0.8;
			transform: rotate(-45deg);
		}

		* {
			font-size: 11.7pt;
			font-family: "Bookman", "Bookman Old Style", "Garamond", "Times New Roman", serif;
		}

		h2 {
			font-weight: normal;
		}
	</style>
	{{-- <script src="assets/js/app.js"></script>
    <script src="/global_assets/js/main/jquery.min.js"></script>
    <script src="/global_assets/js/main/bootstrap.bundle.min.js"></script> --}}
	<!-- /core JS files -->
</head>

<body>
	<div class="watermark">
		DRAF
	</div>
	<?php
	if (isset($data['jenis_layanan_html'])) {
	    $jenis_layanan = str_replace('Izin ', '', $data['jenis_layanan_html']);
	} else {
	    $jenis_layanan = '';
	}
	?>

	<div style="text-align:center !important;">
		<img style="width:120px;" src="{{ public_path('global_assets/images/logo_kominfo.png') }}">
	</div>
	<div style="text-align:center !important;">
		{{-- <h2 class="judul">PEMERINTAH REPUBLIK INDONESIA</h2> --}}
		{{-- <h2 class="judul">PERIZINAN BERUSAHA UNTUK MENUNJANG KEGIATAN BERUSAHA</h2> --}}
		{{-- <h4 class="isi">PENOMORAN TELEKOMUNIKASI</h4> --}}
		<h2 class="judul">PENETAPAN BLOK NOMOR</h2>
		<h2 class="judul">{{ isset($data['nama_perseroan']) ? strtoupper($data['nama_perseroan']) : '' }}</h2>
		<h2 class="judul">Nomor : {{ isset($no_izin) ? $no_izin : '' }}</h2>
	</div>

	{{-- <div>
		<p class='isi' style="text-align: justify;text-justify: inter-word;">Lampiran berikut memuat data teknis
			Penetapan {!! isset($data['kode_akses']['jenis_kode_akses']['full_name_html']) ?
			$data['kode_akses']['jenis_kode_akses']['full_name_html'] :''; !!} sebagai berikut :</p>

	</div> --}}

	<div>
		<table style="text-align: justify !important;width:100%;padding-top:20px;padding-right:10px;padding-bottom:20px;">
			<tr style="vertical-align:top !important;">
				<td width="5%">
					Dasar
				</td>
				<td width="2%">
					:
				</td>
				<td width="2%">
					a.
				</td>
				<td width="91%">
					Peraturan Menteri Komunikasi dan Informatika Nomor 14 Tahun 2018 tentang Rencana Dasar Teknis
					(<i>Fundamental Technical Plan</i>) Telekomunikasi Nasional;
				</td>
			<tr style="vertical-align:top !important;">
				<td width="5%">&nbsp;</td>
				<td width="2%">&nbsp;</td>
				<td width="2%">
					b.
				</td>
				<td width="91%">
					Peraturan Menteri Komunikasi dan Informatika Nomor 5 Tahun 2021 tentang Penyelenggaraan
					Telekomunikasi;
				</td>
			</tr>
			<tr style="vertical-align:top !important;">
				<td width="5%">&nbsp;</td>
				<td width="2%">&nbsp;</td>
				<td width="2%">
					c.
				</td>
				<td width="91%">
					Keputusan Menteri Komunikasi dan Informatika Nomor 793 Tahun 2018 tentang Pemberian Kewenangan
					Penandatanganan Dokumen Bidang Penyelenggaraan Pos dan Informatika Dalam Rangka Pelayanan Prima di
					Lingkungan Direktorat Jenderal Penyelenggaraan Pos dan Informatika;
				</td>
			</tr>
			<tr style="vertical-align:top !important;">
				<td width="5%">&nbsp;</td>
				<td width="2%">&nbsp;</td>
				<td width="2%">
					d.
				</td>
				<td width="91%">
					Keputusan Direktur Jenderal Penyelenggaraan Pos dan Informatika Nomor 167 Tahun 2018 tentang
					Pemberian Kewenangan Penandatanganan Dokumen Bidang Penyelenggaraan Pos dan Informatika Dalam Rangka
					Pelayanan Prima di Lingkungan Direktorat Jenderal Penyelenggaraan Pos dan Informatika sebagaimana
					telah diubah dengan Keputusan Direktur Jenderal Penyelenggaraan Pos dan Informatika Nomor 130 Tahun
					2020 tentang Perubahan Keputusan Direktur Jenderal Penyelenggaraan Pos dan Informatika Nomor 167
					Tahun 2018 tentang Pemberian Kewenangan Penandatanganan Dokumen Bidang Penyelenggaraan Pos dan
					Informatika Dalam Rangka Pelayanan Prima di Lingkungan Direktorat Jenderal Penyelenggaraan Pos dan
					Informatika;
				</td>
			</tr>
			<tr style="vertical-align:top !important;">
				<td width="5%">&nbsp;</td>
				<td width="2%">&nbsp;</td>
				<td width="2%">
					e.
				</td>
				<td width="91%">
					Permohonan Penetapan Penomoran
					{{ isset($data['nama_perseroan']) ? strtoupper($data['nama_perseroan']) : '' }} Nomor
					{{ isset($data['id_permohonan']) ? $data['id_permohonan'] : '' }} tanggal
					{{ isset($data['created_date']) ? $date_reformat->date_lang_reformat_long($data['created_date']) : '' }}.
				</td>
			</tr>
			{{-- <tr style="vertical-align:top !important;">
                <td width="20%">
                    Menetapkan
                    {!! isset($data['kode_akses']['jenis_kode_akses']['full_name_html'])
                        ? $data['kode_akses']['jenis_kode_akses']['full_name_html']
                        : '' !!}
                    {!! isset($data['kode_akses']['jenis_kode_akses']['full_name_html'])
                        ? $data['kode_akses']['jenis_kode_akses']['full_name_html']
                        : '' !!} kepada :
                </td>
            </tr> --}}
			{{-- <tr style="vertical-align:top !important;">
                <td width="20%">&nbsp;</td>
                <td width="3%">&nbsp;</td>

                <td width="7%">
                    b.
                </td>

                <td width="69%">
                    {{ isset($data['dasar_surat_permohonan_ulo']) ? $data['dasar_surat_permohonan_ulo'] : '' }};
                </td>
            </tr> --}}

			{{-- <tr style="vertical-align:top !important;">
                <td width="20%">&nbsp;</td>
                <td width="3%">&nbsp;</td>

                <td width="7%">
                    c.
                </td>

                <td width="69%">
                    Surat Tugas Direktur Telekomunikasi Nomor :
                    {{ isset($data['no_surat_perintah_tugas']) ? $data['no_surat_perintah_tugas'] : '' }}
                    tanggal
                    {{ isset($data['tanggal_surat_perintah_tugas'])
                        ? $date_reformat->date_lang_reformat_long($data['tanggal_surat_perintah_tugas'])
                        : '' }}
                    untuk
                    melaksanakan Uji Laik Operasi (ULO)
                    {!! $jenis_layanan !!}
                    {{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }};
                </td>
            </tr>

            <tr style="vertical-align:top !important;">
                <td width="20%">&nbsp;</td>
                <td width="3%">&nbsp;</td>

                <td width="7%">
                    d.
                </td>

                <td width="69%">
                    Berita Acara Evaluasi Hasil Pelaksanaan Uji Laik Operasi {!! $jenis_layanan !!}
                    {{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }} tanggal
                    {{ isset($data['tanggal_evaluasi_pelaksanaan_ulo'])
                        ? $date_reformat->date_lang_reformat_long($data['tanggal_evaluasi_pelaksanaan_ulo'])
                        : '' }};

                </td>
            </tr> --}}

		</table>
	</div>

	<table style="text-align: justify !important;width:100%;padding-right:10px;">
		<tr style="vertical-align:top !important;">
			<td style="padding-left:10px;" colspan="3">
				Menetapkan Blok Nomor sebagaimana tercantum pada lampiran penetapan ini
				untuk Penyelenggaraan {!! isset($data['jenis_layanan_html']) ? $data['jenis_layanan_html'] : '' !!}
				kepada:
			</td>
		</tr>
		<tr style="vertical-align:top !important;">
			<td style="padding-left:10px;width:25%;">Nama @if ($data['oss_kode'] == 99)
					Instansi
				@elseif ($data['oss_kode'] == 01)
					Perusahaan
				@else
					Perusahaan / Instansi
				@endif
			</td>
			<td style="width:2%;">:</td>
			<td>{{ isset($data['nama_perseroan']) ? strtoupper($data['nama_perseroan']) : '' }}</td>
		</tr>
		<tr style="vertical-align:top !important;">
			<td style="padding-left:10px;width:25%;">NIB</td>
			<td style="width:2%;">:</td>
			<td>{{ isset($datanib['nib']) ? $datanib['nib'] : '' }}</td>
		</tr>
		{{-- <tr style="vertical-align:top !important;">
            <td style="padding-left:50px;width:10%;">NPWP</td>
            <td style="width:2%;">:</td>
            <td>{{ isset($datanib['npwp_perseroan']) ? $datanib['npwp_perseroan'] : '' }}</td>
        </tr> --}}
		<tr style="vertical-align:top !important;">
			<td style="padding-left:10px;width:25%;">Alamat</td>
			<td style="width:2%;">:</td>
			<td>{{ isset($datanib['alamat_perseroan']) ? $datanib['alamat_perseroan'] : '' }}</td>
		</tr>

		{{-- <tr style="vertical-align:top !important;">
            <td style="padding-left:50px;width:40%;">Jenis Layanan</td>
            <td style="width:2%;">:</td>
            <td>{!! $jenis_layanan !!}</td>
        </tr>

        <tr style="vertical-align:top !important;">
            <td style="padding-left:50px;width:40%;">Jenis Penomoran</td>
            <td style="width:2%;">:</td>
            <td>{!! isset($data['kode_akses']['jenis_kode_akses']['full_name_html'])
                ? $data['kode_akses']['jenis_kode_akses']['full_name_html']
                : '' !!}</td>
        </tr>

        <tr style="vertical-align:top !important;">
            <td style="padding-left:50px;width:40%;">Penomoran yang ditetapkan</td>
            <td style="width:2%;">:</td>
            <td>{{ isset($data['kode_akses']['kode_akses']) ? $data['kode_akses']['kode_akses'] : '' }}</td>
        </tr> --}}

		<tr style="vertical-align:top !important;">
			<td style="padding-left:10px;" colspan="3">
				<p>Dalam menggunakan Blok Nomor sebagaimana tercantum pada lampiran penetapan ini,
					{{ isset($data['nama_perseroan']) ? strtoupper($data['nama_perseroan']) : '' }} wajib melaporkan
					penggunaannya setiap 1 (satu) tahun sejak ditetapkan.</p>
				<p>
					Direktorat Jenderal Penyelenggaraan Pos dan Informatika akan melakukan monitoring dan evaluasi
					terhadap penggunaan Blok Nomor sebagaimana tercantum pada lampiran penetapan ini.
				</p>
			</td>
		</tr>

	</table>
	<table>
		{{-- <tr>
			<td width="200px;">&nbsp;</td>
			<td>
				Jakarta,
				{{ isset($data['effective_date']) ? $date_reformat->date_lang_reformat_long($data['effective_date']) : '' }}
			</td>
		</tr> --}}
		<tr>
			<td width="200px;">&nbsp;</td>
			<td style="text-align:center;">
				Jakarta,
				{{ isset($data['effective_date']) ? $date_reformat->date_lang_reformat_long($data['effective_date']) : '' }}
				<br />a.n MENTERI KOMUNIKASI DAN INFORMATIKA
				<br />REPUBLIK INDONESIA
				<br />DIREKTUR JENDERAL PENYELENGGARAAN
				<br />POS DAN INFORMATIKA
				<br /> u.b
				<br /> DIREKTUR TELEKOMUNIKASI<br /> <br />
				<img style="width:70px;" src="data:image/png;base64, {!! base64_encode(
				    QrCode::format('svg')->size(100)->generate('https://e-telekomunikasi.kominfo.go.id/validasi-sk/' . $data['id_izin']),
				) !!} ">
				<img style="width:210px;" src="{{ public_path('global_assets/images/TTE Direktur.png') }}">
			</td>
			<td>
				<div class="visible-print text-center">
				</div>
			</td>
		</tr>

	</table>

	{{-- <div style="text-align:center !important;">
        <img style="width:100%;position:fixed;bottom:0;" src="{{ asset('global_assets/images/ket_tte.jpg') }}">
    </div> --}}

	<div class="page-break"></div>

	<div style="margin-left:35%;">
		LAMPIRAN<br />
		PENETAPAN BLOK NOMOR<br />
		NOMOR : {{ isset($no_izin) ? $no_izin : '' }}<br />
		<br /><br />
	</div>
	<div class="form-group row">
		<div class="col-lg-12">
			<div class="row">
				<?php
				$key2 = 1;
				?>

				<div class="col-lg-4 table-responsive" id="PilihKodeWilayah">
					<table class='table-inner' style="border-spacing:0px !important;width:100%;">
						<thead>
							<tr>
								<td>No</td>
								<td style="text-align: center;">
									Wilayah</td>
								<td style="text-align: center;">
									Kode
									Wilayah</td>
								<td style="text-align: center;">
									Blok Nomor
								</td>
							</tr>

						</thead>
						<tbody id="bloknomor-lists">
							@foreach ($penomoran_bloknomor as $item)
								<tr class="bloknomor-item">
									<td>{{ $key2++ }}</td>
									<td style="width: 60%;">
										<div class="font-size-sm">
											{{ $item['nama_wilayah'] }}
										</div>
									</td>
									<td style="width: 60%;">
										<div class="font-size-sm">
											{{ $item['kode_wilayah'] }}
										</div>
									</td>
									<td style="width: 30%;">
										<div class="font-size-sm">
											{{ $item['prefix_awal'] }}
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>

	<div>
		<table>
			<tr>
				<td width="200px;">&nbsp;</td>
				<td>
					Jakarta,
					{{ isset($data['effective_date']) ? $date_reformat->date_lang_reformat_long($data['effective_date']) : '' }}
				</td>
			</tr>
			<tr>
				<td width="200px;">&nbsp;</td>
				<td style="text-align:center;">
					a.n MENTERI KOMUNIKASI DAN INFORMATIKA
					<br />REPUBLIK INDONESIA
					<br />DIREKTUR JENDERAL PENYELENGGARAAN
					<br />POS DAN INFORMATIKA
					<br /> u.b
					<br /> DIREKTUR TELEKOMUNIKASI<br /> <br />
					<img style="width:70px;" src="data:image/png;base64, {!! base64_encode(
					    QrCode::format('svg')->size(100)->generate('https://e-telekomunikasi.kominfo.go.id/validasi-sk/' . $data['id_izin']),
					) !!} ">
					<img style="width:210px;" src="{{ public_path('global_assets/images/TTE Direktur.png') }}">
				</td>
				<td>
					<div class="visible-print text-center">
					</div>
				</td>
			</tr>

		</table>
	</div>
</body>

</html>
