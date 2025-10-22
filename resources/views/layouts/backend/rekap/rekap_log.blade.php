@extends('layouts.backend.main')
@section('content')

<div class="content-wrapper">

    <!-- Inner content -->
    <div class="content-inner">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-lg-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Rekap Log Permohonan</span></h4>
                    <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
                </div>
            </div>
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">

            <!-- Basic initialization -->
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Rekap Log Registrasi </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top-0">
                        <table class="table text-nowrap datatable-button-init-basic">
                            <thead>
                                <tr>
                                    <th>NIB</th>
                                    <th>KBLI</th>
                                    <th>Jenis Layanan</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Tanggal Permohonan Dokumen</th>
                                    <th>Tanggal Evaluasi Dokumen</th>
                                    <th>Waktu Proses</th>
                                    <th>Status Dokumen</th>
                                    <th>Nama Evaluator Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($log) && count($log) > 0)
                                @foreach ($log as $loges)
                                <tr>
                                    <td class="text-center">{{$loges->nib}}</td>
                                    <td class="text-center">{{$loges->kbli}}</td>
                                    <td class="text-center">{{$loges->izin_layanan}}</td>
                                    <td class="text-center">{{$loges->nama_perseroan}}</td>
                                    <td class="text-center">{{$loges->initiated_at}}</td>
                                    <td class="text-center">{{$loges->submitted_date}}</td>
                                    <td class="text-center">{{$loges->day_of_process}}</td>
                                    <td class="text-center">{{$loges->status}}</td>
                                    <td class="text-center">{{$loges->nama}}</td>
    
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
    <!-- /inner content -->

</div>

@endsection