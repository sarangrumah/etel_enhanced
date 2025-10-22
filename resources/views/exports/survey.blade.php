@php 
$education = ['-', 'SD', 'SMP', 'SMA', 'S1', 'S2', 'S3'];
$occupation = ['-', 'PNS', 'TNI/POLRI', 'SWASTA', 'WIRAUSAHA', 'LAINNYA'];
@endphp
<table>
    <thead>
    <tr>
        <th width="15">Tanggal</th>
        <th width="15">Name</th>
        <th width="15">Jenis Kelamin</th>
        <th width="15">Umur</th>
        <th width="15">Pendidikan</th>
        <th width="15">Pekerjaan</th>
        <th width="15">Jabatan</th>
        <th width="15">ID Izin</th>
        @foreach ($filtered as $item)
            <th height="400" width="30" style="word-wrap: break-word;">{{$question[explode("_", $item)[1]]}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($survey as $item)
        <tr>
            <td>{{ $item->created_date }}</td>
            <td>{{ $item->responder_name }}</td>
            <td>{{ $item->id_tb_mst_gender == 1 ? "Laki-laki":"Perempuan" }}</td>
            <td>{{ $item->responder_age }}</td>
            <td>{{ $education[$item->id_tb_mst_education] }}</td>
            <td>{{ $occupation[$item->id_tb_mst_occupation] }}</td>
            <td>{{ $item->responder_jabatan }}</td>
            <td>{{ $item->id_izin }}</td>
            @foreach ($filtered as $q)
                <th>{{$item->$q}}</th>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>