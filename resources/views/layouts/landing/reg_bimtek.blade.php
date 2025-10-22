@extends('layouts.landing.main_rev')
@section('content')
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
	<section id="slider" class="slider-element slider-parallax min-vh-60 min-vh-md-100 include-header">
		<div class="slider-inner"
			style="background: #FFF url('/assets/kominfo/images/1450840.png') center center no-repeat; background-size: cover;">
			<div class="vertical-middle slider-element-fade">
				<div class="container py-5">
					@if (Session::get('message') != '')
						<div class="alert alert-success alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>{{ Session::get('message') }}</strong>
						</div>
					@endif
					<div class="row pt-5">
						<div class="col-lg-10 col-md-10">
							<div class="badge rounded-pill badge-default">Form Pengajuan Bimbingan Teknis</div>
							<form id="form-pengajuan" action="{{ url('/landing/reqbimtekpost') }}" method="post"
								enctype="multipart/form-data">
								@csrf

								<div class="card">
									<div class="card-body">
										<div class="px-2" style="border-bottom: 1px solid #ddd;padding-top: 15px;padding-bottom: 15px;">
											<div class="form-group row">
												<div class="form-label col-lg-4 mb-2 font-weight-bold">Nama Perusahaan
												</div>
												<div class="form-label col-lg-8 mb-2 font-weight-bold">
													<input type="text" name="nama_perusahaan" class="form-control h-auto" id="nama_perusahaan"
														placeholder="Masukkan Nama Perusahaan"
														value="{{ isset($nama_entity->nama_perseroan) ? $nama_entity->nama_perseroan : '' }}"
														@if (isset($nama_entity->nama_perseroan)) readonly @endif required>
												</div>
											</div>
											<div class="form-group row">
												<div class="form-label col-lg-4 mb-2 font-weight-bold">Nama Pemohon
												</div>
												<div class="form-label col-lg-8 mb-2 font-weight-bold">
													<input type="text" name="nama_pemohon" class="form-control h-auto" id="nama_pemohon"
														placeholder="Masukkan Nama Anda" value="{{ isset(Auth::user()->name) ? Auth::user()->name : '' }}"
														@if (isset(Auth::user()->name)) readonly @endif required>
												</div>
											</div>
											<div class="form-group row">
												<div class="form-label col-lg-4 mb-2 font-weight-bold">No Telp Pemohon
												</div>
												<div class="form-label col-lg-8 mb-2 font-weight-bold">
													<input type="text" name="no_telp_pemohon" class="form-control h-auto" id="no_telp_pemohon"
														placeholder="Masukkan No Telp Anda"
														value="{{ isset($nama_entity->nomor_telpon_perseroan) ? $nama_entity->nomor_telpon_perseroan : '' }}"
														@if (isset($nama_entity->nomor_telpon_perseroan)) readonly @endif required>
												</div>
											</div>
											<div class="form-group row">
												<div class="form-label col-lg-4 mb-2 font-weight-bold">e-Mail Pemohon
												</div>
												<div class="form-label col-lg-8 mb-2 font-weight-bold">
													<input type="email" name="email_pemohon" class="form-control h-auto" id="email_pemohon"
														placeholder="Masukkan Email Anda"
														value="{{ isset($nama_entity->email_perusahaan) ? $nama_entity->email_perusahaan : '' }}"
														@if (isset($nama_entity->email_perusahaan)) readonly @endif required>
												</div>
											</div>
											<div class="form-group row">
												<div class="form-label col-lg-4 mb-2 font-weight-bold">Tujuan Bimbingan Teknis
												</div>
												<div class="form-label col-lg-8 mb-2 font-weight-bold">
													<textarea class="form-control" name="reason_bimtek" id="reason_bimtek" rows="3"
													 placeholder="Masukkan Alasan Anda Mengajukan Bimbingan Teknis" required></textarea>
												</div>
											</div>
										</div>
										<div class="px-2 form-group text-right" style="padding-top: 15px;">
											<div class="row">
												<div class="col-lg-2 text-right">
													<button type="submit" class="button button-rounded ms-2">Ajukan
														Bimbingan Teknis</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
