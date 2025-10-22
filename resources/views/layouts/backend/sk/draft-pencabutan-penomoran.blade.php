<!DOCTYPE html>
<html>

<head>
	<title>Surat Penetapan Pencabutan Penomoran</title>

	<style type="text/css">
		@page {
			size: legal;
			margin-top: 2cm;
			/* Adjust the top margin as needed */
			margin-right: 2cm;
			/* Adjust the right margin as needed */
			margin-bottom: 2.5cm;
			/* Adjust the bottom margin as needed */
			margin-left: 3cm;
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
			font-size: 12pt;
			font-family: "Bookman", "Bookman Old Style", "Garamond", "Times New Roman", serif;
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
		{{-- <h2 class="judul">PEMERINTAH REPUBLIK INDONESIA</h2> --}}
		{{-- <h2 class="judul">PERIZINAN BERUSAHA UNTUK MENUNJANG KEGIATAN BERUSAHA</h2> --}}
		{{-- <h4 class="isi">PENOMORAN TELEKOMUNIKASI</h4> --}}
		<h2 class="judul">PENCABUTAN PENETAPAN {!! isset($penomoran_alokasi->full_name_html) ? strtoupper($penomoran_alokasi->full_name_html) : '' !!}</h2>
		<h2 class="judul">
			{{ isset($penomoran_alokasi->nama_perseroan) ? strtoupper($penomoran_alokasi->nama_perseroan) : '' }}
		</h2>
		<h2 class="judul">Nomor : {{ isset($no_izin) ? $no_izin : '' }}</h2>
	</div>
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
					Peraturan Menteri Komunikasi dan Informatika Nomor 14 Tahun 2018 tentang Rencana
					Dasar
					Teknis
					(<i>Fundamental Technical Plan</i>)
					Telekomunikasi Nasional;
				</td>
			<tr style="vertical-align:top !important;">
				<td width="5%">&nbsp;</td>
				<td width="2%">&nbsp;</td>
				<td width="2%">
					b.
				</td>
				<td width="91%">
					Peraturan Menteri Komunikasi dan Informatika Nomor 5 Tahun 2021 tentang
					Penyelenggaraan
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
					Keputusan Menteri Komunikasi dan Informatika Nomor 793 Tahun 2018 tentang Pemberian
					Kewenangan
					Penandatanganan Dokumen Bidang Penyelenggaraan Pos dan Informatika Dalam Rangka
					Pelayanan Prima di
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
					Keputusan Direktur Jenderal Penyelenggaraan Pos dan Informatika Nomor 167 Tahun 2018
					tentang
					Pemberian Kewenangan Penandatanganan Dokumen Bidang Penyelenggaraan Pos dan
					Informatika
					Dalam Rangka
					Pelayanan Prima di Lingkungan Direktorat Jenderal Penyelenggaraan Pos dan
					Informatika
					sebagaimana
					telah diubah dengan Keputusan Direktur Jenderal Penyelenggaraan Pos dan Informatika
					Nomor 130 Tahun
					2020 tentang Perubahan Keputusan Direktur Jenderal Penyelenggaraan Pos dan
					Informatika
					Nomor 167
					Tahun 2018 tentang Pemberian Kewenangan Penandatanganan Dokumen Bidang
					Penyelenggaraan
					Pos dan
					Informatika Dalam Rangka Pelayanan Prima di Lingkungan Direktorat Jenderal
					Penyelenggaraan Pos dan
					Informatika;
				</td>
			</tr>
			@if (isset($penomoran_alokasi->dasar_pencabutan))
				<tr style="vertical-align:top !important;">
					<td width="5%">&nbsp;</td>
					<td width="2%">&nbsp;</td>
					<td width="2%">
						e.
					</td>
					<td width="91%">
						{{ isset($penomoran_alokasi->dasar_pencabutan) ? $penomoran_alokasi->dasar_pencabutan : '' }}
					</td>
				</tr>
			@endif
		</table>
		<table style="text-align: justify !important;width:100%;padding-right:10px;">
			<tr style="vertical-align:top !important;">
				<td style="padding-left:10px;" colspan="3">
					<p>{{ isset($penomoran_alokasi->pertimbangan_pencabutan) ? $penomoran_alokasi->pertimbangan_pencabutan : '' }}
					</p>
					<p>Berdasarkan hal tersebut, maka penetapan penggunaan {!! isset($penomoran_alokasi->full_name_html) ? $penomoran_alokasi->full_name_html : '' !!}
						{{ isset($penomoran_alokasi->kode_akses) ? $penomoran_alokasi->kode_akses : '' }} sebagaimana
						ditetapkan pada penetapan nomor
						{{ isset($penomoran_alokasi->nomor_penetapan) ? $penomoran_alokasi->nomor_penetapan : '' }}
						tanggal
						{{ isset($penomoran_alokasi->tanggal_penetapan) ? $date_reformat->date_lang_reformat_long($penomoran_alokasi->tanggal_penetapan) : '' }},
						dicabut dan dinyatakan tidak
						berlaku.
					</p>
				</td>
			</tr>
			@if ($penomoran_alokasi->jenis_penomoran == 'Kode Akses Pusat Panggilan Informasi (Call Center)')
				<tr style="vertical-align:top !important;">
					<td style="padding-left:10px;" colspan="3">

						{{ isset($penomoran_alokasi->nama_perseroan) ? strtoupper($penomoran_alokasi->nama_perseroan) : 'Pelaku Usaha' }}
						wajib menginformasikan kepada
						pihak-pihak terkait untuk menonaktifkan kode akses
						{{ isset($d->kode_akses) ? $d->kode_akses : '' }}
						dan menghapus kode akses tersebut pada semua media informasi yang tersedia.

					</td>
				</tr>
			@endif

		</table>
		<table>
			<tr>
				<td width="200px;">&nbsp;</td>
				<td style="text-align:center;">
					Jakarta,
					{{ isset($penomoran_alokasi->effective_date) ? $date_reformat->date_lang_reformat_long($penomoran_alokasi->effective_date) : '' }}
					<br />a.n MENTERI KOMUNIKASI DAN INFORMATIKA
					<br />REPUBLIK INDONESIA
					<br />DIREKTUR JENDERAL PENYELENGGARAAN
					<br />POS DAN INFORMATIKA
					<br /> u.b
					<br /> DIREKTUR TELEKOMUNIKASI,<br /> <br />
					<img style="width:70px;" src="data:image/png;base64, {!! base64_encode(
					    QrCode::format('svg')->size(100)->generate('https://e-telekomunikasi.kominfo.go.id/validasi-sk/' . $penomoran_alokasi->id),
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
