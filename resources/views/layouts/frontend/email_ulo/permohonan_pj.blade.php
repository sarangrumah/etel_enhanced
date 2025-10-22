{{-- pemohon ulo --}}

<p style="text-left">Yth. {{ $email_data['izin']['nama_perseroan'] }}</p>
<p style="text-left">Permohonan Saudara dengan detail sebagai berikut telah berhasil kami terima.</p>

<p></p>

<table>
    <td> No. Permohonan </td>
    <td>: {{ $email_data['izin']['id_izin'] }}</td>
    <tr>
        <td>Tanggal Permohonan </td>
        <td>: {{ $email_data['izin']['tgl_submit'] }}</td>
    </tr>
    <tr>
        <td>Nama Perusahaan </td>
        <td>: {{ $email_data['izin']['nama_perseroan'] }}</td>
    </tr>
    <tr>
        <td>Nomor Izin Berusaha (NIB) </td>
        <td>:{{ $email_data['izin']['nib_user'] }}</td>
    </tr>
    <tr>
        <td>KBLI </td>
        <td>: {{ $email_data['izin']['kbli_name'] }}</td>
    </tr>
    <tr>
        <td>Jenis Permohonan </td>
        <td>: Penyampaian Permohonan Uji Laik Operasi (ULO) {{ $email_data['izin']['jenis_izin'] }}</td>
    </tr>
    <tr>
        <td>Metode ULO </td>
        <td>: {{ $email_data['izin']['status'] }}</td>
    </tr>
    <tr>
        @if ($email_data['tipe_ulo'] == '1')
            <td>Tanggal Pelaksanaan ULO yang dipilih </td>
            <td>: {{ $email_data['tgl_pengajuan_ulo'] }}</td>
        @else
            <td>Batas Waktu Penyampaian Dokumen Hasil Penilaian Mandiri </td>
            <td>: {{ $email_data['tgl_pengajuan_ulo'] }}</td>
        @endif
    </tr>
    <tr>
        <td>URL </td>
        <td>: <a href="{{ url('/') }}">{{ url('/') }}</a></td>
    </tr>
</table>

<p>Untuk tahapan selanjutnya, silahkan menunggu jadwal kegiatan Sosialisasi dan Asistensi Persiapan Pelaksanaan Uji Laik
    Operasi (ULO) yang akan dilaksanakan melalui video conference (Zoom Meeting), dimana pada kegiatan tersebut akan
    didiskusikan mengenai materi dan tata cara pelaksanaan ULO. Undangan resmi dan link Zoom Meeting akan kami sampaikan
    menyusul.</p>

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
