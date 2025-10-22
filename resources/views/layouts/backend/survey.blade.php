@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#btnReset').hide();
        });
    </script>
    <div>
        @if (Session::get('message') != '')
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ Session::get('message') }}</strong>
            </div>
        @endif

        <!-- Latest orders -->
        <div class="card">
            <div class="card-header">
                <div class="row">
					<div class="col-lg-8">
                        <h6 class="card-title font-weight-semibold py-3">Rekap Survey</h6>
					</div>
					<div class="d-inline-flex align-items-center ml-auto">
						<div class="dropdown ml-2">
							<a href="javascript:void(0)" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
								<i class="icon-more2"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right"></a>
								<a href="javascript:void(0)" class="dropdown-item"><i class="icon-database-refresh"></i> Perbaharui Data</a>
								{{-- <a href="javascript:void(0)" class="dropdown-item"><i class="icon-file-plus"></i></b> Tambah Data Perizinan</a> --}}
							</div>
						</div>
					</div>
				</div>
                {{-- <div class="row">
                    <form  action="{{ url('/pb/get_by_date') }}" method="post" enctype="multipart/form-data" id="">
                        @csrf
                        <div class="row">
                            <div class="col col-sm-6 col-xs-6 mt-2">
                            <input type="date" class="form-control" name="tglAwal" id="tglAwal" placeholder="Tanggal Awal" required>
                            </div>
                            <div class="col col-sm-6 col-xs-6 mt-2">
                            <input type="date" class="form-control" name="tglAkhir" id="tglAkhir" placeholder="Tanggal Akhir" required>
                            </div>
                            <div class="col col-sm-6 col-xs-6 mt-2">
                                <a type="butoon" id="btnReset" onclick="location.reload()" class="btn btn-block btn-info">Reset Tanggal</a>
                            </div>
                            <div class="col col-sm-6 col-xs-6 mt-2">
                            <input type="submit" id="btnSubmit" class="btn btn-block btn-primary" value="Cari">
                            </div>
                        </div>
                    </form>
                </div> --}}
            </div>

            <div class="table-responsive border-top-0">
                <table class="table text-nowrap datatable-button-init-basic" id="table">
                    <thead>
                        <tr>
                            <th>Nomor Izin</th>
                            <th class="text-center">Tanggal Submit</th>
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
                                                <div class="text-muted font-size-sm">{{ $izins['id_izin'] }}</div>
                                                <div class="text-muted font-size-sm">{{ $izins['kbli'] }} -
                                                    {{ $izins['kbli_name'] }}</div>
                                                <div class="text-muted font-size-sm">{!! $izins['jenis_layanan_html'] !!}</div>
                                            </div>

                                        </div>
                                    </td>
                                    @if(!isset($izins['created_date']))
                                    <td class="text-center"> - </td>
                                    @else
                                    <td class="text-center"> {{$date_reformat->dateday_lang_reformat_long($izins['created_date'])}}</td>
                                    @endif
                                    <td class="text-center"><span
                                            class="badge badge-success-100 text-success">{{ $izins['status']==0?'Disetujui':($izins['status']==2?'Ditolak':'Belum Disetuju') }}</span>
                                    </td>
                                    <td class="text-center">
										@if($izins['status']==1)
                                        <div class="dropdown">
                                            <a href="#"
                                                class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                                data-toggle="dropdown">
                                                <i class="icon-menu7"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" onclick="setActive({!! $izins['id_responder'], ', ',0 !!})"><i class="icon-file-pdf"></i> Setuju</a>
                                                <a class="dropdown-item" onclick="setActive({!! $izins['id_responder'], ', ',2 !!})"><i class="icon-file-pdf"></i> Tolak</a>
                                                <a class="dropdown-item" href="{{ route('admin.responder.view-responder', [$izins['id_izin'], $izins['jenis_survey'], 1]) }}"><i class="icon-file-pdf"></i> View</a>
                                            </div>
                                        </div>
										@endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>


            </div>

        </div>
        <div class="text-right pagination-flat" style="float:right">
            @if ($paginate != null && $paginate->count() > 0)
                {{ $paginate->links() }}
            @endif
        </div>
        <!-- /latest orders -->
    </div>
<div id="modal_nonaktif" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nonaktifkan Responder</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="POST" action="#" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">ID Izin</label>
                        <div class="col-lg-8">
                            <div>
                                <input type="text" class="form-control form-control-outline"
                                    placeholder="Indeks Kepuasan Masyarakat" id="id_izin" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Nonaktifkan Survei</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function getResponder(id, callback) {
	$.ajax({
		type: "GET",
		url: "{{ url('admin/responder') }}/"+id+"/edit",
		success: callback,
		failure: function(errMsg) {
			alert(errMsg);
		}
	});
}
function setActive(id, status) {
	getResponder(id, function(e) {
		$('#modal_nonaktif').modal("show")

		$('#modal_nonaktif form').attr('action', "{{ url('admin/responder/update') }}/"+id);

		$('<input>').attr({
			type: 'hidden',
			name: 'is_active',
			value: status
		}).appendTo('#modal_nonaktif form');

		$('#modal_nonaktif #id_izin').val(e.id_izin)

		$('#modal_nonaktif button[type=submit]').html(status==0?"Setuju":"Tolak")
	});
}
</script>
@endsection
