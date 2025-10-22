@extends('layouts.backend.main')
@section('content')

<div class="content-wrapper">

    <!-- Content area -->
    <div class="content">

        <!-- Basic initialization -->
        <div class="card">
            <div class="card-header bg-indigo text-white header-elements-inline">
                <div class="row">
                    <div class="col-lg">
                        <h6 class="card-title font-weight-semibold py-3">Rekap Permohonan </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive border-top-0">
                    <table class="table datatable-button-init-basic">
                        <thead>
                            <tr>
                                <th>Nomor Permohonan</th>
                                <th>NIB</th>
                                <th>Nama Perusahaan</th>
                                <th>Email Perusahaan</th>
                                <th>Jenis Izin</th>
                                <th>Tanggal Permohonan</th>
                                <th>Tanggal Update</th>
                                <th>Nama Evaluator Syarat</th>
                                <th>Nama Evaluator ULO</th>
                                <th>Status </th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($log) && count($log) > 0)
                            @foreach ($log as $loges)
                            <tr>
                                <td class="text-center">{{$loges->id_izin}}</td>
                                <td class="text-center">{{strtoupper($loges->nib)}}</td>
                                <td class="text-center">{{$loges->nama_perseroan}}</td>
                                <td class="text-center">{{$loges->email_user_proses}}</td>
                                <td class="text-center">{{$loges->name}}</td>
                                <td class="text-center">{{$loges->submitted_at}}</td>
                                <td class="text-center">{{$loges->updated_at}}</td>
                                <td class="text-center">{{$loges->evaluator_syarat_name}}</td>
                                <td class="text-center">{{$loges->evaluator_ulo_name}}</td>
                                <td class="text-center">{{$loges->name_status_bo}}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#"
                                            class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                            data-toggle="dropdown">
                                            <i class="icon-menu7"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($loges->oss_kode != '00')
                                            <a href="{{ route('admin.view', [$loges->id_izin, $loges->id]) }}"
                                                class="dropdown-item"><i class="icon-pencil"></i> Lihat Detil Perizinan</a>
                                                
                                            @endif
                                            @if (isset($loges->skulo))
                                                <a target="_blank" href="{{ asset($loges->skulo) }}"
                                                    class="dropdown-item"><i class="icon-pencil"></i> SK ULO</a>
                                            @endif
                                            @if (isset($loges->skkomit))
                                                <a target="_blank" href="{{ asset($loges->skkomit) }}"
                                                    class="dropdown-item"><i class="icon-pencil"></i> SK Komitmen</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
    
                            </tr>
                            @endforeach
                            @endif
    
    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /basic initialization -->

    </div>
    <!-- /content area -->

</div>

@endsection