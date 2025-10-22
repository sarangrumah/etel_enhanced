<p style="text-left">Bapak/Ibu {{ $email_data['nib']['nama_perseroan'] }}</p>
{{-- <p style="text-left">Permohonan {!! isset($email_data['izin']['jenis_layanan_html']) ? $email_data['izin']['jenis_layanan_html'] : '-' !!}</p>
<p style="text-left">NIB : {{ isset($email_data['izin']['nib']) ? $email_data['izin']['nib'] : '-' }}</p> --}}
<br>
<table>
    <td> No. Permohonan </td>
    <td>: {{ isset($email_data['izin']['id_izin']) ? $email_data['izin']['id_izin'] : '-' }}</td>

    {{-- <tr>
        <td>Tanggal Permohonan </td>
        <td>: {{ isset($email_data['updated_at']) ? $email_data['updated_date'] : '-' }}</td>
    </tr> --}}
    <tr>
        <td>Tanggal Permohonan </td>
        <td>: {{ $email_data['tgl_permohonan'] }}</td>
    </tr>

    <tr>
        <td>Nama Perusahaan </td>
        <td>: {{ isset($email_data['nib']['nama_perseroan']) ? $email_data['nib']['nama_perseroan'] : '-' }}</td>
    </tr>
    <tr>
        <td>Nomor Izin Berusaha (NIB) </td>
        <td>: {{ isset($email_data['izin']['nib']) ? $email_data['izin']['nib'] : '-' }}</td>
    </tr>
    <tr>
        <td>KBLI </td>
        <td>: {{ isset($email_data['izin']['full_kbli']) ? $email_data['izin']['full_kbli'] : '-' }}</td>
    </tr>
    <tr>
        <td>Jenis Layanan </td>
        <td>: {!! isset($email_data['izin']['jenis_layanan_html']) ? $email_data['izin']['jenis_layanan_html'] : '-' !!}
        </td>
    </tr>
</table>
<p style="text-left">
    Terimakasih yang sebesar-besarnya atas partisipasi dan Kerjasama Bapak/Ibu yang telah
    berkenan meluangkan waktu dan kesempatannya mengisi survei pelayanan publik Direktorat Telekomunikasi.
</p>
<p style="text-left">
    Laporan hasil survei tersebut akan kami umumkan pada website. Kami berharap semoga di
    masa yang akan mendatang, Direktorat Telekomunikasi dapat secara berkelanjutan melakukan pengembangan dan perbaikan
    terhadap layanan publik perizinan telekomunikasi.
</p>
<p style="text-left">
    Demikian disampaikan atas perhatian Bapak/Ibu diucapkan terimakasih.
</p>
<p style="text-left">
    Klik link dibawah ini.
</p>
<a href="{{ url('/survey/' . $email_data['link_survey']) }}">Survey IKM</a>
<br><br><br><br>
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
