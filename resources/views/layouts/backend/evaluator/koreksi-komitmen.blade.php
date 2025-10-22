@extends('layouts.backend.main')
@section('js')
@endsection
@section('content')
	@if (session()->has('success'))
		<div class="alert alert-success">
			Komitmen telah diperbaharui, Terimakasih.
		</div>
	@endif

	<div>
		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Informasi Permohonan </h6>
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
								@if (!isset($izin2['submitted_at']))
									<td class="text-center"> - </td>
								@else
									<label class="col-lg col-form-label text-capitalize">:
										{{ date('d F Y', strtotime($izin2['submitted_at'])) }}</label>
								@endif
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

	<form id="form-koreksi" action="{{ route('admin.evaluator.koreksikomitmenpost', [$izin2['id_izin']]) }}" method="post"
		enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="id_izin" value="{{ $id_izin }}">
		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Form Perbaikan Komitmen</h6>
					</div>
				</div>
			</div>

			<div class="card-body">
				@foreach ($datasyaratpdf as $syarat)
					@if ($syarat->file_type == 'table' && $syarat->component_name != null)
						<div style="background: #fafafa;border-right: 1px solid #ddd;border-left: 1px solid #ddd;">

							{{-- <div class="bg-info text-white">
							<h4 class="m-0 p-2 h6"> Perbaikan Komitmen
							</h4>
						</div> --}}
							<div class="px-2" style="border-bottom: 1px solid #ddd;padding-top: 15px;padding-bottom: 15px;">
								<div class="form-group mb-0">
									{{-- <div class="form-label mb-2 font-weight-bold">
									{!! $syarat->persyaratan_html !!}
								</div> --}}
									@if ($syarat->file_type == 'table' && $syarat->component_name != null)
										@if (isset($syarat->filled_document))
											{{-- <div class="form-label mb-2 font-weight-bold">
											{!! $syarat->persyaratan_html !!}
										</div> --}}
											@if (Illuminate\Support\Str::is('rencanausaha*', $syarat->component_name))
												<input type="hidden" name="id_maplist_rencanausaha" value="{{ $syarat->id_maplist }}">
												{{-- <div class="form-label mb-2 font-weight-bold">
													Komitmen Sebelumnya
												</div>
												<div>
													<x-dynamic-component :triger="null" :component="$syarat->component_name" :datajson="$syarat->filled_document" :needcorrection="false"
														:correctionnote="$syarat->correction_note || ''" />
												</div>
												<div class="form-label mb-2 font-weight-bold">
													Komitmen yang akan dirubah
												</div> --}}
												<div>
													<x-dynamic-component :triger="null" :component="$syarat->component_name" :datajson="$syarat->filled_document" :needcorrection="true"
														:correctionnote="$syarat->correction_note || ''" />
												</div>
											@endif
											@if ($syarat->component_name == 'komitmen_kinerja_layanan_lima_tahun')
												<input type="hidden" name="id_maplist_komitmen_kinerja_layanan_lima_tahun"
													value="{{ $syarat->id_maplist }}">
												{{-- <div class="form-label mb-2 font-weight-bold">
													Komitmen Sebelumnya
												</div>
												<div>
													<x-dynamic-component :triger="null" :component="$syarat->component_name" :datajson="$syarat->filled_document" :needcorrection="$syarat->need_correction ?? false"
														:correctionnote="$syarat->correction_note || ''" />
												</div>
												<div class="form-label mb-2 font-weight-bold">
													Komitmen yang akan dirubah
												</div> --}}
												<div>
													<x-dynamic-component :triger="null" :component="$syarat->component_name" :datajson="$syarat->filled_document" :needcorrection="true"
														:correctionnote="$syarat->correction_note || ''" />
												</div>
											@endif
											@if (Illuminate\Support\Str::is('roll_out_plan*', $syarat->component_name))
												<input type="hidden" name="id_maplist_roll_out_plan" value="{{ $syarat->id_maplist }}">
												{{-- <div class="form-label mb-2 font-weight-bold">
													Komitmen Sebelumnya
												</div>
												<div>
													<x-dynamic-component :triger="null" :component="$syarat->component_name" :datajson="$syarat->filled_document" :needcorrection="$syarat->need_correction ?? false"
														:correctionnote="$syarat->correction_note || ''" />
												</div>
												<div class="form-label mb-2 font-weight-bold">
													Komitmen yang akan dirubah
												</div> --}}
												<div>
													<x-dynamic-component :triger="null" :component="$syarat->component_name" :datajson="$syarat->filled_document" :needcorrection="true"
														:correctionnote="$syarat->correction_note || ''" />
												</div>
											@endif
										@endif
									@endif
								</div>
							</div>
						</div>
					@endif
				@endforeach
			</div>
		</div>
		<div class="text-right">
			<a type="button" href="/" class="btn btn-indigo mr-1"><i class="icon-backward2 ml-2"></i> Kembali</a>
			<button type="button" class="btn btn-secondary float-right" onclick="onSubmit()">Kirim Perbaikan Komitmen
				<i class="icon-paperplane ml-2"></i></button>
		</div>

	</form>

	<div class="modal" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Kirim Evaluasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin persyaratan yang anda koreksi sudah sesuai ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitkoreksi();return false;"
						class="btn btn-primary notif-button">Kirim</button>
					<div class="spinner-border loading text-primary" role="status" hidden>
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function onSubmit() {
			if ($("#form-koreksi")[0].checkValidity()) {
				$('#submitModal').modal('show');
			} else {
				$('#form-koreksi :input[required="required"]').each(function() {
					if (!this.validity.valid) {
						$(this).focus();
						return false;
					}
				});
			}
			return false;
		}

		function submitkoreksi() {
			// $('#form-koreksi').submit();
			// $('.notif-button').attr("hidden",true);
			// $('.loading').attr("hidden",false);	
			// console.log('ok')
			// sampe sini dlu
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			if ($('#form-koreksi')[0].checkValidity()) {
				$('#form-koreksi').submit();
			}
		}

		$(document).on('click', '.btn-delete-removeperangkat', function() {
			$(this).find('.lokasi_perangkat').attr('name', 'daftar_perangkat[' + index + '][lokasi_perangkat]')
				.remove();
			$(this).find('.jenis_perangkat').attr('name', 'daftar_perangkat[' + index + '][jenis_perangkat]')
				.remove();
			$(this).find('.merk_perangkat').attr('name', 'daftar_perangkat[' + index + '][merk_perangkat]')
				.remove();
			$(this).find('.tipe_perangkat').attr('name', 'daftar_perangkat[' + index + '][tipe_perangkat]')
				.remove();
			$(this).find('.buatan_perangkat').attr('name', 'daftar_perangkat[' + index + '][buatan_perangkat]')
				.remove();
			$(this).find('.sn_perangkat').attr('name', 'daftar_perangkat[' + index + '][sn_perangkat]').remove();
			$(this).find('.sertifikat_perangkat').attr('name', 'daftar_perangkat[' + index +
				'][sertifikat_perangkat]').remove();
			$(this).find('.foto_perangkat').attr('name', 'daftar_perangkat[' + index + '][foto_perangkat]')
				.remove();
			$(this).find('.foto_sn_perangkat').attr('name', 'daftar_perangkat[' + index +
				'][foto_sn_perangkat]').remove();
		});

		function removeperangkat(index) {
			$(this).find('.lokasi_perangkat').attr('name', 'daftar_perangkat[' + index + '][lokasi_perangkat]').remove();
			$(this).find('.jenis_perangkat').attr('name', 'daftar_perangkat[' + index + '][jenis_perangkat]').remove();
			$(this).find('.merk_perangkat').attr('name', 'daftar_perangkat[' + index + '][merk_perangkat]').remove();
			$(this).find('.tipe_perangkat').attr('name', 'daftar_perangkat[' + index + '][tipe_perangkat]').remove();
			$(this).find('.buatan_perangkat').attr('name', 'daftar_perangkat[' + index + '][buatan_perangkat]').remove();
			$(this).find('.sn_perangkat').attr('name', 'daftar_perangkat[' + index + '][sn_perangkat]').remove();
			$(this).find('.sertifikat_perangkat').attr('name', 'daftar_perangkat[' + index +
				'][sertifikat_perangkat]').remove();
			$(this).find('.foto_perangkat').attr('name', 'daftar_perangkat[' + index + '][foto_perangkat]').remove();
			$(this).find('.foto_sn_perangkat').attr('name', 'daftar_perangkat[' + index +
				'][foto_sn_perangkat]').remove();

		}
	</script>

@endsection
