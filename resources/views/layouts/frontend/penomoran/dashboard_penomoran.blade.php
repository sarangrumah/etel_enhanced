@extends('layouts.frontend.main')
@section('title', 'Dashboard')
@section('js')

@endsection
@section('content')
	<div class="row">
		@if (isset($proses))
			<div class="col-lg">
				<!-- Members online -->
				<div class="card bg-primary text-white">
					<div class="card-body">
						<div class="d-flex">
							<h3 class="font-weight-semibold mb-0">{{ $proses }}</h3>
							{{-- <a href="javascript:void(0)" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a> --}}
						</div>

						<div>
							<div class="font-size-sm opacity-75">Permohonan Dalam Proses</div>
						</div>
					</div>
					<!-- /members online -->
				</div>

			</div>
			<!-- /quick stats boxes -->
		@endif

		<div class="col-lg">
			<!-- Members online -->
			<div class="card bg-success text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ $done }}</h3>
						{{-- <a href="javascript:void(0)" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a> --}}
					</div>

					<div>
						<div class="font-size-sm opacity-75">Permohonan @if (isset($dashboard_penetapan))
								Penetapan
							@else
								Disetujui
							@endif
						</div>
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
						<h3 class="font-weight-semibold mb-0">{{ $rejected }}</h3>
						{{-- <a href="javascript:void(0)" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a> --}}
					</div>

					<div>
						<div class="font-size-sm opacity-75">Permohonan @if (isset($dashboard_penetapan))
								Pencabutan
							@else
								Ditolak
							@endif
						</div>
					</div>
				</div>
			</div>
			<!-- /members online -->
		</div>
	</div>
	<!-- /quick stats boxes -->

	@if (Session::get('message') != '')
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif

	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-lg-8">
					<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Penomoran Telekomunikasi</h6>
				</div>
				{{-- <div class="d-inline-flex align-items-center ml-auto">
					<div class="dropdown ml-2">
						@if (Auth::user()->jenis_pu == 'NPT')
							<td><button type="button" class="btn btn-secondary" data-toggle="dropdown">Permohonan
									Penomoran <i class="icon-file-plus mr-2"></i></button></td>
							<div class="dropdown-menu dropdown-menu-right">
								<a href="{{ url('/penomoran/barunpt') }}" class="dropdown-item"><i class="icon-database-add"></i> Nomor Baru</a>
								<a href="{{ url('/penomoran/addnpt') }}" class="dropdown-item"><i class="icon-database-insert"></i> Nomor
									Tambahan</a>
								<a href="{{ url('/penomoran/penyesuaiannpt') }}" class="dropdown-item"><i class="icon-database-diff"></i>
									Perubahan Penetapan</a>
								<a href="{{ url('/penomoran/pengembaliannpt') }}" class="dropdown-item"><i class="icon-database-remove"></i>
									Pengembalian
									Nomor</a>
							</div>
							</td>
						@elseif (Auth::user()->jenis_pu == 'PTB')
							<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahData">Tambah
									Permohonan Izin <i class="icon-file-plus mr-2"></i></button></td>
							<td><button type="button" class="btn btn-secondary" data-toggle="dropdown">Permohonan
									Penomoran <i class="icon-file-plus mr-2"></i></button></td>
							<div class="dropdown-menu dropdown-menu-right">
								<a href="{{ url('/penomoran/baru') }}" class="dropdown-item"><i class="icon-database-add"></i> Nomor Baru</a>
								<a href="{{ url('/penomoran/add') }}" class="dropdown-item"><i class="icon-database-insert"></i> Nomor
									Tambahan</a>
								<a href="{{ url('/penomoran/penyesuaian') }}" class="dropdown-item"><i class="icon-database-diff"></i> Perubahan
									Penetapan</a>
								<a href="{{ url('/penomoran/pengembalian') }}" class="dropdown-item"><i class="icon-database-remove"></i>
									Pengembalian
									Nomor</a>
							</div>
							</td>
						@elseif (Auth::user()->jenis_pu == 'TKB')
							<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahData">Tambah
									Permohonan <i class="icon-file-plus mr-2"></i></button>
							</td>
						@elseif (Auth::user()->jenis_pu == 'TKI')
							<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahData_nomor">Tambah
									Permohonan <i class="icon-file-plus mr-2"></i></button></td>
						@endif
					</div>
				</div> --}}
			</div>

		</div>

		<div class="table-responsive border-top-0">

			<table class="table text-nowrap datatable-button-init-basic" id="table">
				<thead>
					<tr>
						<th>Permohonan</th>
						<th class="text-center">Jenis Penomoran</th>
						<th class="text-center">Kode Akses</th>
						<th class="text-center">Tanggal Permohonan</th>
						<th class="text-center">Status</th>
						<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
					</tr>
				</thead>
				<tbody id="tBoodyDataAll">
					@foreach ($izin as $item)
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div>
										<a class="text-body font-weight-semibold" href="javascript:void(0)">{{ $item['id_izin'] }}</a>
										<div class="text-muted font-size-sm">{{ $item['jenis_permohonan'] }}</div>

									</div>
								</div>
							</td>
							<td class="text-center">{!! $item->jenis_kode_akses !!}</td>
							<td class="text-center">{{ isset($item->kode_akses) ? $item->kode_akses : '-' }}
							</td>
							@if (!isset($item['updated_at']))
								<td class="text-center"> - </td>
							@else
								<td class="text-center">
									{{ $date_reformat->dateday_lang_reformat_long($item['updated_at']) }}</td>
							@endif
							<td class="text-center"><span class="badge badge-success-100 text-success">{{ $item->status_fo }}</span></td>
							<td>
								<div class="dropdown">
									<a href="javascript:void(0)"
										class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
										<i class="icon-menu7"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a href="{{ url('penomoran/evaluasi-penomoran') . '/' . $item->id_izin }}" class="dropdown-item"><i
												class="icon-history"></i> Detail
											Permohonan</a>
										@if ($item['status_checklist'] == '50')
											<a href="{{ asset($item->file_sk_penomoran) }}" class="dropdown-item" target="_blank"><i
													class="icon-history"></i>
												SK Penomoran</a>
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

	{{-- <div class="modal-footer">
	<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
	<button type="button" class="btn btn-primary">Buat Izin baru</button>
</div> --}}
	{{-- </div>
    </div> --}}

	<script type="text/javascript">
		// $(document).on("change", 'select[name="perizinan"]',
		//     function() {
		//         //alert($(this).find("option:selected").text());
		//     });
		$(document).ready(function() {


			$('#form_get_by_date').submit(function(e) {
				e.preventDefault();

				$('#btnSubmit').val("Mencari ...");


				var formData = new FormData(this);

				// console.log(formData)
				$.ajax({
					type: 'POST',
					url: "{{ url('/pb/get_by_date') }}",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					tBoodyDataAll,
					success: (data) => {
						console.log(data);
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
									data: 'updated_at',
									"render": function(data, type, row) {
										const myArray = data.split("T");
										const thbl = myArray[0].split("-");
										// console.log(myArray[0]);

										switch (thbl[1]) {
											case "01":
												teks = "Januari";
												break;
											case "02":
												teks = "Februari";
												break;
											case "3":
												teks = "Maret";
												break;
											case "04":
												teks = "April";
												break;
											case "05":
												teks = "Mei";
												break;
											case "06":
												teks = "Juni";
												break;
											case "07":
												teks = "Juli";
												break;
											case "08":
												teks = "Agustus";
												break;
											case "09":
												teks = "September";
												break;
											case "10":
												teks = "Oktober";
												break;
											case "11":
												teks = "November";
												break;
											case "12":
												teks = "Desember";
												break;
											default:
												teks = "Bulan Tidak Valid";
										}
										const jam = myArray[1].split(".");
										var all = thbl[2] + " " + teks + " " +
											thbl[0] + " - " + jam[0]
										return all
									}
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
											"<div class='dropdown'><a href='javascript:void(0)' class='btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill' data-toggle='dropdown'> <i class='icon-menu7'></i></a> <div class='dropdown-menu dropdown-menu-right'> <a href='javascript:void(0)' class='dropdown-item'><i class='icon-file-eye'></i> Informasi Perizinan</a> <a href='{{ url('pb/historyperizinan/') }}/" +
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
						// console.log(data);

					}
				});
			});

			$('select[name="perizinan"]').on('change', function() {
				// $('#perizinan').change(function() {
				alert($(this).find("option:selected").text());
				var izin = $(this).val();
				console.log(izin);
				if (izin == 'penomoran') {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', true);
					$('#KBLIjaringan').attr('hidden', true);
					$('#KBLItelsus').attr('hidden', true);
					$('#jenisLayanan').attr('hidden', true);
					$('select[name="jenislayanan"]').val('Silakan Pilih...');
				} else if (izin == 'jasa') {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', false);
					$('#KBLIjaringan').attr('hidden', true);
					$('#KBLItelsus').attr('hidden', true);
					$('#jenisLayanan').attr('hidden', false);
					$('select[name="jenislayanan"]').val('Silakan Pilih...');
				} else if (izin == 'jaringan') {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', true);
					$('#KBLIjaringan').attr('hidden', false);
					$('#KBLItelsus').attr('hidden', true);
					$('#jenisLayanan').attr('hidden', false);
					$('select[name="jenislayanan"]').val('Silakan Pilih...');
				} else if (izin == 'telsus') {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', true);
					$('#KBLIjaringan').attr('hidden', true);
					$('#KBLItelsus').attr('hidden', false);
					$('#jenisLayanan').attr('hidden', false);
					$('select[name="jenislayanan"]').val('Silakan Pilih...');
				} else {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', true);
					$('#KBLIjaringan').attr('hidden', true);
					$('#KBLItelsus').attr('hidden', true);
					$('#jenisLayanan').attr('hidden', true);
				}
			});

			$('select[name="kbli"]').on('change', function() {
				var kbli = $(this).val();
				var izin = $('select[name="perizinan"]').val();
				// console.log(kbli)
				if (kbli) {
					$.ajax({
						url: '/api/getjenislayanan/' + izin + '/' + kbli,
						type: "GET",
						dataType: "json",
						success: function(data) {
							console.log(data);

							$('select[name="jenislayanan"]').empty();
							$.each(data, function(key, value) {
								$('select[name="jenislayanan"]').append(
									'<option value="' + value.id + '">' + value
									.name + '</option>');
							});


						}
					});
				} else {
					$('select[name="jenislayanan"]').empty();
				}
			});


			$('#tBoodyDataAll').on('click', '.triger-btn', function() {
				// var id_proyek = $(this).attr('data');
				var id_izin = $(this).attr('data2');
				var jenislayanan = $(this).attr('data3');
				// $("#vId_proyek").val(id_proyek);
				$("#vId_izin").val(id_izin);
				$("#modalCekPenomoran").modal("show");
				getNumber(jenislayanan);
			});

			function getNumber(JenisLayanan) {
				$.ajax({
					type: "POST",
					url: "{{ url('penomoran') }}/getjenisnomor",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: JSON.stringify({
						data: JenisLayanan
					}),
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					beforeSend: function() {
						$('#jenisnomor-loading').show();
					},
					success: function(e) {
						var tempoption = "";
						var tempoption =
							"<option selected disabled>-- Pilih jenis penomoran terlebih dulu --</option>";
						$.each(e, function(key, value) {
							tempoption += "<option value='" + value.short_name + "'> " +
								value
								.full_name + " </option>";
						});
						$("#jenisnomors").html(tempoption);
						$("#jenisnomors").removeAttr("disabled");
						$('#jenisnomor-loading').hide();
					},
					failure: function(errMsg) {
						alert(errMsg);
					}
				});
			}

		});
	</script>
@endsection
