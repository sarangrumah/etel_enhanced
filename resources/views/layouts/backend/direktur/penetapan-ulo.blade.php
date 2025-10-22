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
	<div class="form-group">
		<h3>Penetapan Uji Laik Operasi</h3>
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
									<label class="col-lg col-form-label">: {{ $detailnib['nib'] }}</label>
								</div>
							</div>
						</div>
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

		<div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Uji Laik Operasi </h6>
						</div>
					</div>
				</div>
				<div class="card-body">

					<div>

						<input type="hidden" name="id_izin" value="{{ $ulo['id_izin'] }}">
						@if (count($map_izin) > 0)
							@foreach ($map_izin as $mi)
								@if ($mi->file_type == 'pdf' || $mi->file_type == 'integration')
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-12">
													<p class="font-weight-semibold">{{ $mi->persyaratan }}</p>
													<div class="input-group">
														<input disabled="disabled" type="text" class="form-control border-right-0"
															placeholder="{{ isset($mi->nama_asli) ? $mi->nama_asli : '' }}" disabled>
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

												{{-- <div class="col-lg-1 text-center">
									<p class="font-weight-semibold text-center" id="label{{$mi->id}}">Sesuai</p>
									<div
										class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
										<input type="checkbox" data="{{$mi->id}}" name="is_koreksi_dokumen_{{$mi->id}}"
											class="custom-control-input" id="c_upload_{{$mi->id}}">
										<label class="custom-control-label" for="c_upload_{{$mi->id}}"></label>
									</div>
								</div>
								<div class="col-lg-5">
									<p class="font-weight-semibold">Catatan</p>
									<!-- <t type="text" name="catatan_dokumen_{{$mi->id}}" class="form-control"> -->
									<textarea class="form-control disabled" id="catatan_dokumen_{{$mi->id}}"
										name="catatan_dokumen_{{$mi->id}}" rows="2" readonly></textarea>
								</div> --}}
											</div>
										</div>
									</div>
								@elseif($mi->file_type == 'table' && $mi->component_name != null)
									@if (isset($mi->form_isian))
										<div class="form-group">
											<div class="col-lg-12">
												<div class="row">
													<div class="col-12">
														<p class="font-weight-semibold">{{ $mi->persyaratan }}</p>
														<x-dynamic-component :triger="$triger ?? 'null'" :component="$mi->component_name" :datajson="$mi->form_isian" />
													</div>

													{{-- <div class="col-lg-1 text-center">
									<p class="font-weight-semibold text-center" id="label{{$mi->id}}">Sesuai</p>
									<div
										class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
										<input type="checkbox" data="{{$mi->id}}" name="is_koreksi_dokumen_{{$mi->id}}"
											class="custom-control-input" id="c_upload_{{$mi->id}}">
										<label class="custom-control-label" for="c_upload_{{$mi->id}}"></label>
									</div>
								</div>
								<div class="col-lg-5">
									<p class="font-weight-semibold">Catatan</p>
									<textarea class="form-control disabled" id="catatan_dokumen_{{$mi->id}}"
										name="catatan_dokumen_{{$mi->id}}" rows="2" readonly></textarea>
								</div> --}}
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

			<div>
				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Dokumen Uji Laik Operasi
								</h6>
							</div>
						</div>
					</div>
					<div class="card-body">

						<div class="form-group">
							<div class="col-lg-12">

								@if ($ulo['tipe_ulo'] == '1')
									<div class="row">
										<div class="col-12">
											<p class="font-weight-semibold">Dokumen Surat Permohonan Uji Laik Operasi</p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control border-right-0" placeholder="Dokumen"
													value="{{ isset($ulo['surat_permohonan_ulo_asli']) ? $ulo['surat_permohonan_ulo_asli'] : '' }}">
												<span class="input-group-append">
													<?php 
									if (isset($ulo['surat_permohonan_ulo']) && $ulo['surat_permohonan_ulo'] != '') {
										?><a target="_blank" href="{{ asset($ulo['surat_permohonan_ulo']) }}"
														class="btn btn-teal" type="button">Lihat Dokumen</a>
													<?php
									}else{
										?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a>
													<?php
									}
									?>
												</span>
											</div>
										</div>

									</div>
									<br />
								@else
									<div class="row">
										<div class="col-12">
											<p class="font-weight-semibold">Dokumen Surat Tugas Pelaksanaan Uji Laik
												Operasi
												Mandiri </p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control border-right-0" placeholder="Dokumen"
													value="{{ isset($ulo['surat_tugas_pelaksanaan_ulo_mandiri_asli']) ? $ulo['surat_tugas_pelaksanaan_ulo_mandiri_asli'] : '' }}">
												<span class="input-group-append">
													<?php 
									if (isset($ulo['surat_tugas_pelaksanaan_ulo_mandiri']) && $ulo['surat_tugas_pelaksanaan_ulo_mandiri'] != '') {
										?><a target="_blank" href="{{ asset($ulo['surat_tugas_pelaksanaan_ulo_mandiri']) }}"
														class="btn btn-teal" type="button">Lihat Dokumen</a>
													<?php
									}else{
										?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a>
													<?php
									}
									?>
												</span>
											</div>
										</div>

									</div>
									<br />
									<div class="row">
										<div class="col-12">
											<p class="font-weight-semibold">Dokumen Hasil Pengujian Uji Laik Operasi
												Mandiri</p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control border-right-0" placeholder="Dokumen"
													value="{{ isset($ulo['hasil_pengujian_ulo_mandiri_asli']) ? $ulo['hasil_pengujian_ulo_mandiri_asli'] : '' }}">
												<span class="input-group-append">
													<?php 
									if (isset($ulo['hasil_pengujian_ulo_mandiri']) && $ulo['hasil_pengujian_ulo_mandiri'] != '') {
										?><a target="_blank" href="{{ asset($ulo['hasil_pengujian_ulo_mandiri']) }}"
														class="btn btn-teal" type="button">Lihat Dokumen</a>
													<?php
									}else{
										?><a href="#" class="btn btn-teal" type="button">Lihat Dokumen</a>
													<?php
									}
									?>
												</span>
											</div>
										</div>
									</div>
								@endif

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Catatan Hasil Evaluasi</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					@if ($ulo['nama_master_izin'] == 'TELSUS' || $ulo['nama_master_izin'] == 'TELSUS_INSTANSI')
						{{-- <div class="form-group">
                            <label for="MediaTransmisiYangDigunakan">Media Transmisi yang Digunakan </label>
                            <textarea class="form-control" readonly rows="3">{{ $ulo['media_transmisi_yang_digunakan'] }}</textarea>
                        </div> --}}
					@else
						<div class="form-group">
							<label for="alamatPusatLayananPelangan">Alamat Pusat Layanan Pelanggan </label>
							<textarea class="form-control" id="alamatPusatLayananPelangan" readonly rows="3">{{ $ulo['alamat_pusat_layanan_pelangan'] }}</textarea>
						</div>
					@endif
					<div class="form-group">
						<label for="AlamatPelaksanaanUlo">Alamat Pelaksanaan ULO</label>
						<textarea class="form-control" id="AlamatPelaksanaanUlo" readonly rows="3">{{ $ulo['alamat_pelaksanaan_ulo'] }}</textarea>
					</div>
					<div class="form-group">
						<label for="TanggalEvaluasiPelaksanaanUlo">Tanggal Evaluasi Pelaksanaan ULO </label>
						<input type="text" class="form-control" readonly
							value="{{ date('d F Y', strtotime($ulo['tanggal_evaluasi_pelaksanaan_ulo'])) }}" placeholder="dd-mm-yyyy">
					</div>
					<div class="form-group">
						<label for="NoSuratPerintahTugas">No Surat Perintah Tugas (SPT) ULO </label>
						<input type="text" class="form-control" readonly value="{{ $ulo['no_surat_perintah_tugas'] }}">
					</div>
					<div class="form-group">
						<label for="TanggalSuratPerintahTugas">Tanggal Surat Perintah Tugas (SPT) ULO </label>
						<input type="text" class="form-control" readonly
							value="{{ date('d F Y', strtotime($ulo['tanggal_surat_perintah_tugas'])) }}" placeholder="dd-mm-yyyy">
					</div>
					<div class="form-group">
						<label for="uploadSuratPerintahTugas">Surat Perintah Tugas (SPT) ULO </label>
						<div class="input-group">

							<input disabled="disabled" type="text" class="form-control border-right-0" placeholder="Dokumen"
								value="{{ isset($ulo['upload_surat_perintah_tugas_asli']) ? $ulo['upload_surat_perintah_tugas_asli'] : '' }}">
							<span class="input-group-append">
								<?php 
				if (isset($ulo['upload_surat_perintah_tugas_asli']) && $ulo['upload_surat_perintah_tugas_asli'] != '') {
					?><a target="_blank" href="{{ url($ulo['upload_surat_perintah_tugas']) }}"
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

					<div class="form-group">
						<label for="DasarSuratPermohonanUlo">Dasar surat permohonan ULO dari perusahaan Pemohon ULO
						</label>
						<textarea class="form-control" readonly rows="3">{{ $ulo['dasar_surat_permohonan_ulo'] }}</textarea>
					</div>
					<div class="form-group">
						<label for="UploadDokumenHasilEvaluasiPelaksanaanUlo">Upload dokumen hasil evaluasi pelaksanaan ULO
						</label>
						<div class="input-group">
							<input disabled="disabled" type="text" class="form-control border-right-0" placeholder="Dokumen"
								value="{{ isset($ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli']) ? $ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli'] : '' }}">
							<span class="input-group-append">
								<?php 
				if (isset($ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli']) && $ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli'] != '') {
					?><a target="_blank" href="{{ url($ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo']) }}"
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

					<!-- <div class="form-group">
																																																<label for="status_laik">Status Laik</label>
																																																<select name="status_laik" id="status_laik" data-placeholder="Silakan Pilih" class="form-control">
																																																	<option value="1" <?= $ulo['status_laik'] == '1' ? 'selected' : '' ?>>Laik Operasi</option>
																																																	<option value="0" <?= $ulo['status_laik'] == '0' ? 'selected' : '' ?>>Tidak Laik Operasi</option>
																																																</select>
																																															</div> -->
					<div class="form-group">
						<label for="status_laik">Status Laik</label>
						@if ($ulo['status_laik'] == '1')
							<input type="text" class="form-control" disabled="disabled" value="Laik Operasi">
						@elseif($ulo['status_laik'] == '2')
							<input type="text" class="form-control" disabled="disabled" value="Tidak Operasi">
						@endif
					</div>
				</div>
			</div>

			<div>

				{{-- <div class="card-body"> --}}
				<form method="post" id="formEvaluasi"
					action="{{ route('admin.direktur.penetapanulopost', [$id, $ulo['id']]) }}">
					@csrf
					<input type="hidden" name="id_izin" value="{{ $ulo['id_izin'] }}">
					<div class="text-right">
						{{-- <button type="button" class="btn btn-secondary border-transparent"><i
								class="icon-backward2 ml-2"></i> Kembali </button> --}}
						<a href="{{ URL::previous() }}" class="btn btn-secondary border-transparent"><i
								class="icon-backward2 ml-2"></i> Kembali </a>
						<a target="_blank" href="{{ route('admin.historyperizinan', $ulo['id_izin']) }}" class="btn btn-info">Riwayat
							Permohonan <i class="icon-history ml-2"></i></a>

						@if ($ulo['nama_master_izin'] !== 'TELSUS')
							@if (isset($ulo['status_hasil_evaluasi']) && $ulo['kd_izin'] !== '059000020066')
								<a href="{{ route('admin.sk.draftkomitmen', $ulo['id_izin']) }}" target="_blank" class="btn btn-success">Draf
									Komitmen
									<i class="icon-file-pdf ml-2"></i></a>
							@endif
						@endif
						@if (isset($ulo['status_hasil_evaluasi']) && $ulo['kd_izin'] == '059000020066')
							<a href="{{ route('admin.sk.draftIzinPenyelenggaraan', [$ulo['id_izin']]) }}" target="_blank"
								class="btn btn-success">Preview Izin Penyelenggaraan
								<i class="icon-file-pdf ml-2"></i></a>
						@endif
						<a href="{{ route('admin.sk.draft', [$ulo['id_izin'], $ulo['id']]) }}" target="_blank"
							class="btn btn-success">Draf SKLO <i class="icon-file-pdf ml-2"></i></a>
						@if (isset($ulo['tgl_berlaku_ulo']))
							<a href="{{ route('admin.sk.cetakSKUlo', [$ulo['id_izin'], $ulo['id']]) }}" target="_blank"
								class="btn btn-success">Preview SKLO
								<i class="icon-file-pdf ml-2"></i></a>
						@endif
						@if ($ulo['nama_master_izin'] !== 'TELSUS' && $ulo['nama_master_izin'] !== 'TELSUS_INSTANSI')
							@if (isset($ulo['tgl_berlaku_ulo']))
								<a href="{{ route('admin.sk.cetakKomitmen', $ulo['id_izin']) }}" target="_blank"
									class="btn btn-success">Preview Komitmen
									<i class="icon-file-pdf ml-2"></i></a>
							@endif
						@endif
						<button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModal"
							class="btn btn-indigo">Penetapan SKLO</button>
					</div>
				</form>
				{{--
			</div> --}}
			</div>
		</div>

		<div class="modal" id="submitModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Kirim Persetujuan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Apakah anda yakin akan menyetujui Permohonan Uji Laik Operasi ini ?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="notif-button btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="button" onclick="submitdisposisi();return false;"
							class="notif-button btn btn-primary">Kirim</button>
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
			$(document).ready(function() {
				CKEDITOR.replace('alamatPusatLayananPelangan');
				CKEDITOR.replace('AlamatPelaksanaanUlo');

			})

			function submitdisposisi() {
				showLoadingSpinner();
				$('.notif-button').attr("hidden", true);
				$('.loading').attr("hidden", false);
				$('#formEvaluasi').submit();
			}
		</script>
	@endsection
