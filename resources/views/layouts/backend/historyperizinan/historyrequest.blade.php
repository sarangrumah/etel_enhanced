<style>
    tbody tr td, thead tr th{
        font-size:14px;
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
            @foreach($history_permohonan as $history_permohonan)

            @php $count ++;@endphp
                <tr>
                    <td>{{$count}}</td>
                    <!-- <td class="align-items-center">{{$history_permohonan['id_izin']}}</td> -->
                    <td class="text-center" style="text-align:left !important;">{{$history_permohonan['kode_izin']['name_status_bo']}} (Penomoran)</td>
                    <td class="text-center">{{$history_permohonan['created_name']}}</td>
                    
                    @if($history_permohonan['jabatan'] == null OR $history_permohonan['jabatan'] == "")
                    <td class="text-center">Pemohon</td>
                    @else
                    <td class="text-center">{{$history_permohonan['jabatan']}}</td>
                    @endif
                    
                    @if($history_permohonan['created_at'] == null)
                    <td class="text-center"> - </td>
                    @else
                    <td class="text-center">{{ $date_reformat->date_lang_reformat_long_with_time($history_permohonan['created_at']) }}</td>
                    @endif
                    <td class="text-center text-wrap" style="width:50px !important;%;overflow-wrap: break-word;word-wrap: break-word;">{{$history_permohonan['catatan_evaluasi']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>