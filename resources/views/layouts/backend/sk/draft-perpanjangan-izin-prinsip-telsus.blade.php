<!DOCTYPE html>
<html>

<head>
	<title>Surat Ketetapan Perpanjangan Izin Prinsip Telekomunikasi Khusus Instansi Pemerintah</title>

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
			font-size: 12px;
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

	<div style="text-align:center !important;">
		<img style="width:120px;" src="{{ public_path('global_assets/images/logo_kominfo.png') }}">
	</div>
	<div style="text-align:center !important;">
		<p>
			KEPUTUSAN MENTERI KOMUNIKASI DAN INFORMATIKA<br />REPUBLIK INDONESIA
			<br />
			NOMOR : {{ $nomor_sklo }}
		</p>
		<p>
			TENTANG<br />
			PERPANJANGAN IZIN PRINSIP PENYELENGGARAAN TELEKOMUNIKASI KHUSUS <br />
			UNTUK KEPERLUAN INSTANSI PEMERINTAH<br />
			{{ strtoupper($data->nama_perseroan) }}
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
				<td width="2%">a.</td>
				<td width="69%">
					bahwa {{ strtoupper($data->nama_perseroan) }} telah memperoleh Izin Prinsip Penyelenggaraan
					Telekomunikasi Khusus
					untuk Keperluan Instansi Pemerintah berdasarkan Keputusan Menteri Komunikasi dan Informatika Nomor
					{{ $data->no_izin_prinsip }}
					tanggal
					{{ isset($data->tgl_izin_prinsip_init) ? $date_reformat->date_lang_reformat_long($data->tgl_izin_prinsip_init) : '' }};
				</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="12%">&nbsp;</td>
				<td width="1%">&nbsp;</td>
				<td width="2%">b.</td>
				<td width="69%">bahwa {{ strtoupper($data->nama_perseroan) }} telah mengajukan permohonan
					Perpanjangan Izin Prinsip
					Penyelenggaraan Telekomunikasi Khusus untuk Keperluan Instansi Pemerintah dengan nomor permohonan
					{{ $data->id_izin }}
					tanggal
					{{ isset($data->submitted_date) ? $date_reformat->date_lang_reformat_long($data->submitted_date) : '' }};
				</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="12%">&nbsp;</td>
				<td width="1%">&nbsp;</td>
				<td width="2%">c.</td>
				<td width="69%">bahwa {{ strtoupper($data->nama_perseroan) }} telah memenuhi persyaratan sesuai
					dengan ketentuan peraturan perundang-undangan;</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="12%">&nbsp;</td>
				<td width="1%">&nbsp;</td>
				<td width="2%">d.</td>
				<td width="69%">berdasarkan pertimbangan huruf a, huruf b dan huruf c, perlu menetapkan Keputusan
					Menteri Komunikasi dan Informatika tentang Perpanjangan Izin Prinsip Penyelenggaraan Telekomunikasi
					Khusus untuk Keperluan Instansi Pemerintah {{ strtoupper($data->nama_perseroan) }}.</td>
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
					KEPUTUSAN MENTERI KOMUNIKASI DAN INFORMATIKA TENTANG PERPANJANGAN IZIN PRINSIP PENYELENGGARAAN
					TELEKOMUNIKASI KHUSUS UNTUK KEPERLUAN INSTANSI PEMERINTAH {{ strtoupper($data->nama_perseroan) }}.
				</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="12%">KESATU</td>
				<td width="1%">:</td>
				<td width="69%">
					Memberikan perpanjangan masa berlaku Izin Prinsip Penyelenggaraan Telekomunikasi Khusus untuk
					Keperluan Instansi Pemerintah sebagaimana tercantum dalam Keputusan Menteri Komunikasi dan
					Informatika Nomor {{ $data->no_izin_prinsip }} tanggal
					{{ isset($data->tgl_izin_prinsip_init) ? $date_reformat->date_lang_reformat_long($data->tgl_izin_prinsip_init) : '' }}.
				</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="12%">KEDUA</td>
				<td width="1%">:</td>
				<td width="69%">
					Perpanjangan izin prinsip ini diberikan selama 1 (satu) tahun sejak keputusan ini mulai berlaku.
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
					<p>Ditetapkan di Jakarta
						<br />
						pada tanggal
						{{ isset($data->tgl_izin_prinsip_ext_init) ? $date_reformat->date_lang_reformat_long($data->tgl_izin_prinsip_ext_init) : '' }}
					</p>
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
					<br /> DIREKTUR TELEKOMUNIKASI,<br /> <br />

					<img style="width:70px;" src="data:image/png;base64, {!! base64_encode(
					    QrCode::format('svg')->size(100)->generate('https://e-telekomunikasi.kominfo.go.id/validasi-sk/' . $data->id_izin),
					) !!} ">
					<img style="width:210px;" src="{{ public_path('global_assets/images/TTE Direktur.png') }}">

				</td>
			</tr>

		</table>
	</div>
	<div>
		<p style="margin-top:100px;">
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

</body>

</html>
