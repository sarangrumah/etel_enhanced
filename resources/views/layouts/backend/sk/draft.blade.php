<!DOCTYPE html>
<html>

<head>
	<title>Surat Keterangan Laik Operasi</title>

	<style type="text/css">
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

		* {
			/* font-family: Arial, Helvetica, sans-serif; */
			font-family: Cardo;
		}

		h2 {
			font-weight: normal;
		}
	</style>
</head>

<body>
	<div class="watermark">
		DRAF
	</div>

	<div style="text-align:center !important;"><img style="width:120px;"
			src="{{ public_path('global_assets/images/logo_kominfo.png') }}"></div>
	<div style="text-align:center !important;">
		<br />
		<font size="5">SURAT KETERANGAN LAIK OPERASI</font><br />
		<!-- <h3>Nomor : {{ isset($data['no_izin']) ? $data['no_izin'] : '' }}</h3> -->
		<font size="4">Nomor : {{ isset($data['nomor_sklo_fixed']) ? $data['nomor_sklo_fixed'] : '' }} </font>
		<br /><br /><br />
	</div>
	<?php
	if (isset($data['jenis_layanan_html'])) {
	    $jenis_layanan = str_replace('Izin ', '', $data['jenis_layanan_html']);
	} else {
	    $jenis_layanan = '';
	}
	?>

	<div>
		<table style="text-align: justify !important;">
			<tr style="text-align: justify !important;vertical-align:top;">
				<td width="10%">
					Dasar
				</td>
				<td width="3%">
					:
				</td>

				<td width="7%">
					a.
				</td>

				<td width="79%">
					bahwa {{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }}
					telah memperoleh Nomor Induk Berusaha (NIB) Nomor {{ isset($data['nib']) ? $data['nib'] : '' }} dan
					Klasifikasi Baku Lapangan Usaha Indonesia (KBLI) {{ isset($data['kbli']) ? $data['kbli'] : '' }};
				</td>
			</tr>

			<tr style="text-align: justify !important;vertical-align:top;">
				<td width="10%">&nbsp;</td>
				<td width="3%">&nbsp;</td>

				<td width="7%">
					b.
				</td>

				<td width="79%">
					{{ isset($data['dasar_surat_permohonan_ulo']) ? $data['dasar_surat_permohonan_ulo'] : '' }};
				</td>
			</tr>

			<tr style="text-align: justify !important;vertical-align:top;">
				<td width="10%">&nbsp;</td>
				<td width="3%">&nbsp;</td>

				<td width="7%">
					c.
				</td>

				<td width="79%">
					Surat Tugas Direktur Telekomunikasi Nomor :
					{{ isset($data['no_surat_perintah_tugas']) ? $data['no_surat_perintah_tugas'] : '' }}
					tanggal
					{{ isset($data['tanggal_surat_perintah_tugas'])
					    ? $date_reformat->date_lang_reformat_long($data['tanggal_surat_perintah_tugas'])
					    : '' }}
					untuk
					melaksanakan Uji
					Laik Operasi (ULO)
					{!! $jenis_layanan !!}
					{{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }};
				</td>
			</tr>

			<tr style="text-align: justify !important;vertical-align:top;">
				<td width="10%">&nbsp;</td>
				<td width="3%">&nbsp;</td>

				<td width="7%">
					d.
				</td>

				<td width="79%">
					Berita Acara Evaluasi Hasil Pelaksanaan Uji Laik Operasi {!! $jenis_layanan !!}
					{{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }} tanggal
					{{ isset($data['tanggal_evaluasi_pelaksanaan_ulo'])
					    ? $date_reformat->date_lang_reformat_long($data['tanggal_evaluasi_pelaksanaan_ulo'])
					    : '' }};
				</td>
			</tr>

		</table>
	</div>

	<div>
		<p>Ditetapkan bahwa hasil pembangunan sarana dan prasarana yang dilaksanakan oleh :</p>
		<table style="text-align: justify !important;">
			<tr style="text-align: justify !important;vertical-align:top;">
				<td>a.</td>
				<td>Nama Perusahaan</td>
				<td>:</td>
				<td> {{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }}</td>
			</tr>

			<tr style="text-align: justify !important;vertical-align:top;">
				<td>b.</td>
				<td>Jenis Penyelenggaraan</td>
				<td>:</td>
				<td>{!! $jenis_layanan !!}</td>
			</tr>

			<tr style="text-align: justify !important;vertical-align:top;">
				<td>c.</td>
				<td>Alamat</td>
				<td>:</td>
				<td>{{ isset($datanib['alamat_perseroan']) ? $datanib['alamat_perseroan'] : '' }}
				</td>
			</tr>

		</table>
	</div>

	<div>
		<p style="text-align: justify !important;">Telah memenuhi syarat kelaikan operasi untuk penyelenggaraan
			telekomunikasi sesuai dengan ketentuan peraturan perundang-undangan.</p>
	</div>

	<div>
		<table>
			<tr>
				<td></td>
				<td>
					Ditetapkan di Jakarta
					<br />
					pada tanggal
					{{ isset($data['tgl_berlaku_ulo']) ? $date_reformat->date_lang_reformat_long($data['tgl_berlaku_ulo']) : '' }}
				</td>
			</tr>
			<tr>
				<td width="300px;">&nbsp;</td>
				<td style="text-align:center;">
					a.n MENTERI KOMUNIKASI DAN INFORMATIKA
					<br />REPUBLIK INDONESIA
					<br />DIREKTUR JENDERAL
					<br />PENYELENGGARAAN POS DAN INFORMATIKA
					<br /> u.b <br /> <br />
					<img style="width:70px;" src="data:image/png;base64, {!! base64_encode(
					    QrCode::format('svg')->size(100)->generate('https://e-telekomunikasi.kominfo.go.id/validasi-sk/' . $data['id_izin']),
					) !!} ">
					<img style="width:210px;" src="{{ public_path('global_assets/images/TTE Direktur.png') }}">
					<!-- <img style="width:70px;" src="{{ public_path('global_assets/images/qrcode.svg') }}">
																				<img style="width:210px;" src="{{ public_path('global_assets/images/TTE Direktur.png') }}"> -->
					<!-- <br/> DIREKTUR TELEKOMUNIKASI, -->
				</td>
				<td>
					<div class="visible-print text-center">
					</div>
				</td>
				<!-- </div> -->
			</tr>

			<!-- <tr>
			<td></td>
			<td>PENYELENGGARAAN POS DAN INFORMATIKA</td>
		</tr> -->

		</table>
	</div>

	<div class="page-break"></div>

	<div style="text-align:center !important;">
		<p><b>

				BERITA ACARA EVALUASI UJI LAIK OPERASI<br />
				{!! strtoupper($jenis_layanan) !!}<br />
				{{ isset($data['nama_perseroan']) ? strtoupper($data['nama_perseroan']) : '' }}
				<br />DIREKTORAT JENDERAL PENYELENGGARAAN POS DAN INFORMATIKA
				<!-- PENYELENGGARAAN POS DAN INFORMATIKA -->
			</b></p>
	</div>

	<div>
		<table style="text-align: justify !important;">
			<tr style="vertical-align:top;">
				<td>1.</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td style="text-align: justify !important;">
					Pada tanggal
					{{ isset($data['tanggal_evaluasi_pelaksanaan_ulo'])
					    ? $date_reformat->date_lang_reformat_long($data['tanggal_evaluasi_pelaksanaan_ulo'])
					    : '' }}
					telah
					selesai
					dilakukan Evaluasi Uji Laik Operasi dengan metode @if ($data['tipe_ulo'] == 1)
						Uji Petik
					@else
						Penilaian Mandiri
					@endif pada {!! $jenis_layanan !!} milik
					{{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }} dengan hasil sebagai berikut :
					<br />
					<br />
					<table class='table-inner' style="border-spacing:0px !important;">
						<tr style="vertical-align:top;">
							<td>No</td>
							<td>Metode Evaluasi</td>
							<td>Alamat Pusat Pelayanan Pelanggan</td>
							<td>Alamat Pelaksanaan ULO</td>
							<td>Hasil Evaluasi</td>
						</tr>

						<tr style="vertical-align:top;">
							<td style="vertical-align:top">
								<p>1</p>
							</td>
							<td style="vertical-align:top">
								@if ($data['tipe_ulo'] == 1)
									<p>Uji Petik</p>
								@else
									<p>Penilaian Mandiri</p>
								@endif
							</td>
							<td style="vertical-align:top">{!! isset($data['alamat_pusat_layanan_pelangan']) ? $data['alamat_pusat_layanan_pelangan'] : '' !!}</td>
							<td style="vertical-align:top">{!! isset($data['alamat_pelaksanaan_ulo']) ? $data['alamat_pelaksanaan_ulo'] : '' !!}</td>
							<td style="vertical-align:top">
								@if (isset($data['status_laik']))
									@if ($data['status_laik'] == 1)
										<p>Laik</p>
									@elseif ($data['status_laik'] == 0)
										<p>Tidak Laik</p>
									@else
										<p>Belum dievaluasi</p>
									@endif
								@else
									<p>Belum Dievaluasi</p>
								@endif
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<br />
			<tr style="text-align: justify !important;vertical-align:top;">
				<td>2.</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					Berita Acara ini merupakan bagian yang tidak terpisahkan dari proses uji laik operasi secara
					keseluruhan sesuai dengan ketentuan peraturan perundang-undangan.
				</td>
			</tr>
		</table>
	</div>
	<br /><br />
	<div>
		<table>
			<tr>
				<td width="450px;">&nbsp;</td>
				<!-- <td style="text-align:center;">
				DIREKTUR TELEKOMUNIKASI,
				
			</td> -->
			</tr>
		</table>
	</div>

</body>

</html>
