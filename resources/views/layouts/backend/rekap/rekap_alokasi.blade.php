@extends('layouts.backend.main')
@section('content')

	<div class="content-wrapper">
		<div class="content-inner">
			<div class="content">
				<div id="loadingSpinner" class="loading-spinner" style="display: none;">
					<img id="spinnerImage" src="/assets/kominfo/spinner-kominfo-trp.svg" alt="Loading Spinner">
				</div>
				<style>
					.loading-spinner {
						display: none;
						position: fixed;
						top: 0;
						left: 0;
						width: 100%;
						height: 100%;
						background-color: rgba(255, 255, 255, 0.8);
						/* Semi-transparent white background */
						z-index: 9999;
						/* Ensures the spinner is on top of other content */
						justify-content: center;
						align-items: center;
						display: flex;
					}
				</style>
				<div>
					@if (Session::get('message') != '')
						<div class="alert alert-success alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>{{ Session::get('message') }}</strong>
						</div>
					@endif
					<div class="card">
						<div class="card-header bg-indigo text-white header-elements-inline">
							<div class="row">
								<div class="col-lg">
									<h6 class="card-title font-weight-semibold py-3">Manajemen Data Alokasi Penomoran </h6>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="text-right col-lg-12 ms-lg-auto" style="float: right;">
								<a href="{{ route('download.data_alokasi_penomoran') }}" class="btn btn-primary">Unduh <i
										class="icon-file-excel"></i> </a>
							</div>
							<div class="table-responsive border-top-0">
								<table class="table text-nowrap datatable-basic">
									<thead>
										<tr class="text-center">
											<th>No.</th>
											<th>Jenis Penomoran</th>
											<th>Kode Akses</th>
											<th>Status</th>
											<th>Nama Pengguna</th>
											<th>No. Penetapan</th>
											<th>Tanggal Penetapan</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@if (isset($log) && count($log) > 0)
											@foreach ($log as $loges)
												<tr class="text-center">
													<td class="text-center">{{ $loop->iteration }}</td>
													<td class="text-center">{!! $loges->full_name_html !!}</td>
													<td class="text-center">{{ $loges->kode_akses }}</td>
													<td class="text-center">{{ $loges->status }}</td>
													<td class="text-center">{{ $loges->nama_pelakuusaha }}</td>
													<td class="text-center">{{ $loges->nomor_penetapan }}</td>
													@if (isset($loges->tanggal_penetapan) && $loges->tanggal_penetapan != '')
														<td class="text-center">{{ $date_reformat->date_lang_reformat_long($loges->tanggal_penetapan) }}</td>
													@else
														<td class="text-center">-</td>
													@endif
													{{-- <td>{{ $loges->catatan_hasil_evaluasi }}</td> --}}
													<td class="text-center">
														<div class="dropdown">
															<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
																data-toggle="dropdown">
																<i class="icon-menu7"></i>
															</a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-search4"></i> Lihat Data</a>
																@if ($id_jobposition_user == 15)
																	<a href="{{ route('admin.evaluator.cabutnomor', $loges->id) }}" class="dropdown-item"><i
																			class="icon-pencil"></i> Pencabutan
																		Penomoran</a>
																	<a href="{{ route('admin.evaluator.ulangnomor', $loges->id) }}" class="dropdown-item"><i
																			class="icon-pencil"></i> Penetapan Ulang
																		Penomoran</a>
																	<a href="#" class="dropdown-item" data-target="#submitModal" data-toggle="modal"
																		data-id="{{ $loges->id }}"><i class="icon-pencil"></i> Perbaharui Data</a>
																	{{-- <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"> --}}
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
				</div>
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
					<form method="POST" action="{{ url('/admin/updatenomorpost/') }}" id="formPerbaharui">
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
									<option value="" disabled selected>-- Pilih Status --
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
									<option value="" disabled selected>-- Pilih Jenis Pengguna --
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

						<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Kembali</button>

						<button type="submit" class="btn btn-primary" onclick="submit_perbaharui();return false;">Perbaharui</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		var loadingSpinner = document.getElementById('loadingSpinner');

		function showLoadingSpinner() {
			// loadingSpinner.style.display = 'block';
			var spinner = document.getElementById('loadingSpinner');
			spinner.style.display = 'flex';
		}

		function hideLoadingSpinner() {
			// loadingSpinner.style.display = 'block';
			var spinner = document.getElementById('loadingSpinner');
			spinner.style.display = 'none';
		}

		function submit_perbaharui() {
			showLoadingSpinner();
			$('#formPerbaharui').submit();
		}

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
					select_jenisperseroan.append(
						'<option disabled selected> -- Pilih Jenis Pengguna -- </option>');
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

					hideLoadingSpinner();
				},
				error: function(error) {
					console.log(error);
				}
			});
		}

		// Bind to modal events
		$('a[data-target="#submitModal"]').on('click', function() {

			showLoadingSpinner();
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
		// showLoadingSpinner();
		// window.onload = function() {
		// 	hideLoadingSpinner();
		// };
	</script>

@endsection
