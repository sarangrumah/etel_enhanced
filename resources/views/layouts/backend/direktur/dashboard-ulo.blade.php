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
                    <h3 class="font-weight-semibold mb-0">0</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Penetapan Penomoran</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
        <!-- /members online -->
    </div>

    <div class="col-lg">
        <!-- Members online -->
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">{{ isset($countulo)?$countulo:0; }}</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Penetapan Uji Laik Operasi</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
        <!-- /members online -->
    </div>
    <div class="col-lg">
        <!-- Members online -->
        <div class="card bg-pink text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">0</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Pencabutan Surat Penetapan</div>
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
            <h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Perizinan Dalam proses</h6>

            {{-- <div class="d-inline-flex align-items-center ml-auto">
                <div class="dropdown ml-2">
                    <a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                        data-toggle="dropdown">
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
                        <th class="text-center">Tanggal Pelaksanaan ULO</th>
                        <th class="text-center">Batas Verifikasi</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($ulo['data']) && count($ulo['data']) > 0)
                    @foreach($ulo['data'] as $ulo)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <a href="{{route('admin.direktur.penetapan-ulo',[$ulo['id_izin'],$ulo['id']])}}"
                                        class="text-body font-weight-semibold">{{$ulo['id_izin']}}</a>
                                        <div class="text-muted font-size-sm"> {{ strtoupper($ulo['nama_perseroan']) }}</div>
                                        <div class="text-muted font-size-sm">{{$ulo['jenis_izin']}}</div>
                                    <div class="text-muted font-size-sm">{{$ulo['kbli']}} - {{$ulo['kbli_name']}}
                                    </div>
                                    <div class="text-muted font-size-sm">{!! $ulo['jenis_layanan_html'] !!}</div>
                                </div>
                            </div>
                        </td>
                        <!-- <td class="text-center">{{date_format(date_create($ulo['tgl_pengajuan_ulo']),'Y-m-d')}}</td> -->
                        @if($ulo['updated_date'] == null)
                        <td class="text-center"> - </td>
                        @else
                        <td class="text-center"> {{$date_reformat->dateday_lang_reformat_long($ulo['updated_date'])}}
                        </td>
                        @endif
                        @if($ulo['tgl_pengajuan_ulo'] == null)
                        <td class="text-center"> - </td>
                        @else
                        <td class="text-center">
                            {{$date_reformat->dateday_lang_reformat_long($ulo['tgl_pengajuan_ulo'])}}</td>
                        @endif
                        <td class="text-center">3 Hari</td>
                        <td class="text-center"><span
                                class="badge badge-success-100 text-success">{{$ulo['name_status_bo']}}</span>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <a href="#"
                                    class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                    data-toggle="dropdown">
                                    <i class="icon-menu7"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @if($ulo['status_ulo']==904)
                                        <a href="{{route('admin.direktur.penetapan-ulo',[$ulo['id_izin'],$ulo['id']])}}"
                                            class="dropdown-item"><i class="icon-pencil"></i> Penetapan SKLO</a>
                                    @else
                                        <a href="{{route('admin.sk.cetakSKUlo', [$ulo['id_izin'],$ulo['id']])}}"
                                            class="dropdown-item"><i class="icon-pencil"></i> Preview SKLO</a>
                                        <a href="{{route('admin.sk.cetakKomitmen', $ulo['id_izin'])}}"
                                            class="dropdown-item"><i class="icon-pencil"></i> Preview Komitmen</a>
                                        <a href="{{route('admin.direktur.kirimSK',$ulo['id'])}}"
                                            class="dropdown-item"><i class="icon-pencil"></i> Kirim e-mail Penetapan</a>
                                    @endif
                                    <a target="_blank" href="{{ route('admin.historyperizinan', $ulo['id_izin']) }}"
                                        class="dropdown-item"><i class="icon-history"></i> Riwayat Permohonan</a>
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
        @if( $paginate != null && $paginate->count() > 0)
        {{ $paginate->links() }}
        @endif
    </div>
    <!-- /latest orders -->
</div>
@endsection
