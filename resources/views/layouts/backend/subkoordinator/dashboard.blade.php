@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
    <!-- Quick stats boxes -->
    <div class="row">
        <div class="col-lg">
            <!-- Members online -->
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="font-weight-semibold mb-0">{{ $countdisposisi }}</h3>
                        <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                    </div>

                    <div>
                        Permohonan
                        <div class="font-size-sm opacity-75">Evaluasi</div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div id="members-online"></div>
                </div>
            </div>
            <!-- /members online -->
        </div>
    </div>
    <!-- /quick stats boxes -->

    <div>
        @if (Session::get('message') != '')
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ Session::get('message') }}</strong>
            </div>
        @endif

        <!-- Latest orders -->
        <div class="card">
            <div class="card-header d-flex py-0">
                <h6 class="card-title font-weight-semibold py-3">Daftar Permohonan {{ ucwords($jenis_izin) }} Dalam proses
                </h6>

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
                <table class="table text-nowrap datatable-button-init-basic" id="table">
                    <thead>
                        <tr>
                            <th>Permohonan</th>
                            <th class="text-center">Tanggal Permohonan</th>
                            <th class="text-center">Batas Verifikasi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($izin['data']) && count($izin['data']) > 0)
                            @foreach ($izin['data'] as $izins)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <a href="{{ route('admin.subkoordinator.evaluasi', $izins['id_izin']) }}"
                                                    class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
                                                <div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
                                                @if ($izins['status_checklist'] == 802)
                                                @else
                                                    <div class="text-muted font-size-sm">{{ $izins['kbli'] }} -
                                                        {{ $izins['kbli_name'] }}</div>
                                                @endif
                                                <div class="text-muted font-size-sm">{{ strtoupper($izins['nama_perseroan']) }}</div>
                                                <div class="text-muted font-size-sm">{!! $izins['jenis_layanan_html'] !!}</div>
                                            </div>
                                        </div>
                                    </td>
                                    @if ($izins['submitted_at'] == null)
                                        <td class="text-center"> - </td>
                                    @else
                                        @if ($izins['corrected_at'] == null)
                                        <td class="text-center">
                                            {{-- {{ $date_reformat->dateday_lang_reformat_long($izins['updated_at']) }}</td> --}}
                                            {{ $date_reformat->dateday_lang_reformat_long($izins['submitted_at']) }}</td>
                                        @else
                                        <td class="text-center">
                                            {{-- {{ $date_reformat->dateday_lang_reformat_long($izins['updated_at']) }}</td> --}}
                                            {{ $date_reformat->dateday_lang_reformat_long($izins['corrected_at']) }}</td>
                                        @endif
                                        
                                    @endif
                                    <td class="text-center"><span
                                            class="badge badge-success-100 text-success">{{ $izins['batas_verifikasi'] }}</span>
                                        Hari</td>
                                    <td class="text-center">
                                        @if ($izins['status_penyesuaian'] == '902')
                                            <span class="badge badge-success-100 text-success">Perubahan Komitmen</span>
                                        @else
                                            <span
                                                class="badge badge-success-100 text-success">{{ $izins['status_bo'] }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a href="#"
                                                class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                                data-toggle="dropdown">
                                                <i class="icon-menu7"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if ($izins['status_penyesuaian'] == '902')
                                                    <a href="{{ route('admin.subkoordinator.evaluasipenyesuaian', $izins['id_izin']) }}"
                                                        class="dropdown-item"><i class="icon-pencil"></i> Evaluasi Perubahan
                                                        Komitmen</a>
                                                @else
                                                    <a href="{{ route('admin.subkoordinator.evaluasi', $izins['id_izin']) }}"
                                                        class="dropdown-item"><i class="icon-pencil"></i> Evaluasi
                                                        Perizinan</a>
                                                @endif
                                                <!-- <a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Informasi Perizinan</a> -->
                                                <a target="_blank"
                                                    href="{{ route('admin.historyperizinan', $izins['id_izin']) }}"
                                                    class="dropdown-item"><i class="icon-history"></i> Riwayat
                                                    Permohonan</a>
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
        <div class="text-right pagination-flat">
            @if ($paginate != null && $paginate->count() > 0)
                {{ $paginate->links() }}
            @endif
        </div>
        <!-- /latest orders -->
    </div>

@endsection
