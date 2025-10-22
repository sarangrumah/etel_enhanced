{{-- pemohon ulo --}}

<p style="text-left">Yth. Peserta Bimbingan Teknis</p>
<p style="text-left">Permohonan Bimbingan Teknis akan dilaksanakan melalui Zoom Meeting dengan detail sebagai berikut:
</p>

<p></p>

<table>
	<td> Meeting ID </td>
	<td>: {{ isset($email_data['meeting_id']) ? $email_data['meeting_id'] : '-' }}</td>
	<tr>
		<td>Judul Bimbingan Teknis </td>
		<td>: {{ $email_data['meeting_subject'] }}</td>
	</tr>
	<tr>
		<td>Link Zoom </td>
		<td>: {{ isset($email_data['meeting_link']) ? $email_data['meeting_link'] : '-' }}</td>
	</tr>
	<tr>
		<td>Meeting Passcode </td>
		<td>: {{ isset($email_data['meeting_passcode']) ? $email_data['meeting_passcode'] : '-' }}</td>
	</tr>
	<tr>
		<td>Tanggal dan Jam Bimbingan </td>
		<td>: {{ isset($email_data['meeting_date_start']) ? $email_data['meeting_date_start'] : '-' }} -
			{{ isset($email_data['meeting_date_end']) ? $email_data['meeting_date_end'] : '-' }}</td>
	</tr>

	<p> Untuk dapat hadir dengan jadwal yang sudah disesuaikan.</p>
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
