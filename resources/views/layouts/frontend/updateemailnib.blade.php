@extends('layouts.frontend.main')
@section('content')
	<div id="loadingSpinner" class="loading-spinner" style="display: none;">
		<img id="spinnerImage" src="/assets/kominfo/spinner-kominfo-trp.svg" alt="Loading Spinner">
	</div>
	<style>
		.loading-select {
			position: absolute;
			right: -75px;
			bottom: -60%;
			transform: translateY(-50%);
		}

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

		* {
			margin: 0;
			box-sizing: border-box;
		}

		html,
		body {
			height: 100%;
			font: 14px/1.4 sans-serif;
		}

		input,
		textarea {
			font: 14px/1.4 sans-serif;
		}

		.input-group {
			display: table;
			border-collapse: collapse;
			width: 100%;
		}

		.input-group>div {
			display: table-cell;
			border: 1px solid #ddd;
			vertical-align: middle;
			/* needed for Safari */
		}

		.input-group-icon {
			background: #eee;
			color: #777;
			padding: 0 12px
		}

		.input-group-area {
			width: 100%;
		}

		.input-group input {
			border: 0;
			display: block;
			width: 100%;
			padding: 8px;
		}

		.hidden {
			display: none !important
		}
	</style>
	<div class="card">
		<div class="card-header bg-indigo text-white header-elements-inline">
			<div class="row">
				<div class="col-lg">
					<h6 class="card-title font-weight-semibold py-3">Pengajuan Rubah NIB dan e-Mail</h6>
				</div>
			</div>
		</div>
		<form id="form-updateemailnib" action="{{ url('/ip/updateippost') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="card-body">
				<div class="row">
					<div class="col-lg-12">
						<fieldset>
							<div>
								<div class="card">
									<div class="card-header bg-indigo text-white header-elements-inline">
										<div class="row">
											<div class="col-lg">
												<h6 class="card-title font-weight-semibold py-3">Informasi Perusahaan </h6>
											</div>
										</div>
									</div>
									<div class="card-body">
										<legend class="text-uppercase font-size-sm font-weight-bold">Data Perusahaan</legend>
										<div class="form-group row">
											<div class="col-lg-6">
												<div class="row">
													<label class="col-lg-4 col-form-label">NIB </label>
													<div class="col-lg">
														<label class="col-lg col-form-label">: {{ $detailNib['nib'] }}</label>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="row">
													<label class="col-lg-4 col-form-label">Nama </label>
													<div class="col-lg">
														<label class="col-lg col-form-label">: {{ $detailNib['nama_perseroan'] }}</label>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-6">
												<div class="row">
													<label class="col-lg-4 col-form-label">NPWP </label>
													<div class="col-lg">
														<label class="col-lg col-form-label">: {{ $detailNib['npwp_perseroan'] }}</label>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="row">
													<label class="col-lg-4 col-form-label">No Telp </label>
													<div class="col-lg">
														<label class="col-lg col-form-label">:
															{{ $detailNib['nomor_telpon_perseroan'] }}</label>
													</div>
												</div>
											</div>
										</div>
										<legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>
										<div class="form-group row">
											<div class="col-lg-6">
												<div class="row">
													<label class="col-lg-4 col-form-label">NIK </label>
													<div class="col-lg">
														<label class="col-lg col-form-label">:
															{{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}
														</label>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="row">
													<label class="col-lg-4 col-form-label">Nama </label>
													<div class="col-lg">
														<label class="col-lg col-form-label">:
															{{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-6">
												<div class="row">
													<label class="col-lg-4 col-form-label">Email </label>
													<div class="col-lg">
														<label class="col-lg col-form-label">:
															{{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="row">
													<label class="col-lg-4 col-form-label">No Telp/Mobile </label>
													<div class="col-lg">
														<label class="col-lg col-form-label">:
															{{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<fieldset>
							<div>
								<div class="card">
									<div class="card-header bg-indigo text-white header-elements-inline">
										<div class="row">
											<div class="col-lg">
												<h6 class="card-title font-weight-semibold py-3">Verifikasi Perubahan Data
													@if (isset($isupdateemail))
														Email
													@endif
													@if (isset($isupdatenib))
														NIB
													@endif
												</h6>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<div class="col-lg-6">
												<div class="row">
													<label class="col-lg-4 col-form-label">Surat Permohonan Perubahan @if (isset($isupdateemail))
															Email
														@endif
														@if (isset($isupdatenib))
															NIB
														@endif
													</label>
													<div class="col-lg">
														<input type="file" name="surat_permohonan_NIB" accept="application/pdf" class="form-control h-auto"
															id="surat_permohonan_NIB" required>
														<small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
														<small for="" class="text-danger">*Maksimum File : 5Mb</small>
													</div>
												</div>
											</div>
										</div>
										@if (isset($isupdateemail))
											<div class="form-group">
												<div class="col-lg-6">
													<div class="row">
														<label class="col-lg-4 col-form-label">Email </label>
														<div class="col-lg">
															<input type="hidden" name="prev_email-update" id="prev_email-update"
																value="{{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}">
															<input class="form-control email-update" name="email-update" id="email-update" required>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6">
													<div class="row">
														<label class="col-lg-4 col-form-label">Verifikasi Email </label>
														<div class="col-lg">
															<input class="form-control email-verify" name="email-verify" id="email-verify" required>
														</div>
													</div>
												</div>
											</div>
										@endif
										@if (isset($isupdatenib))
											<div class="form-group">
												<div class="col-lg-6">
													<div class="row">
														<label class="col-lg-4 col-form-label">NIB </label>
														<div class="col-lg">
															<input type="hidden" name="prev_nib-update" id="prev_nib-update"
																value="{{ isset($detailNib['nib']) ? $detailNib['nib'] : '-' }}">
															<input class="form-control nib-update" name="nib-update" id="nib-update" required>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6">
													<div class="row">
														<label class="col-lg-4 col-form-label">Verifikasi NIB </label>
														<div class="col-lg">
															<input class="form-control nib-verify" name="nib-verify" id="nib-verify" required>
														</div>
													</div>
												</div>
											</div>
										@endif
									</div>
								</div>
							</div>
						</fieldset>b
					</div>
				</div>
				<div class="text-right">
					<a href="{{ url('/') }}" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i>
						Kembali </a>
					<button type="submit"
						onclick="@if (isset($isupdateemail)) validateEmail() @endif @if (isset($isupdatenib)) validateNIB() @endif; return false;"
						class="btn btn-primary">Kirim Permohonan <i class="icon-paperplane ml-2"></i></button>
				</div>
			</div>
		</form>
	</div>
	<script>
		var loadingSpinner = document.getElementById('loadingSpinner');

		function showLoadingSpinner() {
			// loadingSpinner.style.display = 'block';
			var spinner = document.getElementById('loadingSpinner');
			spinner.style.display = 'flex';
		}

		$("input:file").on('change', function() {
			let input = this.files[0];
			const fileSize = input.size / 1048576;

			var fileExt = $(this).val().split(".");
			fileExt = fileExt[fileExt.length - 1].toLowerCase();
			var arrayExtensions = "pdf";

			if (arrayExtensions != fileExt) {
				alert("Format file yang diunggah tidak sesuai. Hanya format PDF yang diperbolehkan");
				$(this).val('');
			}
			if (fileSize > 5) {
				alert(
					'Ukuran file yang diunggah terlalu besar dari ketentuan. Ukuran file yang diunggah maksimal 5 Mb'
				);
				$(this).val('');
			}
		});

		function validateEmail() {
			var email = document.getElementById("email-update").value;
			var verifyEmail = document.getElementById("email-verify").value;

			// Check if the values are the same
			if (email === verifyEmail) {
				showLoadingSpinner();
				$('#form-updateemailnib').submit();
				return true; // You can return true to continue form submission
			} else {
				// Values are different, show an error message
				alert("Email tidak sesuai!");
				return false; // Return false to prevent form submission
			}
		}

		function validateNIB() {
			var nib = document.getElementById("nib-update").value;
			var verifyNIB = document.getElementById("nib-verify").value;

			// Check if the values are the same
			if (nib === verifyNIB) {
				showLoadingSpinner();
				$('#form-updateemailnib').submit();
				return true; // You can return true to continue form submission
			} else {
				// Values are different, show an error message
				alert("NIB tidak sesuai!");
				return false; // Return false to prevent form submission
			}
		}
	</script>
@endsection
