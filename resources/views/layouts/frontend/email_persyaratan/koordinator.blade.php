{{-- evaluator ulo --}}

<p style="text-left">Yth. {{ $email_data['nama'] }}</p>
<p style="font-size: 14px; line-height: 170%;"><span
        style="font-size: 16px; font-weight:bold; line-height: 27.2px;">{{ $email_data['jabatan'] }}</span></p>

<p>Anda mendapat permohonan persyaratan Izin Penyelenggaraan Telekomunikasi baru dengan detil permohonan sebagai berikut
    telah masuk ke dalam sistem dan siap diproses.</p>

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
        <td>KBLI</td>
        <td>: {{ $email_data['izin']['full_kbli'] }}</td>
    </tr>
    <tr>
        <td>Jenis Layanan </td>
        <td>: {!! isset($email_data['izin']['jenis_layanan_html']) ? $email_data['izin']['jenis_layanan_html'] : '-' !!}
        </td>
    </tr>
    @if ($email_data['jenis_penomoran'] !== '')
        <tr>
            <td>Jenis Penomoran </td>
            <td>: {{ $email_data['jenis_penomoran'] }}</td>
        </tr>
        <tr>
            <td>Jenis Permohonan </td>
            <td>: {{ $email_data['jenis_permohonan'] }}</td>
        </tr>
    @endif
    @if ($email_data['nomor_kodeakses'] !== '')
        <tr>
            <td>Kode Akses </td>
            <td>: {{ $email_data['nomor_kodeakses'] }}</td>
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
        <td>: <a href="{{ url('/admin/login') }}">{{ url('/admin/login') }}</a></td>
    </tr>
</table>

<p style="margin-bottom:2px">Mohon untuk segera ditindaklanjuti.</p>
<p style="margin-top:2px">Terima kasih</p>


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
