@extends('layouts.frontend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
	<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
@endsection

@section('content')
	<div id="loadingSpinner" class="loading-spinner" style="display: none;">
		<img id="spinnerImage" src="/assets/kominfo/spinner-kominfo-trp.svg" alt="Loading Spinner">
	</div>
	<style>
		.no-margin {
			margin-bottom: 0;
		}

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
	<form action="{{ route('survei.post') }}" method="post" id="formSurvei">
		@csrf
		{{-- <div class="content-wrapper"> --}}
		{{-- <div class="content-inner"> --}}
		<div class="content">
			<div>
				@if (Session::get('message') != '')
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>{{ Session::get('message') }}</strong>
					</div>
				@endif

				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3 text-center">PENDAHULUAN
								</h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div>
							<div style="text-align:center !important;"><img src="/global_assets/images/logo_kominfo.png"
									class="rounded-circle mr-xl-2" height="100" alt=""></div>
							<div class="col-lg-12">
								<h6 class="card-title font-weight-bold py-3 text-center">DIREKTORAT TELEKOMUNIKASI<br />
									DIREKTORAT JENDERAL PENYELENGGARAAN POS DAN INFORMATIKA<br />
									KEMENTERIAN KOMUNIKASI DAN INFORMATIKA

								</h6>
							</div>
							<div>&nbsp;</div>
							<div class="col-lg-12">
								<label class="col-form-label text-justify">
									{!! $survei_list_header->infsurveiinit !!}
								</label>
							</div>

						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Informasi Pelayanan
								</h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group row">
							<div class="col">
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">No Permohonan </label>
											<div class="col-lg-8">
												<input type="hidden" name="id_izin" id="id_izin" value="{{ $izin->id_izin }}">
												<input type="text" class="form-control" value="{{ $izin->id_izin }}" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
											<div class="col-lg-8">
												<input type="text" class="form-control"
													value="{{ $date_reformat->date_lang_reformat_long($izin->submitted_at) }}" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Tanggal Penetapan </label>
											<div class="col-lg">
												<input type="hidden" name="tgl_izin" id="tgl_izin" value="{{ $izin->tgl_izin }}">
												<input type="text" class="form-control"
													value="{{ $date_reformat->date_lang_reformat_long($izin->tgl_izin) }}" disabled>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Jenis Penomoran </label>
											<div class="col-lg">
												<input type="text" class="form-control" value="{!! $izin->jenis_kode_akses_nonhtml !!}" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Kode Akses </label>
											<div class="col-lg">
												<input type="text" class="form-control" value="{{ $izin->kode_akses }}" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Evaluator </label>
											<div class="col-lg">
												<input type="text" class="form-control" value="{{ $izin->evaluator_name }}" disabled>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Data Responden
								</h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group row">
							<div class="col">
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-2">
												<label class="col-form-label">Usia </label>
											</div>
											<div class="col-lg-1">
												<input type="number" class="form-control" value="" name="responder_age" id="responder_age"
													required>
											</div>
											<div class="col-lg-2">
												<label class="col-form-label">Tahun </label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-2">
												<label class="col-form-label">Jenis Kelamin </label>
											</div>
											<div class="col-lg-8">
												<div class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="cr-i-l" id="rb_male" value="Laki-Laki" checked
														required>
													<label class="form-check-label" for="rb_male">Laki-Laki</label>
												</div>

												<div class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="cr-i-l" id="rb_female" value="Perempuan">
													<label class="form-check-label" for="rb_female" required>Perempuan</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-2">
												<label class="col-form-label">Pendidikan Terakhir </label>
											</div>

											<div class="col-lg-8">
												<div class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="cr_pendidikan" id="rb_sd" value="SD"
														checked>
													<label class="form-check-label" for="rb_sd">SD</label>
												</div>

												<div class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="cr_pendidikan" id="rb_smp" value="SMP"
														required>
													<label class="form-check-label" for="rb_smp">SMP</label>
												</div>
												<div class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="cr_pendidikan" id="rb_sma" value="SMA"
														required>
													<label class="form-check-label" for="rb_sma">SMA</label>
												</div>
												<div class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="cr_pendidikan" id="rb_d3" value="D3"
														required>
													<label class="form-check-label" for="rb_d3">D3</label>
												</div>
												<div class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="cr_pendidikan" id="rb_s1" value="S1"
														required>
													<label class="form-check-label" for="rb_s1">S1</label>
												</div>
												<div class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="cr_pendidikan" id="rb_s2" value="S2"
														required>
													<label class="form-check-label" for="rb_s2">S2</label>
												</div>
												<div class="form-check form-check-inline">
													<input type="radio" class="form-check-input" name="cr_pendidikan" id="rb_s3" value="S3"
														required>
													<label class="form-check-label" for="rb_s3">S3</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Survei Persepsi Pelayanan Publik
								</h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group">
							<div class="col-lg-12 px-3">
								<div class="col-lg-12 row mb-3">
									<label class="col-form-label text-justify">
										{!! $survei_list_header->infsurveippp !!}
									</label>
								</div>
								<div>&nbsp;</div>
								<div class="dropdown-divider"></div>
								<div>&nbsp;</div>

								@foreach ($survei_list_Quest01_noniipp as $quest_noniipp)
									<div class="col-lg-12 row mb-3">
										<div>
											{!! $quest_noniipp->seq !!}.
										</div>
										<div class="col-lg">
											{!! $quest_noniipp->question !!}
										</div>
									</div>

									<div class="col-lg-12 row px-5 mb-3">
										<div class="col-lg-6">
											<div class="row">
												<label class="col-lg col-form-label text-center">Kinerja </label>
												<div class="col-lg-10">
													<select class="form-control select required" data-minimum-results-for-search="Infinity"
														id="answer_quest01_IKMK[{{ $quest_noniipp->id }}]" name="answer_quest01_IKMK[{{ $quest_noniipp->id }}]"
														required>
														<option value="" disabled selected>-- Pilih Kinerja --</option>
														@foreach ($survei_list_ans as $ans_ikmk)
															@if ($quest_noniipp->question_id == $ans_ikmk->question_id)
																@if ($ans_ikmk->jenisopsi_id == 'IKMK')
																	<option value="{{ $ans_ikmk->id }}">{{ $ans_ikmk->answer }}</option>
																@endif
															@endif
														@endforeach
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="row">
												<label class="col-lg col-form-label text-center">Harapan </label>
												<div class="col-lg-10">
													<select class="form-control select" data-minimum-results-for-search="Infinity"
														id="answer_quest01_IKMH[{{ $quest_noniipp->id }}]" name="answer_quest01_IKMH[{{ $quest_noniipp->id }}]"
														required>
														<option value="" disabled selected>-- Pilih Harapan --</option>
														@foreach ($survei_list_ans as $ans)
															@if ($quest_noniipp->question_id == $ans->question_id)
																@if ($ans->jenisopsi_id == 'IKMH')
																	<option value="{{ $ans->id }}">{{ $ans->answer }}</option>
																@endif
															@endif
														@endforeach
													</select>
												</div>
											</div>
										</div>
									</div>
								@endforeach

							</div>
						</div>

					</div>
				</div>

				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Survei Integritas Pelayanan Publik
								</h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group">
							<div class="col-lg-12 px-3">
								<div class="col-lg-12 row mb-3">
									<label class="col-form-label text-justify">
										{!! $survei_list_header->infsurveiipp !!}
									</label>
								</div>
								<div>&nbsp;</div>
								<div class="dropdown-divider"></div>
								<div>&nbsp;</div>

								@foreach ($survei_list_Quest01_iipp as $quest_iipp)
									<div class="col-lg-12 row mb-3">
										<div>
											{!! $quest_iipp->seq !!}.
										</div>
										<div class="col-lg">
											{!! $quest_iipp->question !!}
										</div>
									</div>

									<div class="col-lg-12 row px-5 mb-3">
										<div class="col-lg-10">
											<div class="row">
												{{-- <label class="col-lg-1 col-form-label text-center">Kinerja </label> --}}
												<div class="col-lg-11">
													<select class="form-control select" data-minimum-results-for-search="Infinity"
														id="answer_quest01_IIPP[{{ $quest_iipp->id }}]" name="answer_quest01_IIPP[{{ $quest_iipp->id }}]"
														required>
														<option value="" disabled selected>-- Pilih Jawaban --</option>
														@foreach ($survei_list_ans as $ans)
															@if ($quest_iipp->question_id == $ans->question_id)
																@if ($ans->jenisopsi_id == 'IIPP')
																	<option value="{{ $ans->id }}">{{ $ans->answer }}</option>
																@endif
															@endif
														@endforeach
													</select>
												</div>
											</div>
										</div>
									</div>
								@endforeach

							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Kritik & Saran
							</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					@foreach ($survei_list_Quest02 as $quest02)
						<div class="form-group">
							<div class="col-lg-12 px-3">
								<div class="col-lg-12 row mb-3">
									<div>
										{!! $quest02->seq !!}.
									</div>
									<div class="col-lg">
										{!! $quest02->question !!}
									</div>
								</div>
								<table style="width: 100%;">
									<tbody id="categorySlot_{{ $loop->index + 1 }}">
										<tr style="width: 100%;">
											<td style="width: 100%;">
												<div class="col-lg-12">
													<div class="col-lg-12 row mb-3">
														<label class="col-lg-2 col-form-label text-center">Kategori </label>
														<div class="col-lg-10">
															<select class="form-control select" data-minimum-results-for-search="Infinity"
																id="answer_quest02[{{ $quest02->id }}][0]" name="answer_quest02[{{ $quest02->id }}][0]" required>
																<option value="" disabled selected>-- Silahkan Pilih --</option>
																@foreach ($survei_kategori as $cat)
																	<option value="{{ $cat->id }}">{{ $cat->desc }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-lg-12 row mb-3">
														<label class="col-lg-2 col-form-label text-lg-end">&nbsp;</label>
														<div class="col-lg-10">
															<textarea class="form-control" name="answer_quest02_respond[{{ $quest02->id }}][0]"
															 id="answer_quest02_respond[{{ $quest02->id }}][0]" rows="3" required></textarea>
														</div>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="col-lg-12">
									<div class="text-center">
										<button type="button" id="btn_Category_Add" name="btn_Category_Add"
											class="btn btn-success btn-labeled btn-labeled-start btn_Category_Add" data-row-id="{{ $loop->index + 1 }}"
											data-questionid="{{ $quest02->id }}">
											<span class="btn-labeled-icon bg-black bg-opacity-20"></span> Tambah Jawaban
										</button>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Testimoni
							</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					@foreach ($survei_list_Quest03 as $quest03)
						<div class="form-group">
							<div class="col-lg-12 px-3">
								<div class="col-lg-12 row mb-3">
									<div>
										{!! $quest03->seq !!}.
									</div>
									<div class="col-lg">
										{!! $quest03->question !!}
									</div>
								</div>
							</div>
							<div class="col-lg-12 mb-3">
								<textarea class="form-control" name="answer_quest03_respond[{{ $quest03->question_id }}]"
								 id="answer_quest03_respond[{{ $quest03->question_id }}]" rows="3" required></textarea>
							</div>
						</div>
					@endforeach
				</div>
			</div>

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Pernyataan
							</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group col-lg-12 row">
						<div class="col-lg-8">
							<label class="custom-control custom-checkbox custom-control-inline">
								<input type="checkbox" name="chekCheklis" id="chekCheklis" class="custom-control-input" required>
								<span class="custom-control-label">Dengan ini secara sadar saya menyatakan bahwa seluruh jawaban yang
									disampaikan adalah <b>&nbsp;BENAR</b>.</span>
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="card-footer d-flex justify-content-end">
				<div class="row">
					<a href="{{ route('survei.isi') }}" class="btn btn-secondary border-transparent"><i
							class="icon-backward2 ml-2"></i> Kembali </a>
					<div>&nbsp;</div>
					<button type="button" class="btn btn-indigo float-right ms-3" onclick="onSubmit()">Kirim
						Survei <i class="icon-paperplane ml-2"></i></button>
				</div>
			</div>

			{{-- <div class="te'xt-right">
				<div class="row">
					<button type="button" href="#" class="btn btn-danger ms-3"><i class="icon-backward2 ml-2"></i>
						Kembali </button>
					<div>&nbsp;</div>
					<button type="button" class="btn btn-indigo float-right ms-3" onclick="onSubmit()">Kirim
						Survei <i class="icon-paperplane ml-2"></i></button>
				</div>
			</div>' --}}
			{{-- </div> --}}
		</div>
	</form>
	<div class="modal" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Kirim Survei</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan mengirim survei ini ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary notif-button" onclick="submitsurvei();return false;">Kirim</button>
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
		};

		function submitsurvei() {
			showLoadingSpinner();
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			$('#formSurvei').submit();
		}

		function onSubmit() {
			// alert("test");
			if ($("#formSurvei")[0].checkValidity()) {
				$('#submitModal').modal('show');
			} else {
				$('#formSurvei :input[required="required"]').each(function() {
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

		let AddCategory = 0;
		let questionCounters = {};
		$(".btn_Category_Add").click(function(e) {
			e.preventDefault();
			let row_id = $(this).data('row-id');
			let question_id = $(this).data('questionid');
			let currentQuestionCounter = questionCounters[row_id] || 0;
			let AnsCat02 = currentQuestionCounter + 1;
			const inputRow =
				`<tr style="width: 100%;">
										<td style="width: 100%;">
											<div class="col-lg-12">
												<div class="col-lg-12 row mb-3">
													<label class="col-lg-2 col-form-label text-center">Kategori </label>
													<div class="col-lg-9">
														<select class="form-control select" data-minimum-results-for-search="Infinity"
													id="answer_quest02[${question_id}][${AnsCat02}]" name="answer_quest02[${question_id}][${AnsCat02}]" required>>
															<option value="" disabled selected>-- Silahkan Pilih --</option>
															@foreach ($survei_kategori as $cat)
																<option value="{{ $cat->id }}">{{ $cat->desc }}</option>
															@endforeach
														</select>
													</div>
													<div class="col-lg-1">
														<button type="button" class="btn btn-danger btn_AnsCat02_Remove" id="btn_AnsCat02_Remove" name="btn_AnsCat02_Remove" data-row-id="${AnsCat02}"><i
																class="icon-trash"></i></button>
													</div>
												</div>
												<div class="col-lg-12 row mb-3">
													<label class="col-lg-2 col-form-label text-lg-end">&nbsp;</label>
													<div class="col-lg-10">
														<textarea class="form-control" name="answer_quest02_respond[${question_id}][${AnsCat02}]" id="answer_quest02_respond[${question_id}][${AnsCat02}]" rows="3" required></textarea>
													</div>
												</div>
											</div>
										</td>
									</tr>`;
			$('#categorySlot_' + row_id).append(inputRow);
			AddCategory++;
			questionCounters[row_id] = currentQuestionCounter + 1;
		});
		$(document).on('click', '.btn_AnsCat02_Remove', function(e) {
			e.preventDefault();

			let row_item = $(this).closest('tr');
			row_item.remove();
		});

		$(document).ready(function() {
			// let AddCategory = 0;
			// let questionCounters = {};
			// $(".btn_Category_Add").click(function(e) {
			// 	e.preventDefault();
			// 	// alert('Test');

			// 	const inputRow =
			// 		`<tr style="width: 100%;">
		// 			<div class="col-lg-12 row mb-3">
		// 				<label class="col-lg-2 col-form-label text-center">Kategori </label>
		// 				<div class="col-lg-10">
		// 					<select class="form-control select" data-minimum-results-for-search="Infinity">
		// 						<option value="" disabled selected>-- Silahkan Pilih --</option>

		// 					</select>
		// 				</div>
		// 			</div>
		// 		</tr>`;
			// 	$('#categorySlot').append(inputRow);
			// 	AddCategory++;
			// });
			// $(document).on('click', '.btn_MainQuestCat01_Remove', function(e) {
			// 	e.preventDefault();

			// 	let row_item = $(this).closest('tr');
			// 	row_item.remove();
			// });

		});
	</script>
@endsection
