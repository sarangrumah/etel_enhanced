@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
	<div class="content-wrapper">
		<div class="content-inner">
			<div class="content">
				<div>
					@if (Session::get('message') != '')
						<div class="alert alert-success alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>{{ Session::get('message') }}</strong>
						</div>
					@endif

					<!-- Latest orders -->
					<div class="card">
						<div class="card-header bg-indigo text-white header-elements-inline">
							<div class="row col-lg-12">
								<div class="col-lg">
									<h6 class="card-title font-weight-semibold py-3">Data Respon Survei
									</h6>
								</div>
							</div>
						</div>
						<div class="card-body">
							{{-- <div class="d-inline-flex align-items-center ml-auto">
                                <div class="dropdown ml-2">
                                    <a href="#"
                                        class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                        data-toggle="dropdown">
                                        <i class="icon-more2"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-printer"></i> Print
                                            report</a>
                                        <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export
                                            report</a>
                                    </div>
                                </div>
                            </div> --}}
							<div class="text-right col-lg-12 ms-lg-auto" style="float: right;">
								<a href="{{ route('download.data_respond_survei') }}" class="btn btn-primary">Unduh <i
										class="icon-file-excel"></i> </a>
							</div>
							<div>&nbsp;</div>
							<table class="table datatable-basic" id="tableno" width="100%">
								<thead>
									<tr>
										<th style="width=5px;" class="text-center">No </th>
										<th style="width=100%;" class="text-center">Periode Survei </th>
										<th style="width=1%;" class="text-center text-nowrap">No Permohonan </th>
										<th style="width=1%;" class="text-center">Nama Pemohon </th>
										<th style="width=1%;" class="text-center text-nowrap sorting sorting_asc">Tingkat Kepuasan </th>
										<th style="width=1%;" class="text-center sorting sorting_asc">Kinerja </th>
										<th style="width=1%;" class="text-center sorting sorting_asc">Harapan </th>
										<th style="width=1%;" class="text-center sorting sorting_asc">IIPP </th>
										<th style="width=1%;" class="text-center">Flag </th>
										<th style="width=1%;" class="text-center sorting_disabled">Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($list_header as $item)
										<tr>
											<td style="width=5%;" class="text-center">{{ $loop->index + 1 }}</td>
											<td style="width=5%;" class="text-center">{{ $item->period }}</td>
											<td style="width=5%;" class="text-center text-nowrap">{{ $item->id_trx_izin }}</td>
											<td style="width=5%;" class="text-center text-nowrap">{{ $item->nama_perseroan }}</td>
											<td style="width=5%;" class="text-center">{{ $item->SERVQL }}</td>
											<td style="width=5%;" class="text-center">{{ $item->result_ikmk }}</td>
											<td style="width=5%;" class="text-center">{{ $item->result_ikmh }}</td>
											<td style="width=5%;" class="text-center">{{ $item->result_iipp }}</td>
											{{-- <td style="width=5%;" class="text-center">{{ $item->result_flag }}</td> --}}

											<td style="width=5%;" class="text-center">
												@if ($item->result_flag !== '0')
													<i class="icon-flag3 me-3 text-danger"></i>
												@endif

											</td>

											<td class="text-center">
												<span>
													<a style="color:grey;" href="{{ route('admin.survei.result_new', [$item->id_respond]) }}"><i
															class="icon-search4"></i></a>
												</span>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<!-- /latest orders -->
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {

			// if (!$.fn.dataTable.isDataTable('#tableno')) {
			// 	$('#tableno').DataTable({
			// 		columnDefs: [{
			// 			targets: [3, 4], // Hide columns with indices 0 and 4
			// 			visible: false
			// 		}]
			// 	});
			// }
		});
	</script>

	<!-- Quick stats boxes -->

@endsection
