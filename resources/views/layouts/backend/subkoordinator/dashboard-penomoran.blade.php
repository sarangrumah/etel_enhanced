@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
	<div class="content-wrapper">

		<!-- Inner content -->
		<div class="content-inner">
			<!-- Content area -->
			<div class="content">
				<!-- Quick stats boxes -->
				<div class="row">
					<div class="col-lg">
						<!-- Members online -->
						<div class="card bg-primary text-white">
							<div class="card-body">
								<div class="d-flex">
									<h3 class="font-weight-semibold mb-0">{{ isset($countevaluasi) ? $countevaluasi : 0 }}
									</h3>
									{{-- <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a> --}}
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
						<div class="card-header bg-indigo text-white header-elements-inline">
							<div class="row">
								<div class="col-lg">
									<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Penomoran
										Telekomunikasi
									</h6>
								</div>
							</div>
						</div>
						<div class="card-body">

							<table class="table datatable-basic" id="tableno">
								<thead>
									<tr>
										<th>Permohonan</th>
										<th class="text-center">Tanggal Permohonan</th>
										<th style="width: 1%;"></th>
										<th class="text-center">Status</th>
										<th style="width: 1%;"></th>
										<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i>
										</th>
									</tr>
								</thead>
								<tbody>
									@if (isset($log) && count($log) > 0)
										@foreach ($log as $loges)
											<tr>
												<td>
													<div class="d-flex align-items-center">
														<div>
															@if ($loges->jenis_permohonan == 'Pencabutan Penetapan Penomoran Telekomunikasi')
																<a href="{{ route('admin.subkoordinator.cabutnomor', [$loges->id_izin]) }}"
																	class="text-body font-weight-semibold">{{ $loges->id_izin }}</a>
															@else
																<a href="{{ route('admin.subkoordinator.evaluasi-penomoran', [$loges->id_izin]) }}"
																	class="text-body font-weight-semibold">{{ $loges->id_izin }}</a>
															@endif

															<div class="text-muted font-size-sm">
																{{ isset($loges->nama_perseroan) ? $loges->nama_perseroan : '' }}
															</div>
															<div class="text-muted font-size-sm">
																{{ isset($loges->jenis_permohonan) ? $loges->jenis_permohonan : '' }}
															</div>
															<div class="text-muted font-size-sm">
																{{ isset($penomorans['jenis_penomoran']) ? $penomorans['jenis_penomoran'] : '' }}
															</div>
															<div class="text-muted font-size-sm">
																{!! isset($loges->jenis_kode_akses) ? $loges->jenis_kode_akses : '' !!}
															</div>
															<div class="text-muted font-size-sm">Kode Akses :
																{{ isset($loges->kode_akses) ? $loges->kode_akses : '' }}
															</div>
														</div>
													</div>
												</td>
												<td class="text-center">
													{{ $date_reformat->dateday_lang_reformat_long($loges->submitted_date) }}
												</td>
												<td class="text-center"></td>
												<td class="text-center"><span
														class="badge badge-success-100 text-success">{{ isset($loges->status_bo) ? $loges->status_bo : '' }}</span>
												</td>
												<td class="text-center"></td>
												<td class="text-center">
													@if ($loges->jenis_permohonan == 'Pencabutan Penetapan Penomoran Telekomunikasi')
														<a href="{{ route('admin.subkoordinator.cabutnomor', [$loges->id_izin]) }}" style="color:grey;"><i
																class="icon-pencil"></i></a>
													@else
														<a href="{{ route('admin.subkoordinator.evaluasi-penomoran', [$loges->id_izin]) }}" style="color:grey;"><i
																class="icon-pencil"></i></a>
													@endif

												</td>
											</tr>
										@endforeach
									@endif

								</tbody>
							</table>

						</div>

					</div>
					<script type="text/javascript">
						$(document).ready(function() {

							if (!$.fn.dataTable.isDataTable('#tableno')) {
								$('#tableno').DataTable({
									columnDefs: [{
										targets: [3, 4], // Hide columns with indices 0 and 4
										visible: false
									}]
								});
							}
						});
					</script>
					<!-- /latest orders -->
				</div>

			</div>
		</div>
	</div>

@endsection
