@extends('layouts.backend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
	<form action="{{ route('admin.verifikatornib.evaluasiregistrasipost', $user->id) }}" method="POST">
		@csrf
		<div class="form-group">
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Evaluasi Registrasi Perusahaan/Instansi </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					{{-- {{$user->id}} --}}
					<x-be-register-pt :datapt="$user_pt" />
				</div>
			</div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Evaluasi Registrasi Penanggung Jawab </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<x-be-register-pj :datapj="$user" />
				</div>
			</div>

			@if (isset($vw_pelaku_usaha->idchange_email_updated_data) || isset($vw_pelaku_usaha->idchange_nib_updated_data))
				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Evaluasi Perubahan Akun </h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="col-lg">
							@if (isset($vw_pelaku_usaha->idchange_nib_updated_data))
								<input type="hidden" id="idchange_nib_" name="idchange_nib_"
									value="{{ $vw_pelaku_usaha->idchange_nib_updated_data }}">
								<div class="form-group">
									<div class="col-lg">
										<div class="row">
											@if ($user_pt->jenis_pu == 'PTB' || $user_pt->jenis_pu == 'TKB' || $user_pt->jenis_pu == 'PTP')
												<div class="col-lg-6">
													<p class="font-weight-semibold"> Nomor Induk Berusaha (NIB)</p>
													<input type="text" class="form-control" value="{{ $vw_pelaku_usaha->idchange_nib_updated_data }}"
														disabled>
												</div>
												<div class="col-lg-6">
													<p class="font-weight-semibold"> Nomor Induk Berusaha (NIB) Sebelumnya</p>
													<input type="text" class="form-control" value="{{ $vw_pelaku_usaha->nib }}" disabled>
												</div>
											@elseif ($user_pt->jenis_pu == 'TKI')
												<div class="col-lg-6">
													<p class="font-weight-semibold"> Nama K/D/L/I </p>
													<input type="text" class="form-control" value="{{ $vw_pelaku_usaha->idchange_nib_updated_data }}"
														disabled>
												</div>
												<div class="col-lg-6">
													<p class="font-weight-semibold"> Nama K/D/L/I Sebelumnya</p>
													<input type="text" class="form-control" value="{{ $vw_pelaku_usaha->nib }}" disabled>
												</div>
											@else
												<div class="col-lg-6">
													<p class="font-weight-semibold"> Nama Instansi/Perusahaan</p>
													<input type="text" class="form-control" value="{{ $vw_pelaku_usaha->idchange_nib_updated_data }}"
														disabled>
												</div>
												<div class="col-lg-6">
													<p class="font-weight-semibold"> Nama Instansi/Perusahaan Sebelumnya</p>
													<input type="text" class="form-control" value="{{ $vw_pelaku_usaha->nib }}" disabled>
												</div>
											@endif
										</div>
									</div>
								</div>
							@endif
							@if (isset($vw_pelaku_usaha->idchange_email_updated_data))
								<input type="hidden" id="idchange_email_" name="idchange_email_"
									value="{{ $vw_pelaku_usaha->idchange_email_updated_data }}">
								<div class="form-group">
									<div class="col-lg">
										<div class="row">
											<div class="col-lg-6">
												<p class="font-weight-semibold"> Email Akun</p>
												<input type="text" class="form-control" value="{{ $vw_pelaku_usaha->idchange_email_updated_data }}"
													disabled>
											</div>
											<div class="col-lg-6">
												<p class="font-weight-semibold"> Email Akun Sebelumnya</p>
												<input type="text" class="form-control" value="{{ $vw_pelaku_usaha->email_user_proses }}" disabled>
											</div>
										</div>
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
			@endif

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Hasil Evaluasi </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<select class="form-control" name="is_setuju" id="" required>
						<option disabled selected>Silakan Pilih..</option>
						<option value="1">Setuju</option>
						<option value="2">Tolak</option>
					</select>
				</div>
			</div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Catatan Hasil Evaluasi </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<textarea id="catatan_evaluasi" name="catatan_evaluasi" rows="3" cols="3" class="form-control"
					 placeholder="Hasil Evaluasi"></textarea>
				</div>
			</div>
			<div class="form-group text-right">
				{{-- <button type="submit" class="btn btn-light">Kembali <i class="icon-backward2 ml-2"></i></button> --}}
				<a href="{{ URL::previous() }}" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i>
					Kembali </a>
				<button type="submit" class="btn btn-primary">Kirim Evaluasi Pendaftaran <i
						class="icon-paperplane ml-2"></i></button>
			</div>
		</div>
	</form>
@endsection
