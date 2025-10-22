@extends('layouts.backend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
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
	<div class="form-group">
		{{-- <h3>Disposisi Uji Laik Operasi  </h3>
	<hr/> --}}

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
									<label class="col-lg col-form-label">: {{ $ulo['id_izin'] }}</label>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Jenis Permohonan </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {!! $ulo['jenis_layanan_html'] !!}</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
								<div class="col-lg">
									@if ($ulo['updated_date'] == null)
										<label class="col-lg col-form-label">: - </label>
									@else
										<label class="col-lg col-form-label">:
											{{ $date_reformat->dateday_lang_reformat_long($ulo['updated_date']) }}</label>
									@endif
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Status Permohonan </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{ $ulo['kode_izin']['name_status_bo'] }}</label>

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
							<h6 class="card-title font-weight-semibold py-3">Informasi @if ($detailnib['jenis_pu'] != 'TKI')
									Perusahaan
								@else
									Instansi
								@endif
							</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<legend class="text-uppercase font-size-sm font-weight-bold">Data @if ($detailnib['jenis_pu'] != 'TKI')
							Perusahaan
						@else
							Instansi
						@endif
					</legend>
					<div class="form-group row">
						@if ($detailnib['jenis_pu'] != 'TKI')
							<div class="col-lg-6">
								<div class="row">
									<label class="col-lg-4 col-form-label">NIB </label>
									<div class="col-lg">
										<label class="col-lg col-form-label">: {{ $detailnib['nib'] }}</label>
									</div>
								</div>
							</div>
						@endif
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Nama </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{ $detailnib['nama_perseroan'] }}</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">NPWP </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{ $detailnib['npwp_perseroan'] }}</label>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">No Telp </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">:
										{{ $detailnib['nomor_telpon_perseroan'] }}</label>
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
										{{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }} </label>
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

		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Evaluasi Persyaratan</h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div>
					@csrf
					<input type="hidden" name="id_izin" value="{{ $izin['id_izin'] }}">
					@if (isset($izin['name_sk_izinprinsip']))
						<div class="form-group">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-12">
										<p class="font-weight-semibold">Salinan Izin Prinsip</p>
										<div class="input-group">
											<input disabled="disabled" type="text" class="form-control border-right-0"
												placeholder="SK_IzinPrinsip_{{ isset($izin['name_sk_izinprinsip']) ? $izin['name_sk_izinprinsip'] : '' }}">
											<span class="input-group-append">
												<?php 
                                                    if (isset($izin['path_sk_izinprinsip_final'])) {
                                                        ?><a target="_blank" href="{{ asset($izin['path_sk_izinprinsip_final']) }}"
													class="btn btn-teal" type="button">Lihat Dokumen</a>
												<?php
                                                    }else{
                                                        ?><a href="#" class="btn btn-teal" type="button">Lihat
													Dokumen</a>
												<?php
                                                    }
                                                    ?>
											</span>

										</div>
									</div>

								</div>
							</div>

						</div>
					@endif
					@if (count($map_izin) > 0)
						@foreach ($map_izin as $mi)
							@if ($mi->file_type == 'pdf')
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-12">
												<p class="font-weight-semibold">{!! $mi->persyaratan_html !!}</p>
												<div class="input-group">
													<input disabled="disabled" type="text" class="form-control border-right-0"
														placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : '' }}" disabled>
													<span class="input-group-append">
														<?php 
                                                    if (isset($mi->form_isian) && $mi->form_isian != '') {
                                                        ?><a target="_blank" href="{{ asset($mi->form_isian) }}" class="btn btn-teal"
															type="button">Lihat Dokumen</a><?php
                                                    }else{
                                                        ?><a href="#" class="btn btn-teal"
															type="button">Lihat
															Dokumen</a><?php
                                                    }
                                                    ?>
													</span>
												</div>
											</div>

										</div>
									</div>
								</div>
							@elseif($mi->file_type == 'table' && $mi->component_name != null)
								@if (isset($mi->form_isian))
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-12">
													<p class="font-weight-semibold">{!! $mi->persyaratan_html !!}</p>
													<x-dynamic-component :triger="null" :component="$mi->component_name" :datajson="$mi->form_isian ?? 'kosong'" :needcorrection="$mi->need_correction ?? ''"
														:correctionnote="$mi->correction_note ?? ''" />
												</div>
											</div>
										</div>
									</div>
								@endif
							@endif
						@endforeach
					@endif
				</div>

			</div>
		</div>

		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Catatan Disposisi </h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<form method="post" id="formDisposisi"
					action="{{ route('admin.koordinator.disposisiulopost', [$id, $ulo['id']]) }}">
					@csrf
					<div class="form-group row">
						<div class="col-lg-12">
							<fieldset>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Evaluator Sebelumnya </label>
									<div class="col-lg">
										<label class="col-lg-2 col-form-label">: {{ $ulo['evaluator_ulo_name'] }} </label>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="col-lg-12">
							<fieldset>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Disposisi ke </label>
									<div class="col-lg">
										<select name="id_user_disposisi" data-placeholder="Silakan Pilih" class="form-control ">
											<option>-- Silakan Pilih --</option>
											@if (count($user) > 0)
												@foreach ($user as $users)
													<option value="{{ $users['id'] }}">{{ $users['nama'] }} |
														{{ $users['short_desc'] }}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="form-group row" hidden>
									<textarea name="catatan" rows="3" cols="3" class="form-control" placeholder="Catatan Disposisi"></textarea>
								</div>
							</fieldset>
						</div>
					</div>
					<input type="hidden" id="id_izin" name="id_izin" value="{{ $id }}">
					<div class="text-right">
						<a href="{{ route('admin.koordinator') }}" class="btn btn-secondary border-transparent"><i
								class="icon-backward2 ml-2"></i> Kembali </a>
						<a target="_blank" href="{{ route('admin.historyperizinan', $ulo['id_izin']) }}" class="btn btn-info">Riwayat
							Permohonan <i class="icon-history ml-2"></i></a>
						<button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModal"
							class="btn btn-indigo">Kirim Disposisi <i class="icon-paperplane ml-2"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Kirim Disposisi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan mengirim disposisi ini ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitdisposisi();return false;"
						class="btn btn-primary notif-button">Kirim</button>
					<div class="spinner-border loading text-primary" role="status" hidden>
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="detailLog" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Informasi Riwayat Permohonan</h5>
					<hr />
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="modal-body-log">
					<?php
					?>
				</div>
			</div>
		</div>
	</div>

@endsection
@push('scripts')
	<script>
		var loadingSpinner = document.getElementById('loadingSpinner');

		function showLoadingSpinner() {
			// loadingSpinner.style.display = 'block';
			var spinner = document.getElementById('loadingSpinner');
			spinner.style.display = 'flex';
		}
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		function submitdisposisi() {
			showLoadingSpinner();
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			$('#formDisposisi').submit();
		}
	</script>
@endpush
