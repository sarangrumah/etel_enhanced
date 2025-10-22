@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
	<!-- Quick stats boxes -->
	<div class="row">
		<div class="col-lg">
			<!-- Members online -->
			<div class="card bg-primary text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">0</h3>
						<a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
					</div>

					<div>
						Permohonan
						<div class="font-size-sm opacity-75">Penetapan komitmen_list</div>
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
			<div class="card bg-secondary text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ isset($countpenomoran) ? $countpenomoran : 0 }}</h3>
						<a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
					</div>

					<div>
						Permohonan
						<div class="font-size-sm opacity-75">Penetapan Uji Laik Operasi</div>
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
				<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Perizinan Dalam proses</h6>

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
				<table class="table text-nowrap datatable-button-init-basic" id="table">
					<thead>
						<tr>
							<th>Permohonan</th>
							<th class="text-center">Tanggal Permohonan</th>
							<th class="text-center">Tanggal Pelaksanaan ULO</th>
							<th class="text-center">Batas Verifikasi</th>
							<th class="text-center">Status</th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						@if (isset($komitmen_list['data']) && count($komitmen_list['data']) > 0)
							@foreach ($komitmen_list['data'] as $komitmen_list)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												{{-- <a href="{{route('admin.direktur.penetapan-ulo',$komitmen_list['id_izin'])}}"
                                        class="text-body font-weight-semibold">{{$komitmen_list['id_izin']}}</a> --}}
												<a href="#" class="text-body font-weight-semibold">{{ $komitmen_list['id_izin'] }}</a>
												<div class="text-muted font-size-sm">{{ $komitmen_list['jenis_izin'] }}</div>
												<div class="text-muted font-size-sm">{{ $komitmen_list['kbli'] }} - {{ $komitmen_list['kbli_name'] }}
												</div>
												<div class="text-muted font-size-sm">{!! $komitmen_list['jenis_layanan_html'] !!}</div>
											</div>
										</div>
									</td>
									<!-- <td class="text-center">{{ date_format(date_create($komitmen_list['tgl_permohonan']), 'Y-m-d') }}</td> -->
									@if ($komitmen_list['tgl_permohonan'] == null)
										<td class="text-center"> - </td>
									@else
										<td class="text-center"> {{ $date_reformat->dateday_lang_reformat_long($komitmen_list['tgl_permohonan']) }}
										</td>
									@endif
									@if ($komitmen_list['tgl_permohonan'] == null)
										<td class="text-center"> - </td>
									@else
										<td class="text-center">
											{{ $date_reformat->dateday_lang_reformat_long($komitmen_list['tgl_permohonan']) }}</td>
									@endif
									<td class="text-center">3 Hari</td>
									<td class="text-center"><span class="badge badge-success-100 text-success">Koreksi Komitmen</span>
									</td>
									<td class="text-center">
										<div class="dropdown">
											<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
												data-toggle="dropdown">
												<i class="icon-menu7"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="{{ route('admin.evaluator.koreksikomitmen_id', $komitmen_list['id_izin']) }}"
													class="dropdown-item"><i class="icon-pencil"></i> Koreksi Komitmen</a>
												{{-- <a target="_blank" href="{{ route('admin.historyperizinan', $komitmen_list['id_izin']) }}"
													class="dropdown-item"><i class="icon-history"></i> Riwayat Permohonan</a> --}}
												{{-- <a href="#" class="dropdown-item"><i class="icon-pencil"></i> Koreksi Komitmen</a> --}}
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
		<div class="text-right pagination-flat">
			@if ($paginate != null && $paginate->count() > 0)
				{{ $paginate->links() }}
			@endif
		</div>
		<!-- /latest orders -->
	</div>
@endsection
