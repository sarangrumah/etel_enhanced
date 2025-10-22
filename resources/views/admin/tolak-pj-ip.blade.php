{{-- pemohon ulo --}}

<p style="text-left">Yth. {{ $email_data['nama'] }}</p>
<p style="font-size: 14px; line-height: 170%;"><span
        style="font-size: 16px; font-weight:bold; line-height: 27.2px;">{{ $email_data['nib']['nama_perseroan'] }}</span>
</p>
<p style="text-left">Berdasarkan permohonan {!! isset($email_data['izin']['jenis_layanan_html']) ? $email_data['izin']['jenis_layanan_html'] : '-' !!}
    Pemerintah {{ isset($email_data['nib']['nama_perseroan']) ? $email_data['nib']['nama_perseroan'] : '-' }}
    dengan nomor permohonan {{ isset($email_data['izin']['id_izin']) ? $email_data['izin']['id_izin'] : '-' }} hari
    {{ $email_data['tgl_permohonan'] }}
    disampaikan bahwa dokumen yang disampaikan oleh
    {{ isset($email_data['nib']['nama_perseroan']) ? $email_data['nib']['nama_perseroan'] : '-' }}
    masih belum lengkap dan sesuai. Adapun dokumen yang belum lengkap dan sesuai diantaranya :</p>


<table>
    <thead>
        <tr class="fw-bolder fs-6 text-center text-gray-800">
            <th>No</th>
            <th>Persyaratan</th>
            <th>Catatan Koreksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($email_data['catatan_koreksi'] as $key)
            <tr>
                <td width="30">{{ $key->row_num }}</td>
                <td>{{ $key->persyaratan }}</td>
                <td>{{ $key->correction_note }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p style="text-left">Sehubungan dengan hal tersebut diatas, maka permohonan {!! isset($email_data['izin']['jenis_layanan_html']) ? $email_data['izin']['jenis_layanan_html'] : '-' !!}
    {{ isset($email_data['nib']['nama_perseroan']) ? $email_data['nib']['nama_perseroan'] : '-' }} ditolak.</p>
<p style="text-left">Apabila
    {{ isset($email_data['nib']['nama_perseroan']) ? $email_data['nib']['nama_perseroan'] : '-' }} masih berminat untuk
    menjadi penyelenggara telekomunikasi khusus, silahkan mengajukan permohonan {!! isset($email_data['izin']['jenis_layanan_html']) ? $email_data['izin']['jenis_layanan_html'] : '-' !!} kembali dengan persyaratan
    yang lengkap dan sesuai ketentuan yang berlaku.</p>


<p>Demikian disampaikan, atas perhatiannya kami ucapkan terima kasih.</p>

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
