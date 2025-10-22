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
							<div class="row">
								<div class="col-lg">
									<h6 class="card-title font-weight-semibold py-3">Data Hasil Survei
									</h6>
								</div>
							</div>
						</div>
						<div class="card-body">

							<div class="text-right col-lg-12 ms-lg-auto" style="float: right;">
								<a href="{{ route('download.data_respond_summary') }}" class="btn btn-primary">Unduh <i
										class="icon-file-excel"></i> </a>
							</div>
							<div>&nbsp;</div>
							<table class="table datatable-basic" id="tableno">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Periode Survei</th>
										<th class="text-center">Total <br />Responden<br />Dihitung</th>
										<th class="text-center">Total <br />Responden<br />Flag*</th>
										<th class="text-center">Tingkat <br />Kepuasan</th>
										<th class="text-center text-nowrap sorting sorting_asc">Nilai IKM <br />Kerja<br />Skala 4</th>
										<th class="text-center text-nowrap">Nilai IKM <br />Kerja<br />Skala 100</th>
										<th class="text-center text-nowrap">Nilai IKM <br />Harapan <br />Skala 4</th>
										<th class="text-center text-nowrap">Nilai IKM <br />Harapan <br />Skala 100</th>
										<th class="text-center">Nilai IIPP<br />Skala 4</th>
										<th class="text-center">Nilai IIPP<br />Skala 10</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach ($list_summary as $item)
										<tr>
											<td class="text-center">{{ $loop->index + 1 }}</td>
											<td class="text-center">{{ $item->period }}</td>
											<td class="text-center">{{ $item->total_responder }}</td>
											<td class="text-center">{{ $item->total_flag }}</a></td>
											<td class="text-center">{{ $item->servql }}</td>
											<td class="text-center">{{ $item->IKMK_4 }}</td>
											<td class="text-center">{{ $item->IKMK_100 }}</td>
											<td class="text-center">{{ $item->IKMH_4 }}</td>
											<td class="text-center">{{ $item->IKMH_100 }}</td>
											<td class="text-center">{{ $item->IIPP_4 }}</td>
											<td class="text-center">{{ $item->IIPP_10 }}</td>

											<td class="text-center">
												<div class="dropdown">
													<a href="javascript:void(0)"
														class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
														data-toggle="dropdown">
														<i class="icon-menu7"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<a href="{{ route('admin.survei.result_survei_detail', [$item->period_month, $item->period_year]) }}"
															class="dropdown-item"><i class="icon-search"></i>
															Lihat Rincian Hasil Survei </a>
														<a href="{{ route('download.summary_IKM', [$item->period_month, $item->period_year, 'IKMK']) }}"
															class="dropdown-item"><i class="icon-file-download"></i> Unduh Hasil Survei IKM Kinerja
														</a>
														<a href="{{ route('download.summary_IKM', [$item->period_month, $item->period_year, 'IKMH']) }}"
															class="dropdown-item"><i class="icon-file-download"></i> Unduh Hasil Survei IKM Harapan
														</a>
														<a href="{{ route('download.summary_IKM', [$item->period_month, $item->period_year, 'IIPP']) }}"
															class="dropdown-item"><i class="icon-file-download"></i> Unduh Hasil Survei IIPP </a>
														<a href="{{ route('download.quest_active') }}" class="dropdown-item"><i class="icon-file-download"></i>
															Unduh Pertanyaan Survei </a>

													</div>
												</div>
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
