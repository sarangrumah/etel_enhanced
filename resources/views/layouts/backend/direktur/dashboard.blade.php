@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
	<!-- Quick stats boxes -->
	<div class="row">
		<div class="col-lg">
			<!-- Members online -->
			<a href="javascript:void(0)" id="TrigerPenomoran" class="text-decoration-none" title="Penetapan Penomoran">
				<div class="card bg-primary text-white">
					<div class="card-body">
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ isset($countpenomoran) ? $countpenomoran : 0 }}</h3>
							{{-- <p class="badge badge-dark badge-pill align-self-center ml-auto">baru</p> --}}
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
			</a>
			<!-- /members online -->
		</div>

		<div class="col-lg">
			<!-- Members online -->
			<a href="javascript:void(0)" id="TrigerUlo" class="text-decoration-none" title="Penetapan Uji Laik Oprasi">
				<div class="card bg-teal text-white">
					<div class="card-body">
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ isset($countulo) ? $countulo : 0 }}</h3>
							{{-- <p class="badge badge-dark badge-pill align-self-center ml-auto">baru</p> --}}
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
			</a>
			<!-- /members online -->
		</div>

		<div class="col-lg">
			<!-- Members online -->
			<a href="javascript:void(0)" id="TrigerIP" class="text-decoration-none" title="Penetapan Izin Prinsip">
				<div class="card bg-secondary text-white">
					<div class="card-body">
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ isset($countip) ? $countip : 0 }}</h3>
							{{-- <p class="badge badge-dark badge-pill align-self-center ml-auto">baru</p>/ --}}
						</div>

						<div>
							Permohonan
							<div class="font-size-sm opacity-75">Penetapan Izin Prinsip</div>
						</div>
					</div>

					<div class="container-fluid">
						<div id="members-online"></div>
					</div>
				</div>
			</a>
			<!-- /members online -->
		</div>

		{{-- <div class="col-lg">
			<!-- Members online -->
			<a href="javascript:void(0)" id="TrigerKomitmen" class="text-decoration-none" title="Penetapan Komitmen">
				<div class="card bg-secondary text-white">
					<div class="card-body">
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ isset($countkomitmen) ? $countkomitmen : 0 }}</h3>
							s<p class="badge badge-dark badge-pill align-self-center ml-auto">baru</p>
						</div>

						<div>
							Permohonan
							<div class="font-size-sm opacity-75">Penetapan Komitmen</div>
						</div>
					</div>

					<div class="container-fluid">
						<div id="members-online"></div>
					</div>
				</div>
			</a>
			<!-- /members online -->
		</div> --}}
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
				<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Dalam proses</h6>
			</div>

			<div class="table-responsive border-top-0 d-none" id="vTable">
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
						@if (isset($ulo['data']) && count($ulo['data']) > 0)

							@foreach ($ulo['data'] as $ulos)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												<a href="{{ route('admin.direktur.penetapan-ulo', [$ulos['id_izin'], $ulos['id']]) }}"
													class="text-body font-weight-semibold">{{ $ulos['id_izin'] }}</a>
												<div class="text-muted font-size-sm">{{ $ulos['jenis_izin'] }}</div>
												<div class="text-muted font-size-sm">{{ $ulos['kbli'] }} -
													{{ @$ulos['kbli_name'] }}
												</div>
												<div class="text-muted font-size-sm">{!! $ulos['jenis_layanan_html'] !!}</div>
											</div>
										</div>
									</td>
									<!-- <td class="text-center">{{ date_format(date_create($ulos['tgl_pengajuan_ulo']), 'Y-m-d') }}</td> -->
									@if ($ulos['updated_date'] == null)
										<td class="text-center"> - </td>
									@else
										<td class="text-center">
											{{ $date_reformat->dateday_lang_reformat_long($ulos['updated_date']) }}
										</td>
									@endif
									@if ($ulos['tgl_pengajuan_ulo'] == null)
										<td class="text-center"> - </td>
									@else
										<td class="text-center">
											{{ $date_reformat->dateday_lang_reformat_long($ulos['tgl_pengajuan_ulo']) }}
										</td>
									@endif
									<td class="text-center">3 Hari</td>
									<td class="text-center"><span
											class="badge badge-success-100 text-success">{{ $ulos['kode_izin']['name_status_bo'] }}</span>
									</td>
									<td class="text-center">
										<div class="dropdown">
											<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
												data-toggle="dropdown">
												<i class="icon-menu7"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="{{ route('admin.direktur.penetapan-ulo', [$ulos['id_izin'], $ulos['id']]) }}"
													class="dropdown-item"><i class="icon-pencil"></i> Penetapan SKLO</a>
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
			<div class="table-responsive border-top-0 d-none" id="vTable1">
				<!-- TABLE PENOMORAN -->
				<table class="table text-nowrap datatable-button-init-basic" id="table1">
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
						@if (isset($log) && count($log) > 0)
							@foreach ($log as $loges)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												@if ($loges->jenis_permohonan == 'Pencabutan Penetapan Penomoran Telekomunikasi')
													<a href="{{ route('admin.direktur.cabutnomor', [$loges->id_izin]) }}"
														class="text-body font-weight-semibold">{{ $loges->id_izin }}</a>
												@else
													<a href="{{ route('admin.evaluator.evaluasi-penomoran', [$loges->id_izin, $loges->id_kode_akses]) }}"
														class="text-body font-weight-semibold">{{ $loges->id_izin }}</a>
												@endif

												<div class="text-muted font-size-sm">
													{{ isset($loges->nama_perseroan) ? $loges->nama_perseroan : '' }}
												</div>
												<div class="text-muted font-size-sm">
													{{ isset($loges->jenis_permohonan) ? $loges->jenis_permohonan : '' }}
												</div>
												<div class="text-muted font-size-sm">
													{{ isset($loges->jenis_penomoran) ? $loges->jenis_penomoran : '' }}
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
										<div class="dropdown">
											@if ($loges->jenis_permohonan == 'Pencabutan Penetapan Penomoran Telekomunikasi')
												<a href="{{ route('admin.direktur.cabutnomor', [$loges->id_izin]) }}" style="color:grey;"><i
														class="icon-pencil"></i></a>
											@else
												<a href="{{ route('admin.direktur.penetapan-penomoran', [$loges->id_izin, $loges->id_kode_akses]) }}"
													style="color:grey;"><i class="icon-pencil"></i></a>
											@endif

										</div>
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				<!-- END TABLE PENOMORAN -->

			</div>
			<div class="table-responsive border-top-0 d-none" id="vTable2">
				<table class="table text-nowrap datatable-button-init-basic" id="table2">
					<thead>
						<tr>
							<th>Permohonan</th>
							<th class="text-center">Tanggal Permohonan</th>
							<th class="text-center">Batas Verifikasi</th>
							<th class="text-center">Status</th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						@if (isset($izinprinsip['data']) && count($izinprinsip['data']) > 0)
							@foreach ($izinprinsip['data'] as $izinprinsip)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												<a href="{{ route('admin.direktur.penetapan-ip', $izinprinsip['id_izin']) }}"
													class="text-body font-weight-semibold">{{ $izinprinsip['id_izin'] }}</a>
												<div class="text-muted font-size-sm">{{ $izinprinsip['jenis_izin'] }}
												</div>
												{{-- <div class="text-muted font-size-sm">{{ @$izinprinsip['kbli'] }} -
                                                    {{ @$izinprinsip['kbli_name'] }}
                                                </div> --}}
												<div class="text-muted font-size-sm">{!! @$izinprinsip['jenis_layanan_html'] !!}
												</div>
											</div>
										</div>
									</td>
									@if ($izinprinsip['submitted_date'] == null)
										<td class="text-center"> - </td>
									@else
										<td class="text-center">
											{{ $date_reformat->dateday_lang_reformat_long($izinprinsip['submitted_date']) }}
										</td>
									@endif

									<td class="text-center"><span
											class="badge badge-success-100 text-success">{{ $izinprinsip['batas_verifikasi'] }}</span>
										Hari</td>
									<td class="text-center"><span
											class="badge badge-success-100 text-success">{{ $izinprinsip['status_bo'] }}</span>
									</td>
									<td class="text-center">
										<div class="dropdown">
											<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
												data-toggle="dropdown">
												<i class="icon-menu7"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="{{ route('admin.direktur.penetapan-ip', $izinprinsip['id_izin']) }}" class="dropdown-item"><i
														class="icon-pencil"></i> Penetapan Izin
													Prinsip</a>
												<a target="_blank" href="{{ route('admin.historyperizinan', $izinprinsip['id_izin']) }}"
													class="dropdown-item"><i class="icon-history"></i> Riwayat
													Permohonan</a>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
						@endif

						@if (isset($izintelsus['data']) && count($izintelsus['data']) > 0)
							@foreach ($izintelsus['data'] as $izintelsus)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div>
												<a href="{{ route('admin.direktur.penetapan-ip', $izintelsus['id_izin']) }}"
													class="text-body font-weight-semibold">{{ $izintelsus['id_izin'] }}</a>
												<div class="text-muted font-size-sm">{{ $izintelsus['jenis_izin'] }}
												</div>
												<div class="text-muted font-size-sm">{{ @$izintelsus['kbli'] }} -
													{{ @$izintelsus['kbli_name'] }}
												</div>
												<div class="text-muted font-size-sm">{!! @$izintelsus['jenis_layanan_html'] !!}
												</div>
											</div>
										</div>
									</td>
									@if ($izintelsus['updated_at'] == null)
										<td class="text-center"> - </td>
									@else
										<td class="text-center">
											{{ $date_reformat->dateday_lang_reformat_long($izintelsus['updated_at']) }}
										</td>
									@endif

									<td class="text-center">3 Hari</td>
									<td class="text-center"><span
											class="badge badge-success-100 text-success">{{ $izintelsus['status_bo'] }}</span>
									</td>
									<td class="text-center">
										<div class="dropdown">
											<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
												data-toggle="dropdown">
												<i class="icon-menu7"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="{{ route('admin.direktur.penetapan-ip', $izintelsus['id_izin']) }}" class="dropdown-item"><i
														class="icon-pencil"></i> Penetapan Izin
													Penyelenggaraan</a>
												<a target="_blank" href="{{ route('admin.historyperizinan', $izintelsus['id_izin']) }}"
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

		<script>
			$(document).ready(function() {
				// $('#table').DataTable();
				// $("#vTable").removeClass("d-none");

				$('#TrigerPenomoran').on('click', function() {
					$('#table1').DataTable();
					$("#vTable1").removeClass("d-none");
					$("#vTable").addClass("d-none");
					$("#vTable2").addClass("d-none");

				});

				$('#TrigerUlo').on('click', function() {
					$('#table').DataTable();
					$("#vTable").removeClass("d-none");
					$("#vTable1").addClass("d-none");
					$("#vTable2").addClass("d-none");
				});

				$('#TrigerIP').on('click', function() {
					$('#table2').DataTable();
					$("#vTable2").removeClass("d-none");
					$("#vTable1").addClass("d-none");
					$("#vTable").addClass("d-none");
				});
			})
		</script>
		<!-- /latest orders -->
	</div>
@endsection
