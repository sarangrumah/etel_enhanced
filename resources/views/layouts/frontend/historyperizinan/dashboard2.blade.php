
@extends('layouts.frontend.main')
@section('content')
<!-- Quick stats boxes -->

<div>

    
    <!-- Latest orders -->
    <div class="card">
        <div class="card-header d-flex py-0">
            <h6 class="card-title font-weight-semibold py-3">Riwayat Permohonan</h6>
        
            {{-- <div class="d-inline-flex align-items-center ml-auto">
                <div class="dropdown ml-2">
                    <a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
                        <i class="icon-more2"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="icon-printer"></i> Print report</a>
                        <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export report</a>
                    </div>
                </div> 
            </div> --}}
        </div>

        <table class="table text-nowrap datatable-button-init-basic table-striped" id="table">
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
                @foreach($penomoranlog as $history_penomoran)
    
                @php $count ++;@endphp
                    <tr>
                        <td>{{$count}}</td>
                        <!-- <td class="align-items-center">{{$history_penomoran['id_izin']}}</td> -->
                        <td class="text-center" style="text-align:left !important;">{{$history_penomoran['kode_izin']['name_status_bo']}} (Penomoran)</td>
                        <td class="text-center">{{$history_penomoran['created_name']}}</td>
                        
                        @if($history_penomoran['jabatan'] == null OR $history_penomoran['jabatan'] == "")
                        <td class="text-center">Pemohon</td>
                        @else
                        <td class="text-center">{{$history_penomoran['jabatan']}}</td>
                        @endif
                        
                        @if($history_penomoran['created_date'] == null)
                        <td class="text-center"> - </td>
                        @else
                        <td class="text-center">{{ $date_reformat->date_lang_reformat_long_with_time($history_penomoran['created_date']) }}</td>
                        @endif
                        <td class="text-center text-wrap" style="width:50px !important;%;overflow-wrap: break-word;word-wrap: break-word;">{{$history_penomoran['catatan_hasil_evaluasi']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>


    <script>
        $(document).ready(function () {
            // $('#table').DataTable({
            //     order: [[4, 'asc']],
            // });
            if ( $.fn.dataTable.isDataTable( '#table' ) ) {
                table = $('#table').DataTable();
            }
            else {
                table = $('#table').DataTable( {
                    paging: false,
                    order: [[4, 'asc']],
                } );
            }
        });
    </script>
    

    <!-- /latest orders -->
</div>
@endsection