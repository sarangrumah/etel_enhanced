@extends('layouts.backend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
	<script src="//cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
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
			z-index: 9999;
			justify-content: center;
			align-items: center;
			display: flex;
		}
	</style>
	<form action="{{ route('survei.post') }}" method="post" id="formSurvei">
		@csrf
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
												<input type="number" class="form-control" value="{{ $izin->age }}" name="responder_age"
													id="responder_age" readonly>
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
												<input type="text" class="form-control" value="{{ $izin->gender }}" name="responder_gender"
													id="responder_gender" readonly>
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
												<input type="text" class="form-control" value="{{ $izin->study }}" name="responder_study"
													id="responder_study" readonly>
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
								<h6 class="card-title font-weight-semibold py-3">Penilaian dan Analisa Survei
								</h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group">
							<h6 class="card-title font-weight-semibold py-3">INDEKS KEPUASAN MASYARAKAT</h6>

							<div class="form-group row">
								<div class="col">
									<div class="form-group col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Kinerja </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" value="{{ $list_header->result_final_ikmk }}" readonly>
											</div>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Harapan </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" value="{{ $list_header->result_final_ikmh }}" readonly>
											</div>
										</div>
									</div>
								</div>
								<div class="col">
									<div class="form-group col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Tingkat Kepuasan </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" value="{{ $list_header->SERVQL }}" readonly>
											</div>
										</div>
									</div>
								</div>
							</div>

							<h6 class="card-title font-weight-semibold py-3">GAP ANALISIS</h6>
							<div class="form-group row">
								<div class="table-responsive">
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Unsur</th>
												<th style="text-align: center;">Pertanyaan</th>
												<th style="text-align: center;">Kinerja</th>
												<th style="text-align: center;">Harapan</th>
												<th style="text-align: center;">GAP</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($list_ans_ikm as $key => $ans_ikm)
												<tr class="@if ($ans_ikm->nilai_gap < 0) table-danger @endif">
													<td style="text-align: center;width: 5%;">
														{{ $ans_ikm->seq }}
													</td>
													<td style="text-align: center;width: 15%;">
														{{ $ans_ikm->unsur }}
													</td>
													<td style="text-align: justify;width: 45%;">
														{{ $ans_ikm->question }}
													</td>
													<td style="text-align: center;width: 5%;">
														{{ $ans_ikm->nilai_kinerja }}
													</td>
													<td style="text-align: center;width: 5%;">
														{{ $ans_ikm->nilai_harapan }}
													</td>
													@if ($ans_ikm->nilai_gap < 0)
														<td style="text-align: center;width: 5%;" class="font-weight-semibold text-danger">
															{{ $ans_ikm->nilai_gap }}
														</td>
													@else
														<td style="text-align: center;width: 5%;">
															{{ $ans_ikm->nilai_gap }}
														</td>
													@endif
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>

							<div class="dropdown-divider"></div>

							<h6 class="card-title font-weight-semibold py-3">INDEKS INTEGRITAS PELAYANAN PUBLIK</h6>

							<div class="form-group row">
								<div class="col">
									<div class="form-group col-lg-12">
										<div class="col-lg-6 row">
											<label class="col-lg-4 col-form-label">Nilai </label>
											<div class="col-lg-8">
												<input type="text" class="form-control" value="{{ $list_header->result_final_ikmk }}" readonly>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="table-responsive">
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th style="text-align: center;">No</th>
												<th style="text-align: center;">Unsur</th>
												<th style="text-align: center;">Pertanyaan</th>
												<th style="text-align: center;">Nilai</th>
												<th style="text-align: center;">Nilai x Bobot</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($list_ans_iipp as $key => $ans_iipp)
												<tr>
													<td style="text-align: center;width: 5%;">
														{{ $ans_iipp->seq }}
													</td>
													<td style="text-align: center;width: 15%;">
														{{ $ans_iipp->unsur }}
													</td>
													<td style="text-align: justify;width: 45%;">
														{{ $ans_iipp->question }}
													</td>
													<td style="text-align: center;width: 5%;">
														{{ $ans_iipp->nilai }}
													</td>
													<td style="text-align: center;width: 10%;">
														{{ $ans_iipp->nilai_bobot }}
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
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
														readonly>
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
														readonly>
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
												<label class="col-lg-1 col-form-label text-center">&nbsp; </label>
												<div class="col-lg-11">
													<select class="form-control select" data-minimum-results-for-search="Infinity"
														id="answer_quest01_IIPP[{{ $quest_iipp->id }}]" name="answer_quest01_IIPP[{{ $quest_iipp->id }}]"
														readonly>
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
																id="answer_quest02[{{ $quest02->id }}][0]" name="answer_quest02[{{ $quest02->id }}][0]" readonly>
																@foreach ($survei_kategori as $cat)
																	<option value="{{ $cat->id }}" @if ($cat->id == $quest02->answer_id) selected @endif>
																		{{ $cat->desc }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-lg-12 row mb-3">
														<label class="col-lg-2 col-form-label text-lg-end">&nbsp;</label>
														<div class="col-lg-10">
															<textarea class="form-control" name="answer_quest02_respond[{{ $quest02->id }}][0]"
															 id="answer_quest02_respond[{{ $quest02->id }}][0]" rows="3" readonly>{{ $quest02->answer }}</textarea>
														</div>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
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
								<div class="col-lg-12 mb-3">
									<p>{!! $quest03->answer !!}</p>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>

			<div class="card-footer d-flex justify-content-end">
				<div class="row">
					<a href="/admin/survei/respond" class="btn btn-danger ms-3">
						<i class="icon-backward2 ml-2"></i> Kembali
					</a>
					<div>&nbsp;</div>
				</div>
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
@endsection
