<p style="text-left">Yth. {{ $email_data['user']->nama_user_proses }}</p>

<p style="text-left"> Evaluasi Registrasi Anda
    @if ($email_data['is_setuju'] == 1)
        Disetujui. Akun Anda dengan akun pengguna : {{ $email_data['email'] }} sudah dapat melakukan permohonan.
    @else
        Ditolak. <br />
        Dengan catatan hasil Evaluasi sebagai berikut : {{ $email_data['catatan_evaluasi'] }}
    @endif
</p>

<p></p>

<table>
    <tr>
        <td>URL </td>
        <td>: <a href="{{ url('/') }}">{{ url('/') }}</a></td>
    </tr>
</table>

<p>Terima Kasih</p>

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
