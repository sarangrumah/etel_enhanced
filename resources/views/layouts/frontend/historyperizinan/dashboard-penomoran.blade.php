
@extends('layouts.frontend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
<!-- Quick stats boxes -->

<div>

    
    <!-- Latest orders -->
    <div class="card">
        <div class="card-header d-flex py-0">
            <h6 class="card-title font-weight-semibold py-3">Riwayat Permohonan</h6>
        </div>

        <div class="card-body">
			@include('layouts/frontend/historyperizinan/historypenomoran', array( "history_penomoran" => $history))
		</div>  

        <div class="modal-footer">
        <?php 
            if ($izin2['nama_master_izin'] == "JASA") {
            $url = 'pb/permohonan/jasa';
            } else if($izin2['nama_master_izin'] == "JARINGAN"){
                $url = 'pb/permohonan/jaringan';
            } else if($izin2['nama_master_izin'] == "TELSUS"){
                $url = 'pb/permohonan/telsus';
            }
            
        ?>
        <a href="{{url($url)}}" class="btn btn-indigo text-right"><i class="icon-backward2 ml-2"></i> Kembali </a>
        </div>
        
    </div>


    {{-- <script>
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
    </script> --}}
    

    <!-- /latest orders -->
</div>
@endsection