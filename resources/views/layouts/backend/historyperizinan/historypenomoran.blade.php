<style>
    tbody tr td,
    thead tr th {
        font-size: 14px;
    }
</style>
<div class="table-responsive border-top-0">
    <table class="table text-nowrap" id="table">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Status</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Waktu</th>
                <th class="text-center">Catatan Hasil Evaluasi</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 0;@endphp
            @foreach ($history_penomoran as $history_penomoran)
                @php $count ++;@endphp
                <tr>
                    <td>{{ $count }}</td>
                    <!-- <td class="align-items-center">{{ $history_penomoran['id_izin'] }}</td> -->
                    <td class="text-center" style="text-align:left !important;">
                        {{ $history_penomoran['kode_izin']['name_status_bo'] }} ({{$history_penomoran['jenis_permohonan']}})</td>
                    <td class="text-center">{{ $history_penomoran['created_name'] }}</td>

                    @if ($history_penomoran['jabatan'] == null or $history_penomoran['jabatan'] == '')
                        <td class="text-center">Pemohon</td>
                    @else
                        <td class="text-center">{{ $history_penomoran['jabatan'] }}</td>
                    @endif

                    @if ($history_penomoran['created_date'] == null)
                        <td class="text-center"> - </td>
                    @else
                        <td class="text-center">
                            {{ $date_reformat->date_lang_reformat_long_with_time($history_penomoran['created_date']) }}
                        </td>
                    @endif
                    <td class="text-center text-wrap"
                        style="width:50px !important;%;overflow-wrap: break-word;word-wrap: break-word;">
                        {!! $history_penomoran['catatan_hasil_evaluasi'] !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
