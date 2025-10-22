{{-- pemohon ulo --}}

<p style="text-left">Yth. {{ $email_data['nama'] }}</p>
<p style="font-size: 14px; line-height: 170%;"><span style="font-size: 16px; font-weight:bold; line-height: 27.2px;">{{ $email_data['jabatan'] }}</span></p>
<p style="text-left"> Anda mendapat notifikasi verifikasi permohonan Penerbitan SK dengan detail permohonan sebagai berikut:</p>

<p></p>

<table>
    <td> No. Permohonan </td>
    <td>: {{ isset($email_data['izin']['id_izin']) ? $email_data['izin']['id_izin'] :'-' }}</td>
    @if($email_data['tipe_ulo'] !== '')
    <tr>
        <td>Tanggal Permohonan	</td>
        <td>: {{ isset($email_data['izin']['updated_at']) ? $email_data['tgl_submit'] :'-' }}</td>
    </tr>
    @elseif($email_data['updated_date'] !== '')
    <tr>
        <td>Tanggal Permohonan	</td>
        <td>: {{ isset($email_data['updated_date']) ? $email_data['updated_date'] :'-' }}</td>
    </tr>
    @else
    <tr>
        <td>Tanggal Permohonan	</td>
        <td>: {{ isset($email_data['izin']['updated_at']) ? $email_data['tanggal_permohonan'] :'-' }}</td>
    </tr>
    @endif
    <tr>
        <td>Nama Perusahaan	</td>
        <td>: {{ isset($email_data['nib']['nama_perseroan']) ? $email_data['nib']['nama_perseroan'] :'-' }}</td>
    </tr>
    <tr>
        <td>Nomor Izin Berusaha (NIB)	</td>
        <td>: {{ isset($email_data['izin']['nib']) ? $email_data['izin']['nib'] :'-' }}</td>
    </tr>
    <tr>
      <td>Jenis Layanan	</td>
      <td>:  {!! isset($email_data['izin']['jenis_layanan_html']) ? $email_data['izin']['jenis_layanan_html'] :'-' !!}</td>
    </tr>
    <tr>
        <td>KBLI	</td>
        <td>: {{ isset($email_data['izin']['full_kbli']) ? $email_data['izin']['full_kbli'] :'-' }}</td>
    </tr>
    @if($email_data['tipe_ulo'] !== '')
    <tr>
        <td>Metode ULO	</td>
        <td>: {{ $email_data['tipe_ulo']}}</td>
    </tr>
    <tr>
        <td>Tanggal Pelaksanaan ULO yang dipilih   </td>
        <td>: {{$email_data['tgl_pengajuan_ulo']}}</td>
    </tr>
    <tr>
        <td>Hasil Evaluasi Pelaksanaan ULO   </td>
        <td>: {{$email_data['status_laik']}}</td>
    </tr>
    @endif
    {{-- <tr>
        <td>Evaluator ULO   </td>
        <td>: {{$email_data['tgl_pengajuan_ulo']}}</td>
    </tr> --}}
    @if($email_data['full_kode_akses'] !== '')
    <tr>
        <td>Kode Akses	</td>
        <td>: {{$email_data['full_kode_akses']}}</td>
    </tr>
    @endif
    @if($email_data['jenis_penomoran'] !== '')
    <tr>
        <td>Jenis Penomoran	</td>
        <td>: {{$email_data['jenis_penomoran']}}</td>
    </tr>
    <tr>
        <td>Jenis Permohonan Penomoran</td>
        <td>: {{$email_data['jenis_permohonan']}}</td>
    </tr>
    @endif
    <tr>
        <td>URL	</td>
        <td>: <a href="{{url('/admin/login')}}">{{url('/admin/login')}}</a></td>
    </tr>
</table>

<p >  Demikian dapat kami sampaikan.
  Terima Kasih</p>

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
