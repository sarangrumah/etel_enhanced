<!DOCTYPE html>
<html>

<head>
	<title>Surat Ketetapan Izin Penyelenggaraan Telekomunikasi Khusus Instansi Pemerintah</title>

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
			font-size: 12px;
		}

		h2 {
			font-weight: normal;
		}
	</style>
</head>

<body>
	{{-- <div class="watermark">
        DRAF
    </div> --}}

	<div style="text-align:center !important;">
		<img style="width:120px;" src="{{ public_path('global_assets/images/logo_kominfo.png') }}">
	</div>
	<div style="text-align:center !important;">
		<p>
			KEPUTUSAN MENTERI KOMUNIKASI DAN INFORMATIKA<br />REPUBLIK INDONESIA
			<br />
			NOMOR : {{ strtoupper($IzinPrinsip['no_izin_penyelenggaraan']) }}
		</p>
		<p>
			TENTANG
			<br />
			IZIN PENYELENGGARAAN TELEKOMUNIKASI KHUSUS<br /> UNTUK KEPERLUAN INSTANSI PEMERINTAH
			<br />
			{{ strtoupper($data['nama_perseroan']) }}
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
				@if ($id_trxizinip_stat == 0)
					<td width="69%">
						bahwa {{ strtoupper($data['nama_perseroan']) }} telah memperoleh Izin Prinsip Penyelenggaraan
						Telekomunikasi Khusus
						untuk Keperluan Instansi Pemerintah berdasarkan keputusan Menteri Komunikasi dan Informatika
						Nomor {{ isset($data['no_izin_prinsip']) ? $data['no_izin_prinsip'] : '' }} tanggal
						{{ isset($data['tgl_izin_prinsip_init']) ? $date_reformat->date_lang_reformat_long($data['tgl_izin_prinsip_init']) : '' }}
						dan Surat Keterangan Laik Operasi
						Penyelenggaraan Telekomunikasi Khusus untuk Keperluan Instansi Pemerintah dengan nomor
						{{ strtoupper($data['no_sk_ulo']) }}
						tanggal
						{{ isset($data['tgl_izin_prinsip_ulo']) ? $date_reformat->date_lang_reformat_long($data['tgl_izin_prinsip_ulo']) : '' }};
					</td>
				@else
					<td width="69%">
						bahwa {{ strtoupper($data['nama_perseroan']) }} telah memperoleh Izin Prinsip Penyelenggaraan
						Telekomunikasi Khusus
						untuk Keperluan Instansi Pemerintah berdasarkan keputusan Menteri Komunikasi dan Informatika
						Nomor {{ isset($data['no_izin_prinsip']) ? $data['no_izin_prinsip'] : '' }} tanggal
						{{ isset($data['tgl_izin_prinsip_init']) ? $date_reformat->date_lang_reformat_long($data['tgl_izin_prinsip_init']) : '' }},
						Perpanjangan Izin Prinsip Penyelenggaraan
						Telekomunikasi Khusus
						untuk Keperluan Instansi Pemerintah berdasarkan keputusan Menteri Komunikasi dan Informatika
						Nomor {{ isset($data['no_izin_prinsip_ext']) ? $data['no_izin_prinsip_ext'] : '' }}
						tanggal
						{{ isset($data['tgl_izin_prinsip_ext_init']) ? $date_reformat->date_lang_reformat_long($data['tgl_izin_prinsip_ext_init']) : '' }}
						dan Surat Keterangan Laik Operasi
						Penyelenggaraan Telekomunikasi Khusus untuk Keperluan Instansi Pemerintah dengan nomor
						{{ strtoupper($data['no_sk_ulo']) }}
						tanggal
						{{ isset($data['tgl_izin_prinsip_ulo']) ? $date_reformat->date_lang_reformat_long($data['tgl_izin_prinsip_ulo']) : '' }};
					</td>
				@endif
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="12%">&nbsp;</td>
				<td width="1%">&nbsp;</td>
				<td width="2%">b.</td>
				<td width="69%">bahwa {{ strtoupper($data['nama_perseroan']) }} telah memenuhi persyaratan sesuai
					dengan ketentuan
					peraturan perundang-undangan;</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="12%">&nbsp;</td>
				<td width="1%">&nbsp;</td>
				<td width="2%">c.</td>
				<td width="69%">berdasarkan pertimbangan huruf a dan huruf b, perlu menetapkan Keputusan Menteri
					Komunikasi dan Informatika tentang Izin Penyelenggaraan Telekomunikasi Khusus untuk Keperluan
					Instansi Pemerintah {{ strtoupper($data['nama_perseroan']) }}.</td>
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
					KEPUTUSAN MENTERI KOMUNIKASI DAN INFORMATIKA TENTANG IZIN PENYELENGGARAAN TELEKOMUNIKASI KHUSUS
					UNTUK KEPERLUAN INSTANSI PEMERINTAH {{ strtoupper($data['nama_perseroan']) }}.
				</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="12%">KESATU</td>
				<td width="1%">:</td>
				<td width="69%">
					Memberikan Izin Penyelenggaraan Telekomunikasi Khusus untuk Keperluan Instansi Pemerintah kepada
					{{ strtoupper($data['nama_perseroan']) }}.
				</td>
			</tr>

			<tr style="vertical-align:top !important;">
				<td width="12%">KEDUA</td>
				<td width="1%">:</td>
				<td width="69%">
					{{ strtoupper($data['nama_perseroan']) }} wajib mematuhi ketentuan peraturan perundang-undangan
					yang
					berlaku.
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
					Ditetapkan di Jakarta
					<br />
					pada tanggal
					{{ isset($data['tgl_izin_prinsip_ulo']) ? $date_reformat->date_lang_reformat_long($data['tgl_izin_prinsip_ulo']) : '' }}
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
		LAMPIRAN I<br />
		KEPUTUSAN MENTERI KOMUNIKASI DAN INFORMATIKA<br />
		REPUBLIK INDONESIA<br />
		NOMOR : {{ strtoupper($IzinPrinsip['no_izin_penyelenggaraan']) }}<br />
		TENTANG IZIN PENYELENGGARAAN TELEKOMUNKASI KHUSUS UNTUK KEPERLUAN INSTANSI PEMERINTAH <br />
		{{ strtoupper($data['nama_perseroan']) }}
	</div>

	<div style="text-align:center !important;margin-top:30px;">
		CAKUPAN WILAYAH LAYANAN <br />PENYELENGGARAAN TELEKOMUNIKASI KHUSUS
		UNTUK KEPERLUAN INSTANSI PEMERINTAH<br />
		{{ strtoupper($data['nama_perseroan']) }}
	</div>

	@if (count($map_izin) > 0)
		@foreach ($map_izin as $key => $mi)
			@if ($mi->file_type == 'table' && $mi->component_name != null && $mi->component_name != 'daftar_perangkat_telsus')
				@if (isset($mi->form_isian))
					<div class="form-group">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-12">
									@if (isset($mi->form_isian))
										@php
											$triger = 'true';
											$sk = 'true';
										@endphp
										{{-- <p class="font-weight-bold">{!! $mi->persyaratan_html !!}</p> --}}
										<x-dynamic-component :component="$mi->component_name" :triger="$triger ?? 'null'" :datajson="$mi->form_isian ?? 'kosong'" :needcorrection="$mi->need_correction ?? ''" :correctionnote="$mi->correction_note ?? ''"
											:sk="$sk ?? 'null'" />
										<hr>
									@endif
								</div>

							</div>
						</div>
					</div>
				@endif
			@endif
		@endforeach
	@endif
	<br /><br />
	<div>
		<table>
			<tr>
				<td></td>
				<td>
					<p>Ditetapkan di Jakarta
						<br />
						pada tanggal
						{{ isset($data['tgl_izin_prinsip_ulo']) ? $date_reformat->date_lang_reformat_long($data['tgl_izin_prinsip_ulo']) : '' }}
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
					<br /> DIREKTUR TELEKOMUNIKASI,<br />

					<img style="width:70px;" src="data:image/png;base64, {!! base64_encode(
					    QrCode::format('svg')->size(100)->generate('https://e-telekomunikasi.kominfo.go.id/validasi-sk/' . $data['id_izin']),
					) !!} ">
					<img style="width:210px;" src="{{ public_path('global_assets/images/TTE Direktur.png') }}">
				</td>
			</tr>

		</table>
	</div>

	{{-- <div class="page-break"></div>

    <div style="margin-left:35%;">
        LAMPIRAN I<br />
        KEPUTUSAN MENTERI KOMUNIKASI DAN INFORMATIKA<br />
        REPUBLIK INDONESIA<br />
        NOMOR<br />
        TENTANG IZIN PENYELENGGARAAN TELEKOMUNKASI KHUSUS UNTUK KEPERLUAN INSTANSI PEMERINTAH <br />
        {{ strtoupper($data['nama_perseroan']) }}
    </div>

    <div style="text-align:center !important;margin-top:30px;">
        TOPOLOGI JARINGAN PENYELENGGARAAN TELEKOMUNIKASI KHUSUSCAKUPAN WILAYAH LAYANAN PENYELENGGARAAN TELEKOMUNIKASI
        KHUSUS<br />
        UNTUK KEPERLUAN INSTANSI PEMERINTAH<br />
        {{ strtoupper($data['nama_perseroan']) }}
    </div>

    <div>
        <div>
            <p>a. Media Transmisi: Kawat/Serat Optik</p>
        </div>

        <div>
            <p>b. Media Transmisi: Spektrum Frekuensi Radio - Komunikasi Radio Konvensional</p>
        </div>

        <div>
            <p>c. Media Transmisi: Spektrum Frekuensi Radio - Komunikasi Radio Trunking</p>
        </div>

        <div>
            <p>d. Media Transmisi: Spektrum Frekuensi Radio – Sistem Komunikasi Radio untuk Data </p>
        </div>

        <div>
            <p>e. Media Transmisi: Sistem Komunikasi Radio untuk Sistem Komunikasi Satelit</p>
        </div>
    </div>

    <div>
        <table>
            <tr>
                <td></td>
                <td>
                    Ditetapkan di Jakarta
                    <br />
                    pada tanggal
                    {{ isset($data['updated_date']) ? $date_reformat->dateday_lang_reformat_long($data['updated_date']) : '' }}
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

        </table>
    </div> --}}
</body>

</html>
