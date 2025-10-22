@extends('layouts.backend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="//cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
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
	<form method="post" id="formEvaluasi" action="{{ route('admin.koordinator.evaluasipost', $id) }}">
		<div class="form-group">
			<!-- Section Detail Permohonan -->
			<h3>Evaluasi Persyaratan</h3>
			<hr />

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
										<label class="col-lg col-form-label">: {{ $izin['id_izin'] }}</label>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<label class="col-lg-4 col-form-label">Jenis Permohonan </label>
									<div class="col-lg">
										<label class="col-lg col-form-label">: {!! $izin['jenis_layanan_html'] !!}</label>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<div class="row">
									<label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
									<div class="col-lg">
										@if ($izin['submitted_at'] == null)
											<label class="col-lg col-form-label">: - </label>
										@else
											<label class="col-lg col-form-label">:
												{{ $date_reformat->dateday_lang_reformat_long($izin['submitted_at']) }}</label>
										@endif
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<label class="col-lg-4 col-form-label">Status Permohonan </label>
									<div class="col-lg">
										<label class="col-lg col-form-label">: {{ $izin['status_bo'] }}</label>
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

			<!-- Section Previous Izin -->

			@if ($izin['kd_izin'] == '059000030066' || $izin['kd_izin'] == '059000020066')
				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Pemenuhan Persyaratan Izin Prinsip</h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div>
							@csrf
							<input type="hidden" name="id_izin" value="{{ $izin['id_izin'] }}">
							@if (count($map_izin_pre) > 0)
								@foreach ($map_izin_pre as $mi_pre)
									@if ($mi_pre->file_type == 'pdf')
										@if (isset($mi->form_isian))
											<div class="form-group">
												<div class="col-lg-12">
													<div class="row">
														<div class="col-12">
															<p class="font-weight-semibold">{!! $mi_pre->persyaratan_html !!}</p>
															<div class="input-group">
																<input disabled="disabled" type="text" class="form-control border-right-0"
																	placeholder="{{ isset($mi_pre->nama_asli) ? $mi_pre->nama_asli : '' }}">
																<span class="input-group-append">
																	<?php 
                                            if (isset($mi_pre->form_isian) && $mi_pre->form_isian != '') {
                                                ?><a target="_blank" href="{{ asset($mi_pre->form_isian) }}" class="btn btn-teal"
																		type="button">Lihat Dokumen</a>
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
									@elseif($mi_pre->file_type == 'table' && $mi_pre->component_name != null)
										@if (isset($mi_pre->form_isian))
											<p class="font-weight-bold">{!! $mi_pre->persyaratan_html !!}</p>
											<x-dynamic-component :component="$mi_pre->component_name" :triger="$triger ?? 'null'" :datajson="$mi_pre->form_isian ?? 'kosong'" :needcorrection="$mi_pre->need_correction ?? ''"
												:correctionnote="$mi_pre->correction_note ?? ''" />
											<hr>
										@endif
									@elseif($mi_pre->file_type == 'integration')
										@if ($mi_pre->is_mandatory == '1')
											<p class="font-weight-semibold">{{ $mi_pre->persyaratan }}</p>
											<?php
											if ($mi_pre->form_isian) {
											    $datajson = json_decode($mi_pre->form_isian, true)[0];
											}
											?>
											@if (isset($datajson))
												<table class="table">
													@foreach ($datajson as $key => $d)
														<tr>
															<td width="30">{{ ucwords(str_replace('_', ' ', $key)) }}
															</td>
															<td>{{ $d }}</td>
														</tr>
													@endforeach
												</table>
												@php
													$datajson = '';
												@endphp
											@else
												<p>Data Kosong!</p>
											@endif
											<hr>
										@else
											<div class="form-group">
												<div class="col-lg-12">
													<div class="row">
														<div class="col-12">
															{{-- <p class="font-weight-semibold">Surat Pernyataan Tidak Menggunakan --}}
															<p class="font-weight-semibold">
																{!! $mi_pre->persyaratan_html !!}</p>
															<div class="input-group">
																<input disabled="disabled" type="text" class="form-control border-right-0"
																	placeholder="{{ isset($mi_pre->nama_asli) ? $mi_pre->nama_asli : '' }}">
																<span class="input-group-append">
																	<?php 
                                            if (isset($mi_pre->form_isian) && $mi_pre->form_isian != '') {
                                                ?><a target="_blank" href="{{ asset($mi_pre->form_isian) }}" class="btn btn-teal"
																		type="button">Lihat
																		Dokumen</a>
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
									@endif
								@endforeach
							@endif
						</div>

					</div>
				</div>
			@endif

			<!-- End Section Previous Izin -->

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Evaluasi Persyaratan </h6>
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
										<div class="col-6">
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
									@if (isset($mi->form_isian))
										<div class="form-group">
											<div class="col-lg-12">
												<div class="row">
													<div class="col-6">
														<p class="font-weight-semibold">{!! $mi->persyaratan_html !!}</p>
														<div class="input-group">
															<input disabled="disabled" type="text" class="form-control border-right-0"
																placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : '' }}">
															<span class="input-group-append">
																<?php 
                                                    if (isset($mi->form_isian) && $mi->form_isian != '') {
                                                        ?><a target="_blank" href="{{ asset($mi->form_isian) }}" class="btn btn-teal"
																	type="button">Lihat Dokumen</a>
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

													{{-- <div class="col-lg-1 text-center"> --}}
													@if ($mi->need_correction)
														<div class="col-lg-1 text-center">
															<p class="font-weight-semibold text-center" id="label{{ $mi->id }}">Tidak Sesuai</p>
															<div
																class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
																<input type="checkbox" data="{{ $mi->id }}" name="is_koreksi_dokumen_{{ $mi->id }}"
																	class="custom-control-input" id="c_upload_{{ $mi->id }}" checked>
																<label class="custom-control-label" for="c_upload_{{ $mi->id }}"></label>
															</div>
														</div>
														<div class="col-lg-5">
															<p class="font-weight-semibold">Catatan</p>
															<textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_{{ $mi->id }}"
															 name="catatan_dokumen_{{ $mi->id }}" rows="2" readonly>{!! $mi->correction_note !!}</textarea>
														</div>
													@else
														<div class="col-lg-1 text-center">
															<p class="font-weight-semibold text-center" id="label{{ $mi->id }}">Sesuai</p>
															<div
																class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
																<input type="checkbox" data="{{ $mi->id }}" name="is_koreksi_dokumen_{{ $mi->id }}"
																	class="custom-control-input" id="c_upload_{{ $mi->id }}">
																<label class="custom-control-label" for="c_upload_{{ $mi->id }}"></label>
															</div>
														</div>
														<div class="col-lg-5">
															<p class="font-weight-semibold">Catatan</p>
															<textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_{{ $mi->id }}"
															 name="catatan_dokumen_{{ $mi->id }}" rows="2" readonly></textarea>
														</div>
													@endif
													{{-- </div> --}}
													{{-- <div class="col-lg-5">
                                                    <p class="font-weight-semibold">Catatan</p>
                                                    <textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_{{ $mi->id }}"
                                                        name="catatan_dokumen_{{ $mi->id }}" rows="2" readonly></textarea>
                                                </div> --}}
												</div>
											</div>
										</div>
									@endif
								@elseif($mi->file_type == 'table' && $mi->component_name != null)
									@if (isset($mi->form_isian))
										<hr>
										<p class="font-weight-semibold">{!! $mi->persyaratan_html !!}</p>
										<x-dynamic-component :triger="$triger ?? 'null'" :component="$mi->component_name" :datajson="$mi->form_isian ?? 'kosong'" :needcorrection="$mi->need_correction ?? ''"
											:correctionnote="$mi->correction_note ?? ''" />
										<div class="row mt-4 mb-4">
											@if ($mi->need_correction)
												<div class="col-lg-1 text-center">
													<p class="font-weight-semibold text-center" id="label{{ $mi->id }}">Tidak Sesuai</p>
													<div
														class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
														<input type="checkbox" data="{{ $mi->id }}" name="is_koreksi_dokumen_{{ $mi->id }}"
															class="custom-control-input" id="c_upload_{{ $mi->id }}" checked>
														<label class="custom-control-label" for="c_upload_{{ $mi->id }}"></label>
													</div>
												</div>
												<div class="col-lg-11">
													<p class="font-weight-semibold">Catatan</p>
													<textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_{{ $mi->id }}"
													 name="catatan_dokumen_{{ $mi->id }}" rows="2" readonly>{!! $mi->correction_note !!}</textarea>
												</div>
											@else
												<div class="col-lg-1 text-center">
													<p class="font-weight-semibold text-center" id="label{{ $mi->id }}">Sesuai</p>
													<div
														class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
														<input type="checkbox" data="{{ $mi->id }}" name="is_koreksi_dokumen_{{ $mi->id }}"
															class="custom-control-input" id="c_upload_{{ $mi->id }}">
														<label class="custom-control-label" for="c_upload_{{ $mi->id }}"></label>
													</div>
												</div>
												<div class="col-lg-11">
													<p class="font-weight-semibold">Catatan</p>
													<textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_{{ $mi->id }}"
													 name="catatan_dokumen_{{ $mi->id }}" rows="2" readonly></textarea>
												</div>
											@endif

										</div>
										<hr>
									@endif
								@elseif($mi->file_type == 'integration')
									@if ($mi->is_mandatory == '1')
										<p class="font-weight-semibold">{{ $mi->persyaratan }}</p>
										<?php
										if ($mi->form_isian) {
										    $datajson = json_decode($mi->form_isian, true)[0];
										}
										?>
										@if (isset($datajson))
											<table class="table">
												@foreach ($datajson as $key => $d)
													<tr>
														<td width="30">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
														<td>{{ $d }}</td>
													</tr>
												@endforeach
											</table>
											@php
												$datajson = '';
											@endphp
										@else
											<p>Data Kosong!</p>
										@endif
									@else
										<div class="form-group">
											<div class="col-lg-12">
												<div class="row">
													<div class="col-6">
														{{-- <p class="font-weight-semibold">Surat Pernyataan Tidak Menggunakan --}}
														<p class="font-weight-semibold">
															{!! $mi->persyaratan_html !!}</p>
														<div class="input-group">
															<input disabled="disabled" type="text" class="form-control border-right-0"
																placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : '' }}">
															<span class="input-group-append">
																<?php 
                                                    if (isset($mi->form_isian) && $mi->form_isian != '') {
                                                        ?><a target="_blank" href="{{ asset($mi->form_isian) }}" class="btn btn-teal"
																	type="button">Lihat Dokumen</a>
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

													@if ($mi->need_correction)
														<div class="col-lg-1 text-center">
															<p class="font-weight-semibold text-center" id="label{{ $mi->id }}">Tidak Sesuai</p>
															<div
																class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
																<input type="checkbox" data="{{ $mi->id }}" name="is_koreksi_dokumen_{{ $mi->id }}"
																	class="custom-control-input" id="c_upload_{{ $mi->id }}" checked>
																<label class="custom-control-label" for="c_upload_{{ $mi->id }}"></label>
															</div>
														</div>
														<div class="col-lg-5">
															<p class="font-weight-semibold">Catatan</p>
															<textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_{{ $mi->id }}"
															 name="catatan_dokumen_{{ $mi->id }}" rows="2" readonly>{!! $mi->correction_note !!}</textarea>
														</div>
													@else
														<div class="col-lg-1 text-center">
															<p class="font-weight-semibold text-center" id="label{{ $mi->id }}">Sesuai</p>
															<div
																class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
																<input type="checkbox" data="{{ $mi->id }}" name="is_koreksi_dokumen_{{ $mi->id }}"
																	class="custom-control-input" id="c_upload_{{ $mi->id }}">
																<label class="custom-control-label" for="c_upload_{{ $mi->id }}"></label>
															</div>
														</div>
														<div class="col-lg-5">
															<p class="font-weight-semibold">Catatan</p>
															<textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_{{ $mi->id }}"
															 name="catatan_dokumen_{{ $mi->id }}" rows="2" readonly></textarea>
														</div>
													@endif
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
							<h6 class="card-title font-weight-semibold py-3">Catatan Hasil Evaluasi </h6>
						</div>
					</div>
				</div>
				<div class="card-body">

					<div class="form-group row">
						<div class="col-lg-12">
							<fieldset>
								<textarea rows="3" cols="3" class="form-control" placeholder="Hasil Evaluasi"
								 id="catatan_hasil_evaluasi" name="catatan_hasil_evaluasi"></textarea>
							</fieldset>
						</div>
					</div>

				</div>
			</div>

			<div class="text-right">
				<a type="button" href="{{ route('admin.koordinator') }}" class="btn btn-secondary border-transparent"><i
						class="icon-backward2 ml-2"></i> Kembali </a>
				<a target="_blank" href="{{ route('admin.historyperizinan', $izin['id_izin']) }}" class="btn btn-info">Riwayat
					Permohonan <i class="icon-history ml-2"></i></a>
				{{-- @if ($mi->need_correction)
                    <button type="button" id="btnSubmitModal" data-target="#submitModal" data-toggle="modal"
                        class="btn btn-indigo">Tolak Persyaratan <i class="icon-paperplane ml-2"></i></button>
                @else
                    <button type="button" id="btnSubmitModal" data-target="#submitModal" data-toggle="modal"
                        class="btn btn-indigo">Setujui Persyaratan <i class="icon-paperplane ml-2"></i></button>
                @endif
                <button type="button" id="btnSubmitModalKoreksi" data-toggle="modal" data-target="#submitModalKoreksi"
                    class="btn btn-warning">Kirim Evaluasi Perbaikan <i class="icon-paperplane ml-2"></i></button> --}}

				@if ($izin['kd_izin'] == '059000010066')
					<a href="{{ route('admin.sk.draftIzinPrinsip', [$izin['id_izin']]) }}" target="_blank"
						class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a>
				@elseif ($izin['kd_izin'] == '059000030066')
					<a href="{{ route('admin.sk.draftIzinPerpanjangan', [$izin['id_izin']]) }}" target="_blank"
						class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a>
				@elseif ($izin['kd_izin'] == '059000040066')
					<a href="{{ route('admin.sk.draftIzinPencabutan', [$izin['id_izin']]) }}" target="_blank"
						class="btn btn-success">Draf Penetapan Pencabutan <i class="icon-file-pdf ml-2"></i></a>
				@endif
				<button type="button" id="btnSubmitModalKoreksi" data-toggle="modal" data-target="#submitModalKoreksi"
					class="btn btn-warning">
					@if ($detailnib['jenis_pu'] != 'TKI')
						Kirim Evaluasi Perbaikan
					@else
						Kirim Rekomendasi Penolakan
					@endif <i class="icon-paperplane ml-2"></i>
				</button>
				{{-- @else --}}
				<button type="button" id="btnSubmitModal" data-target="#submitModal" data-toggle="modal"
					class="btn btn-indigo">Kirim Evaluasi <i class="icon-paperplane ml-2"></i></button>
				{{-- @endif --}}

			</div>
		</div>

	</form>

	<form method="post" id="formPenolakan" action="{{ route('admin.koordinator.evaluasipost.penolakan', $id) }}">
		<!-- Form penolakan -->
		@csrf
		<input type="hidden" name="is_penolakan" value="1">
		<input type="hidden" id="catatan_evaluasi_penolakan" name="catatan_evaluasi">

	</form>
	<input type="hidden" id="id_izin" name="id_izin" value="{{ $id }}">

	<div class="modal" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Kirim Hasil Evaluasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan mengirim hasil evaluasi permohonan ini ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitevaluasi();return false;"
						class="btn btn-primary notif-button">Kirim</button>
					<div class="spinner-border loading text-primary" role="status" hidden>
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="submitModalKoreksi" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">
						@if ($detailnib['jenis_pu'] != 'TKI')
							Kirim Perbaikan Evaluasi
						@else
							Kirim Rekomendasi Penolakan
						@endif
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="text-warning">
						@if ($detailnib['jenis_pu'] != 'TKI')
							Apakah anda yakin akan mengirim perbaikan evaluasi ini ?
						@else
							Apakah anda yakin akan mengirim rekomendasi penolakan ?
						@endif
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitdisposisi();return false;" class="btn btn-primary">Kirim</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="penolakanModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Tolak Persyaratan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan menolak permohonan izin ini ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitpenolakan();return false;"
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
	<script type="text/javascript">
		$(document).ready(function() {

			var need_correction_all = parseInt(@json($need_correction_all));
			if (need_correction_all === 1) {

				// alert(need_correction_all);
				$("#btnSubmitModalKoreksi").show();
				$("#btnSubmitModal").hide();

			} else {

				// alert('need_correction_all');
				$("#btnSubmitModalKoreksi").hide();
				$("#btnSubmitModal").show();

			}
			CKEDITOR.replace('catatan_hasil_evaluasi');


			function CekChek() {
				let yourArray = []
				$("input:checkbox[class=custom-control-input]:checked").each(function() {
					yourArray.push($(this).val());
				});
				if (yourArray.length > 1) {
					$("#btnSubmitModalKoreksi").show();
					$("#btnSubmitModal").hide();

				} else {

					$("#btnSubmitModal").show();
					$("#btnSubmitModalKoreksi").hide();
				}
			}


			$('#formEvaluasi').on('change', ':checkbox', function() {
				CekChek();
				var id = $(this).attr('data');
				if ($(this).is(':checked')) {
					$("#label" + id).html("Tidak Sesuai")
					$("#catatan_dokumen_" + id).attr("readonly", false);
					$("#catatan_dokumen_" + id).focus();

				} else {
					$("#label" + id).html("Sesuai")
					$("#catatan_dokumen_" + id).attr("readonly", true);
					$("#catatan_dokumen_" + id).val("");
					setValue();
				}
			});

			function setValue() {
				const vall = [];
				var inputs = $(".koreksi-catatan");
				for (var i = 0; i < inputs.length; i++) {
					if ($(inputs[i]).val() !== '') {
						vall.push($(inputs[i]).val().replace(",", "^"))
					}
				}
				FsetValue(vall.toString());
			}

			$('.koreksi-catatan').on("input", function() {
				const vall = [];
				var inputs = $(".koreksi-catatan");
				for (var i = 0; i < inputs.length; i++) {
					if ($(inputs[i]).val() !== '') {
						vall.push($(inputs[i]).val().replace(",", "^"))
					}
				}
				FsetValue(vall.toString());

			});

			function FsetValue(val) {
				var a = val.split(",")
				var x = a.toString().replace(/,/g, "</br>");
				// $("#catatan_hasil_evaluasi").val(x.replace("^", ","));
				CKEDITOR.instances.catatan_hasil_evaluasi.setData(x.replace("^", ","));
			}
		});
	</script>
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

		function submitevaluasi() {
			showLoadingSpinner();
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			$('#formEvaluasi').submit();
		}

		function submitdisposisi() {
			showLoadingSpinner();
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			$('#formEvaluasi').submit();
		}

		function submitpenolakan() {
			showLoadingSpinner();
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			$('#catatan_evaluasi_penolakan').val($('#catatan_evaluasi').val());
			$('#formPenolakan').submit();
		}
	</script>
@endpush
