@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
	<div class="content-wrapper">

		<!-- Inner content -->
		<div class="content-inner">
			<!-- Content area -->
			<div class="content">

				<div class="row">
					<div class="col-lg">
						<!-- Members online -->
						<div class="card bg-secondary text-white">
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
															<a href="{{ route('admin.evaluator.evaluasi-penomoran', [$loges->id_izin, $loges->id_kode_akses]) }}"
																class="text-body font-weight-semibold">{{ $loges->id_izin }}</a>
															<div class="text-muted font-size-sm">
																{{ isset($loges->nama_perseroan) ? $loges->nama_perseroan : '' }}
															</div>
															<div class="text-muted font-size-sm">
																{{ isset($loges->jenis_permohonan) ? $loges->jenis_permohonan : '' }}
															</div>
															<div class="text-muted font-size-sm">
																{{ isset($penomorans['jenis_penomoran']) ? $penomorans['jenis_penomoran'] : '' }}
															</div>
															{{-- <div class="text-muted font-size-sm">{{ $penomorans['kbli'] }} -
                                                    {!! $penomorans['jenis_layanan_html'] !!}</div> --}}
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
												{{-- <td class="text-center">3 Hari</td> --}}
												{{-- <td class="text-center">
                                        <div class="badge badge-success-100 text-success">
                                            {{ isset($penomorans['jenis_permohonan']) ? $penomorans['jenis_permohonan'] : '' }}
                                        </div>
                                    </td> --}}
												<td class="text-center"><span
														class="badge badge-success-100 text-success">{{ isset($loges->status_bo) ? $loges->status_bo : '' }}</span>
												</td>
												<td class="text-center"></td>
												<td class="text-center">
													<span>
														<a style="color:grey;" {{-- href="{{ route('admin.evaluator.evaluasi-penomoran', [$penomorans['id_izin'], $penomorans['id_kode_akses']]) }}"><i --}}
															href="{{ route('admin.evaluator.evaluasipe', [$loges->id_izin]) }}"><i class="icon-pencil"></i></a>
													</span>
												</td>
											</tr>
										@endforeach
									@endif
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

	<!-- Quick stats boxes -->

@endsection
