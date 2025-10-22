@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
	<!-- Quick stats boxes -->
	<div class="row">
		<!-- <div class="col-lg">
																																		
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
																														</div> -->

		<div class="col-lg">
			<!-- Members online -->
			<div class="card bg-primary text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ isset($countpenomoran) ? $countpenomoran : 0 }}</h3>
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

				<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Pengajuan Penomoran</h6>

				<div class="d-inline-flex align-items-center ml-auto">
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
				</div>
			</div>

			<div class="table-responsive border-top-0">
				<table class="table text-nowrap datatable-button-init-basic">
					<thead>
						<tr>
							<th>Permohonan</th>
							<!-- <th>Detil Permohonan Penomoran</th> -->
							<th class="text-center">Tanggal Permohonan</th>
							<!-- <th class="text-center">Tanggal Permohonan</th> -->
							{{-- <th class="text-center">Batas Verifikasi</th> --}}
							{{-- <th class="text-center">Jenis Permohonan</th> --}}
							<th class="text-center">Status</th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						@if (isset($penomoran['data']) && count($penomoran['data']) > 0)
							@foreach ($penomoran['data'] as $penomoran)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												<a
													href="{{ route('admin.direktur.penetapan-penomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}"
													class="text-body font-weight-semibold">{{ $penomoran['id_izin'] }}</a>
												<div class="text-body font-weight-semibold">
													{{ isset($penomoran['nama_perseroan']) ? $penomoran['nama_perseroan'] : '' }}
												</div>
												<div class="text-muted font-size-sm">{{ $penomoran['jenis_permohonan'] }}
												</div>
												{{-- <div class="text-muted font-size-sm">{{isset($penomoran['jenis_permohonan']) ?
                                        $penomoran['jenis_permohonan'] :''; }}</div> --}}

												{{-- <div class="text-muted font-size-sm">{{ $penomoran['kbli'] }} -
                                                    {{ $penomoran['kbli_name'] }}</div> --}}

												{{-- <div class="text-muted font-size-sm">{!! $penomoran['jenis_layanan_html'] !!}</div> --}}
												<div class="text-muted font-size-sm">{!! isset($penomoran['jenis_kode_akses']) ? $penomoran['jenis_kode_akses'] : '' !!}</div>
												<div class="text-muted font-size-sm">Kode Akses :
													@if ($penomoran['jenis_kode_akses'] == 'Blok Nomor')
														{{ isset($penomoran['bloknomor_list']) ? $penomoran['bloknomor_list'] : '' }}
													@else
														{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}
													@endif
												</div>
											</div>
										</div>
									</td>

									@if ($penomoran['updated_date'] == null)
										<td class="text-center"> - </td>
									@else
										<td class="text-center" style="overflow-wrap: break-word;">
											{{ date('d F Y', strtotime($penomoran['updated_date'])) }}
										</td>
									@endif

									{{-- <td class="text-center">3 Hari</td> --}}
									{{-- <td class="text-center">
                                        <div class="badge badge-success-100 text-success">
                                            {{ isset($penomoran['jenis_permohonan']) ? $penomoran['jenis_permohonan'] : '' }}
                                        </div>
                                    </td> --}}
									<td class="text-center"><span
											class="badge badge-success-100 text-success">{{ isset($penomoran['name_status_bo']) ? $penomoran['kode_izin']['name_status_bo'] : '' }}</span>
									</td>
									<td class="text-center">
										<div class="dropdown">
											<a
												href="{{ route('admin.direktur.penetapan-penomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}"
												style="color:grey;"><i class="icon-pencil"></i></a>

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
			@if ($paginate != null && $paginate->count() > 0)
				{{ $paginate->links() }}
			@endif
		</div>
		<!-- /latest orders -->
	</div>
@endsection
