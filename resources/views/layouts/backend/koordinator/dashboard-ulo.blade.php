@extends('layouts.backend.main')
@section('content')
	<div class="row">
		<div class="col-lg">
			<div class="card bg-secondary text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ isset($countdisposisi) ? $countdisposisi : 0 }}</h3>
						<a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
					</div>
					<div>
						Permohonan
						<div class="font-size-sm opacity-75">Disposisi</div>
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
						<h3 class="font-weight-semibold mb-0">{{ isset($countpersetujuan) ? $countpersetujuan : 0 }}</h3>
						<a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
					</div>
					<div>
						Permohonan
						<div class="font-size-sm opacity-75">Persetujuan</div>
					</div>
				</div>
				<div class="container-fluid">
					<div id="members-online"></div>
				</div>
			</div>
		</div>
	</div>
	<div>
		@if (Session::get('message') != '')
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{{ Session::get('message') }}</strong>
			</div>
		@endif

		<div class="card">
			<div class="card-header d-flex py-0">
				<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Uji Laik Operasi Penyelenggaraan
					Telekomunikasi Dalam
					Proses</h6>
			</div>
			<div class="card-body">
				<table class="table datatable-basic" id="table">
					<thead>
						<tr>
							<th style="width: 30%;">Permohonan</th>
							<th class="text-center" style="width: 20%;">Tanggal Permohonan</th>
							<th class="text-center" style="width: 20%;">Tanggal Pelaksanaan ULO</th>
							<th class="text-center" style="width: 5%;" hidden></th>
							<th class="text-center" style="width: 20%;">Status</th>
							<th class="text-center" style="width: 5%;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						@if (isset($ulo) && count($ulo) > 0)
							@foreach ($ulo as $ulos)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												@if ($ulos['status_ulo'] == 20)
													<a href="{{ route('admin.koordinator.disposisi-ulo', [$ulos['id_izin'], $ulos['id']]) }}"
														class="text-body font-weight-semibold">{{ $ulos['id_izin'] }}</a>
												@elseif($ulos['status_ulo'] == 903)
													<a href="{{ route('admin.koordinator.evaluasi-ulo', [$ulos['id_izin'], $ulos['id']]) }}"
														class="text-body font-weight-semibold">{{ $ulos['id_izin'] }}</a>
												@elseif($ulos['status_ulo'] == 901)
													<a href="{{ route('admin.koordinator.redisposisi-ulo', [$ulos['id_izin'], $ulos['id']]) }}"
														class="text-body font-weight-semibold">{{ $ulos['id_izin'] }}</a>
												@endif
												<div class="text-muted font-size-sm"> {{ strtoupper($ulos['nama_perseroan']) }}</div>
												<div class="text-muted font-size-sm">{{ $ulos['jenis_izin'] }}</div>
												<div class="text-muted font-size-sm">{{ $ulos['kbli'] }} -
													{{ $ulos['kbli_name'] }}
												</div>
												<div class="text-muted font-size-sm">{!! $ulos['jenis_layanan_html'] !!}</div>
											</div>
										</div>
									</td>
									@if ($ulos['tgl_submit'] == null)
										<td class="text-center"> - </td>
									@else
										<td class="text-center">
											{{ $date_reformat->dateday_lang_reformat_long($ulos['tgl_submit']) }}
										</td>
									@endif
									@if ($ulos['tgl_pengajuan_ulo'] == null)
										<td class="text-center"> - </td>
									@else
										<td class="text-center">
											{{ $date_reformat->dateday_lang_reformat_long($ulos['tgl_pengajuan_ulo']) }}
										</td>
									@endif
									<td class="text-center" hidden>3 Hari</td>
									<td class="text-center"><span class="badge badge-success-100 text-success">
											{{-- @if ($ulos['status_ulo'] == 20)
                                Untuk dilakukan Disposisi
                                @elseif($ulos['status_ulo'] == 903)
                                Evaluasi Koordinator
                                @endif --}}
											{{ $ulos['name_status_bo'] }}
										</span></td>
									<td class="text-center">
										<div class="dropdown">
											<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
												data-toggle="dropdown">
												<i class="icon-menu7"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												@if ($ulos['status_ulo'] == 20)
													<a href="{{ route('admin.koordinator.disposisi-ulo', [$ulos['id_izin'], $ulos['id']]) }}"
														class="dropdown-item"><i class="icon-pencil"></i> Disposisi
														Perizinan</a>
												@elseif($ulos['status_ulo'] == 901)
													<a href="{{ route('admin.koordinator.redisposisi-ulo', [$ulos['id_izin'], $ulos['id']]) }}"
														class="dropdown-item"><i class="icon-pencil"></i> Re-Disposisi</a>
												@elseif($ulos['status_ulo'] == 903)
													<a href="{{ route('admin.koordinator.evaluasi-ulo', [$ulos['id_izin'], $ulos['id']]) }}"
														class="dropdown-item"><i class="icon-pencil"></i> Evaluasi</a>
												@endif
												<a target="_blank" href="{{ route('admin.historyperizinan', $ulos['id_izin']) }}" class="dropdown-item"><i
														class="icon-history"></i> Riwayat
													Permohonan</a>
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

		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-lg-8">
						<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Izin Penyelenggaraan Telekomunikasi Khusus
							Instansi Dalam
							Proses</h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<table class="table text-nowrap datatable-basic" id="table">
					<thead>
						<tr>
							<th>Permohonan</th>
							<th class="text-center">Tanggal Permohonan</th>
							<th class="text-center" style="width: 5%;" hidden></th>
							<th class="text-center">Batas Verifikasi</th>
							<th class="text-center">Status</th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						@if (isset($izin) && count($izin) > 0)
							@foreach ($izin as $izins)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												@if ($izins['status_checklist'] == 20)
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}"
														class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
													<div class="text-muted font-size-sm">{{ $izins['kbli'] }} -
														{{ $izins['kbli_name'] }}</div>
												@elseif ($izins['status_checklist'] == 901)
													<a href="{{ route('admin.koordinator.redisposisi', $izins['id_izin']) }}"
														class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
													<div class="text-muted font-size-sm">{{ $izins['kbli'] }} -
														{{ $izins['kbli_name'] }}</div>
												@elseif ($izins['status_checklist'] == 21)
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}"
														class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
												@elseif ($izins['status_checklist'] == 22)
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}"
														class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
												@elseif ($izins['status_checklist'] == 23)
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}"
														class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
												@elseif ($izins['status_checklist'] == 24)
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}"
														class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
												@elseif($izins['status_checklist'] == 903)
													<a href="{{ route('admin.koordinator.evaluasi', $izins['id_izin']) }}"
														class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
													<div class="text-muted font-size-sm">{{ $izins['kbli'] }} -
														{{ $izins['kbli_name'] }}</div>
												@elseif($izins['status_checklist'] == 803)
													<a href="{{ route('admin.koordinator.evaluasi', $izins['id_izin']) }}"
														class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
												@elseif($izins['status_checklist'] == 8031)
													<a href="{{ route('admin.koordinator.evaluasi', $izins['id_izin']) }}"
														class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
												@else
													<a href="" class="text-body font-weight-semibold">{{ $izins['id_izin'] }}</a>
													<div class="text-muted font-size-sm">{{ $izins['jenis_izin'] }}</div>
													<div class="text-muted font-size-sm">{{ $izins['kbli'] }} -
														{{ $izins['kbli_name'] }}</div>
												@endif

												<div class="text-muted font-size-sm"> {{ strtoupper($izins['nama_perseroan']) }}</div>

												<div class="text-muted font-size-sm">{!! $izins['jenis_layanan_html'] !!}</div>
											</div>

										</div>
									</td>
									@if ($izins['submitted_at'] == null)
										<td class="text-center"> - </td>
									@else
										@if ($izins['corrected_at'] == null)
											<td class="text-center">
												{{-- {{ $date_reformat->dateday_lang_reformat_long($izins['updated_at']) }}</td> --}}
												{{ $date_reformat->dateday_lang_reformat_long($izins['submitted_at']) }}</td>
										@else
											<td class="text-center">
												{{-- {{ $date_reformat->dateday_lang_reformat_long($izins['updated_at']) }}</td> --}}
												{{ $date_reformat->dateday_lang_reformat_long($izins['corrected_at']) }}</td>
										@endif
									@endif

									<td class="text-center" hidden>3 Hari</td>
									<td class="text-center"><span
											class="badge badge-success-100 text-success">{{ $izins['batas_verifikasi'] }}</span>
										Hari</td>
									<td class="text-center">
										@if ($izins['status_penyesuaian'] == '0' || $izins['status_penyesuaian'] == '903')
											<span class="badge badge-success-100 text-success">Perubahan Komitmen</span>
										@else
											<span class="badge badge-success-100 text-success">{{ $izins['status_bo'] }}</span>
										@endif
									</td>
									<td class="text-center">
										<div class="dropdown">
											<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
												data-toggle="dropdown">
												<i class="icon-menu7"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												@if ($izins['status_penyesuaian'] == '0')
													<a href="{{ route('admin.koordinator.disposisipenyesuaian', $izins['id_izin']) }}"
														class="dropdown-item"><i class="icon-pencil"></i> Disposisi
														Perubahan Komitmen</a>
												@elseif ($izins['status_penyesuaian'] == '903')
													<a href="{{ route('admin.koordinator.evaluasipenyesuaian', $izins['id_izin']) }}"
														class="dropdown-item"><i class="icon-pencil"></i> Evaluasi
														Perubahan
														Komitmen</a>
												@elseif ($izins['status_checklist'] == '20')
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Disposisi
														Perizinan</a>
												@elseif ($izins['status_checklist'] == '901')
													<a href="{{ route('admin.koordinator.redisposisi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Re-Disposisi
														Perizinan</a>
												@elseif ($izins['status_checklist'] == '701')
													<a href="{{ route('admin.koordinator.redisposisi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Re-Disposisi
														Perizinan</a>
												@elseif ($izins['status_checklist'] == '801')
													<a href="{{ route('admin.koordinator.redisposisi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Re-Disposisi
														Perizinan</a>
												@elseif ($izins['status_checklist'] == '21')
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Disposisi
														Perizinan</a>
												@elseif ($izins['status_checklist'] == '22')
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Disposisi
														Perizinan</a>
												@elseif ($izins['status_checklist'] == '23')
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Disposisi
														Perizinan</a>
												@elseif ($izins['status_checklist'] == '24')
													<a href="{{ route('admin.koordinator.disposisi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Disposisi
														Perizinan</a>
												@elseif($izins['status_checklist'] == '903')
													<a href="{{ route('admin.koordinator.evaluasi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Evaluasi</a>
												@elseif($izins['status_checklist'] == '803')
													<a href="{{ route('admin.koordinator.evaluasi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Evaluasi</a>
												@elseif($izins['status_checklist'] == '8031')
													<a href="{{ route('admin.koordinator.evaluasi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Evaluasi</a>
												@elseif($izins['status_checklist'] == '703')
													<a href="{{ route('admin.koordinator.evaluasi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Evaluasi</a>
												@elseif($izins['status_checklist'] == '603')
													<a href="{{ route('admin.koordinator.evaluasi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Evaluasi</a>
												@elseif($izins['status_checklist'] == '99902')
													<a href="{{ route('admin.koordinator.evaluasi', $izins['id_izin']) }}" class="dropdown-item"><i
															class="icon-pencil"></i> Evaluasi</a>
												@endif

												<!-- <a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Informasi Perizinan</a> -->

												<a target="_blank" href="{{ route('admin.historyperizinan', $izins['id_izin']) }}"
													class="dropdown-item"><i class="icon-history"></i> Riwayat
													Permohonan</a>

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
		{{-- <div class="text-right pagination-flat" style="float:right"> --}}

		{{-- @if ($paginate != null && $paginate->count() > 0)
				{{ $paginate->links() }}
			@endif --}}
		{{-- </div> --}}
	</div>
@endsection
