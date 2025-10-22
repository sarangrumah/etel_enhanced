@extends('layouts.frontend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
	<form method="post" id="formEvaluasi"
		action="{{ route('admin.evaluator.evaluasi-penomoran-post', [$id, $penomoran['id_kode_akses']]) }}"
		enctype="multipart/form-data">
		@csrf
		<div class="form-group">
			<!-- Section Detail Permohonan -->

			<input type="hidden" name="id_izin" value="{{ $penomoran['id_izin'] }}">
			<div>
				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Permohonan
									{{ isset($penomoran['jenis_permohonan']) ? $penomoran['jenis_permohonan'] : '' }}</h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group row">
							@if ($penomoran['status_badan_hukum'] != '03')
								<div class="col-lg-6">
									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Perizinan </label>
										<div class="col-lg-8">
											<input type="text" class="form-control"
												value="{{ isset($penomoran['jenis_izin']) ? $penomoran['jenis_izin'] : '' }}" disabled>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-4 col-form-label">KBLI</label>
										<div class="col-lg-8">
											<input type="text" class="form-control"
												value="{{ isset($penomoran['full_kbli']) ? $penomoran['full_kbli'] : '' }}" disabled>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Jenis Layanan </label>
										<div class="col-lg-8">
											<input type="text" class="form-control"
												value="{{ isset($penomoran['jenis_layanan']) ? $penomoran['jenis_layanan'] : '' }}" disabled>
										</div>
									</div>
								</div>
							@endif

							<div class="col-lg-6">
								@if ($penomoran['status_badan_hukum'] == '03')
									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Jenis Layanan </label>
										<div class="col-lg-8">
											<input type="text" class="form-control"
												value="{{ isset($penomoran['jenis_layanan']) ? $penomoran['jenis_layanan'] : '' }}" disabled>
										</div>
									</div>
								@endif
								<div class="form-group row">
									<label class="col-lg-4 col-form-label">Jenis Penomoran</label>
									<div class="col-lg-8">
										<input type="text" class="form-control"
											value="{{ isset($penomoran['kode_akses']['jeniskodeakses']['full_name'])
											    ? $penomoran['kode_akses']['jeniskodeakses']['full_name']
											    : $penomoran['jenis_kode_akses'] }}"
											disabled>
									</div>
								</div>

								@if ($penomoran['jenis_kode_akses'] == 'Blok Nomor')
									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Daftar Blok Nomor </label>
										<div class="col-lg-8" id="PilihKodeWilayah">
											<table class="table table-custom table-sm">
												<thead>
													<tr>
														<th style="border-top: none;background: #fafafa;text-align: center;">
															Wilayah Penomoran</th>

														<th style="border-top: none;background: #fafafa;text-align: center;">
															Blok Nomor
														</th>
													</tr>

												</thead>
												<tbody id="bloknomor-lists">
													@foreach ($penomoran_bloknomor as $item)
														<tr class="bloknomor-item">
															<td style="width: 60%;">
																<div class="font-size-sm">
																	{{ $item['kode_wilayah'] }} -
																	{{ $item['nama_wilayah'] }}
																</div>
															</td>
															<td style="width: 30%;">
																<div class="font-size-sm">
																	{{ $item['prefix_awal'] }}
																</div>
															</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								@else
									<div class="form-group row">
										<label class="col-lg-4 col-form-label">Kode Akses </label>
										<div class="col-lg-8">
											<input type="text" class="form-control"
												value="{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}"
												disabled>
											{{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}</label> --}}
										</div>
									</div>
									@if (
										$penomoran['jenis_permohonan'] == 'Perubahan Penetapan' ||
											$penomoran['jenis_permohonan'] == 'Pengembalian Penomoran')
										{{-- <div class="col-lg-6"> --}}
										<div class="form-group row">
											<label class="col-lg-4 col-form-label">No SK Penetapan </label>
											<div class="col-lg-8">
												<input disabled="disabled" type="text" class="form-control border-right-0"
													placeholder="{{ $penomoran['pe_no_sk'] }}">
											</div>
										</div>
										{{-- </div> --}}
										{{-- <div class="col-lg-6"> --}}
										<div class="form-group row">
											<label class="col-lg-4 col-form-label">Tanggal Penetapan </label>
											<div class="col-lg-8">
												<input disabled="disabled" type="text" class="form-control border-right-0"
													placeholder="{{ $date_reformat->date_lang_reformat_long($penomoran['pe_date_sk']) }}">
											</div>
										</div>
										{{-- </div> --}}
									@endif
								@endif
							</div>
						</div>

					</div>
				</div>

			</div>
			<!-- End Section Detail Permohonan -->
			@if ($penomoran['jenis_permohonan'] !== 'Penetapan Nomor Baru')

				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Kelengkapan </h6>
							</div>
						</div>
					</div>
					<div class="card-body">

						@if ($penomoran['jenis_permohonan'] == 'Penetapan Nomor Tambahan')
							<div class="form-group ">
								<?php
								if (isset($penomoran['dok_pengguna_penomoran']) && $penomoran['dok_pengguna_penomoran'] !== '') {
								    $file = explode('/', $penomoran['dok_pengguna_penomoran']);
								    // $file4 = $_file4[3];
								} else {
								    $file4 = '';
								}
								// $file = explode('/', $penomoran['dok_pengguna_penomoran']);
								if (isset($penomoran['dok_izin_penyelenggaraan']) && $penomoran['dok_izin_penyelenggaraan'] !== '') {
								    $_file4 = explode('/', $penomoran['dok_izin_penyelenggaraan']);
								    $file4 = $_file4[3];
								} else {
								    $file4 = '';
								}
								
								$file4 = $file4;
								?>
								<div class="form-group row">
									@if (isset($penomoran['dok_izin_penyelenggaraan']) && $penomoran['dok_izin_penyelenggaraan'] != '')
										<div class="col-lg-6">
											<div class="row">
												<div class="col-12">
													<p class="font-weight-semibold">Dokumen Perizinan Berusaha
													</p>
													<div class="input-group">
														<input disabled="disabled" type="text" class="form-control border-right-0"
															placeholder="{{ $file4 }}">
														<span class="input-group-append">
															<a target="_blank" href="{{ asset($penomoran['dok_izin_penyelenggaraan']) }}" class="btn btn-teal"
																type="button">Lihat Dokumen</a>
														</span>
													</div>
												</div>
											</div>
										</div>
									@endif
									<div class="col-lg-6">
										<div class="row">
											<div class="col-12">
												<p class="font-weight-semibold">Laporan Penggunaan Penomoran Yang Pernah
													Ditetapkan</p>
												<div class="input-group">
													<input disabled="disabled" type="text" class="form-control border-right-0"
														placeholder="{{ $file[3] }}">
													<span class="input-group-append">
														<a target="_blank" href="{{ asset($penomoran['dok_pengguna_penomoran']) }}" class="btn btn-teal"
															type="button">Lihat Dokumen</a>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							@if (strtolower($penomoran['jenis_layanan']) == 'sertifikat penyelenggaraan jasa konten sms premium')
								<div
									class="form-group row <?= strtolower($penomoran['jenis_layanan']) == 'sertifikat penyelenggaraan jasa konten sms premium' ? 'd-blok' : 'd-none' ?>">
									<?php
									if (isset($penomoran['dok_kode_akses_konten'])) {
									    $_file2 = explode('/', $penomoran['dok_kode_akses_konten']);
									    $file2 = $_file2[3];
									} else {
									    $file2 = '';
									}
									
									$file2 = $file2;
									?>
									<div class="col-6">
										<div class="row">
											<div class="col-12">
												<p class="font-weight-semibold">Penjelasan Singkat (<i>Product Brief</i>)
													untuk Layanan Baru</p>
												<div class="input-group">
													<input disabled="disabled" type="text" class="form-control border-right-0"
														placeholder="{{ $file2 }}">
													<span class="input-group-append">
														<a target="_blank" href="{{ asset($penomoran['dok_kode_akses_konten']) }}" class="btn btn-teal"
															type="button">Lihat Dokumen</a>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endif

							@if (strtolower($penomoran['jenis_layanan_kode_izin']) == '059000000052')
								<div class="form-group row">
									<?php
									if (isset($penomoran['dok_call_center'])) {
									    $_file3 = explode('/', $penomoran['dok_call_center']);
									    $file3 = $_file3[3];
									} else {
									    $file3 = '';
									}
									
									$file3 = $file3;
									
									if (isset($penomoran['dok_izin_penyelenggaraan'])) {
									    $_file4 = explode('/', $penomoran['dok_izin_penyelenggaraan']);
									    $file4 = $_file4[3];
									} else {
									    $file4 = '';
									}
									
									$file4 = $file4;
									
									?>
									<div class="col-6">
										<div class="row">
											<div class="col-12">
												<p class="font-weight-semibold">Surat dukungan dari calon pengguna untuk
													pengajuan kode
													akses call center</p>
												<div class="input-group">
													<input disabled="disabled" type="text" class="form-control border-right-0"
														placeholder="{{ $file3 }}">
													<span class="input-group-append">
														<a target="_blank" href="{{ asset($penomoran['dok_call_center']) }}" class="btn btn-teal"
															type="button">Lihat Dokumen</a>
													</span>
												</div>
											</div>

										</div>
									</div>
								</div>
							@endif
						@elseif(strtolower($penomoran['jenis_permohonan']) == 'pengembalian penomoran')
							<div class="row">
								<?php
								$file_sk = explode('/', $penomoran['pe_dok_sk']);
								?>
								<div class="col-6">
									{{-- <div class="col-lg-12 row">
                                        <div class="col-lg-4 form-group">
                                            <label class="col-form-label">No SK Penetapan </label>
                                        </div>
                                        <div class="col-lg-8 form-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ $penomoran['pe_no_sk'] }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 row">
                                        <div class="col-lg-4 form-group">
                                            <label class="col-form-label">Tanggal Penetapan </label>
                                        </div>
                                        <div class="col-lg-8 form-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ $date_reformat->date_lang_reformat_long($penomoran['pe_date_sk']) }}">
                                        </div>
                                    </div> --}}
									<div class="col-lg-12 row">
										<div class="col-lg-4 form-group">
											<label class="col-form-label">SK Penetapan Penomoran </label>
										</div>
										<div class="col-lg-8 form-group">
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control border-right-0"
													placeholder="{{ $file_sk[3] }}">
												<span class="input-group-append">
													<a target="_blank" href="{{ asset($penomoran['pe_dok_sk']) }}" class="btn btn-teal"
														type="button">Lihat Dokumen</a>
												</span>
											</div>
										</div>
									</div>

								</div>
								<div class="col-6">
									<div class="form-group">
										<label class="col-lg-6 col-form-label">Alasan Pengembalian </label>
									</div>
									<div class="form-group row">
										<div class="col-lg-12">
											<textarea disabled="disabled" rows="4" cols="3" class="form-control" id="ReasonRemoval_SK"
											 placeholder="{{ $penomoran['note'] }}" name="ReasonRemoval_SK" required></textarea>
										</div>
									</div>
								</div>
							</div>
						@elseif($penomoran['jenis_permohonan'] == 'Perubahan Penetapan')
							<div class="form-group">
								<div class="col-lg-12">
									{{-- <div class="col-lg-12 row">
                                        <div class="col-lg-4 form-group">
                                            <label class="col-form-label">No SK Penetapan </label>
                                        </div>
                                        <div class="col-lg-8 form-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ $penomoran['pe_no_sk'] }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 row">
                                        <div class="col-lg-4 form-group">
                                            <label class="col-form-label">Tanggal Penetapan </label>
                                        </div>
                                        <div class="col-lg-8 form-group">
                                            <input disabled="disabled" type="text" class="form-control border-right-0"
                                                placeholder="{{ $date_reformat->date_lang_reformat_long($penomoran['pe_date_sk']) }}">
                                        </div>
                                    </div> --}}
									<div class="row">
										<div class="col-6">
											<p class="font-weight-semibold">SK Penetapan Penomoran yang disesuaikan</p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control border-right-0"
													placeholder="{{ isset($penomoran['pe_dok_sk']) ? $penomoran['pe_dok_sk'] : '' }}">
												<span class="input-group-append">
													<a target="_blank" href="{{ asset($penomoran['pe_dok_sk']) }}" class="btn btn-teal"
														type="button">Lihat Dokumen</a>
												</span>
											</div>
										</div>

										{{-- <div class="col-lg-1 text-center">
                                        <p class="font-weight-semibold text-center" id="label4">Sesuai</p>
                                        <div
                                            class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                            <input type="checkbox" data="4" name="is_koreksi_dokumen_4"
                                                class="custom-control-input" id="c_upload_4">
                                            <label class="custom-control-label" for="c_upload_4"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <p class="font-weight-semibold">Catatan</p>
                                        <textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_4" name="catatan_pe_dok_sk"
                                            rows="2" readonly></textarea>
                                    </div> --}}
									</div>
								</div>
							</div>

							@if (isset($penomoran['pe_dok_perizinan_terakhir']) && $penomoran['pe_dok_perizinan_terakhir'] != '')
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-6">
												<p class="font-weight-semibold">Dokumen Perizinan Terakhir</p>
												<div class="input-group">
													<input disabled="disabled" type="text" class="form-control border-right-0"
														placeholder="{{ isset($penomoran['pe_dok_perizinan_terakhir']) ? $penomoran['pe_dok_perizinan_terakhir'] : '' }}">
													<span class="input-group-append">
														<a target="_blank" href="{{ asset($penomoran['pe_dok_perizinan_terakhir']) }}" class="btn btn-teal"
															type="button">Lihat Dokumen</a>
													</span>
												</div>
											</div>
											{{-- <div class="col-lg-1 text-center">
                                        <p class="font-weight-semibold text-center" id="label5">Sesuai</p>
                                        <div
                                            class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                                            <input type="checkbox" data="5" name="is_koreksi_dokumen_5"
                                                class="custom-control-input" id="c_upload_5">
                                            <label class="custom-control-label" for="c_upload_5"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <p class="font-weight-semibold">Catatan</p>
                                        <textarea class="form-control disabled koreksi-catatan" id="catatan_dokumen_5"
                                            name="catatan_pe_dok_perizinan_terakhir" rows="2" readonly></textarea>
                                    </div> --}}
										</div>
									</div>
								</div>
							@endif

							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-6">
											<p class="font-weight-semibold">Dokumen Pendukung Lainnya</p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control border-right-0"
													placeholder="{{ isset($penomoran['pe_dok_pendukung']) ? $penomoran['pe_dok_pendukung'] : '' }}">
												<span class="input-group-append">
													<a target="_blank" href="{{ asset($penomoran['pe_dok_pendukung']) }}" class="btn btn-teal"
														type="button">Lihat Dokumen</a>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>

							<hr class="" />
						@endif

					</div>
				</div>
			@endif

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Riwayat Permohonan</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					@include('layouts/backend/historyperizinan/historypenomoran_nonote', [
						'history_penomoran' => $penomoranlog,
					])
				</div>
			</div>

			<div class="form-group text-right">
				<a href="{{ url('/') }}" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i>
					Kembali </a>
				{{-- <a href="{{ route('admin.sk.draftpenomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}"
                    target="_blank" class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a>
                <!-- <a target="_blank" href="{{ route('admin.historyperizinan', $penomoran['id_izin']) }}" class="btn btn-info">Riwayat Permohonan </a> -->
                <button type="button" id="" data-target="#submitModal" data-toggle="modal"
                    class="btn btn-indigo">Kirim
                    Evaluasi <i class="icon-paperplane ml-2"></i></button> --}}
			</div>
		</div>

		{{-- <div class="modal" id="submitModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kirim Evaluasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin akan mengirim evaluasi ini ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSubmit" onclick="submitdisposisi();return false;"
                            class="btn btn-primary notif-button">Kirim</button>
                        <div class="spinner-border loading text-primary" role="status" hidden>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
		{{-- <div class="modal" id="submitModalKoreksi" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kirim Perbaikan Evaluasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-warning">Apakah anda yakin akan mengirim perbaikan evaluasi ini ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSubmitKoreksi" onclick="submitdisposisiTolak();return false;"
                            class="btn btn-primary notif-button">Kirim</button>
                        <div class="spinner-border loading text-primary" role="status" hidden>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

	</form>

	{{-- <script>
        function submitdisposisi() {
            if ($('#status_sk').val() == 0 && $('#catatan_hasil_evaluasi').val() == '') {
                $('#submitModal').modal('toggle');
                alert('Silakan mengisi catatan hasil evaluasi');
            } else {
                $('#formEvaluasi').submit();
                $('.notif-button').attr("hidden", true);
                $('.loading').attr("hidden", false);
                $('#formEvaluasi').submit();
                $("#btnSubmit").attr("disabled", true);
                $("#btnSubmitKoreksi").attr("disabled", true);
            }
        }

        function submitdisposisiTolak() {
            $('#formEvaluasiTolak').submit();
        }
    </script> --}}
	{{-- <script type="text/javascript">
        $(document).ready(function() {

            $("#btnSubmitModalKoreksi").hide();
            $("#btnSubmitModal").show();

            function CekChek() {
                let yourArray = []
                $("input:checkbox[class=custom-control-input]:checked").each(function() {
                    yourArray.push($(this).val());
                });
                // console.log(yourArray)
                if (yourArray.length > 1) {
                    $("#btnSubmitModalKoreksi").show();
                    $("#btnSubmitModal").hide();

                    // $("#submitModalKoreksi").modal("show");
                } else {

                    $("#btnSubmitModal").show();
                    $("#btnSubmitModalKoreksi").hide();

                    // $("#submitModal").modal("show");
                }
            }

            $('#formEvaluasi').on('change', ':checkbox', function() {

                // CekChek();
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

            $('#status_sk').change(function() {
                let status_sk = $('#status_sk').val();
                if (status_sk == 0) {

                } else {

                }
            })
        });
    </script> --}}
@endsection
