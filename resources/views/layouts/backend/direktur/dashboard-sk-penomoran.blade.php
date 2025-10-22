@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')

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
            <h6 class="card-title font-weight-semibold py-3">Daftar Surat Penetapan Penomoran</h6>

            <div class="d-inline-flex align-items-center ml-auto">
                <div class="dropdown ml-2">
                    <!-- <a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
                        <i class="icon-more2"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="icon-printer"></i> Print report</a>
                        <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export report</a>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="table-responsive border-top-0">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>KBLI</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($sk['data']) && count($sk['data']) > 0)
                    @foreach($sk['data'] as $sk)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <a href="{{route('admin.direktur.lihat-sk-penomoran',[$sk['id_izin'], $sk['id_kode_akses'] ] )}}"
                                        target="_blank" class="text-body font-weight-semibold">{{$sk['id_izin']}}</a>
                                    <div class="text-muted font-size-sm">{{$sk['jenis_izin']}}</div>
                                    <div class="text-muted font-size-sm">{{$sk['kbli']}} - {{$sk['kbli_name']}}</div>
                                    <div class="text-muted font-size-sm">{!! $sk['jenis_layanan_html'] !!}</div>
                                </div>
                            </div>
                        </td>

                        <td class="text-center">
                            @if($sk['is_active'] == 1)
                            <span class="badge badge-success-100 text-success">Aktif</span>
                            @else
                            <span class="badge badge-danger-100 text-danger">Non-aktif</span>
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
                                    <a href="{{route('admin.direktur.lihat-sk-penomoran',[$sk['id_izin'], $sk['id_kode_akses'] ] )}}"
                                        target="_blank" class="dropdown-item"><i class="icon-file-pdf"></i> Lihat Surat
                                        Ketetapan</a>
                                    <!-- @if($sk['is_active'] == 1)
                                        
                                        <a onclick="return false;" data-toggle="modal" data-id="{{$sk['id_izin']}}" data-target="#pencabutanModal" class="dropdown-item openDialog"><i class="icon-cross2"></i> Cabut SK</a>
                                        @endif -->
                                    <!-- <a target="_blank" href="{{ route('admin.historyperizinan', $sk['id_izin']) }}" class="dropdown-item"><i class="icon-file-pdf"></i> Riwayat Permohonan</a> -->
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
    <div class="text-right pagination-flat" style="float:right;">
        @if( isset($paginate) && $paginate != null && $paginate->count() > 0)
        {{ $paginate->links() }}
        @endif
    </div>
    <!-- /latest orders -->
</div>

<div class="modal" id="pencabutanModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Persyaratan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin akan mencabut Surat Penetapan Penomoran ini ?</p>
                <input type="text" name="izinId" id="izinId" value="" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="linkcabut" href='' class="btn btn-primary">Ya</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.openDialog').click(function(){
            let izinId = $(this).data('id');
            $(".modal-body #izinId").val( izinId );
            $('#linkcabut').attr('href','{{ route('admin.direktur.cabutsk', "izinId" ) }} ') ;
        });
    })
    
</script>

@endsection