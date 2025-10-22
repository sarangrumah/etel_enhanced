@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
<!-- Quick stats boxes -->

<!-- /quick stats boxes -->
<div>
    @if ($message = Session::get('message'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    <!-- Latest orders -->
    <div class="card">
        <div class="card-header d-flex py-0">
            <h6 class="card-title font-weight-semibold py-3">Daftar Pencabutan Penomoran</h6>

        </div>

        <div class="table-responsive border-top-0">
            <table class="table text-nowrap datatable-button-init-basic" id="table">
                <thead>
                    <tr>
                        <th>Permohonan</th>
                        <!-- <th>Detil Permohonan Penomoran</th> -->
                        <th class="text-center">Tanggal Permohonan</th>
                        <th class="text-center">Batas Verifikasi</th>
                        <th class="text-center">Jenis Permohonan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                    </tr>
                </thead>
                <tbody>

                    @if (isset($penomoran['data']) && count($penomoran['data']) > 0)
                    @foreach ($penomoran['data'] as $penomorans)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>

                                    <a href="#" class="text-body font-weight-semibold">{{ $penomorans['id_izin'] }}</a>

                                    <div class="text-muted font-size-sm">{{isset($penomorans['nama_perseroan']) ?
                                        $penomorans['nama_perseroan'] :''; }} </div>
                                    <div class="text-muted font-size-sm">{{ isset($penomorans['jenis_izin']) ?
                                        $penomorans['jenis_izin'] : ''; }}</div>
                                    <div class="text-muted font-size-sm">{{ $penomorans['kbli'] }} - {!!
                                        $penomorans['jenis_layanan_html'] !!}</div>
                                    <div class="text-muted font-size-sm">{!!
                                        isset($penomorans['kode_akses']['jenis_kode_akses']['full_name_html']) ?
                                        $penomorans['kode_akses']['jenis_kode_akses']['full_name_html'] :''; !!}</div>
                                    <div class="text-muted font-size-sm">Kode Akses :
                                        {{isset($penomorans['kode_akses']['kode_akses']) ?
                                        $penomorans['kode_akses']['kode_akses'] :''; }}</div>
                                </div>

                            </div>
                        </td>
                        @if(!isset($penomorans['updated_date']))
                        <td class="text-center"> - </td>
                        @else
                        <td class="text-center" style="overflow-wrap: break-word;">
                            {{$date_reformat->dateday_lang_reformat_long($penomorans['updated_date'])}}</td>
                        @endif

                        <td class="text-center">3 Hari</td>
                        <td class="text-center">
                            <div class="badge badge-success-100 text-success">{{isset($penomorans['jenis_permohonan']) ?
                                $penomorans['jenis_permohonan'] :''; }}</div>
                        </td>
                        <td class="text-center"><span class="badge badge-success-100 text-success">{{
                                isset($penomorans['kode_izin']['name_status_bo']) ?
                                $penomorans['kode_izin']['name_status_bo'] : ''; }}</span>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <a href="#"
                                    class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                    data-toggle="dropdown">
                                    <i class="icon-menu7"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <a href="{{route('admin.pencabutan-penomoran-proses',[$penomorans['id_izin'],$penomorans['id_kode_akses']])}}"
                                        class="dropdown-item"><i class="icon-stack-cancel"></i>
                                        Pencabutan
                                        Kode Akses</a>
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
    <div class="text-right pagination-flat" style="float:right">
        @if (isset($paginate) && $paginate != null && $paginate->count() > 0)
        {{ $paginate->links() }}
        @endif
    </div>
    <!-- /latest orders -->
</div>
@endsection