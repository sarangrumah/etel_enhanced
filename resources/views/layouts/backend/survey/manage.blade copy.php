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
									<textarea class="form-control" name="infsurveiinit" id="infsurveiinit" rows="3" required></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<div>
								<label class="col-lg-12 col-form-label">Informasi Survei Persepsi Pelayanan Publik </label>
								<div class="col-lg">
									<textarea class="form-control" name="infsurveippp" id="infsurveippp" rows="3" required></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<div>
								<label class="col-lg-12 col-form-label">Informasi Survei Integritas Pelayanan Publik </label>
								<div class="col-lg">
									<textarea class="form-control" name="infsurveiipp" id="infsurveiipp" rows="3" required></textarea>
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
						<tbody id="Question01">
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
						<tbody id="Question02">
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
						<tbody id="Question03">
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
		var loadingSpinner = document.getElementById('loadingSpinner');

		function add_opt_quest01(questseq, optseq) {
			// alert(newOptions);
			// Get the select element by ID
			let selectElement = document.getElementById('AnsCat01_JenisOpsi_' + questseq + '[' + optseq + ']');
			let newOptions = @json($opt_answer01);

			// Remove existing options
			selectElement.innerHTML = '';

			// Add new options based on the data
			newOptions.forEach(option => {
				let newOption = document.createElement('option');
				newOption.value = option.opt_answer;
				newOption.text = option.opt_answer_desc;
				selectElement.appendChild(newOption);
			});

			// If you want to add a default option
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
		// let isSelected = false;

		function toggleState(button, hiddenInput) {
			// const icon = document.querySelector('.btnIcon');

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

			// Save the state (true or false) as needed
			// You can use isSelected variable for further processing
			// console.log('State:', isSelected)
		};



		$(document).ready(function() {
			CKEDITOR.replace('infsurveiinit');
			CKEDITOR.replace('infsurveippp');
			CKEDITOR.replace('infsurveiipp');
			// let AddQuestion01 = 0;
			// let AnsCat01 = 1;
			let questionCounters = {};
			$(".btn_Question01_Add").click(function(e) {
				e.preventDefault();

				let currentQuestionId = $(this).data('row-id');
				questionCounters[currentQuestionId] = (questionCounters[currentQuestionId] || 0) + 1;

				alert(questionCounters[currentQuestionId]);
				let AddQuestion01 = questionCounters[currentQuestionId];
				// alert(AddQuestion01);

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
									<input id="Question01_Seq[${AddQuestion01}]" name="Question01_Seq[${AddQuestion01}]" type="text"
									class="form-control list-quest" placeholder="Urutan" value="" />
								</div>
								<div class="col-11">
								<input id="Question01[${AddQuestion01}]" name="Question01[${AddQuestion01}]" type="text"
									class="form-control list-quest" placeholder="Pertanyaan" value="" />
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
											<div class="col-lg-1">
												<label class="col-form-label">Jawaban</label>
											</div>
											<div class="col-lg-3">
												<select class="form-control select" id="AnsCat01_JenisOpsi_${AddQuestion01}[${AddQuestion01}]" name="AnsCat01_JenisOpsi_${AddQuestion01}[${AddQuestion01}]" data-minimum-results-for-search="Infinity">
													<option value="" disabled selected>-- Pilih Jenis Opsi --</option>
												</select>
											</div>
											<div class="col-lg-4">
												<input id="AnsCat01_OpsiPilihan_${AddQuestion01}[${AddQuestion01}]" name="AnsCat01_OpsiPilihan_${AddQuestion01}[${AddQuestion01}]" type="text" class="form-control list-quest" placeholder="Opsi Pilihan" value="" />
											</div>
											<div class="col-lg-1">
												<input id="AnsCat01_Nilai_${AddQuestion01}[${AddQuestion01}]" name="AnsCat01_Nilai_${AddQuestion01}[${AddQuestion01}]" type="text" class="form-control list-quest" placeholder="Nilai" value="" />
											</div>
											<div class="col-lg-1">
												<input id="AnsCat01_Bobot_${AddQuestion01}[${AddQuestion01}]" name="AnsCat01_Bobot_${AddQuestion01}[${AddQuestion01}]" type="text" class="form-control list-quest" placeholder="Bobot" value="" />
											</div>
											<div class="text-center col-lg-1">
												<input type="hidden" id="AnsCat01_Flag_hidden_${AddQuestion01}[${AddQuestion01}]" name="AnsCat01_Flag_hidden_${AddQuestion01}[${AddQuestion01}]" value="" />
												<button id="AnsCat01_Flag_${AddQuestion01}[${AddQuestion01}]" name="AnsCat01_Flag_${AddQuestion01}[${AddQuestion01}]" type="button" class="btn btnIcon" onclick="toggleState(this, document.getElementById('AnsCat01_Flag_hidden_${AddQuestion01}[${AddQuestion01}]'))"><i
														class="icon-flag3"></i></button>
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
				// add_opt_quest01(AddQuestion01, AnsCat01);
			});
			$(document).on('click', '.btn_MainQuestCat01_Remove', function(e) {
				e.preventDefault();

				let row_item = $(this).closest('tr');
				row_item.remove();
			});
			$(document).on('click', '.btn_AnsCat01_Add', function(e) {
				e.preventDefault();
				let row_id = $(this).data('row-id');

				let currentQuestionCounter = questionCounters[row_id] || 0;

				// Increment AnsCat01 when adding an answer to the current question
				let AnsCat01 = currentQuestionCounter + 1;
				// alert(AnsCat01);
				// if (row_id != AddQuestion01) {
				// 	AnsCat01++;
				// }
				// alert(row_id);

				// let AnsCat01 = 1;
				// AnsCat01++;
				const inputRow =
					`
					<tr>
						<td>	
						<div class="row col-lg-12">
							<div class="col-lg-1">
								<label class="col-form-label">&nbsp;</label>
							</div>
							<div class="col-lg-3">
								<select class="form-control select" id="AnsCat01_JenisOpsi_${row_id}[${AnsCat01}]" name="AnsCat01_JenisOpsi_${row_id}[${AnsCat01}]" data-minimum-results-for-search="Infinity">
									
								</select>
							</div>
							<div class="col-lg-4">
								<input id="AnsCat01_OpsiPilihan_${row_id}[${AnsCat01}]" name="AnsCat01_OpsiPilihan_${row_id}[${AnsCat01}]" type="text" class="form-control list-quest" placeholder="Opsi Pilihan" value="" />
							</div>
							<div class="col-lg-1">
								<input id="AnsCat01_Nilai_${row_id}[${AnsCat01}]" name="AnsCat01_Nilai_${row_id}[${AnsCat01}]" type="text" class="form-control list-quest" placeholder="Nilai" value="" />
							</div>
							<div class="col-lg-1">
								<input id="AnsCat01_Bobot_${row_id}[${AnsCat01}]" name="AnsCat01_Bobot_${row_id}[${AnsCat01}]" type="text" class="form-control list-quest" placeholder="Bobot" value="" />
							</div>
							<div class="text-center col-lg-1">
								<input type="hidden" id="AnsCat01_Flag_hidden_${row_id}[${AnsCat01}]" name="AnsCat01_Flag_hidden_${row_id}[${AnsCat01}]" value="" />
								<button id="AnsCat01_Flag_${row_id}[${AnsCat01}]" name="AnsCat01_Flag_${row_id}[${AnsCat01}]" type="button" class="btn btnIcon" onclick="toggleState(this, document.getElementById('AnsCat01_Flag_hidden_${row_id}[${AnsCat01}]'))"><i
										class="icon-flag3"></i></button>
							</div>
							<div class="col-lg-1">
								<button type="button" class="btn btn-danger btn_AnsCat01_Remove" id="btn_AnsCat01_Remove" name="btn_AnsCat01_Remove" data-row-id="${AnsCat01}"><i
										class="icon-trash"></i></button>
							</div>
						</div>
						</td>
					</tr>
				`;
				// $('#Answer01_' + row_id).append(inputRow);

				add_opt_quest01(AnsCat01);
				questionCounters[row_id] = currentQuestionCounter + 1;
				// alert(questionCounters[row_id]);
			});
			$(document).on('click', '.btn_AnsCat01_Remove', function(e) {
				e.preventDefault();

				let row_item = $(this).closest('tr');
				row_item.remove();
			});

			let AddQuestion02 = 0;
			$(".btn_Question02_Add").click(function(e) {
				e.preventDefault();

				AddQuestion02++;
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

			let AddQuestion03 = 0;
			$(".btn_Question03_Add").click(function(e) {
				e.preventDefault();

				AddQuestion03++;
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
								<div class="col-lg-1 row">
									<div
										class="col text-center custom-control custom-switch custom-switch-square custom-control-success justify-content-center mb-3">
										<input type="checkbox" name="is_active_QuestCat03[${AddQuestion03}]" class="custom-control-input"
											id="is_active_QuestCat03[${AddQuestion03}]">
										<label class="custom-control-label" for="is_active_QuestCat03[${AddQuestion03}]"></label>
									</div>
									<div class="col">
										<div class="text-center">
											<button type="button" id="btn_MainQuestCat03_Remove" name="btn_MainQuestCat03_Remove"
												class="btn btn-danger btn-labeled btn-labeled-start btn_MainQuestCat03_Remove">
												<i class="icon-trash"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						<div class="dropdown-divider"></div>
						</td>
					</tr> 
				`;
				$('#Question03').append(inputRow);
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
