@extends('layouts.backend.main')
@section('content')
	<div class="row">
		<div class="col-lg">
			<div class="card bg-secondary text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ isset($log_meeting_count) ? $log_meeting_count : 0 }}</h3>
					</div>
					<div>
						Jadwal
						<div class="font-size-sm opacity-75">Bimbingan Teknis</div>
					</div>
				</div>
				<div class="container-fluid">
					<div id="members-online"></div>
				</div>
			</div>
			</a>
		</div>

		<div class="col-lg">
			<div class="card bg-teal text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ isset($log_invited) ? $log_invited : 0 }}</h3>
					</div>
					<div>
						Pelaku Usaha
						<div class="font-size-sm opacity-75">Telah Diundang</div>
					</div>
				</div>
				<div class="container-fluid">
					<div id="members-online"></div>
				</div>
			</div>
		</div>

		<div class="col-lg">
			<div class="card bg-primary text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ isset($log_notyetinvited) ? $log_notyetinvited : 0 }}</h3>
					</div>
					<div>
						Pelaku Usaha
						<div class="font-size-sm opacity-75">Belum Diundang</div>
					</div>
				</div>
				<div class="container-fluid">
					<div id="members-online"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header bg-indigo text-white header-elements-inline">
			<div class="row">
				<div class="col-lg">
					<h6 class="card-title font-weight-semibold py-3">Rekap Bimbingan Teknis</h6>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive border-top-0">
				<table class="table datatable-button-init-basic">
					<thead>
						<tr class="text-center">
							<th style="width: 5%;">No.</th>
							<th style="width: 24%;">Nama Pemohon</th>
							<th class="sorting" style="width: 50%;">Nama Pelaku Usaha</th>
							<th style="width: 10%;">Email</th>
							<th style="width: 10%;" class="sorting">Kontak</th>
							<th style="width: 10%;" class="sorting">Tanggal Permohonan</th>
							<th style="width: 10%;" class="sorting">Tanggal Bimbingan Teknis</th>
							{{-- <th style="width: 1%;"></th> --}}
						</tr>
					</thead>
					<tbody>
						@if (isset($log) && count($log) > 0)
							@foreach ($log as $loges)
								<tr class="text-center">
									<td class="text-center">{{ $loop->iteration }}</td>
									<td class="text-center">
										<div class="text-body font-size-sm">
											{{ isset($loges['nama_pemohon']) ? $loges['nama_pemohon'] : '-' }}
										</div>
									</td>
									<td class="text-center">
										<div class="text-body font-size-sm">
											{{ isset($loges['nama_perusahaan']) ? $loges['nama_perusahaan'] : '-' }}
										</div>
									</td>
									<td class="text-center">
										<div>
											<div class="text-body font-size-sm">
												{{ isset($loges['email_pemohon']) ? $loges['email_pemohon'] : '' }}
											</div>
										</div>
									</td>
									<td class="text-center">
										<div>
											<div class="text-body font-size-sm">
												{{ isset($loges['notelp_pemohon']) ? $loges['notelp_pemohon'] : '' }}
											</div>
										</div>
									</td>
									<td class="text-center">
										<div>
											<div class="text-body font-size-sm">
												{{ isset($loges['req_date']) ? $date_reformat->date_lang_reformat_long_with_time($loges['req_date']) : '' }}
											</div>
										</div>
									</td>
									<td class="text-center">
										<div>
											<div class="text-body font-size-sm">
												{{ isset($loges['submitted_date']) ? $date_reformat->date_lang_reformat_long_with_time($loges['submitted_date']) : '' }}
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
	</div>

@endsection
