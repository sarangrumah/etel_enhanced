{{-- pemohon ulo --}}

<p style="text-left">Yth. {{ $email_data['nama'] }}</p>
<p style="font-size: 14px; line-height: 170%;"><span
		style="font-size: 16px; font-weight:bold; line-height: 27.2px;">{{ isset($email_data['jabatan']) ? $email_data['jabatan'] : '' }}</span>
</p>
<p style="text-left">Anda mendapat notifikasi perubahan tanggal pelaksanaan uji laik operasi dengan detail sebagai
	berikut:</p>

<p></p>

<table>
	<tr>
		<td> No. Permohonan </td>
		<td>: {{ isset($email_data['id_izin']) ? $email_data['id_izin'] : '-' }}</td>
	</tr>
	<tr>
		<td>Tanggal Permohonan </td>
		<td>: {{ isset($email_data['tanggal_permohonan']) ? $email_data['tanggal_permohonan'] : '-' }}</td>
	</tr>
	<tr>
		<td>Tanggal Pelaksanaan Evaluasi Uji Laik Operasi </td>
		<td>: {{ isset($email_data['tgl_before_formatted']) ? $email_data['tgl_before_formatted'] : '-' }}</td>
	</tr>
	<tr>
		<td>Tanggal Pelaksanaan Evaluasi Uji Laik Operasi Sebelumnya </td>
		<td>: {{ isset($email_data['updated_date']) ? $email_data['updated_date'] : '-' }}</td>
	</tr>
	<tr>
		<td>Nama Perusahaan </td>
		<td>: {{ isset($email_data['nama_perseroan']) ? $email_data['nama_perseroan'] : '-' }}</td>
	</tr>
	@if (substr($email_data['id_izin'], 0, 3) != 'TKI')
		<tr>
			<td>Nomor Izin Berusaha (NIB) </td>
			<td>: {{ isset($email_data['nib']) ? $email_data['nib'] : '-' }}</td>
		</tr>
	@endif
	<tr>
		<td>KBLI </td>
		<td>: {{ isset($email_data['full_kbli']) ? $email_data['full_kbli'] : '-' }}</td>
	</tr>
	<tr>
		<td>Jenis Layanan </td>
		<td>: {!! isset($email_data['jenis_layanan_html']) ? $email_data['jenis_layanan_html'] : '-' !!}
		</td>
	</tr>

	<tr>
		<td>URL </td>
		<td>: <a href="{{ url('/login') }}">{{ url('/login') }}</a></td>
	</tr>
</table>

@if ($email_data['tipe_ulo'] == '2')
	<p> Harap lakukan pemenuhan syarat evaluasi Uji Laik Operasi sebelum hari/tanggal
		{{ isset($email_data['tgl_before_formatted']) ? $email_data['tgl_before_formatted'] : '-' }}.</p>
@else
@endif
<p>Demikian informasi yang bisa kami sampaikan. Terima Kasih</p>

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
