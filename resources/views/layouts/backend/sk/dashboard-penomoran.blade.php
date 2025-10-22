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
                        <h3 class="font-weight-semibold mb-0">{{ isset($countdisposisi) ? $countdisposisi : 0 }}</h3>
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
                <h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Penomoran Telekomunikasi</h6>

                <div class="d-inline-flex align-items-center ml-auto">
                    <div class="dropdown ml-2">
                        <a href="#"
                            class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                            data-toggle="dropdown">
                            <i class="icon-more2"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item"><i class="icon-printer"></i> Print report</a>
                            <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export report</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive border-top-0">
                <table class="table text-nowrap datatable-button-init-basic" id="table">
                    <thead>
                        <tr>
                            <th>Permohonan</th>
                            {{-- <th>Detil Permohonan Penomoran</th> --}}
                            <th class="text-center">Tanggal Permohonan</th>
                            {{-- <th class="text-center">Tanggal Permohonan</th> --}}
                            {{-- <th class="text-center">Batas Verifikasi</th> --}}
                            {{-- <th class="text-center">Jenis Permohonan</th> --}}
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($penomoran) && count($penomoran) > 0)
                            @foreach ($penomoran['data'] as $penomorans)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <a href="{{ route('admin.evaluator.evaluasi-penomoran', [$penomorans['id_izin'], $penomorans['id_kode_akses']]) }}"
                                                    class="text-body font-weight-semibold">{{ $penomorans['id_izin'] }}</a>
                                                <div class="text-muted font-size-sm">
                                                    {{ isset($penomorans['nama_perseroan']) ? $penomorans['nama_perseroan'] : '' }}
                                                </div>
                                                <div class="text-muted font-size-sm">
                                                    {{ isset($penomorans['jenis_permohonan']) ? $penomorans['jenis_permohonan'] : '' }}
                                                </div>
                                                <div class="text-muted font-size-sm">
                                                    {{ isset($penomorans['jenis_penomoran']) ? $penomorans['jenis_penomoran'] : '' }}
                                                </div>
                                                {{-- <div class="text-muted font-size-sm">{{ $penomorans['kbli'] }} -
                                                    {!! $penomorans['jenis_layanan_html'] !!}</div> --}}
                                                <div class="text-muted font-size-sm">{!! isset($penomorans['jenis_kode_akses']) ? $penomorans['jenis_kode_akses'] : '' !!}</div>
                                                <div class="text-muted font-size-sm">Kode Akses :
                                                    @if ($penomorans['jenis_kode_akses'] == 'Blok Nomor')
                                                        {{ isset($penomorans['bloknomor_list']) ? $penomorans['bloknomor_list'] : '' }}
                                                    @else
                                                        <?php dd($penomorans); ?>
                                                        {{ isset($penomorans['kode_akses']) ? $penomorans['kode_akses'] : '' }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td></td> --}}
                                    @if ($penomorans['updated_date'] == null)
                                        <td class="text-center"> - </td>
                                    @else
                                        <td class="text-center" style="overflow-wrap: break-word;">
                                            {{ $date_reformat->dateday_lang_reformat_long($penomorans['updated_date']) }}
                                        </td>
                                    @endif
                                    {{-- <td class="text-center">3 Hari</td> --}}
                                    {{-- <td class="text-center">
                                        <div class="badge badge-success-100 text-success">
                                            {{ isset($penomorans['jenis_permohonan']) ? $penomorans['jenis_permohonan'] : '' }}
                                        </div>
                                    </td> --}}
                                    <td class="text-center"><span
                                            class="badge badge-success-100 text-success">{{ isset($penomorans['status_bo']) ? $penomorans['status_bo'] : '' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span>
                                            <a style="color:grey;" {{-- href="{{ route('admin.evaluator.evaluasi-penomoran', [$penomorans['id_izin'], $penomorans['id_kode_akses']]) }}"><i --}}
                                                href="{{ route('admin.evaluator.evaluasipe', [$penomorans['id_izin']]) }}"><i
                                                    class="icon-pencil"></i></a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>


            </div>

        </div>
        <div class="text-right pagination-flat">
            @if ($paginate->count() > 0)
                {{ $paginate->links() }}
            @endif
        </div>
        <!-- /latest orders -->
    </div>
@endsection
