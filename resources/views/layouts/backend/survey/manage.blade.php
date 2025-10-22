@extends('layouts.backend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
	<script src="//cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
	<script>
		// Initialize the latestInnerIterations array
		var latestInnerIterations = [];
		var latestInnerIterations_02 = [];

		@foreach ($survei_list_Quest01 as $quest01)
			// Initialize the inner iteration count for each question
			latestInnerIterations[{{ $loop->index }}] = 0;
		@endforeach
		// 
	</script>
@endsection

@section('content')
	<div id="loadingSpinner" class="loading-spinner" style="display: none;">
		<img id="spinnerImage" src="/assets/kominfo/spinner-kominfo-trp.svg" alt="Loading Spinner">
	</div>
	<style>
		.customCheckboxLabelFlag {
			cursor: pointer;
			display: inline-block;
			position: relative;
		}

		.customCheckboxLabelFlag i {
			font-size: 24px;
			/* Adjust size as needed */
			color: black;
			/* Default color */
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
		}

		/* Hide the actual checkbox */
		.customCheckboxFlag {
			display: none;
		}

		/* Change icon color when checkbox is checked */
		.customCheckboxFlag:checked+.customCheckboxLabelFlag i {
			color: red;
			/* Change to desired color */
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
	<form action="{{ route('admin.survei.post') }}" method="post" id="formSurvei">
		@csrf
		<div class="form-group">
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Informasi Survei </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="col-lg-12">
							<div>
								<label class="col-lg-12 col-form-label">Kata Pengantar </label>
								<div class="col-lg">
									<textarea class="form-control" name="infsurveiinit" id="infsurveiinit" rows="3" required>{!! $survei_list_header->infsurveiinit !!}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<div>
								<label class="col-lg-12 col-form-label">Informasi Survei Persepsi Pelayanan Publik </label>
								<div class="col-lg">
									<textarea class="form-control" name="infsurveippp" id="infsurveippp" rows="3" required>{!! $survei_list_header->infsurveippp !!}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<div>
								<label class="col-lg-12 col-form-label">Informasi Survei Integritas Pelayanan Publik </label>
								<div class="col-lg">
									<textarea class="form-control" name="infsurveiipp" id="infsurveiipp" rows="3" required>{!! $survei_list_header->infsurveiipp !!}</textarea>
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
							<h6 class="card-title font-weight-semibold py-3">Pertanyaan Opsi Pilihan </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table style="width: 100%;">
						@php $AddQuestion01 = 0; @endphp
						<tbody id="Question01">
							@foreach ($survei_list_Quest01 as $quest01)
								<tr style="width: 100%;">
									<td>
										<div class="row col-lg-12">
											<div class="col-lg-1">
												<label class="col-form-label">Unsur</label>
											</div>
											<div class="col-lg-10">
												<div class="col-lg-12 row mb-3">
													<div class="col-12">
														<select id="Question01_Unsur[{{ $AddQuestion01 }}]" name="Question01_Unsur[{{ $AddQuestion01 }}]"
															class="form-control select" data-minimum-results-for-search="Infinity">
															<option value="" disabled selected>-- Silahkan Pilih --</option>
															@foreach ($survei_unsur as $unsur)
																<option value="{{ $unsur->id }}" @if ($unsur->id == $quest01->unsur_id) selected @endif>{{ $unsur->desc }}
																</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-1">
												<div
													class="text-center custom-control custom-switch custom-switch-square custom-control-success justify-content-center mb-3">
													<input type="checkbox" name="is_active_QuestCat01[{{ $AddQuestion01 }}]" class="custom-control-input"
														@if ($quest01->is_active == '1') checked @endif id="is_active_QuestCat01[{{ $AddQuestion01 }}]">
													<label class="custom-control-label" for="is_active_QuestCat01[{{ $AddQuestion01 }}]"></label>
												</div>
											</div>
										</div>
										<div class="row col-lg-12">
											<div class="col-lg-1">
												<label class="col-form-label">Pertanyaan</label>
											</div>
											<div class="col-lg-10">
												<div class="col-lg-12 row mb-3">
													<div class="col-1">
														<input id="Question01_Seq[{{ $AddQuestion01 }}]" name="Question01_Seq[{{ $AddQuestion01 }}]"
															type="text" class="form-control list-quest" placeholder="Urutan" value="{{ $quest01->seq }}" />
													</div>
													<div class="col-11">
														<input id="Question01[{{ $AddQuestion01 }}]" name="Question01[{{ $AddQuestion01 }}]" type="text"
															class="form-control list-quest" placeholder="Pertanyaan" value="{{ $quest01->question }}" />
													</div>
												</div>
											</div>
											<div class="col-lg-1">&nbsp;
											</div>
										</div>
										<div class="row col-lg-12">
											<table style="width: 100%;">
												<thead>
													<tr>
														<td>
															<div class="row col-lg-12">
																<div class="col-lg-1">
																	<label class="col-form-label">&nbsp;</label>
																</div>
																<div class="text-center col-lg-3">
																	<label class="col-form-label">Jenis Opsi</label>
																</div>
																<div class="text-center col-lg-4">
																	<label class="col-form-label">Opsi Pilihan</label>
																</div>
																<div class="text-center col-lg-1">
																	<label class="col-form-label">Nilai</label>
																</div>
																<div class="text-center col-lg-1">
																	<label class="col-form-label">Bobot</label>
																</div>
																<div class="text-center col-lg-1">
																	<label class="col-form-label">Flag</label>
																</div>
																<div class="col-lg-1">
																	<label class="col-form-label">&nbsp;</label>
																</div>
															</div>
														</td>
													</tr>
												</thead>
												<tbody id="Answer01_{{ $AddQuestion01 }}">
													@php $innerIteration[$AddQuestion01] = 0; @endphp
													@foreach ($survei_list_ans as $ans_ikmk)
														@if ($quest01->question_id == $ans_ikmk->question_id)
															<tr>
																<td>
																	<div class="row col-lg-12">
																		<input type="hidden"
																			id="AnsCat01_Quest_hidden_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																			name="AnsCat01_Quest_hidden_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																			value="{{ $quest01->seq }}" />
																		<div class="col-lg-1">
																			<label class="col-form-label">
																				@if ($innerIteration[$AddQuestion01] == 0)
																					Jawaban
																				@else
																					&nbsp;
																				@endif
																			</label>
																		</div>
																		<div class="col-lg-3">
																			<select class="form-control select"
																				id="AnsCat01_JenisOpsi_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				name="AnsCat01_JenisOpsi_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				data-minimum-results-for-search="Infinity">
																				<option value="" disabled selected>-- Pilih Jenis Opsi --</option>
																				@foreach ($opt_answer01 as $optanswer)
																					<option value="{{ $optanswer->opt_answer }}" @if ($optanswer->opt_answer == $ans_ikmk->jenisopsi_id) selected @endif>
																						{{ $optanswer->opt_answer_desc }}
																					</option>
																				@endforeach
																			</select>
																		</div>
																		<div class="col-lg-4">
																			<input id="AnsCat01_OpsiPilihan_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				name="AnsCat01_OpsiPilihan_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				type="text" class="form-control list-quest" placeholder="Opsi Pilihan"
																				value="{{ $ans_ikmk->answer }}" />
																		</div>
																		<div class="col-lg-1">
																			<input id="AnsCat01_Nilai_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				name="AnsCat01_Nilai_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				type="text" class="form-control list-quest" placeholder="Nilai"
																				value="{{ $ans_ikmk->nilai }}" />
																		</div>
																		<div class="col-lg-1">
																			<input id="AnsCat01_Bobot_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				name="AnsCat01_Bobot_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				type="text" class="form-control list-quest" placeholder="Bobot"
																				value="{{ $ans_ikmk->bobot }}" />
																		</div>
																		<div class="text-center col-lg-1">
																			{{-- <input type="hidden"
																				id="AnsCat01_Flag_hidden_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				name="AnsCat01_Flag_hidden_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				value="@if ($ans_ikmk->is_flag == '1') true @else false @endif" /> --}}
																			{{-- <button id="AnsCat01_Flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				name="AnsCat01_Flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]" type="button"
																				class="btn btnIcon @if ($ans_ikmk->is_flag == '1') selected btn-outline-danger @endif"
																				onclick="toggleState(this, document.getElementById('AnsCat01_Flag_hidden_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]'))"><i
																					class="icon-flag3"></i></button> --}}
																			{{-- <input type="checkbox" id="customCheckbox_flag">
																			<label for="customCheckbox_flag" class="customCheckboxLabel_flag" checked>
																				<i class="icon-flag3"></i>
																			</label> --}}
																			{{-- <input type="checkbox"
																				id="customCheckbox_flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				class="customCheckboxFlag">
																			<label for="customCheckbox_flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				class="customCheckboxLabelFlag">
																				<i class="icon-flag3"></i>
																			</label> --}}
																			{{-- <input type="checkbox"
																				id="customCheckbox_flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				name ="customCheckbox_flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				class="customCheckboxFlag" unchecked>
																			<label for="customCheckbox_flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				class="customCheckboxLabelFlag">
																				<i class="icon-flag3"></i>
																			</label> --}}
																			<div
																				class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
																				<input type="checkbox" class="custom-control-input"
																					@if ($ans_ikmk->is_flag == '1') checked @endif
																					id="AnsCat01_Flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																					name="AnsCat01_Flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]">
																				<label class="custom-control-label"
																					for="AnsCat01_Flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"></label>
																			</div>
																			{{-- <input id="AnsCat01_Flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				name="AnsCat01_Flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]"
																				type="checkbox" class="@if ($ans_ikmk->is_flag == '1') selected btn-outline-danger @endif"
																				onchange="toggleState(this, document.getElementById('AnsCat01_Flag_hidden_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]'))">
																			<i class="icon-flag3"></i> --}}
																		</div>
																		<div class="col-lg">
																			@if ($innerIteration[$AddQuestion01] == 0)
																				<button type="button" class="btn btn-success  btn_AnsCat01_Add" id="btn_AnsCat01_Add"
																					name="btn_AnsCat01_Add" data-row-id="{{ $AddQuestion01 }}"><i class="icon-plus3"></i></button>
																			@else
																				<button type="button" class="btn btn-danger btn_AnsCat01_Remove" id="btn_AnsCat01_Remove"
																					name="btn_AnsCat01_Remove" data-row-id="${AnsCat01}"><i class="icon-trash"></i></button>
																			@endif

																		</div>
																	</div>
																</td>
															</tr>
															@php $innerIteration[$AddQuestion01]++; @endphp
															<script>
																latestInnerIterations[{{ $AddQuestion01 }}] = {{ $innerIteration[$AddQuestion01] }};
															</script>
														@endif
													@endforeach
												</tbody>
											</table>
										</div>
										<div>&nbsp;<div>
												<div class="col-lg-12">
													<div class="text-center">
														<button type="button" id="btn_MainQuestCat01_Remove" name="btn_MainQuestCat01_Remove"
															class="btn btn-danger btn-labeled btn-labeled-start btn_MainQuestCat01_Remove">
															<span class="btn-labeled-icon bg-black bg-opacity-20"></span> Hapus Pertanyaan
														</button>
													</div>
												</div>
												<div class="dropdown-divider"></div>
									</td>
								</tr>

								@php $AddQuestion01++; @endphp
							@endforeach
						</tbody>
					</table>

					<div class="text-center">
						<button type="button" id="btn_Question01_Add" name="btn_Question01_Add"
							class="btn btn-success btn-labeled btn-labeled-start btn_Question01_Add">
							<span class="btn-labeled-icon bg-black bg-opacity-20"></span> Tambah Pertanyaan
						</button>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Pertanyaan Terbuka Dengan Kategori Jawaban</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table style="width: 100%;">
						@php $AddQuestion02 = 0; @endphp
						<tbody id="Question02">
							@foreach ($survei_list_Quest02 as $quest02)
								<tr style="width: 100%;">
									<td>
										<div class="row col-lg-12">
											<div class="col-lg-1">
												<label class="col-form-label">Pertanyaan</label>
											</div>
											<div class="col-lg-10 row">
												<div class="col-1">
													<input id="Question02_Seq[{{ $AddQuestion02 }}]" name="Question02_Seq[{{ $AddQuestion02 }}]"
														type="text" class="form-control list-quest" placeholder="Urutan" value="{!! $quest02->seq !!}" />
												</div>
												<div class="col-11">
													<input id="Question02[{{ $AddQuestion02 }}]" name="Question02[{{ $AddQuestion02 }}]" type="text"
														class="form-control list-quest" placeholder="" value="{!! $quest02->question !!}" />
												</div>
											</div>
											<div class="col row">
												<div
													class="text-center custom-control custom-switch custom-switch-square custom-control-success justify-content-center mb-3">
													<input type="checkbox" name="is_active_QuestCat02[{{ $AddQuestion02 }}]" class="custom-control-input"
														@if ($quest02->is_active == '1') checked @endif id="is_active_QuestCat02[{{ $AddQuestion02 }}]">
													<label class="custom-control-label" for="is_active_QuestCat02[{{ $AddQuestion02 }}]"></label>
												</div>
												<div class="col text-center">
													<button type="button" id="btn_MainQuestCat02_Remove" name="btn_MainQuestCat02_Remove"
														class="btn btn-danger btn-labeled btn-labeled-start btn_MainQuestCat02_Remove">
														<i class="icon-trash"></i>
													</button>
												</div>
											</div>
										</div>
										<div>&nbsp;<div>
												<div class="dropdown-divider"></div>
									</td>
								</tr>

								@php $AddQuestion02++; @endphp
							@endforeach
						</tbody>
					</table>

					<div class="text-center">
						<button type="button" id="btn_Question02_Add" name="btn_Question02_Add"
							class="btn btn-success btn-labeled btn-labeled-start btn_Question02_Add">
							<span class="btn-labeled-icon bg-black bg-opacity-20"></span> Tambah Pertanyaan
						</button>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Pertanyaan Terbuka Tanpa Kategori Jawaban</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table style="width: 100%;">
						@php $AddQuestion03 = 0; @endphp
						<tbody id="Question03">
							@foreach ($survei_list_Quest03 as $quest03)
								<tr style="width: 100%;">
									<td>
										<div class="row col-lg-12">
											<div class="col-lg-1">
												<label class="col-form-label">Pertanyaan</label>
											</div>
											<div class="col-lg-10 row">
												<div class="col-1">
													<input id="Question03_Seq[{{ $AddQuestion03 }}]" name="Question03_Seq[{{ $AddQuestion03 }}]"
														type="text" class="form-control list-quest" placeholder="Urutan" value="{!! $quest03->seq !!}" />
												</div>
												<div class="col-11">
													<input id="Question03[{{ $AddQuestion03 }}]" name="Question03[{{ $AddQuestion03 }}]" type="text"
														class="form-control list-quest" placeholder="" value="{!! $quest03->question !!}" />
												</div>
											</div>
											<div class="col row">
												<div
													class="text-center custom-control custom-switch custom-switch-square custom-control-success justify-content-center mb-3">
													<input type="checkbox" name="is_active_QuestCat03[{{ $AddQuestion03 }}]" class="custom-control-input"
														@if ($quest03->is_active == '1') checked @endif id="is_active_QuestCat03[{{ $AddQuestion03 }}]"
														value="on">
													<label class="custom-control-label" for="is_active_QuestCat03[{{ $AddQuestion03 }}]"
														value="on"></label>
												</div>
												<div class="col text-center">
													<button type="button" id="btn_MainQuestCat03_Remove" name="btn_MainQuestCat03_Remove"
														class="btn btn-danger btn-labeled btn-labeled-start btn_MainQuestCat03_Remove">
														<i class="icon-trash"></i>
													</button>
												</div>
											</div>
										</div>
										<div class="dropdown-divider"></div>
									</td>
								</tr>
								@php $AddQuestion03++; @endphp
							@endforeach
						</tbody>
					</table>

					<div class="text-center">
						<button type="button" id="btn_Question03_Add" name="btn_Question03_Add"
							class="btn btn-success btn-labeled btn-labeled-start btn_Question03_Add">
							<span class="btn-labeled-icon bg-black bg-opacity-20"></span> Tambah Pertanyaan
						</button>
					</div>
				</div>
			</div>
			<div class="text-right">
				<a type="button" href="#" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i>
					Kembali </a>
				<button type="button" id="btnSubmitModal" data-target="#submitModal" data-toggle="modal"
					class="btn btn-indigo">Simpan
					Survei <i class="icon-checkmark ml-2"></i></button>
			</div>
		</div>
	</form>
	<div class="modal" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Update Survei</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan menyimpan survei ini ?</p>
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
		document.addEventListener("DOMContentLoaded", function() {
			var checkboxes = document.querySelectorAll(".customCheckboxFlag");

			checkboxes.forEach(function(checkbox) {
				var label = checkbox.nextElementSibling;
				var icon = label.querySelector("i");

				label.addEventListener("click", function() {
					// Trigger click event on the checkbox
					checkbox.click();

					// Toggle flag color based on checkbox state
					if (checkbox.checked) {
						icon.style.color = "red"; // Change to red
					} else {
						icon.style.color = "black"; // Change to black
					}
					if (!checkbox.checked) {
						icon.style.color = "red"; // Change to red
					} else {
						icon.style.color = "black"; // Change to black
					}
				});

				// Initialize flag color based on initial checkbox state
				if (checkbox.checked) {
					icon.style.color = "red"; // Change to red
				} else {
					icon.style.color = "black"; // Change to black
				}
			});
		});
		var loadingSpinner = document.getElementById('loadingSpinner');

		function add_opt_quest01(questseq, optseq) {
			let selectElement = document.getElementById('AnsCat01_JenisOpsi_' + '[' + questseq + ']' + '[' + optseq + ']');
			let newOptions = @json($opt_answer01);

			selectElement.innerHTML = '';

			newOptions.forEach(option => {
				let newOption = document.createElement('option');
				newOption.value = option.opt_answer;
				newOption.text = option.opt_answer_desc;
				selectElement.appendChild(newOption);
			});

			let defaultOption = document.createElement('option');
			defaultOption.value = '';
			defaultOption.text = '-- Pilih Jenis Opsi --';
			defaultOption.disabled = true; // Add 'disabled' attribute
			defaultOption.selected = true; // Add 'selected' attribute
			selectElement.insertBefore(defaultOption, selectElement.firstChild);

		}

		function showLoadingSpinner() {
			// loadingSpinner.style.display = 'block';
			var spinner = document.getElementById('loadingSpinner');
			spinner.style.display = 'flex';
		};

		function toggleState(button, hiddenInput) {

			const isSelected = button.classList.contains('selected');
			// isSelected = !isSelected;

			if (isSelected) {
				button.classList.remove('selected');
				button.classList.remove('btn-outline-danger');
				hiddenInput.value = 'false';
			} else {
				button.classList.add('selected');
				button.classList.add('btn-outline-danger');
				hiddenInput.value = 'true';
			}
		};



		$(document).ready(function() {
			CKEDITOR.replace('infsurveiinit');
			CKEDITOR.replace('infsurveippp');
			CKEDITOR.replace('infsurveiipp');
			let AddQuestion01_ = 0;
			let AddQuestion02_ = 0;
			let AddQuestion03_ = 0;
			let AddAnswer01_ = 0;
			// var latestInnerIterations = [];
			// let AnsCat01 = 1;
			let questionCounters = {};
			$(".btn_Question01_Add").click(function(e) {
				e.preventDefault();
				var QuestionIteration = {{ $AddQuestion01 }} + AddQuestion01_;
				// alert(QuestionIteration);
				let AddQuestion01 = QuestionIteration;
				// let currentQuestionId = $(this).data('row-id');
				// questionCounters[currentQuestionId] = (questionCounters[currentQuestionId] || 0) + 1;

				// let AddQuestion01 = questionCounters[currentQuestionId];
				// console.log('Question-' + AddQuestion01);
				let answerReset = 0;

				const inputRow =
					`
					<tr style="width: 100%;">
										<td>
						<div class="row col-lg-12">
							<div class="col-lg-1">
								<label class="col-form-label">Unsur</label>
							</div>
							<div class="col-lg-10">
								<div class="col-lg-12 row mb-3">
									<div class="col-12">
										<select id="Question01_Unsur[${AddQuestion01}]" name="Question01_Unsur[${AddQuestion01}]" class="form-control select" data-minimum-results-for-search="Infinity">
													<option value="" disabled selected>-- Silahkan Pilih --</option>
													@foreach ($survei_unsur as $unsur)
														<option value="{{ $unsur->id }}">{{ $unsur->desc }}</option>
													@endforeach
												</select>
									</div>
								</div>
							</div>
							<div class="col-lg-1">
								<div
									class="text-center custom-control custom-switch custom-switch-square custom-control-success justify-content-center mb-3">
									<input type="checkbox" name="is_active_QuestCat01[${AddQuestion01}]" class="custom-control-input"
										id="is_active_QuestCat01[${AddQuestion01}]">
									<label class="custom-control-label" for="is_active_QuestCat01[${AddQuestion01}]"></label>
								</div>
							</div>
						</div>
						<div class="row col-lg-12">
							<div class="col-lg-1">
								<label class="col-form-label">Pertanyaan</label>
							</div>
							<div class="col-lg-10">
								<div class="col-lg-12 row mb-3">
									<div class="col-1">
										<input id="Question01_Seq[${AddQuestion01}]" name="Question01_Seq[${AddQuestion01}]" type="text"
										class="form-control list-quest" placeholder="Urutan" value="" />
									</div>
									<div class="col-11">
									<input id="Question01[${AddQuestion01}]" name="Question01[${AddQuestion01}]" type="text"
										class="form-control list-quest" placeholder="Pertanyaan" value="" />
									</div>
								</div>
							</div>
							<div class="col-lg-1">&nbsp;
							</div>
						</div>
						<div class="row col-lg-12">
							<table style="width: 100%;">
								<thead>
									<tr>
										<td>
										<div class="row col-lg-12">
											<div class="col-lg-1">
												<label class="col-form-label">&nbsp;</label>
											</div>
											<div class="text-center col-lg-3">
												<label class="col-form-label">Jenis Opsi</label>
											</div>
											<div class="text-center col-lg-4">
												<label class="col-form-label">Opsi Pilihan</label>
											</div>
											<div class="text-center col-lg-1">
												<label class="col-form-label">Nilai</label>
											</div>
											<div class="text-center col-lg-1">
												<label class="col-form-label">Bobot</label>
											</div>
											<div class="text-center col-lg-1">
												<label class="col-form-label">Flag</label>
											</div>
											<div class="col-lg-1">
												<label class="col-form-label">&nbsp;</label>
											</div>
										</div>
										</td>
									</tr>
								</thead>
								<tbody id="Answer01_${AddQuestion01}">
									<tr>
										<td>	
										<div class="row col-lg-12">
											<input type="hidden" id="AnsCat01_Quest_hidden_[${AddQuestion01}][${answerReset}]" name="AnsCat01_Quest_hidden_[${AddQuestion01}][${answerReset}]" value="${AddQuestion01}" />
											<div class="col-lg-1">
												<label class="col-form-label">Jawaban</label>
											</div>
											<div class="col-lg-3">
												<select class="form-control select" id="AnsCat01_JenisOpsi_[${AddQuestion01}][${answerReset}]" name="AnsCat01_JenisOpsi_[${AddQuestion01}][${answerReset}]" data-minimum-results-for-search="Infinity">
													<option value="" disabled selected>-- Pilih Jenis Opsi --</option>
												</select>
											</div>
											<div class="col-lg-4">
												<input id="AnsCat01_OpsiPilihan_[${AddQuestion01}][${answerReset}]" name="AnsCat01_OpsiPilihan_[${AddQuestion01}][${answerReset}]" type="text" class="form-control list-quest" placeholder="Opsi Pilihan" value="" />
											</div>
											<div class="col-lg-1">
												<input id="AnsCat01_Nilai_[${AddQuestion01}][${answerReset}]" name="AnsCat01_Nilai_[${AddQuestion01}][${answerReset}]" type="text" class="form-control list-quest" placeholder="Nilai" value="" />
											</div>
											<div class="col-lg-1">
												<input id="AnsCat01_Bobot_[${AddQuestion01}][${answerReset}]" name="AnsCat01_Bobot_[${AddQuestion01}][${answerReset}]" type="text" class="form-control list-quest" placeholder="Bobot" value="" />
											</div>
											<div class="col-lg-1">
											<div
												class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
												<input type="checkbox" class="custom-control-input"
													@if ($ans_ikmk->is_flag == '1') checked @endif
													id="AnsCat01_Flag_[${AddQuestion01}][${answerReset}]"
													name="AnsCat01_Flag_[${AddQuestion01}][${answerReset}]">
												<label class="custom-control-label"
													for="AnsCat01_Flag_[${AddQuestion01}][${answerReset}]"></label>
											</div>
											</div>
											<div class="col-lg">

												<button type="button" class="btn btn-success  btn_AnsCat01_Add" id="btn_AnsCat01_Add" name="btn_AnsCat01_Add" data-row-id="${AddQuestion01}"><i
														class="icon-plus3"></i></button>
											</div>
										</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div>&nbsp;<div>
						<div class="col-lg-12">
							<div class="text-center">
								<button type="button" id="btn_MainQuestCat01_Remove" name="btn_MainQuestCat01_Remove"
									class="btn btn-danger btn-labeled btn-labeled-start btn_MainQuestCat01_Remove">
									<span class="btn-labeled-icon bg-black bg-opacity-20"></span> Hapus Pertanyaan
								</button>
							</div>
						</div>	
						<div class="dropdown-divider"></div>
										</td>
					</tr> 
				`;
				$('#Question01').append(inputRow);
				add_opt_quest01(AddQuestion01, answerReset);
				AddQuestion01_++;
			});
			$(document).on('click', '.btn_MainQuestCat01_Remove', function(e) {
				e.preventDefault();

				let row_item = $(this).closest('tr');
				row_item.remove();
			});
			$(document).on('click', '.btn_AnsCat01_Add', function(e) {
				e.preventDefault();
				let row_id = $(this).data('row-id');
				if (latestInnerIterations[row_id] == null) {
					let AnsCat01 = 1;
					latestInnerIterations[row_id] = AnsCat01;
				}
				let AnsCat01 = latestInnerIterations[row_id];

				console.log(AnsCat01, row_id, latestInnerIterations[row_id]);
				// console.log(latestInnerIterations[4]);
				const inputRow =
					`
						<tr>
							<td>	
							<div class="row col-lg-12">
								<div class="col-lg-1">
									<input type="hidden" id="AnsCat01_Quest_hidden_[${row_id}][${AnsCat01}]" name="AnsCat01_Quest_hidden_[${row_id}][${AnsCat01}]" value="${row_id}" />
								
									<label class="col-form-label">&nbsp;</label>
								</div>
								<div class="col-lg-3">
									<select class="form-control select" id="AnsCat01_JenisOpsi_[${row_id}][${AnsCat01}]" name="AnsCat01_JenisOpsi_[${row_id}][${AnsCat01}]" data-minimum-results-for-search="Infinity">
									
									</select>
								</div>
								<div class="col-lg-4">
									<input id="AnsCat01_OpsiPilihan_[${row_id}][${AnsCat01}]" name="AnsCat01_OpsiPilihan_[${row_id}][${AnsCat01}]" type="text" class="form-control list-quest" placeholder="Opsi Pilihan" value="" />
								</div>
								<div class="col-lg-1">
									<input id="AnsCat01_Nilai_[${row_id}][${AnsCat01}]" name="AnsCat01_Nilai_[${row_id}][${AnsCat01}]" type="text" class="form-control list-quest" placeholder="Nilai" value="" />
								</div>
								<div class="col-lg-1">
									<input id="AnsCat01_Bobot_[${row_id}][${AnsCat01}]" name="AnsCat01_Bobot_[${row_id}][${AnsCat01}]" type="text" class="form-control list-quest" placeholder="Bobot" value="" />
								</div>
								<div class="col-lg-1">
								<div
									class=" text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
									<input type="checkbox" class="custom-control-input"
										@if ($ans_ikmk->is_flag == '1') checked @endif
										id="AnsCat01_Flag_[${row_id}][${AnsCat01}]"
										name="AnsCat01_Flag_[${row_id}][${AnsCat01}]">
									<label class="custom-control-label"
										for="AnsCat01_Flag_[${row_id}][${AnsCat01}]"></label>
								</div>
								</div>
								<div class="col-lg-1">
									<button type="button" class="btn btn-danger btn_AnsCat01_Remove" id="btn_AnsCat01_Remove" name="btn_AnsCat01_Remove" data-row-id="${AnsCat01}"><i
											class="icon-trash"></i></button>
								</div>
							</div>
							</td>
						</tr>
					`;
				$('#Answer01_' + row_id).append(inputRow);

				add_opt_quest01(row_id, AnsCat01);
				AddAnswer01_++;
				AnsCat01++;
				latestInnerIterations[row_id] = AnsCat01;
				console.log(latestInnerIterations[row_id]);

			});
			$(document).on('click', '.btn_AnsCat01_Remove', function(e) {
				e.preventDefault();

				let row_item = $(this).closest('tr');
				row_item.remove();
			});

			// let AddQuestion02 = 0;
			$(".btn_Question02_Add").click(function(e) {
				e.preventDefault();
				var QuestionIteration = {{ $AddQuestion02 }} + AddQuestion02_;
				let AddQuestion02 = QuestionIteration;

				// AddQuestion02++;
				const inputRow =
					`
					<tr style="width: 100%;">
										<td>
						<div class="row col-lg-12">
							<div class="col-lg-1">
								<label class="col-form-label">Pertanyaan</label>
							</div>
							<div class="col-lg-10 row">
								<div class="col-1">
									<input id="Question02_Seq[${AddQuestion02}]" name="Question02_Seq[${AddQuestion02}]" type="text"
									class="form-control list-quest" placeholder="Urutan" value="" />
								</div>
								<div class="col-11">
									<input id="Question02[${AddQuestion02}]" name="Question02[${AddQuestion02}]" type="text"
									class="form-control list-quest" placeholder="" value="" />
								</div>
							</div>
							<div class="col row">
								<div
									class="text-center custom-control custom-switch custom-switch-square custom-control-success justify-content-center mb-3">
									<input type="checkbox" name="is_active_QuestCat02[${AddQuestion02}]" class="custom-control-input"
										id="is_active_QuestCat02[${AddQuestion02}]">
									<label class="custom-control-label" for="is_active_QuestCat02[${AddQuestion02}]"></label>
								</div>
								<div class="col text-center">
									<button type="button" id="btn_MainQuestCat02_Remove" name="btn_MainQuestCat02_Remove"
										class="btn btn-danger btn-labeled btn-labeled-start btn_MainQuestCat02_Remove">
										<i class="icon-trash"></i>
									</button>
								</div>
							</div>
						</div>
						<div>&nbsp;<div>	
						<div class="dropdown-divider"></div>
										</td>
					</tr> 
				`;
				$('#Question02').append(inputRow);
				AddQuestion02_++;
			});
			$(document).on('click', '.btn_MainQuestCat02_Remove', function(e) {
				e.preventDefault();

				let row_item = $(this).closest('tr');
				row_item.remove();
			});
			$(document).on('click', '.btn_AnsCat02_Add', function(e) {
				e.preventDefault();

				let AnsCat02 = 0;
				let row_id = $(this).data('row-id');

				AnsCat02++;
				const inputRow =
					`
					<tr>
						<td>	
						<div class="row col-lg-12">
							<div class="col-lg-1">
								<label class="col-form-label">Kategori</label>
							</div>
							<div class="col-lg-10">
								<input id="AnsCat02_Kategori[${AnsCat02}]" name="AnsCat02_Kategori[${AnsCat02}]" type="text" class="form-control list-quest" placeholder="Kategori" value="" />
							</div>
							<div class="col-lg-1">
								<button type="button" class="btn btn-danger btn_AnsCat02_Remove" id="btn_AnsCat02_Remove" name="btn_AnsCat02_Remove"><i
										class="icon-trash"></i></button>
							</div>
						</div>
						</td>
					</tr>
				`;
				$('#Answer02_' + row_id).append(inputRow);
			});
			$(document).on('click', '.btn_AnsCat01_Remove', function(e) {
				e.preventDefault();

				let row_item = $(this).closest('tr');
				row_item.remove();
			});
			$(document).on('click', '.btn_AnsCat02_Remove', function(e) {
				e.preventDefault();

				let row_item = $(this).closest('tr');
				row_item.remove();
			});

			// let AddQuestion03 = 0;
			$(".btn_Question03_Add").click(function(e) {
				e.preventDefault();
				var QuestionIteration = {{ $AddQuestion03 }} + AddQuestion03_;
				let AddQuestion03 = QuestionIteration;
				const inputRow =
					`
					<tr style="width: 100%;">
						<td>
							<div class="row col-lg-12">
								<div class="col-lg-1">
									<label class="col-form-label">Pertanyaan</label>
								</div>
								<div class="col-lg-10 row">
									<div class="col-1">
										<input id="Question03_Seq[${AddQuestion03}]" name="Question03_Seq[${AddQuestion03}]" type="text"
										class="form-control list-quest" placeholder="Urutan" value="" />
									</div>
									<div class="col-11">
										<input id="Question03[${AddQuestion03}]" name="Question03[${AddQuestion03}]" type="text"
										class="form-control list-quest" placeholder="" value="" />
									</div>	
								</div>
								<div class="col row">
									<div
										class="text-center custom-control custom-switch custom-switch-square custom-control-success justify-content-center mb-3">
										<input type="checkbox" name="is_active_QuestCat03[${AddQuestion03}]" class="custom-control-input"
											id="is_active_QuestCat03[${AddQuestion03}]">
										<label class="custom-control-label" for="is_active_QuestCat03[${AddQuestion03}]"></label>
									</div>
									<div class="col text-center">
										<button type="button" id="btn_MainQuestCat03_Remove" name="btn_MainQuestCat03_Remove"
												class="btn btn-danger btn-labeled btn-labeled-start btn_MainQuestCat03_Remove">
												<i class="icon-trash"></i>
											</button>
									</div>
								</div>
							</div>
						<div class="dropdown-divider"></div>
						</td>
					</tr> 
				`;
				$('#Question03').append(inputRow);
				AddQuestion03_++;
			});
			$(document).on('click', '.btn_MainQuestCat03_Remove', function(e) {
				e.preventDefault();

				let row_item = $(this).closest('tr');
				row_item.remove();
			});

		});

		function submitsurvei() {
			showLoadingSpinner();
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			$('#formSurvei').submit();
		}
	</script>
@endsection
