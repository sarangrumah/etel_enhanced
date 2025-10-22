@extends('layouts.frontend.main')
{{-- @section('js')
	<script type="text/javascript">
		$(document).ready(function() {
			$('#btnReset').hide();
		});
	</script>
	<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script src="/global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script>

	<script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
	<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>

	<script src="/global_assets/js/kominfo/form_option_kominfo.js"></script>
	<script src="/global_assets/js/demo_pages/form_select2.js"></script>
@endsection --}}
@section('content')
	<!-- Quick stats boxes -->
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Sorry!</strong> There were more problems with your HTML input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	@if (session()->has('success'))
		<div class="alert alert-success">
			Persyaratan telah dikirim harap menunggu proses verifikasi, Terima kasih.
		</div>
	@endif

	<div class="card">
		<div class="card-header bg-indigo text-white header-elements-inline">
			<div class="row">
				{{-- <div class="d-inline-flex align-items-center ml-auto">
					<div class="dropdown ml-2">
						<a href="javascript:void(0)" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
							data-toggle="dropdown">
							<i class="icon-more2"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right"></a>
							<a href="javascript:void(0)" class="dropdown-item"><i class="icon-database-refresh"></i>
								Perbaharui Data</a>
							
						</div>
					</div>
				</div> --}}

				<div class="col-lg-12">
					<h6 class="card-title font-weight-semibold py-3">Permohonan Koreksi Pemenuhan Persyaratan </h6>
				</div>
			</div>
		</div>
		@if (session('message'))
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="alert alert-success">
							{{ session('message') }}
						</div>
					</div>
				</div>
			</div>
		@endif
		<div class="card-body">
			<table class="table text-nowrap datatable-basic" id="table">
				<thead>
					<tr>
						<th>Permohonan</th>
						<th class="text-center">Tanggal</th>
						<th class="text-center">Status</th>
						<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($izin as $item)
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div>
										<a class="text-body font-weight-semibold" href="javascript:void(0)">{{ $item['id_izin'] }}</a>
										<div class="text-muted font-size-sm">{{ $item['kbli'] }} -
											{{ $item['jenis_izin'] }}</div>
										<div class="text-muted font-size-sm">{!! $item['jenis_layanan_html'] !!}</div>
										<div class="text-muted font-size-sm">{{ $item['id_proyek'] }}</div>
									</div>
								</div>
							</td>
							@if (!isset($item['updated_at']))
								<td class="text-center"> - </td>
							@else
								<td class="text-center">
									{{ $date_reformat->dateday_lang_reformat_long($item['submitted_at']) }}</td>
							@endif
							<td class="text-center"><span class="badge badge-success-100 text-success">
									@if ($item->status_penyesuaian == '90')
										Perbaikan Penyesuaian Komitmen
									@else
										{{ $item->status_fo }}
									@endif
								</span></td>
							<td>
								<div class="dropdown">
									<a href="javascript:void(0)"
										class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
										<i class="icon-menu7"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										@if ($item->status_penyesuaian == '90')
											<a href="{{ url('komitmen/koreksi-penyesuaian/') . '/' . $item->id_izin }}" class="dropdown-item"><i
													class="icon-pencil"></i> Perbaikan Penyesuaian
												Komitmen</a>
										@else
											<a href="{{ url('pb/koreksi-persyaratan/') . '/' . $item->id_izin }}" class="dropdown-item"><i
													class="icon-pencil"></i> Perbaikan
												Persyaratan</a>
											<a href="{{ url('pb/historyperizinan/') . '/' . $item->id_izin }}" class="dropdown-item" target="_blank"><i
													class="icon-history"></i>
												Riwayat Permohonan</a>
										@endif
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<!-- Modal -->
	<div id="modal_theme_primary" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-indigo text-white">
					<h6 class="modal-title">Pilih KBLI</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="mb-4">
						<div class="mb-3">
							<p>Perizinan</p>
							<select class="form-control select-data-array-jenisperizinan" data-fouc></select>
						</div>
						<div class="mb-3">
							<p>KBLI</p>
							<select class="form-control select-data-array-kbli" data-fouc></select>
						</div>
						<div class="mb-3">
							<p>Jenis Layanan</p>
							<select class="form-control select-data-array-jenislayanan" data-fouc>
							</select>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary">Buat Izin baru</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('custom-js')
	<script type="text/javascript">
		$(document).ready(function() {
			$('#form_get_by_date_jasa').submit(function(e) {
				e.preventDefault();

				$('#btnSubmit').val("Mencari ...");


				var formData = new FormData(this);

				// console.log(formData)
				$.ajax({
					type: 'POST',
					url: "{{ url('/pb/koreksi_get_by_date_jasa') }}",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: (data) => {
						table = $('#table').DataTable({
							destroy: true,
							data: data,
							columns: [{
									data: null,
									render: function(data, type, row) {
										// Combine the first and last names into a single table field
										var view =
											"<div class='d-flex align-items-center'><div><a class='text-body font-weight-semibold' href='javascript:void(0)'>" +
											data.id_izin +
											"</a><div class='text-muted font-size-sm'>" +
											data.kbli + " - " + data
											.jenis_izin +
											"</div><div class='text-muted font-size-sm'>" +
											data.jenis_layanan +
											"</div><div class='text-muted font-size-sm'>" +
											data.id_proyek +
											"</div></div></div>"
										return view;
									},
									editField: ['id_izin', 'jenis_izin', 'kbli',
										'jenis_layanan', 'id_proyek'
									]
								},
								{
									data: 'status_fo',
									"render": function(data, type, row) {
										var button =
											"<span class='badge badge-success-100 text-success'>" +
											data + "</spam>"
										return button;
									},
								},
								{
									data: 'id_izin',
									"render": function(data, type, row) {
										var button =
											"<div class='dropdown'><a href='javascript:void(0)' class='btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill' data-toggle='dropdown'> <i class='icon-menu7'></i></a> <div class='dropdown-menu dropdown-menu-right'> <a href='{{ url('pb/koreksi-persyaratan/') }}/" +
											data +
											"' class='dropdown-item'><i class='icon-pencil'></i> Perbaikan Persyaratan</a> <a href='{{ url('pb/historyperizinan/') }}/" +
											data +
											"' class='dropdown-item' target='_blank'><i class='icon-history'></i> Riwayat Permohonan</a> </div> </div>"
										return button;
									},
								}
							],
							"order": [
								[1, 'asc']
							]
						});
						$('#btnReset').show();
						$('#btnSubmit').val("Cari");

					},
					error: function(data) {
						console.log(data);

					}
				});
			});

			$('#form_get_by_date_jaringan').submit(function(e) {
				e.preventDefault();

				$('#btnSubmit').val("Mencari ...");


				var formData = new FormData(this);

				// console.log(formData)
				$.ajax({
					type: 'POST',
					url: "{{ url('/pb/koreksi_get_by_date_jaringan') }}",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: (data) => {
						table = $('#table').DataTable({
							destroy: true,
							data: data,
							columns: [{
									data: null,
									render: function(data, type, row) {
										// Combine the first and last names into a single table field
										var view =
											"<div class='d-flex align-items-center'><div><a class='text-body font-weight-semibold' href='javascript:void(0)'>" +
											data.id_izin +
											"</a><div class='text-muted font-size-sm'>" +
											data.kbli + " - " + data
											.jenis_izin +
											"</div><div class='text-muted font-size-sm'>" +
											data.jenis_layanan +
											"</div><div class='text-muted font-size-sm'>" +
											data.id_proyek +
											"</div></div></div>"
										return view;
									},
									editField: ['id_izin', 'jenis_izin', 'kbli',
										'jenis_layanan', 'id_proyek'
									]
								},
								{
									data: 'status_fo',
									"render": function(data, type, row) {
										var button =
											"<span class='badge badge-success-100 text-success'>" +
											data + "</spam>"
										return button;
									},
								},
								{
									data: 'id_izin',
									"render": function(data, type, row) {
										var button =
											"<div class='dropdown'><a href='javascript:void(0)' class='btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill' data-toggle='dropdown'> <i class='icon-menu7'></i></a> <div class='dropdown-menu dropdown-menu-right'> <a href='{{ url('pb/koreksi-persyaratan/') }}/" +
											data +
											"' class='dropdown-item'><i class='icon-pencil'></i> Perbaikan Persyaratan</a> <a href='{{ url('pb/historyperizinan/') }}/" +
											data +
											"' class='dropdown-item' target='_blank'><i class='icon-history'></i> Riwayat Permohonan</a> </div> </div>"
										return button;
									},
								}
							],
							"order": [
								[1, 'asc']
							]
						});
						$('#btnReset').show();
						$('#btnSubmit').val("Cari");

					},
					error: function(data) {
						console.log(data);

					}
				});
			});

		});
	</script>
@endsection
