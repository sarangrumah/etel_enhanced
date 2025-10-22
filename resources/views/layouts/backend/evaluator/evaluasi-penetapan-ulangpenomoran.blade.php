@extends('layouts.backend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
	<div id="loadingSpinner" class="loading-spinner" style="display: none;">
		<img id="spinnerImage" src="/assets/kominfo/spinner-kominfo-trp.svg" alt="Loading Spinner">
	</div>
	{{-- @if (Session::get('message') != '')
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ Session::get('message') }}</strong>
        </div>
    @endif --}}
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
	<form method="post" id="formEvaluasi" action="{{ route('admin.evaluator.evaluasi-penetapanulangpenomoranPost', [$id]) }}"
		enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="action" id="action" value="">
		<div class="form-group">
			<input type="hidden" id="id" name="id" value="{{ $id }}">

			<div>
				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Penetapan Penomoran </h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group row">
							<div class="col">
								<legend class="text-uppercase font-size-sm font-weight-bold">Data Penomoran
								</legend>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-2 col-form-label">Jenis Penomoran </label>
											<div class="input-group col-lg-10">
												<input type="text" class="col-lg form-control" value="{{ $penomoran->jenis_penomoran }}" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-2 col-form-label">Kode Akses </label>
											<div class="col-lg-10">
												<input type="text" class="col-lg form-control" value="{{ $penomoran->kode_akses }}" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-2 col-form-label">Status </label>
											<div class="col-lg-10">
												<input type="text" class="col-lg form-control" value="{{ $penomoran->status }}" disabled>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div>
				<div class="card">
					<div class="card-header bg-indigo text-white header-elements-inline">
						<div class="row">
							<div class="col-lg">
								<h6 class="card-title font-weight-semibold py-3">Data Kelengkapan Institusi </h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group row">
							<div class="col">
								<legend class="text-uppercase font-size-sm font-weight-bold">Data Penguna Penomoran</legend>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-2 col-form-label">Jenis Pengguna </label>
											<div class="input-group col-lg-10">
												<select class="form-control form-control-select2" id="alokasi_jenispengguna" name="alokasi_jenispengguna">
													<option value="" disabled selected>-- Pilih Jenis Pengguna --
														@foreach ($jenis_perseroan as $item)
													<option value="{{ $item->oss_kode }}" @if ($penomoran->jenis_pengguna == $item->name) selected @endif>{{ $item->name }}
													</option>
													@endforeach
													</option>
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-12 d-none" id="pilih_perizinan">
										<div class="row">
											<label class="col-lg-2 col-form-label">Perizinan</label>
											<div class="col-lg-10">
												<select name="perizinan" class="form-control form-control-select2" data-toggle="tooltip"
													data-placement="bottom" title="Pilih Perizinan Izin Penyelenggaraan" required>
													<option value="">Silakan Pilih..</option>
													<option value="jasa">Izin Penyelenggaraan Jasa</option>
													<option value="jaringan">Izin Penyelenggaraan Jaringan</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12 d-none" id="pilih_kbli">
										<div class="row">
											<label class="col-lg-2 col-form-label">KBLI</label>
											<div class="input-group col-lg-10">
												<select class="form-control form-control-select2" name="jeniskbli" id="jeniskbli" data-toggle="tooltip"
													data-placement="bottom" title="Pilih Perizinan KBLI" required>
													<option value="">Silakan Pilih..</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group" id="PilihNomor">
									<div class="col-lg-12 d-none" id="pilih_layanan">
										<div class="row">
											<label class="col-lg-2 col-form-label">Jenis Layanan</label>
											<div class="input-group col-lg-10">
												<select class="form-control form-control-select2" name="jenislayanan" data-toggle="tooltip"
													data-placement="bottom" title="Pilih Jenis Layanan" required>
													<option value="">Silakan Pilih..</option>
												</select>
											</div>
										</div>
									</div>
								</div>

								@if (isset($penomoran->jenis_pengguna))
									@if ($penomoran->jenis_pengguna == 'Penyelenggara Telekomunikasi')
										<div class="form-group">
											<div class="col-lg-12 d-none" id="pilih_nib">

												<div class="row">
													<label class="col-lg-2 col-form-label">NIB </label>

													<div class=" col-lg-10 row">
														<div class="col-lg-6">
															<input type="text" class="col-lg form-control" id="nib" name="nib"
																value="{{ $penomoran->nib }}">
														</div>
														<div class="col-lg-6">
															<input type="file" class="form-control h-auto" name="berkas_nib" id="berkas_nib"
																accept="application/pdf">
														</div>
													</div>
												</div>
											</div>
										</div>
									@endif
								@else
									<div class="form-group">
										<div class="col-lg-12 d-none" id="pilih_nib">

											<div class="row">
												<label class="col-lg-2 col-form-label">NIB </label>

												<div class=" col-lg-10 row">
													<div class="col-lg-6">
														<input type="text" class="col-lg form-control" id="nib" name="nib" value="">
													</div>
													<div class="col-lg-6">
														<input type="file" class="form-control h-auto" name="berkas_nib" id="berkas_nib"
															accept="application/pdf">
													</div>
												</div>
											</div>
										</div>
									</div>
								@endif

								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-2 col-form-label">Nama Institusi </label>
											<div class="col-lg-10">
												<input type="text" class="col-lg form-control" id="nama_perseroan" name="nama_perseroan"
													value="{{ $penomoran->nama_perseroan }}">
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-2 col-form-label">Jenis Institusi </label>
											<div class="col-lg-10">
												<select data-placeholder="Pilih Jenis Instansi/Badan Hukum/Perusahaan" name="vJenisInstansi"
													id="vJenisInstansi" class="form-control form-control-select2" data-fouc required>
													<option></option>
													@if ($penomoran->jenis_pengguna == 'Penyelenggara Telekomunikasi')
														@foreach ($instansi_bh as $key => $vi)
															<option value="{{ $vi->oss_kode }}">
																{{ $vi->name }}
															</option>
														@endforeach
													@else
														@foreach ($instansi_npt as $key => $vi)
															<option value="{{ $vi->oss_kode }}">
																{{ $vi->name }}
															</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-2 col-form-label">Alamat </label>
											<div class="col-lg-10">
												<input type="text" class="col-lg form-control" name="alamat_perseroan" id="alamat_perseroan">
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-2 col-form-label"> </label>
											<div class="col-lg-10 row">
												<div class="col-lg-6 ms-lg-auto">
													<div class="form-group">
														<div class="col-lg-12">
															<div class="row">
																<label class="col-lg-3 col-form-label">Provinsi </label>
																<div class="col-lg-9">
																	<select data-placeholder="Pilih Provinsi" name="vProvinsi" id="vProvinsi"
																		class="form-control form-control-select2" data-fouc required>
																		<option></option>
																		@foreach ($provinsi as $vp)
																			<option value="{{ $vp->id }}">
																				{{ $vp->name }}
																			</option>
																		@endforeach
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="col-lg-12">
															<div class="row">
																<label class="col-lg-3 col-form-label">Kota/Kabupaten </label>
																<div class="col-lg-9">
																	<select data-placeholder="Pilih Kota/Kabupaten" name="vKotaKabupaten" id="vKotaKabupaten"
																		class="form-control form-control-select2" data-fouc required>
																		<option></option>
																	</select>
																	<div class="mt-1 spinner-border loading text-primary" role="status" id="vKotaKabupaten-loading">
																		<span class="sr-only">Loading...</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="col-lg-12">
															<div class="row">
																<label class="col-lg-3 col-form-label">Kecamatan </label>
																<div class="col-lg-9">
																	<select data-placeholder="Pilih Kecamatan" name="vKecamatan" id="vKecamatan"
																		class="form-control form-control-select2" data-fouc required>
																		<option></option>
																	</select>
																	<div class="mt-1 spinner-border loading text-primary" role="status" id="vKecamatan-loading">
																		<span class="sr-only">Loading...</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-lg-6 ms-lg-auto">
													<div class="form-group">
														<div class="col-lg-12">
															<div class="row">
																<label class="col-lg-3 col-form-label">Kelurahan/Desa </label>
																<div class="col-lg-9">
																	<select data-placeholder="Pilih Kelurahan/Desa" name="vKelurahan" id="vKelurahan"
																		class="form-control form-control-select2" data-fouc required>
																		<option></option>
																	</select>
																	<div class="mt-1 spinner-border loading text-primary" role="status" id="vKelurahan-loading">
																		<span class="sr-only">Loading...</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="col-lg-12">
															<div class="row">
																<label class="col-lg-3 col-form-label">Kode POS </label>
																<div class="col-lg-9">
																	<input type="text" class="col-lg form-control" name="kodepos" id="kodepos">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-2 col-form-label">e-Mail </label>
											<div class="col-lg-10">
												<input type="text" class="col-lg form-control" name="email_perusahaan" id="email_perusahaan">
											</div>
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
						<h6 class="card-title font-weight-semibold py-3">Kelengkapan </h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="col-lg-12 form-group row">
					<div class="col-lg-12">
						<div class="col-lg-12">
							<label class="col-form-label">Dasar Penetapan Ulang </label>
						</div>
						<div class="col-lg-12">
							<textarea rows="6" cols="6" class="form-control dasarpenetapan" id="dasarpenetapan" placeholder=""
							 name="dasarpenetapan" required></textarea>
						</div>
					</div>
				</div>
				<div class="col-lg-12 row">
					<div class="col-lg-12">
						<label class="col-lg-12 col-form-label" for="berkas_tambahan">Data Dukung Penetapan Ulang
							Penomoran</label>
					</div>
					<div class="col-lg-12">
						<div class="col-lg-12">
							<input type="file" class="form-control h-auto" name="berkas_tambahan" id="berkas_tambahan"
								accept="application/pdf">
						</div>
					</div>
					<div class="col-lg-12 form-group row">

						<div class="col-lg-12">
							<label class="col-lg-12 col-form-label">Catatan Penetapan Ulang </label>
						</div>
						<div class="col-lg-12">
							<textarea rows="3" cols="3" class="form-control" id="catatan_hasil_evaluasi"
							 placeholder="Catatan Hasil Evaluasi" name="catatan_hasil_evaluasi"></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group text-right">
				<a href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i
						class="icon-backward2 ml-2"></i> Kembali </a>
				{{-- <a href="{{ route('admin.sk.draftpenomoranpenetapanulang', [$id]) }}" target="_blank" class="btn btn-success"
				id='draftpenomoran'>Draf Penetapan <i class="icon-file-pdf ml-2"></i></a> --}}
				<button type="button" id="btn_draft" name="btn_draft" value="draft"
					onclick="submitdisposisi('draft');return false;" class="btn btn-success">Draf Penetapan <i
						class="icon-file-pdf ml-2"></i></button>
				<button type="button" id="btn_submit" name="btn_submit" value="submit" data-target="#submitModal"
					data-toggle="modal" class="btn btn-indigo">Kirim
					Evaluasi <i class="icon-paperplane ml-2"></i></button>
			</div>
		</div>

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
						<p>Apakah anda yakin akan mengirim evaluasi ini ?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
						<button type="button" id="btnSubmit" onclick="submitdisposisi('disposisi');return false;"
							class="btn btn-primary notif-button">Kirim</button>
						<div class="spinner-border loading text-primary" role="status" hidden>
							<span class="sr-only">Loading...</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" id="submitDraft" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Kirim Evaluasi</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Apakah anda yakin akan menyimpan evaluasi ini ?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
						<button type="button" id="btnSubmit" onclick="submitdisposisi('draft');return false;"
							class="btn btn-primary notif-button">Kirim</button>
						<div class="spinner-border loading text-primary" role="status" hidden>
							<span class="sr-only">Loading...</span>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>

	<script>
		var loadingSpinner = document.getElementById('loadingSpinner');

		function showLoadingSpinner() {
			// loadingSpinner.style.display = 'block';
			var spinner = document.getElementById('loadingSpinner');
			spinner.style.display = 'flex';
		}
		// document.getElementById('btn_draft').addEventListener('click', function() {
		//     // Open the form in a new tab
		//     window.open('', '_blank').location.href =
		//         '{{ route('admin.evaluator.evaluasi-pencabutanpenomoranPost', [$id, $penomoran->id_mst_kode_akses]) }}?btn_draft=true';
		// });

		function draftpencabutan(kode_akses) {
			// var selectedvalue = document.getElementById('kodeakses_hapus[' + selectElement + '][status_pe_sk]').value;
			// var kode_akses = document.getElementById('kodeakses_hapus[' + selectElement + '][kode_akses]').value;
			// var kode_wilayah = document.getElementById('kode_wilayah[' + selectElement + ']').value;
			// var prefix_awal = document.getElementById('prefix_awal[' + selectElement + ']').value;
			var id_izin = document.getElementById('id_izin').value;
			// console.log('Selected Element:', selectedElement.value, selectedElement2.value);
			// var selectedValue = selectElement.value;
			// console.log(selectedValue);
			// document.getElementById('otherInput').value;

			// Make an AJAX request to Laravel backend
			$.ajax({
				type: "POST",
				url: "/admin/disactivated-kodeakses",
				// dataType: "json",
				data: {
					// value: selectedvalue,
					kode_akses: kode_akses,
					// prefix_awal: prefix_awal,
					id_izin: id_izin,
					_token: "{{ csrf_token() }}",
				},
				success: function(data) {
					// Handle success response
					console.log(data);
				},
				error: function(data) {
					var errors = data.responseJSON;
					// Handle error response
					console.log(errors);
				}
			});
		}

		function submitdisposisi($act) {
			if ($('#status_sk').val() == 0 && $('#catatan_hasil_evaluasi').val() == '') {
				$('#submitModal').modal('toggle');
				alert('Silakan mengisi catatan hasil evaluasi');
			} else {
				if ($act == 'draft') {
					$('#formEvaluasi').attr('target', '_blank');
					$('#action').val($act);
					$('#formEvaluasi').submit();
				} else {
					$('#formEvaluasi').removeAttr('target', '_blank');
					$('#action').val($act);
					showLoadingSpinner();
					// $('#formEvaluasi').submit();
					$('.notif-button').attr("hidden", true);
					$('.loading').attr("hidden", false);
					$('#formEvaluasi').submit();
					$("#btnSubmit").attr("disabled", true);
					$("#btnSubmitKoreksi").attr("disabled", true);
				}
			}
		}

		function submitdisposisiTolak() {
			showLoadingSpinner();
			$('#formEvaluasiTolak').submit();
		}

		function updateskpencabutan() {
			var id = document.getElementById('id').value;
			// var id_kodeakses = document.getElementById('id_kodeakses').value;
			var dasarpencabutan = document.getElementById('dasarpencabutan').value;
			var pertimbanganpencabutan = document.getElementById('pertimbanganpencabutan').value;
			// alert(id_kodeakses);
			// Make an AJAX request to Laravel backend
			$.ajax({
				type: "POST",
				url: "/admin/updateskpencabutan-kodeakses",
				// dataType: "json",
				data: {
					id: id,
					dasarpencabutan: dasarpencabutan,
					pertimbanganpencabutan: pertimbanganpencabutan,
					// no_sk: no_sk,
					_token: "{{ csrf_token() }}",
				},
				success: function(data) {
					// Handle success response
					console.log(data);
				},
				error: function(data) {
					var errors = data.responseJSON;
					// Handle error response
					console.log(errors);
				}
			});
		}
	</script>
	<script type="text/javascript">
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

		$('select[name="perizinan"]').on('change', function() {
			var izin = $(this).val();
			$(this).tooltip('dispose');
			// alert(izin);
			if (izin) {
				$.ajax({
					url: '/api/getjenislayanan_nomor/' + izin,
					type: "GET",
					dataType: "json",
					success: function(data) {
						console.log(data);

						$('select[name="jeniskodeakses"]').empty();
						$('select[name="jeniskodeakses"]').append(
							'<option value="">-- Pilih Jenis Penomoran --</option>'
						);
						$('select[name="availno"]').empty();
						$('select[name="availno"]').append(
							'<option value="">-- Pilih Kode Akses --</option>'
						);

						$('select[name="jenislayanan"]').empty();
						$('select[name="jenislayanan"]').append(
							'<option value="">-- Pilih Jenis Layanan --</option>'
						);

						$('select[name="jeniskbli"]').empty();
						$('select[name="jeniskbli"]').append(
							'<option value="" selected disabled>-- Pilih KBLI --</option>');
						$.each(data, function(key, value) {
							$('select[name="jeniskbli"]').append(
								'<option value="' + value.name + '">' + value
								.name + ' - ' + value.desc + '</option>');
						});


					}
				});
			} else {
				$('select[name="jeniskbli"]').empty();
			}
		});
		$('select[name="jeniskbli"]').on('change', function() {
			var kbli = $(this).val();
			$(this).tooltip('dispose');
			// console.log(izin);
			if (kbli) {
				$.ajax({
					url: '/api/getjeniskbli_nomor/' + kbli,
					type: "GET",
					dataType: "json",
					success: function(data) {
						console.log(data);

						$('select[name="jeniskodeakses"]').empty();
						$('select[name="jeniskodeakses"]').append(
							'<option value="">-- Pilih Jenis Penomoran --</option>'
						);
						$('select[name="availno"]').empty();
						$('select[name="availno"]').append(
							'<option value="">-- Pilih Kode Akses --</option>'
						);

						$('select[name="jenislayanan"]').empty();
						$('select[name="jenislayanan"]').append(
							'<option value="">-- Pilih Jenis Layanan --</option>'
						);
						$.each(data, function(key, value) {

							$('select[name="jenislayanan"]').append(
								'<option value="' + value.kode_izin + '">' +
								value
								.name + '</option>');
						});


					}
				});
			} else {

				$('select[name="jeniskbli"]').empty();
				$('select[name="jeniskbli"]').append(
					'<option value="">-- Pilih Jenis KBLI --</option>'
				);
				$('select[name="jeniskodeakses"]').empty();
				$('select[name="jeniskodeakses"]').append(
					'<option value="">-- Pilih Jenis Penomoran --</option>'
				);
				$('select[name="availno"]').empty();
				$('select[name="availno"]').append(
					'<option value="">-- Pilih Kode Akses --</option>'
				);

				$('select[name="jenislayanan"]').empty();
				$('select[name="jenislayanan"]').append(
					'<option value="">-- Pilih Jenis Layanan --</option>'
				);

			}
		});
		$(document).ready(function() {

			$("#btnSubmitModalKoreksi").hide();
			$("#btnSubmitModal").show();
			$('#dasarpencabutan').blur(function(e) {
				// Get value from the input box
				e.preventDefault();
				// let row_item = $(this).parent().parent();

				// let inputValue = row_item.find('.pilih-bloknomor').val();
				// alert(inputValue);
				updateskpencabutan();
			});

			// $('#btn_draft').click(function() {
			// 	// Capture input values and construct the URL with query parameters
			// 	var params = {};
			// 	$('#formEvaluasi').find('input').each(function() {
			// 		params[$(this).attr('name')] = $(this).val();
			// 	});

			// 	$('#formEvaluasi').find('select').each(function() {
			// 		params[$(this).attr('name')] = $(this).val();
			// 	});

			// 	// Capture file uploads
			// 	var formData = new FormData();
			// 	$('#formEvaluasi').find('input[type="file"]').each(function() {
			// 		var fileInput = $(this)[0];
			// 		if (fileInput.files.length > 0) {
			// 			formData.append($(this).attr('name'), fileInput.files[0]);
			// 		}
			// 	});

			// 	// Construct the query string
			// 	var queryString = $.param(params);

			// 	// Construct the URL with query parameters
			// 	var draftUrl = "{{ route('admin.sk.draftpenomoranpenetapanulang', [$id]) }}" + '?' +
			// 		queryString;

			// 	// Open the draft URL in a new tab
			// 	window.open(draftUrl, '_blank');
			// });

			$('#pertimbanganpencabutan').blur(function(e) {
				// Get value from the input box
				e.preventDefault();
				// let row_item = $(this).parent().parent();

				// let inputValue = row_item.find('.pilih-bloknomor').val();
				// alert(inputValue);
				updateskpencabutan();
			});

			$('#vKotaKabupaten-loading').hide();
			$('#vKecamatan-loading').hide();
			$('#vKelurahan-loading').hide();

			$("#chekCheklis").change(function() {
				if ($('#chekCheklis').is(":checked")) {
					$("#btnSubmitRegisPt").removeClass("disabled");
				} else {
					$("#btnSubmitRegisPt").addClass("disabled");
				}
			});


			$("#vProvinsi").change(function() {
				var provinsi = $("#vProvinsi").val();
				$.ajax({
					type: "POST",
					url: "{{ url('/admin/ip/getKabupaten') }}",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						provinsi: provinsi
					},
					// contentType: "application/json; charset=utf-8",
					dataType: "json",
					beforeSend: function() {
						$('#vKotaKabupaten-loading').show();
					},
					success: function(e) {
						if (e.pesan == 'Suksess') {
							var tempoption = "";
							var tempoption = "<option>-- Pilih kabupaten --</option>";
							$.each(e.data, function(key, value) {
								tempoption += "<option value='" + value.id + "'>" +
									value.name + "</option>";
							});
						} else {
							alert("Terjadi Kesalahan Silahkan Coba Lagi nanti!");
						}

						$("#vKotaKabupaten").html(tempoption);
						var tempoption_kec = "<option>-- Pilih Kecamatan --</option>";
						$("#vKecamatan").html(tempoption_kec);
						$("#vKecamatan").attr("disabled");

						var tempoption_kel = "<option>-- Pilih Kelurahan --</option>";
						$("#vKelurahan").html(tempoption_kel);
						$("#vKelurahan").attr("disabled");

						$("#vKotaKabupaten").removeAttr("disabled");
						$('#vKotaKabupaten-loading').hide();
					},
					failure: function(errMsg) {
						alert(errMsg);
					}
				});
			});
			$("#vKotaKabupaten").change(function() {
				var kabupaten = $("#vKotaKabupaten").val();
				$.ajax({
					type: "POST",
					url: "{{ url('/admin/ip/getKecamatan') }}",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						kabupaten: kabupaten
					},
					// contentType: "application/json; charset=utf-8",
					dataType: "json",
					beforeSend: function() {
						$('#vKecamatan-loading').show();
					},
					success: function(e) {
						if (e.pesan == 'Suksess') {
							var tempoption = "";
							var tempoption = "<option>-- Pilih kecamatan --</option>";
							$.each(e.data, function(key, value) {
								tempoption += "<option value='" + value.id + "'>" +
									value.name + "</option>";
							});
						} else {
							alert("Terjadi Kesalahan Silahkan Coba Lagi nanti!");
						}

						$("#vKecamatan").html(tempoption);
						$("#vKecamatan").removeAttr("disabled");
						$('#vKecamatan-loading').hide();

						var tempoption_kel = "<option>-- Pilih Kelurahan --</option>";
						$("#vKelurahan").html(tempoption_kel);
						$("#vKelurahan").attr("disabled");
					},
					failure: function(errMsg) {
						alert(errMsg);
					}
				});
			});
			$("#vKecamatan").change(function() {
				var kecamatan = $("#vKecamatan").val();
				$.ajax({
					type: "POST",
					url: "{{ url('/admin/ip/getKelurahan') }}",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						kecamatan: kecamatan
					},
					// contentType: "application/json; charset=utf-8",?
					dataType: "json",
					beforeSend: function() {
						$('#vKelurahan-loading').show();
					},
					success: function(e) {
						if (e.pesan == 'Suksess') {
							var tempoption = "";
							var tempoption = "<option>-- Pilih Kelurahan --</option>";
							$.each(e.data, function(key, value) {
								tempoption += "<option value='" + value.id + "'>" +
									value.name + "</option>";
							});
						} else {
							alert("Terjadi Kesalahan Silahkan Coba Lagi nanti!");
						}

						$("#vKelurahan").html(tempoption);
						$("#vKelurahan").removeAttr("disabled");
						$('#vKelurahan-loading').hide();
					},
					failure: function(errMsg) {
						alert(errMsg);
					}
				});
			});
			$('#alokasi_jenispengguna').change(function() {

				var selectedValue = $(this).val();
				var selectedName = $(this).find('option:selected').text();
				console.log(selectedName);
				var options = '';
				// var instansiNpt = @json($instansi_npt);

				// Clear the existing options
				$('#vJenisInstansi').empty();

				// Check the selected value and populate the appropriate options
				if (selectedValue === '01') {
					$('#pilih_perizinan').removeClass("d-none");
					$('#pilih_kbli').removeClass("d-none");
					$('#pilih_layanan').removeClass("d-none");
					$('#pilih_nib').removeClass("d-none");
					$('#vJenisInstansi').empty();
					@foreach ($instansi_bh as $vi)
						options += '<option value="{{ $vi->oss_kode }}">{{ $vi->name }}</option>';
					@endforeach
				} else {
					$('#pilih_perizinan').addClass("d-none");
					$('#pilih_kbli').addClass("d-none");
					$('#pilih_layanan').addClass("d-none");
					$('#pilih_nib').addClass("d-none");
					// @foreach ($instansi_npt as $vi)
					// console.log($instansi_npt);
					// if ($instansi_npt.name == selectedName) {
					// 	options += '<option value="{{ $vi->oss_kode }}">{{ $vi->name }}</option>';
					// }
					options = '<option value="' + selectedName +
						'">' + selectedName +
						'</option>';
					// @endforeach
					// instansiNpt.forEach(function(instansi) {
					// 	if (instansi.name === selectedName) {
					// 		options += '<option value="' + instansi.oss_kode + '">' + instansi.name +
					// 			'</option>';
					// 	}
					// });
				}

				// Append the new options
				$('#vJenisInstansi').append(options);

				// Optionally, trigger change event to update any dependent elements
				$('#vJenisInstansi').trigger('change');
			});

			// Trigger change event on page load to populate initial options if needed
			$('#alokasi_jenispengguna').trigger('change');
		});
	</script>
@endsection
