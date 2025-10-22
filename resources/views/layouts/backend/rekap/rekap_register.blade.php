@extends('layouts.backend.main')
@section('content')

<div class="content-wrapper">

    <!-- Inner content -->
    <div class="content-inner">
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
                                    <th>Nama Perusahaan</th>
                                    <th>Nama Penanggung Jawab</th>
                                    <th>No Telepon Penanggung Jawab</th>
                                    <th>Email Penanggung Jawab</th>
                                    <th>Status Registrasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($log) && count($log) > 0)
                                @foreach ($log as $loges)
                                <tr>
                                    <td class="text-center">{{$loges->nib}}</td>
                                    <td class="text-center">{{strtoupper($loges->nama_perseroan)}}</td>
                                    <td class="text-center">{{$loges->nama_user_proses}}</td>
                                    <td class="text-center">{{$loges->hp_user_proses}}</td>
                                    <td class="text-center">{{$loges->email_user_proses}}</td>
                                    <td>{{$loges->note}}</td>
    
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