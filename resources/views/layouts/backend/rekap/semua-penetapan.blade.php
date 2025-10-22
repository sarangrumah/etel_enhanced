@extends('layouts.backend.main')
@section('content')

	<!-- /quick stats boxes -->
	<div>
		@if ($message = Session::get('message'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{{ $message }}</strong>
			</div>
		@endif
		<div class="row">
			{{-- @if (isset($proses)) --}}
			{{-- <div class="col-lg">
				<!-- Members online -->
				<div class="card bg-success text-white">
					<div class="card-body">
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $total }}</h3>
							<a href="javascript:void(0)" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
						</div>

						<div>
							<div class="font-size-sm opacity-75">Total Permohonan</div>
						</div>
					</div>
					<!-- /members online -->
				</div>

			</div> --}}
			{{-- <div class="col-lg">
				<!-- Members online -->
				<div class="card bg-primary text-white">
					<div class="card-body">
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $proses }}</h3>
							<a href="javascript:void(0)" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
						</div>

						<div>
							<div class="font-size-sm opacity-75">Permohonan Dalam Proses</div>
						</div>
					</div>
					<!-- /members online -->
				</div>

			</div> --}}
			<!-- /quick stats boxes -->
			{{-- @endif --}}

			<div class="col-lg">
				<!-- Members online -->
				<div class="card bg-success text-white">
					<div class="card-body">
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $tetap }}</h3>
							{{-- <a href="javascript:void(0)" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a> --}}
						</div>

						<div>
							<div class="font-size-sm opacity-75">SK Penetapan</div>
						</div>
					</div>
				</div>
				<!-- /members online -->
			</div>

			<div class="col-lg">
				<!-- Members online -->
				<div class="card bg-danger text-white">
					<div class="card-body">
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $cabut }}</h3>
							{{-- <a href="javascript:void(0)" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a> --}}
						</div>

						<div>
							<div class="font-size-sm opacity-75">SK Pencabutan</div>
						</div>
					</div>
				</div>
				<!-- /members online -->
			</div>
		</div>

		<!-- Latest orders -->
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-lg-8">
						<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Penomoran Telekomunikasi</h6>
					</div>
				</div>

			</div>

			<div class="text-right col-lg-12 ms-lg-auto" style="float: right;">
				<a href="{{ route('download.tetap_penomoran') }}" class="btn btn-primary">Unduh <i class="icon-file-excel"></i> </a>
			</div>
			<div class="table-responsive border-top-0">
				<table class="table text-nowrap datatable-button-init-basic" id="table">
					<thead>
						<tr>
							<th>Permohonan</th>
							<!-- <th>Detil Permohonan Penomoran</th> -->
							{{-- <th class="text-center">Jenis Penomoran</th> --}}
							<th class="text-center">Kode Akses</th>
							<th class="text-center">No Penetapan</th>
							<th class="text-center">Tanggal Penetapan/Pencabutan</th>
							<th class="text-center">Jenis SK</th>
							<th class="text-center" style="width: 20px;"></th>
						</tr>
					</thead>
					<tbody>

						@if (isset($penomoran) && count($penomoran) > 0)
							@foreach ($penomoran as $penomorans)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												<a href="{{ route('admin.evaluasipenomoran_view', [$penomorans['id_izin']]) }}"
													class="text-body font-weight-semibold">{{ $penomorans['id_izin'] }}</a>
												<div class="text-body font-weight-semibold">
													{{ isset($penomorans['nama_perseroan']) ? $penomorans['nama_perseroan'] : '' }}
												</div>
												{{-- <div class="text-muted font-size-sm">
                                                    {{ isset($penomorans['jenis_izin']) ? $penomorans['jenis_izin'] : '' }}
                                                </div> --}}
												@if (isset($penomorans['jenis_permohonan']))
													<div class="text-muted font-size-sm">{{ $penomorans['jenis_permohonan'] }}</div>
												@endif
												@if (isset($penomorans['jenis_kode_akses_nonhtml']))
													<div class="text-muted font-size-sm">{{ $penomorans['jenis_kode_akses_nonhtml'] }}</div>
												@endif

												{{-- <div class="text-muted font-size-sm">Kode Akses :
                                                    {{ isset($penomorans['kode_akses']['kode_akses']) ? $penomorans['kode_akses']['kode_akses'] : '' }}
                                                </div> --}}
											</div>

										</div>
									</td>
									{{-- <td class="text-center">
										<div class="text-center">
											{{ isset($penomorans['jenis_kode_akses_nonhtml']) ? $penomorans['jenis_kode_akses_nonhtml'] : '' }}
										</div>
									</td> --}}

									<td class="text-center">
										<div class="text-center">
											{{ isset($penomorans['kode_akses']['kode_akses']) ? $penomorans['kode_akses']['kode_akses'] : '' }}
										</div>
									</td>
									<td class="text-center">
										<div class="text-center">
											{{ isset($penomorans['no_izin']) ? $penomorans['no_izin'] : '' }}
										</div>
									</td>
									@if (!isset($penomorans['tgl_izin']))
										<td class="text-center"> - </td>
									@else
										<td class="text-center" style="overflow-wrap: break-word;">
											{{ $date_reformat->dateday_lang_reformat_long($penomorans['tgl_izin']) }}
										</td>
									@endif
									<td class="text-center"><span class="badge badge-success-100 text-success">
											@if (
												$penomorans['jenis_permohonan'] == 'Pengembalian Penomoran' ||
													$penomorans['jenis_permohonan'] == 'Pencabutan Penetapan Penomoran Telekomunikasi')
												Pencabutan
											@else
												Penetapan
											@endif
										</span>
									</td>
									<td>
										<div class="dropdown">
											<a href="javascript:void(0)"
												class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
												data-toggle="dropdown">
												<i class="icon-menu7"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="{{ route('admin.evaluasipenomoran_view', [$penomorans['id_izin']]) }}" class="dropdown-item"><i
														class="icon-history"></i> Detail
													Permohonan</a>
												@if ($penomorans['status_checklist'] == '50' || $penomorans['status_checklist'] == '95')
													<a href="{{ asset($penomorans['file_sk_penomoran']) }}" class="dropdown-item" target="_blank"><i
															class="icon-history"></i>
														SK Penomoran</a>
												@endif
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
