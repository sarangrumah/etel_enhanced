@extends('layouts.backend.main')
@section('content')

	<div class="card">
		<div class="card-header bg-indigo text-white header-elements-inline">
			<div class="row">
				<div class="col-lg">
					<h6 class="card-title font-weight-semibold py-3">Rekap Pelaku Usaha Aktif </h6>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive border-top-0">
				<table class="table datatable-button-init-basic">
					<thead>
						<tr class="text-center">
							<th style="width: 5%;">No.</th>
							<th style="width: 24%;">Nama Pelaku Usaha</th>
							<th class="sorting" style="width: 50%;">Alamat</th>
							<th style="width: 10%;">Email</th>
							<th style="width: 10%;" class="sorting">Kontak</th>
							<th style="width: 1%;"></th>
						</tr>
					</thead>
					<tbody>
						@if (isset($log) && count($log) > 0)
							@foreach ($log as $loges)
								<tr class="text-center">
									<td class="text-center">{{ $loop->iteration }}</td>
									<td class="text-center">
										<div>
											<a href="#" class="text-body font-weight-semibold">{{ $loges->nama_perseroan }}</a>
											<div class="text-muted font-size-sm">
												{{ isset($loges->jenis_perseroan) ? $loges->jenis_perseroan : '' }}
											</div>
										</div>
									</td>
									<td class="text-center">
										<div>
											<a href="#" class="text-body font-weight-semibold">{{ $loges->alamat_perseroan }}</a>
											<div class="text-muted font-size-sm">
												{{ isset($loges->nama_kelurahan) ? $loges->nama_kelurahan : '' }},
												{{ isset($loges->nama_kecamatan) ? $loges->nama_kecamatan : '' }},
												{{ isset($loges->nama_kabupaten) ? $loges->nama_kabupaten : '' }}
											</div>
										</div>
									</td>
									<td class="text-center">
										<div>
											<div class="text-muted font-size-sm">
												{{ isset($loges->email_perusahaan) ? $loges->email_perusahaan : '' }}
											</div>
										</div>
									</td>
									<td class="text-center">
										<div>
											<div class="text-body font-weight-semibold">
												{{ isset($loges->nama_kelurahan) ? $loges->nama_penanggungjawab : '' }}
											</div>
											<div class="text-muted font-size-sm">
												{{ isset($loges->pekerjaan_user_proses) ? $loges->pekerjaan_user_proses : '' }}
											</div>
											<div class="text-muted font-size-sm">
												{{ isset($loges->hp_user_proses) ? $loges->hp_user_proses : '' }}
											</div>
										</div>
									</td>
									{{-- <td>{{ $loges->catatan_hasil_evaluasi }}</td> --}}
									<td class="text-center">
										<div class="dropdown">
											<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
												data-toggle="dropdown">
												<i class="icon-menu7"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="{{ route('admin.detailpelakuusaha', $loges->id) }}" class="dropdown-item"><i
														class="icon-search4"></i> Lihat Data</a>
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

	<div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Perbaharui Data Alokasi Penomoran</h5>
				</div>
				<div class="modal-body">
					<!-- Your Form Goes Here -->
					<form method="POST" action="{{ url('/admin/updatenomorpost/') }}">
						@csrf
						<!-- Your Form Fields -->
						<div class="mb-3 row">
							<div class="col-lg-4">
								<label for="alokasi_jenispenomoran" class="form-label">Jenis Penomoran</label>
							</div>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="alokasi_jenispenomoran" name="alokasi_jenispenomoran" readonly>
							</div>
						</div>
						<div class="mb-3 row">
							<div class="col-lg-4">
								<label for="alokasi_kodeakses" class="form-label">Kode Akses</label>
							</div>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="alokasi_kodeakses" name="alokasi_kodeakses" readonly>
							</div>
						</div>
						<div class="mb-3 row">
							<div class="col-lg-4">
								<label for="alokasi_status" class="form-label">Status</label>
							</div>
							<div class="col-lg-8">
								{{-- <input type="email" class="form-control" id="alokasi_status" placeholder="name@example.com"
										name="alokasi_status"> --}}
								<select class="form-control form-control-select2" id="alokasi_status" name="alokasi_status">
									<option value="" selected>-- Pilih Status --
									</option>
								</select>
							</div>
						</div>
						<div class="mb-3">
							<h6 class="card-title font-weight-semibold py-3">Manajemen Data Alokasi Penomoran </h6>
						</div>
						<div class="mb-3 row">
							<div class="col-lg-4">
								<label for="alokasi_jenispengguna" class="form-label">Jenis Pengguna</label>
							</div>
							<div class="col-lg-8">
								{{-- <input type="email" class="form-control" id="alokasi_jenispengguna" placeholder="name@example.com"
										name="alokasi_jenispengguna"> --}}
								<select class="form-control form-control-select2" id="alokasi_jenispengguna" name="alokasi_jenispengguna">
									<option value="" selected>Pilih Jenis Pengguna
									</option>
								</select>
							</div>
						</div>
						<div class="mb-3 row">
							<div class="col-lg-4">
								<label for="alokasi_namapengguna" class="form-label">Nama Pengguna</label>
							</div>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="alokasi_namapengguna" name="alokasi_namapengguna">
							</div>
						</div>
						<div class="mb-3 row">
							<div class="col-lg-4">
								<label for="alokasi_nib" class="form-label">NIB</label>
							</div>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="alokasi_nib" name="alokasi_nib">
							</div>
						</div>
						<div class="mb-3 row">
							<div class="col-lg-4">
								<label for="alokasi_nopenetapan" class="form-label">No. Penetapan</label>
							</div>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="alokasi_nopenetapan" name="alokasi_nopenetapan">
							</div>
						</div>
						<div class="mb-3 row">
							<div class="col-lg-4">
								<label for="alokasi_tglpenetapan" class="form-label">Tgl. Penetapan</label>
							</div>
							<div class="col-lg-8">
								<input type="date" class="form-control" id="alokasi_tglpenetapan" name="alokasi_tglpenetapan">
							</div>
						</div>
						<!-- Add other form fields as needed -->

						<button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal"
							aria-label="Close">Kembali</button>
						<button type="submit" class="btn btn-primary">Perbaharui</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		// $(document).ready(function() {
		// Function to refresh modal content
		// function showDatePicker() {
		// 	// Trigger a click on the hidden date input
		// 	document.getElementById('alokasi_tglpenetapan').click();
		// }

		// $(function() {
		// 	$("#alokasi_tglpenetapan").datepicker();
		// });
		// $(function() {
		// 	// $(function() {
		// 	$('.component-datepicker.default').datepicker({
		// 		autoclose: true,
		// 		startDate: "today",
		// 	}).on('changeDate', function(e) {
		// 		// Format the selected date and set it as the input value
		// 		var formattedDate = moment(e.date).format('MMMM D, YYYY');
		// 		$(this).val(formattedDate);
		// 		console.log("Input value changed:", $(this).val(formattedDate));
		// 	});
		// 	// });
		// 	$('#alokasi_tglpenetapana').on('click', function() {
		// 		// Retrieve the current value of the input
		// 		var inputValue = $(this).val();
		// 		var formattedDate = inputValue.format('MMMM D, YYYY');
		// 		// Do something with the input value
		// 		console.log("Input value changed:", formattedDate);
		// 		// You can perform additional actions or validations here
		// 	});
		// 	// $('.component-datepicker.default').format('MMMM D, YYYY');
		// 	// .html(start.format('MMMM D, YYYY')
		// 	$("#alokasi_tglpenetapan").datepicker();
		// 	$("#datepickerButton").click(function() {
		// 		$("#alokasi_tglpenetapan").datepicker("show");
		// 	});
		// });

		// Listen for the 'input' event on the date input
		// document.getElementById('alokasi_tglpenetapan').addEventListener('input', function() {
		// 	// When a date is selected, update the text input with the formatted date
		// 	var formattedDate = formatDate(this.value);
		// 	this.value = formattedDate;
		// });

		// function formatDate(inputDate) {
		// 	// Parse the input date as a JavaScript Date object
		// 	var date = new Date(inputDate);

		// 	// Get the day, month, and year components
		// 	var day = date.getDate().toString().padStart(2, '0');
		// 	var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
		// 	var year = date.getFullYear();

		// 	// Construct the reformatted date string
		// 	var formattedDate = day + '/' + month + '/' + year;

		// 	return formattedDate;
		// }

		function refreshModalContent(id) {
			$.ajax({
				url: '/admin/updatenomor/' + id,
				method: 'GET',
				dataType: "json",
				success: function(data) {
					console.log(data);
					$('#alokasi_jenispenomoran').val(data.log.jenis_penomoran);
					$('#alokasi_kodeakses').val(data.log.kode_akses);

					var select_status = $('select[name="alokasi_status"]');
					select_status.empty();
					$.each(data.status_umku, function(index, option) {
						var optionElement = $('<option>', {
							value: option.oss_kode,
							text: option.name_status_fo
						});

						if (option.name_status_fo == data.log.status) {
							optionElement.attr('selected', true);
							console.log(option.name_status_fo);
							console.log(data.log.status);
						}

						select_status.append(optionElement);
					});

					var select_jenisperseroan = $('select[name="alokasi_jenispengguna"]');
					select_jenisperseroan.empty();
					$.each(data.jenis_perseroan, function(index, option) {
						var optionElement = $('<option>', {
							value: option.oss_kode,
							text: option.name
						});

						if (option.name == data.log.jenis_pengguna) {
							optionElement.attr('selected', true);
						}

						select_jenisperseroan.append(optionElement);
					});

					$('#alokasi_namapengguna').val(data.log.nama_perseroan);
					$('#alokasi_nib').val(data.log.nib);
					$('#alokasi_nopenetapan').val(data.log.nomor_penetapan);
					$('#alokasi_tglpenetapan').val(data.log.tanggal_penetapan);
				},
				error: function(error) {
					console.log(error);
				}
			});
		}

		// Bind to modal events
		$('a[data-target="#submitModal"]').on('click', function() {
			var id = $(this).data('id');
			console.log(id);
			refreshModalContent(id);
		});

		// Clear modal content when modal is hidden
		$('#submitModal').on('hidden.bs.modal', function() {
			$(this).modal('hide');
			// Clear the modal content
			// You may want to reset form fields, clear selects, etc.
			// Example: $('#alokasi_jenispenomoran, #alokasi_kodeakses, ...).val('');
			$('select[name="alokasi_status"]').empty();
			$('select[name="alokasi_jenispengguna"]').empty();
		});

		// });
	</script>

@endsection
