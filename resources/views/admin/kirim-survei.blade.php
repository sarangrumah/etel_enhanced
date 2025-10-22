{{-- pemohon ulo --}}

<p style="text-left">Yth. {{ $email_data['nama'] }}</p>
<p style="font-size: 14px; line-height: 170%;"><span
		style="font-size: 16px; font-weight:bold; line-height: 27.2px;">{{ $email_data['nib']['nama_perseroan'] }}</span>
</p>
<p style="text-left">Permohonan Penetapan Penomoran Telekomunikasi Saudara <b>&nbsp;telah disetujui</b> dengan detail
	permohonan sebagai berikut: </p>

<p></p>

<table>
	<td> No. Permohonan </td>
	<td>: {{ isset($email_data['izin']['id_izin']) ? $email_data['izin']['id_izin'] : '-' }}</td>
	<tr>
		<td>Tanggal Permohonan </td>
		<td>: {{ $email_data['tgl_permohonan'] }}</td>
	</tr>
	<tr>
		<td>Nama Perusahaan </td>
		<td>: {{ isset($email_data['nib']['nama_perseroan']) ? $email_data['nib']['nama_perseroan'] : '-' }}</td>
	</tr>
	@if ($email_data['izin']['jenis_pu'] == 'PTB')
		<tr>
			<td>Nomor Izin Berusaha (NIB) </td>
			<td>: {{ isset($email_data['izin']['nib']) ? $email_data['izin']['nib'] : '-' }}</td>
		</tr>
		<tr>
			<td>KBLI </td>
			<td>: {{ isset($email_data['izin']['full_kbli']) ? $email_data['izin']['full_kbli'] : '-' }}</td>
		</tr>
	@endif
	<tr>
		<td>Jenis Permohonan </td>
		<td>: {!! isset($email_data['izin']['jenis_permohonan']) ? $email_data['izin']['jenis_permohonan'] : '-' !!}
		</td>
	</tr>
	<tr>
		<td>Nama Evaluator</td>
		<td>: {{ $email_data['nama2'] }}</td>
	</tr>
	@if ($email_data['jenis_penomoran'] !== '')
		<tr>
			<td>Jenis Permohonan Penomoran</td>
			<td>: {{ $email_data['jenis_permohonan'] }}</td>
		</tr>
		<tr>
			<td>Jenis Penomoran </td>
			<td>: {{ $email_data['jenis_penomoran'] }}</td>
		</tr>
	@endif
	@if ($email_data['izin']['kode_akses']['kode_akses'] !== '')
		<tr>
			<td>Kode Akses </td>
			<td>: {{ $email_data['izin']['kode_akses']['kode_akses'] }}</td>
		</tr>
	@endif
</table>

<p> Untuk dapat mengunduh Surat Penetapan Penomoran, silakan Saudara terlebih dahulu melakukan pengisian survei
	Pelayanan Publik Direktorat Telekomunikasi Bidang Penomoran pada tautan: {{ $email_data['link_survey'] }}</p>
<p> Terima Kasih</p>

<p style="margin-bottom:2px">Kontak Kami:</p>
<table>
	<tr>
		<td>DITJEN PPI KEMENTERIAN KOMUNIKASI DAN INFORMATIKA</td>
	</tr>
	<tr>
		<td>Jl. Medan Merdeka Barat No. 9, Jakarta Pusat, 10110</td>
	</tr>
	<tr>
		<td>Call Center: 159</td>
	</tr>
	<tr>
		<td>Pelayanan Terpadu Satu Pintu</td>
	</tr>
	<tr>
		<td>Email : helpdesk@pelayananprimaditjenppi.go.id</td>
	</tr>
</table>

<p style="margin-bottom:2px; text-muted">Ini adalah e-mail otomatis yang dikirim oleh layanan e-Telekomunikasi, Harap
	tidak membalas e-mail berikut.</p>
