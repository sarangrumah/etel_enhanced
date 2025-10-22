@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
	<!-- Quick stats boxes -->
	<div class="row">

		<div class="col-lg">
			<!-- Members online -->

			<!-- /members online -->
			</a>

		</div>

		<div class="col-lg">
			<!-- Current server load -->

			<!-- /current server load -->
		</div>
	</div>
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
				<h6 class="card-title font-weight-semibold py-3">List Dalam proses</h6>

				{{-- <div class="d-inline-flex align-items-center ml-auto">
            <div class="dropdown ml-2">
                <a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
                    <i class="icon-more2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{route('admin.masterholiday.create')}}" class="dropdown-item"><i class="icon-add"></i> Tambahkan Hari Libur</a>
                    <a href="#" class="dropdown-item"><i class="icon-printer"></i> Print report</a>
                    <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export report</a>
                </div>
            </div> 
        </div> --}}
			</div>

			<!-- <div class="card-header d-flex">
														<div  class="d-inline-flex align-items-center ml-auto">
																		<a href="{{ route('admin.masterholiday.create') }}" class="btn btn-secondary"><i class="icon-add"> Tambahkan Hari Libur</i></a>
														</div>
										
										</div> -->

			<div class="table-responsive border-top-0 container-fluid">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th>No</th>
							<th class="text-center">Hari Libur</th>
							<th class="text-center">Status</th>
							<th class="text-center">Updated By</th>
							<th class="text-center">Tanggal Update</th>

							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 0;
						
						?>
						@foreach ($masterholiday['data'] as $holiday)
							<?php $count++; ?>
							<tr>
								<td>{{ $count }}</td>
								<td>
									<div class="d-flex align-items-center">
										<div class="text-muted font-size-sm">
											{{ date('d F Y', strtotime($holiday['off_day'])) }}<br>
											{{ $holiday['desc'] }}
										</div>
									</div>
								</td>
								<td>
									<div class="d-flex align-items-center">
										@if ($holiday['is_active'] == '1')
											<div class="text-success font-size-sm">Active</div>
										@else
											<div class="text-danger font-size-sm">Non Active</div>
										@endif
									</div>
								</td>

								<!-- <td class="text-center">{{ $holiday['updated_by'] }}</td> -->
								<td class="text-center"> {{ isset($holiday['updated_by']) ? $holiday['updated_by'] : $holiday['created_by'] }}
								</td>
								<td class="text-center">{{ date('d F Y - H:i:s', strtotime($holiday['updated_date'])) }}</td>
								<!-- <td>

																																		<div class="btn-group">

																																										<a href="{{ url('/admin/masterholiday/edit') . '/' . $holiday['id'] }}" class="btn btn-secondary"><i class="icon-pencil" style="font-size:11px;"> Edit</i>
																																										</a>
																																										
																																														
																																										
																																										
																																						</div>
																														

																										</td> -->

								<td class="text-center">
									<div class="dropdown">
										<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
											data-toggle="dropdown">
											<i class="icon-menu7"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right">
											<a href="{{ url('/admin/masterholiday/edit') . '/' . $holiday['id'] }}" class="dropdown-item"><i
													class="icon-pencil" style="font-size:11px;"> Edit</i></a>
											<a href="{{ url('/admin/masterholiday/delete') . '/' . $holiday['id'] }}"
												class="dropdown-item text-danger"><i class="icon-trash" style="font-size:11px;"> Delete</i></a>
										</div>
									</div>
								</td>
							</tr>
						@endforeach

					</tbody>
				</table>

			</div>

		</div>
		<div class="text-right pagination-flat" style="float:right">
			{{ $paginate->links() }}
		</div>
		<!-- /latest orders -->
	</div>

	<script type="text/javascript"></script>
@endsection
