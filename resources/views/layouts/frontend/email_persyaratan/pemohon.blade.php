{{-- pemohon ulo --}}

<p style="text-left">Yth. {{ $email_data['izin']['nama_perseroan'] }}</p>
<p style="text-left">Permohonan Saudara dengan detail sebagai berikut telah berhasil kami terima.</p>

<p></p>

<table>
	<td> No. Permohonan </td>
	<td>: {{ $email_data['izin']['id_izin'] }}</td>
	{{-- <tr>
        <td>Tanggal Permohonan </td>
        <td>: {{$email_data['date']}}</td>
    </tr> --}}
	<tr>
		<td>Tanggal Permohonan </td>
		<td>: {{ $email_data['tgl_permohonan'] }}</td>
	</tr>
	<tr>
		<td>Nama Perusahaan </td>
		<td>: {{ $email_data['izin']['nama_perseroan'] }}</td>
	</tr>
	@if (substr($email_data['izin']['id_izin'], 0, 3) !== 'TKI')
		<tr>
			<td>Nomor Izin Berusaha (NIB) </td>
			<td>: {{ $email_data['izin']['nib'] }}</td>
		</tr>
	@endif
	<tr>
		<td>KBLI </td>
		<td>: {{ $email_data['izin']['full_kbli'] }}</td>
	</tr>
	<tr>
		<td>Jenis Layanan </td>
		<td>: {!! isset($email_data['izin']['jenis_layanan_html']) ? $email_data['izin']['jenis_layanan_html'] : '-' !!}
		</td>
	</tr>
	@if ($email_data['jenis_penomoran'] !== '')
		<tr>
			<td>Jenis Permohonan </td>
			<td>: {{ $email_data['jenis_permohonan'] }}</td>
		</tr>
		<tr>
			<td>Jenis Penomoran </td>
			<td>: {{ $email_data['jenis_penomoran'] }}</td>
		</tr>
	@endif
	{{-- @if ($email_data['nomor_kodeakses'] !== '')
        <tr>
            <td>Kode Akses </td>
            <td>: {{ $email_data['nomor_kodeakses'] }}</td>
        </tr>
    @endif --}}
	@if ($email_data['full_kode_akses'] !== '')
		<tr>
			<td>Kode Akses </td>
			<td>: {{ $email_data['full_kode_akses'] }}</td>
		</tr>
	@endif
	@if ($email_data['kode_akses'] !== '')
		<tr>
			<td>Kode Akses </td>
			<td>: {{ $email_data['kode_akses'] }} {{ $email_data['prefix'] }}</td>
		</tr>
	@endif
	<tr>
		<td>URL </td>
		<td>: <a href="{{ url('/') }}">{{ url('/') }}</a></td>
	</tr>
</table>

<p>Untuk tahapan selanjutnya, akan kami informasikan melalui email e-telekomunikasi@kominfo.go.id</p>

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
