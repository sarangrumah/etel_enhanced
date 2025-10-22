{{-- evaluator ulo --}}

<p style="text-left">Yth. {{ $email_data['nama'] }}</p>
<p style="font-size: 14px; line-height: 170%;"><span style="font-size: 16px; font-weight:bold; line-height: 27.2px;">{{
        $email_data['jabatan'] }}</span></p>
{{-- nama koordinator --}}
</p>

<p>
    Permohonan Uji Laik Operasi (ULO) Izin Penyelenggaraan Telekomunikasi baru dengan detil permohonan sebagai berikut
    telah masuk ke dalam sistem dan siap diproses.
</p>

<table>
    <td> No. Permohonan </td>
    <td>: {{$email_data['izin']['id_izin']}}</td>
    <tr>
        <td>Tanggal Permohonan </td>
        <td>: {{$email_data['izin']['tgl_submit']}}</td>
    </tr>
    <tr>
        <td>Nama Perusahaan </td>
        <td>: {{$email_data['izin']['nama_perseroan']}}</td>
    </tr>
    <tr>
        <td>Nomor Izin Berusaha (NIB) </td>
        <td>:{{$email_data['izin']['nib_user']}}</td>
    </tr>
    <tr>
        <td>KBLI </td>
        <td>: {{$email_data['izin']['kbli_name']}}</td>
    </tr>
    <tr>
        <td>Jenis Permohonan </td>
        <td>: Penyampaian Permohonan Uji Laik Operasi (ULO) {{$email_data['izin']['jenis_izin']}}</td>
    </tr>
    <tr>
        <td>Metode ULO </td>
        <td>: {{$email_data['izin']['status']}}</td>
    </tr>
    <tr>
        @if ($email_data['tipe_ulo'] == '1')
        <td>Tanggal Pelaksanaan ULO yang dipilih </td>
        <td>: {{$email_data['tgl_pengajuan_ulo']}}</td>
        @else
        <td>Batas Waktu Penyampaian Dokumen Hasil Penilaian Mandiri </td>
        <td>: {{$email_data['tgl_pengajuan_ulo']}}</td>
        @endif
    </tr>
    <tr>
        <td>URL </td>
        <td>: <a href="{{url('/admin/login')}}">{{url('/admin/login')}}</a></td>
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