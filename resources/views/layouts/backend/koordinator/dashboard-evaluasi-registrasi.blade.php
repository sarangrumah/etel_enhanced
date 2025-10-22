@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')

	@if ($message = Session::get('message'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
		</div>
	@endif

	<!-- Latest orders -->
	<div class="card">
		<div class="card-header bg-indigo text-white header-elements-inline">
			<h6 class="card-title font-weight-semibold py-3">Daftar Pengajuan Verifikasi Pelaku Usaha</h6>

			{{-- <div class="d-inline-flex align-items-center ml-auto">
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
            </div> --}}
		</div>

		<div class="table-responsive border-top-0">
			<table class="table text-nowrap">
				<thead>
					<tr>
						<th>Nama / Email</th>
						<th class="text-center">NIB / Nama Instansi</th>
						<th class="text-center">Tanggal Permohonan</th>
						<th class="text-center">No KTP / Paspor</th>
						<th class="text-center">Status</th>
						<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
					</tr>
				</thead>
				<tbody>
					@if (isset($user) && count($user) > 0)
						@foreach ($user as $users)
							<tr>
								<td>
									<div class="d-flex align-items-center">
										<div>
											<a href="{{ route('admin.verifikatornib.evaluasiregistrasiprocess', $users->id) }}"
												class="text-body font-weight-semibold">{{ $users->name ? $users->name : '' }}</a>
											<div class="text-muted font-size-sm">
												{{ $users->email_user_proses ? $users->email_user_proses : '' }}
											</div>
											<div class="text-muted font-size-sm"> {{ strtoupper($users->nama_perseroan ? $users->nama_perseroan : '') }}
											</div>
											<div class="text-muted font-size-sm"></div>
										</div>
									</div>
								</td>
								<td class="text-center">
									{{ $users->nib ? $users->nib : '' }}
								</td>
								<td class="text-center">
									{{ $users->updated_at ? $date_reformat->date_lang_reformat_long_with_time($users->updated_at) : '' }}
								</td>
								<td class="text-center">
									{{ $users->no_ktp ? $users->no_ktp : '' }}
								</td>

								<td class="text-center"><span class="badge badge-success-100 text-success">
										@if ($users->is_deleted == 1)
											Permohonan Re-Aktifasi Akun
										@else
											Untuk Dievaluasi
										@endif
									</span></td>
								<td class="text-center">
									<div class="dropdown">
										<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
											data-toggle="dropdown">
											<i class="icon-menu7"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right">
											@if ($users->is_deleted == 1)
												<a href="{{ route('admin.verifikatornib.reaktifasiakunpost', $users->id) }}" class="dropdown-item"><i
														class="icon-pencil"></i> Re-Aktifasi Akun</a>
											@else
												<a href="{{ route('admin.verifikatornib.evaluasiregistrasiprocess', $users->id) }}" class="dropdown-item"><i
														class="icon-pencil"></i> Evaluasi Pendaftaran
													Pelaku Usaha</a>
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
	{{-- <div class="text-right pagination-flat" style="float:right">
		@if ($paginate != null && $paginate->count() > 0)
			{{ $paginate->links() }}
		@endif
	</div> --}}
	<!-- /latest orders -->
	{{-- </div> --}}
@endsection
