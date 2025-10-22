@extends('layouts.frontend.main')
<!-- @section('title', 'Pemenuhan Persyaratan') -->
@section('js')

	<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="/global_assets/js/demo_pages/form_layouts.js"></script>
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
	{{--
<x-frm-jartup-fo-ter />
<x-frm-komittahun />
<x-frm-kinerjalayanan />
<x-frm-dataalatperangkat />
<x-frm-jar-persyaratan /> --}}
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

	<div>
		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Informasi Permohonan</h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<div class="col-lg-6">
						<div class="row">
							<label class="col-lg-4 col-form-label">No Permohonan </label>
							<div class="col-lg">
								<label class="col-lg col-form-label">: {{ $izin2['id_izin'] }}</label>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="row">
							<label class="col-lg-4 col-form-label">Jenis Layanan </label>
							<div class="col-lg">
								<label class="col-lg col-form-label text-capitalize">: {!! $izin2['jenis_layanan_html'] !!}</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-6">
						<div class="row">
							<label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
							<div class="col-lg">
								<label class="col-lg col-form-label">:
									@if ($izin2['submitted_at'] == null)
										{{ $date_reformat->dateday_lang_reformat_long($datenow) }}
									@else
										{{ $date_reformat->dateday_lang_reformat_long($izin2['submitted_at']) }}
									@endif

								</label>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="row">
							<label class="col-lg-4 col-form-label">Status Permohonan </label>
							<div class="col-lg">
								<label class="col-lg col-form-label">: {{ $izin2['status_fo'] }}</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- End Section Detail Permohonan -->

	<!-- Section Detail Perusahaan -->
	<div>
		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Informasi @if ($detailNib['jenis_pu'] == 'TKI')
								Instansi
							@else
								Perusahaan
							@endif
						</h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<legend class="text-uppercase font-size-sm font-weight-bold">Data @if ($detailNib['jenis_pu'] == 'TKI')
						Instansi
					@else
						Perusahaan
					@endif
				</legend>
				<div class="form-group row">
					@if ($detailNib['jenis_pu'] != 'TKI')
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">NIB </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{ $detailNib['nib'] }}</label>
								</div>
							</div>
						</div>
					@endif

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
								<label class="col-lg col-form-label">: {{ $detailNib['nomor_telpon_perseroan'] }}</label>
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
	<!-- End Section Detail Perusahaan -->

	<form id="form-persyaratan" action="{{ url('/pb/submitpersyaratan') }}" method="post" enctype="multipart/form-data">
		<!-- <form id="form-persyaratan" action="javascript:void(0)" method="post" enctype="multipart/form-data"> -->
		@csrf
		<input type="hidden" name="id_izin" value="{{ $id_izin }}">
		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Form Persyaratan</h6>
					</div>
				</div>
				@php
					$i = 0;
					$group = '';
				@endphp
			</div>
			<div class="card-body">
				{{-- <table class="table-frm">
                <tbody> --}}
				@foreach ($datasyaratpdf as $keys => $syarat)
					<div style="background: #fafafa;border-right: 1px solid #ddd;border-left: 1px solid #ddd;">
						@if ($group != $syarat->group_by)
							<div class="bg-info text-white">
								<h4 class="m-0 p-2 h6"> {{ $syarat->group_by ? $syarat->group_by : ' Syarat Lainnya' }}
								</h4>
							</div>
						@endif
						@php
							$group = $syarat->group_by;
						@endphp
						<div class="px-2" style="border-bottom: 1px solid #ddd;padding-top: 15px;padding-bottom: 15px;">
							<div class="form-group mb-0">
								@if ($syarat->file_type == 'integration' && $syarat->is_mandatory == '0')
									<div class="form-label mb-2 font-weight-bold">
										{{-- Surat Pernyataan Tidak Menggunakan {!! $syarat->persyaratan_html !!} --}}
										{!! $syarat->persyaratan_html !!}
										<small for="" class="text-danger mr-2">*Jika tidak menggunakan ISR/Hak
											Labuh, maka mohon mengunggah Surat Pernyataan Tidak Menggunakan ISR/Hak Labuh
											seperti template dibawah ini.</small>
									</div>
								@else
									<div class="form-label mb-2 font-weight-bold">
										{!! $syarat->persyaratan_html !!}
									</div>
								@endif

								@if ($syarat->file_type == 'pdf')
									<input type="hidden" name="persyaratan[{{ $keys }}]" value="{{ $syarat->persyaratan }}">
									<input type="hidden" name="id_maplist[{{ $keys }}]" value="{{ $syarat->id_maplist }}">
									<input type="hidden" name="id_syarat[{{ $keys }}]" value="{{ $syarat->file_type }}">
									<input type="file" name="syarat[{{ $keys }}]" accept="application/pdf"
										class="form-control h-auto" id="syarat_{{ $keys }}" {{ $syarat->is_mandatory ? 'required' : '' }}>
									@if ($detailNib['jenis_pu'] == 'TKI' && $syarat->id_maplist == 405)
										<small for="" class="text-danger mr-2">*Jika tidak
											menggunakan Spektrum Frekuensi Radio, diganti dengan dokumen
											Surat Pernyataan Tidak Menggunakan Media Transmisi Spektrum
											Frekuensi Radio</small>
									@elseif ($detailNib['jenis_pu'] == 'TKI' && $syarat->id_maplist == 406)
										<small for="" class="text-danger mr-2">* Jika tidak menggunakan media
											Satelit Asing, diganti
											dengan dokumen Surat Pernyataan Tidak Menggunakan Satelit Asing</small>
									@elseif ($detailNib['jenis_pu'] == 'TKI' && $syarat->id_maplist == 407)
										<small for="" class="text-danger mr-2">* Jika tidak membangun serat optik
											yang melintasi jalan
											umum, diganti dengan dokumen Surat Pernyataan Tidak Ada Izin
											Galian</small>
									@endif
									@if ($syarat->is_mandatory)
										<small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
										<small for="" class="text-danger">*Maksimum File : 5Mb</small>
									@else
										<label for="" class="text-success">(Opsional)</label>
									@endif
									@if ($syarat->download_link != null && $syarat->download_link != '')
										<small>Download Lampiran Template <a target="_blank" href="{{ $syarat->download_link }}">Disini</a></small>
									@endif
								@elseif($syarat->file_type == 'integration')
									@if ($syarat->is_mandatory == '1')
										<div class="integration">
											<div class="input-group">
												<div class="input-group-icon"><i class="icon-cross"></i></div>
												<div class="input-group-area">
													<input type="text" placeholder="Masukan Nomor NIB" data-type="{{ $syarat->persyaratan }}"
														name="id_integration[{{ $keys }}]" value="">
													<input type="hidden" name="integration[{{ $keys }}]">
													<input type="text" name="id_maplist_integration[{{ $keys }}]"
														value="{{ $syarat->id_maplist }}" class="hidden">
												</div>
											</div>
											<br>
											<button class="btn btn-success verify">Verifikasi Sertifikat</button>
										</div>
									@else
										<input type="hidden" name="persyaratan[{{ $keys }}]" value="{{ $syarat->persyaratan }}">
										<input type="hidden" name="id_maplist[{{ $keys }}]" value="{{ $syarat->id_maplist }}">
										<input type="hidden" name="id_syarat[{{ $keys }}]" value="{{ $syarat->file_type }}">
										<input type="file" name="syarat[{{ $keys }}]" accept="application/pdf" class="form-control"
											id="syarat_{{ $keys }}" required>

										<small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
										<small for="" class="text-danger">*Maksimum File : 5Mb</small>
										@if ($syarat->download_link != null && $syarat->download_link != '')
											<small>Download Lampiran Template <a target="_blank" href="{{ $syarat->download_link }}">Disini</a></small>
										@endif
									@endif
								@else
									@php
										$datajson = 'kosong';
									@endphp

									<x-dynamic-component :triger="null" :component="$syarat->component_name" :datajson="$datajson" :needcorrection="false" />
									{{-- <x-dynamic-component :triger="null" :component="'daftar_perangkat_mtd'" :datajson="$datajson" :needcorrection="false" /> --}}

									{{-- <x-daftar_perangkat_mtd :devices="$datajson" :triger="null" :datajson="$datajson" :needcorrection="false" /> --}}

									@if (Illuminate\Support\Str::is('cakupanwilayahtelsus_mtk', $syarat->component_name))
										<input type="hidden" name="id_maplist_cakupanwilayahtelsus_mtk" value="{{ $syarat->id_maplist }}">
									@endif
									@if (Illuminate\Support\Str::is('cakupanwilayahtelsus_skrd', $syarat->component_name))
										<input type="hidden" name="id_maplist_cakupanwilayahtelsus_skrd" value="{{ $syarat->id_maplist }}">
									@endif
									@if (Illuminate\Support\Str::is('cakupanwilayahtelsus_skrk', $syarat->component_name))
										<input type="hidden" name="id_maplist_cakupanwilayahtelsus_skrk" value="{{ $syarat->id_maplist }}">
									@endif
									@if (Illuminate\Support\Str::is('cakupanwilayahtelsus_skrt', $syarat->component_name))
										<input type="hidden" name="id_maplist_cakupanwilayahtelsus_skrt" value="{{ $syarat->id_maplist }}">
									@endif
									@if (Illuminate\Support\Str::is('cakupanwilayahtelsus_sks', $syarat->component_name))
										<input type="hidden" name="id_maplist_cakupanwilayahtelsus_sks" value="{{ $syarat->id_maplist }}">
									@endif

									@if (Illuminate\Support\Str::is('rencanausaha*', $syarat->component_name))
										<input type="hidden" name="id_maplist_rencanausaha" value="{{ $syarat->id_maplist }}">
									@endif
									@if (Illuminate\Support\Str::is('daftar_perangkat*', $syarat->component_name))
										<input type="hidden" name="id_maplist_daftar_perangkat" value="{{ $syarat->id_maplist }}">
									@endif
									@if (Illuminate\Support\Str::is('daftar_perangkat_telsus*', $syarat->component_name))
										<input type="hidden" name="id_maplist_daftar_perangkat_telsus" value="{{ $syarat->id_maplist }}">
									@endif
									@if (Illuminate\Support\Str::is('daftar_ket_konfigurasiteknis*', $syarat->component_name))
										<input type="hidden" name="id_maplist_daftar_ket_konfigurasiteknis" value="{{ $syarat->id_maplist }}">
									@endif
									@if ($syarat->component_name === 'komitmen_kinerja_layanan_lima_tahun')
										<input type="hidden" name="id_maplist_komitmen_kinerja_layanan_lima_tahun"
											value="{{ $syarat->id_maplist }}">
									@endif
									@if (Illuminate\Support\Str::is('roll_out_plan*', $syarat->component_name))
										<input type="hidden" name="id_maplist_roll_out_plan" value="{{ $syarat->id_maplist }}">
									@endif
									@if ($syarat->is_mandatory)
										<small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
										<small for="" class="text-danger">*Maksimum File : 5Mb</small>
									@else
										<label for="" class="text-success">(Opsional)</label>
									@endif
									@if ($syarat->download_link != null && $syarat->download_link != '')
										<small>Download Lampiran Template <a target="_blank" href="{{ $syarat->download_link }}">Disini</a></small>
									@endif
								@endif
							</div>
						</div>
						@php
							$i++;
						@endphp
					</div>
				@endforeach

				{{--
                </tbody>
            </table> --}}
			</div>
		</div>

		@if ($izin2['nama_master_izin'] == 'TELSUS_INSTANSI')
			<div class="dropdown-divider"></div>
			<div class="form-group col-lg-12 row">
				<label class="col-form-label">Dengan ini saya menyatakan : </label>
			</div>
			<div class="form-group col-lg-12 row">
				<label class="col-form-label">
					1.Seluruh data dan dokumen yang disampaikan kepada Kementerian Komunikasi dan Informatika oleh
					{{ strtoupper($detailNib['nama_perseroan']) }} sebagai persyaratan permohonan izin penyelenggaraan
					adalah valid dan benar;<br />
					2.Sanggup untuk melaksanakan ketentuan penyelenggaraan telekomunikasi sebagaimana yang diatur dalam
					ketentuan peraturan perundang-undangan;<br />
					3.Akan mengembalikan izin apabila jaringan telekomunikasi khusus tidak diperlukan lagi;<br />
					4.Berkomitmen tidak melakukan komunikasi dan perbuatan yang mengarah kepada kolusi, korupsi dan
					nepotisme (KKN) serta akan melaporkan kepada pihak yang berwajib/berwenang apabila mengetahui ada
					indikasi korupsi, kolusi dan nepotisme (KKN).<br />
				</label>
			</div>
			<div class="form-group col-lg-12 row">
				<label class="col-form-label">Apabila dikemudian hari ternyata pernyataan ini tidak benar atau
					dokumen-dokumen seperti tersebut yang dinyatakan pada butir 1. tidak sah menurut hukum, maka
					{{ strtoupper($detailNib['nama_perseroan']) }} bersedia menerima sanksi hukum sesuai dengan peraturan
					perundang-undangan yang berlaku.
				</label>
			</div>
			<div class="form-group col-lg-12 row">
				<div class="col-lg-8">
					<label class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" name="chekCheklis" id="chekCheklis" class="custom-control-input" required>
						<span class="custom-control-label">Dengan membubuhkan cek list, saya telah membaca dan
							menyetujui ketentuan di atas.</span>
					</label>
				</div>
			</div>
		@endif

		<?php
		if ($izin2['nama_master_izin'] == 'JASA') {
		    $url = 'pb/permohonan/jasa';
		} elseif ($izin2['nama_master_izin'] == 'JARINGAN') {
		    $url = 'pb/permohonan/jaringan';
		} elseif ($izin2['nama_master_izin'] == 'TELSUS') {
		    $url = 'pb/permohonan/telsus';
		} elseif ($izin2['nama_master_izin'] == 'TELSUS_INSTANSI') {
		    $url = 'pb/permohonan/telsus_instansi';
		}
		?>
		<div class="text-right">
			<a href="{{ url($url) }}" class="btn btn-indigo mr-1"><i class="icon-backward2 ml-2"></i> Kembali </a>

			{{-- <button type="submit" class="btn btn-secondary float-right" onclick="return false;" data-toggle="modal"
                data-target="#submitModal">Permohonan Persyaratan <i class="icon-paperplane ml-2"></i></button> --}}
			<button type="button" class="btn btn-secondary float-right" onclick="onSubmit()">Permohonan Persyaratan <i
					class="icon-paperplane ml-2"></i></button>

		</div>
	</form>

	<div id="modal_theme_primary" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-indigo text-white justify-content-center">
					<h6 class="modal-title self-align-center"> PERNYATAAN KESANGGUPAN PEMENUHAN PERSYARATAN <br />
						LAYANAN
						IZIN PENYELENGGARAAN JASA TELEKOMUNIKASI</h6>
				</div>
				<div class="modal-body">
					<div class="mb-4">
						<div class="form-group text-center row">
							<label class="col-form-label">Dengan ini saya menyatakan bahwa seluruh data yang disampaikan
								dalam SURAT PERNYATAAN adalah BENAR dan VALID. Jika dikemudian hari data yang
								disampaikan
								terbukti tidak benar, maka kami siap menerima akibat hukum sesuai dengan ketentuan
								perundang-undangan.</label>
						</div>
						<div class="form-group row">
							<div class="col-lg-8">
								<label class="custom-control custom-checkbox custom-control-inline">
									<input type="checkbox" class="custom-control-input" checked>
									<span class="custom-control-label">YA, Saya Setuju.</span>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer float-right">
					<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-secondary">Kirim Persyaratan</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Kirim Pemenuhan Persyaratan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin persyaratan yang akan dikirim sudah sesuai ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitpersyaratan();return false;"
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

		function onSubmit() {
			if ($("#form-persyaratan")[0].checkValidity()) {
				$('#submitModal').modal('show');
			} else {
				$('#form-persyaratan :input[required="required"]').each(function() {
					if (!this.validity.valid) {
						$(this).focus();
						// alert(
						//     'Mohon lengkapi persyaratan yang dibutuhkan dan lakukan checklist setelah melengkapi persyaratan.'
						// );
						return false;
					}
				});
			}
			return false;
		}

		function submitpersyaratan() {
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			if ($('#form-persyaratan')[0].checkValidity()) {

				showLoadingSpinner();
				$('#form-persyaratan').submit();
			}
		}

		$("button.verify").click(function(e) {
			let integration = $(this).parents('.integration')
			let type = integration.find('input').data('type')
			let endpointToken
			let uname
			let pass
			let endpoint
			let method = 'GET'

			if (type == 'ISR') {
				endpointToken = "https://dev-middleware.ditfrek.postel.go.id/middleware_sdppi/get_token"
				uname = "telecomunication"
				pass = "tele324"
				endpoint = "https://dev-middleware.ditfrek.postel.go.id/middleware_sdppi/isr_telecomunication/index"
			} else {
				endpointToken = "/api/v1/get-token"
				endpoint = "/api/v1/izin-terbit"
			}

			let val = integration.find('input').val()
			let token
			e.preventDefault();
			$.ajax({
				type: method,
				url: endpointToken,
				dataType: "json",
				data: {
					username: uname, // < note use of 'this' here
					password: pass, // < note use of 'this' here
				},
				async: false,
				success: function(result) {
					token = result.tokens
				},
				error: function(error) {
					alert("Tidak dapat terhubung ke server!")
				}
			});
			$.ajax({
				type: "GET",
				url: endpoint,
				dataType: "json",
				headers: {
					"Authorization": "Bearer " + token
				},
				data: {
					search: val
				},
				success: function(result) {
					// alert(JSON.stringify(result));
					if (result.data) {
						alert(type + ' Ditemukan!')
						integration.find('i').removeClass('icon-cross')
						integration.find('i').addClass('icon-check')
						integration.find('input').attr('readonly', true)
						integration.find('input[type=hidden]').val(JSON.stringify(result.data))
						integration.find('button').attr('disabled', true)
					} else {
						alert('ISR Tidak Ditemukan!')
						integration.find('i').addClass('icon-cross')
						integration.find('i').removeClass('icon-check')
						integration.find('input').removeAttr('readonly')
						integration.find('button').removeAttr('disabled')
					}
				},
				error: function(error) {
					alert("Tidak dapat terhubung ke server!")
				}
			});
		});
	</script>
@endsection
