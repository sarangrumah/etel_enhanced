
@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
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

        <div class="table-responsive border-top-0">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="">No Permohonan</th>
                        <th class="">KBLI</th>
                        <th class="text-center">Waktu</th>
                        <th class="text-center">Petugas</th>
                        <th class="text-center">Status</th>
                        
                        <!-- <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th> -->
                    </tr>
                </thead>
                <tbody>
                @php $count = 0;

            
                @endphp

                @foreach($historyizin as $historizin1)

                @php $count ++; 

                @endphp
                    <tr>
                        <td>{{$count}}</td>
                        <td class="align-items-center">{{$historizin1['id_izin']}}</td>
                        <td class="align-items-center">{{$historizin1['full_kbli']}}</td>

                        @if($historizin1['created_at'] == null)
                        <td class="text-center"> - </td>
                        @else
                        <td class="text-center"> {{date('d F Y - H:i:s', strtotime($historizin1['created_at']))}}</td>
                        @endif

                        @if($historizin1['nama_created'] == null)
                        <td class="text-center">{{$historizin1['created_name']}}</td>
                        @else
                        <td class="text-center">{{$historizin1['nama_created']}}</td>
                        @endif
                        <td class="text-center">{{$historizin1['status_bo']}}</td>

                        <!-- <td class="text-center">
                            <div class="dropdown">
                                <a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
                                    <i class="icon-menu7"></i>
                                </a>
                            </div>
                        </td> -->
                    </tr>
                @endforeach
                
                @foreach($history as $historizin)
                @php $count ++; 

                @endphp
                    <tr>
                        <td>{{$count}}</td>
                        <td class="align-items-center">{{$historizin['id_izin']}}</td>
                        <td class="align-items-center">{{$historizin['full_kbli']}}</td>

                        @if($historizin['created_date'] == null)
                        <td class="text-center"> - </td>
                        @else
                        <!-- <td class="text-center"> {{date('d F Y - H:i:s', strtotime($historizin['created_date']))}}</td> -->
                        <td class="text-center"> {{$date_reformat->date_lang_reformat_long_with_time($historizin['created_date']))}}</td>
                        @endif

                        <td class="text-center">{{$historizin['created_name']}}</td>

                        <td class="text-center">{{$historizin['kode_izin']['name_status_bo']}} (ULO)</td>

                        <!-- <td class="text-center">
                            <div class="dropdown">
                                <a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
                                    <i class="icon-menu7"></i>
                                </a>
                            </div>
                        </td> -->
                    </tr>
                @endforeach

                    
                </tbody>
            </table>

            
        </div>

    </div>

    <!-- /latest orders -->
</div>
@endsection