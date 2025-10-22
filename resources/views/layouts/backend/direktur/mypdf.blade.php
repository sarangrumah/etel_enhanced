<!DOCTYPE html>
<html>

<head>
	<title>Laravel 8 Generate PDF From View</title>

	<style type="text/css">
		.page-break {
			page-break-after: always;
		}

		.table-inner tr td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
		}
	</style>
</head>

<body>
	<div style="text-align:center !important;"><img style="width:120px;"
			src="{{ public_path('global_assets/images/logo_kominfo.png') }}"></div>
	<div style="text-align:center !important;">
		<h2>SURAT KETERANGAN LAIK OPERASI</h2>
		<h3>Nomor : {{ isset($data['no_izin']) ? $data['no_izin'] : '' }}</h3>
	</div>

	<div>
		<table>
			<tr style="vertical-align:top !important;">
				<td width="20%">
					Dasar
				</td>
				<td width="3%">
					:
				</td>

				<td width="7%">
					a.
				</td>

				<td width="69%">
					bahwa {{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }}
					telah memperoleh Nomor Induk Berusaha (NIB) Nomor {{ isset($data['nib']) ? $data['nib'] : '' }} dan
					Klasifikasi Baku Lapangan Usaha Indonesia (KBLI) {{ isset($data['kbli']) ? $data['kbli'] : '' }};
				</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="20%">&nbsp;</td>
				<td width="3%">&nbsp;</td>

				<td width="7%">
					b.
				</td>

				<td width="69%">
					Berdasarkan surat Direktur Utama {{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }}
					Nomor: … tanggal … perihal …;
				</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="20%">&nbsp;</td>
				<td width="3%">&nbsp;</td>

				<td width="7%">
					c.
				</td>

				<td width="69%">
					Surat Tugas Direktur Telekomunikasi Nomor : … tanggal … untuk melaksanakan Uji Laik Operasi (ULO)
					{!! isset($data['jenis_layanan_html']) ? $data['jenis_layanan_html'] : '' !!}
					{{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }}
				</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="20%">&nbsp;</td>
				<td width="3%">&nbsp;</td>

				<td width="7%">
					d.
				</td>

				<td width="69%">
					Berita Acara Evaluasi Hasil Pelaksanaan Uji Laik Operasi {!! isset($data['jenis_layanan_html']) ?
					$data['jenis_layanan_html'] : '' !!} {{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] :
					'' }} tanggal ….;
				</td>
			</tr>

		</table>
	</div>

	<div>
		<p>Ditetapkan bahwa hasil pembangunan sarana dan prasarana yang dilaksanakan oleh :</p>
		<table>
			<tr style="vertical-align:top;">
				<td>a.</td>
				<td>Nama Perusahaan</td>
				<td>:</td>
				<td>{{ isset($data['nama_perseroan']) ? $data['nama_perseroan'] : '' }}</td>
			</tr>

			<tr style="vertical-align:top;">
				<td>b.</td>
				<td>Jenis Penyelenggaraan</td>
				<td>:</td>
				<td>{!! isset($data['jenis_layanan_html']) ? $data['jenis_layanan_html'] : '' !!}</td>
			</tr>

			<tr style="vertical-align:top;">
				<td>c.</td>
				<td>Alamat</td>
				<td>:</td>
				<td>...</td>
			</tr>

		</table>
	</div>

	<div>
		<p>Telah memenuhi syarat kelaikan operasi untuk penyelenggaraan telekomunikasi sesuai dengan ketentuan peraturan
			perundang-undangan.</p>
	</div>

	<div>
		<table>
			<tr>
				<td></td>
				<td>
					Ditetapkan di Jakarta pada
					<br />
					tanggal ....
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

	<div class="page-break"></div>

	<div style="text-align:center !important;">
		<h3>
			BERITA ACARA EVALUASI UJI LAIK OPERASI {!! isset($data['jenis_layanan_html']) ?
			strtoupper($data['jenis_layanan_html']) : '' !!}
			<br />{{ isset($data['nama_perseroan']) ? strtoupper($data['nama_perseroan']) : '' }}
			<br />DIREKTORAT JENDERAL PENYELENGGARAAN POS DAN INFORMATIKA
		</h3>
	</div>

	<div>
		<table>
			<tr style="vertical-align:top;">
				<td>1.</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					Pada hari ini Rabu tanggal 29 bulan Desember tahun 2021, telah selesai dilakukan Evaluasi Uji Laik
					Operasi dengan metode Uji Petik pada {!! isset($data['jenis_layanan_html']) ?
					$data['jenis_layanan_html'] : '' !!} milik {{ isset($data['nama_perseroan']) ?
					$data['nama_perseroan'] : '' }} dengan hasil sebagai berikut:
					<br />
					<br />
					<table class='table-inner' style="border-spacing:0px !important;">
						<tr>
							<td>No</td>
							<td>Metode Evaluasi</td>
							<td>Alamat Pusat Pelayanan Pelanggan</td>
							<td>Alamat Pelaksanaan ULO</td>
							<td>Hasil Evaluasi</td>
						</tr>

						<tr>
							<td>1</td>
							<td>Uji Petik</td>
							<td></td>
							<td></td>
							<td>Laik</td>
						</tr>
					</table>
				</td>
			</tr>
			<br />
			<tr style="vertical-align:top;">
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
				<td style="text-align:center;">
					DIREKTUR TELEKOMUNIKASI,

				</td>
			</tr>
		</table>
	</div>

</body>

</html>