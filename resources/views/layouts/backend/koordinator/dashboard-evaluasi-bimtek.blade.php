@extends('layouts.backend.main')
@section('js')
	<script src="/global_assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="/global_assets/js/plugins/pickers/daterangepicker.js"></script>
	<script src="/global_assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script src="/global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script src="/global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script src="/global_assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script src="/global_assets/js/plugins/notifications/jgrowl.min.js"></script>
	<script src="/global_assets/js/demo_pages/picker_date.js"></script>
@endsection
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
	</style>

	@if ($message = Session::get('message'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
		</div>
	@endif

	<!-- Latest orders -->

	<form method="post" id="formEvaluasi" action="{{ route('admin.verifikatornib.evaluasiBimtekPost') }}">
		@csrf
		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<h6 class="card-title font-weight-semibold py-3">Detil Jadwal Bimbingan Teknis</h6>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<div class="col-lg-12">
						<div class="col-lg-6 form-group row">
							<label class="col-lg-4 col-form-label">Tanggal </label>
							<div class="col-lg-8">
								<div class="input-group">
									<span class="input-group-prepend">
										<span class="input-group-text"><i class="icon-calendar52"></i></span>
									</span>
									<input type="text" id="meeting_date" name="meeting_date" class="form-control daterange-time rounded-right"
										placeholder="Pilih Tanggal">
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group row">
							<label class="col-lg-4 col-form-label">Subject </label>
							<div class="col-lg">
								<input type="text" id="meeting_subject" name="meeting_subject" class="form-control"
									placeholder="Masukkan Judul BimTek">
							</div>
						</div>
						<div class="col-lg-6 form-group row">
							<label class="col-lg-4 col-form-label">Meeting Link </label>
							<div class="col-lg">
								<input type="text" id="meeting_link" name="meeting_link" class="form-control"
									placeholder="Masukkan Link Meeting">
							</div>
						</div>
						<div class="col-lg-6 form-group row">
							<label class="col-lg-4 col-form-label">Meeting ID </label>
							<div class="col-lg">
								<input type="text" id="meeting_id" name="meeting_id" class="form-control" placeholder="Masukkan Meeting ID">
							</div>
						</div>
						<div class="col-lg-6 form-group row">
							<label class="col-lg-4 col-form-label">Meeting Passcode </label>
							<div class="col-lg">
								<input type="text" id="meeting_passcode" name="meeting_passcode" class="form-control"
									placeholder="Masukkan Meeting Passcode">
							</div>
						</div>
					</div>
				</div>

				<div>
					<a type="button" href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i
							class="icon-backward2 ml-2"></i> Kembali </a>
					<button type="button" id="btnSubmitModal" data-target="#submitModal" data-toggle="modal"
						class="btn btn-indigo">Kirim Undangan <i class="icon-paperplane ml-2"></i></button>
				</div>
			</div>
		</div>
	</form>
	<div class="card">
		<div class="card-header bg-indigo text-white header-elements-inline">
			<h6 class="card-title font-weight-semibold py-3">Daftar Pengajuan Bimbingan Teknis Pelaku Usaha</h6>
		</div>

		<div class="table-responsive border-top-0">
			<table class="table text-nowrap">
				<thead>
					<tr>
						<th>Nama</th>
						<th class="text-center">Nama Pelaku Usaha</th>
						<th class="text-center">Tanggal Permohonan</th>
						<th class="text-center">No Telp Pelaku Usaha</th>
						<th class="text-center">eMail Pelaku Usaha</th>
						<th class="text-center">Status</th>
						<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
					</tr>
				</thead>
				<tbody>
					@if (isset($req_bimtek) && count($req_bimtek) > 0)
						@foreach ($req_bimtek as $req_bimteks)
							<tr>
								<td>
									<div class="d-flex align-items-center">
										<div>
											<a href="{{ route('admin.verifikatornib.evaluasiregistrasiprocess', $req_bimteks['id']) }}"
												class="text-body font-weight-semibold">{{ $req_bimteks->nama_pemohon ? $req_bimteks->nama_pemohon : '' }}</a>
										</div>
									</div>
								</td>
								<td class="text-center">
									{{ $req_bimteks->nama_perusahaan ? $req_bimteks->nama_perusahaan : '' }}
								</td>
								<td class="text-center">
									{{ $req_bimteks->req_date ? $date_reformat->date_lang_reformat_long_with_time($req_bimteks->req_date) : '' }}
								</td>
								<td class="text-center">
									{{ $req_bimteks->notelp_pemohon ? $req_bimteks->notelp_pemohon : '' }}
								</td>
								<td class="text-center">
									{{ $req_bimteks->email_pemohon ? $req_bimteks->email_pemohon : '' }}
								</td>

								<td class="text-center"><span class="badge badge-success-100 text-success">
										{{-- @if ($req_bimteks->status_evaluasi == 0) --}}
										Untuk Dievaluasi
										{{-- @endif --}}
									</span></td>
								<td class="text-center">
									<div class="dropdown">
										<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
											data-toggle="dropdown">
											<i class="icon-menu7"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right">

											<a href="{{ route('admin.verifikatornib.evaluasiregistrasiprocess', $req_bimteks->id) }}"
												class="dropdown-item"><i class="icon-pencil"></i> Evaluasi Pendaftaran
												Pelaku Usaha</a>
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

	<div class="modal" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Kirim Undangan Bimbingan Teknis</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan mengirim undangan ini ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitinvitation();return false;"
						class="btn btn-primary notif-button">Kirim</button>
					<div class="spinner-border loading text-primary" role="status" hidden>
						<span class="sr-only">Loading...</span>
					</div>
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

		function submitinvitation() {
			showLoadingSpinner();
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			$('#formEvaluasi').submit();
		}
	</script>
@endsection
