@extends('layouts.frontend.main')
<!-- @section('title', 'Permohonan Penomoran Baru') -->
@section('js')

	<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="/global_assets/js/demo_pages/form_layouts.js"></script>
	{{-- <script src="/global_assets/js/demo_pages/uploader_dropzone.js"></script> --}}
	{{-- <link href="/global_assets/css/extras/select2.min.css" rel="stylesheet" /> --}}

@endsection
@section('content')
	<div id="loadingSpinner" class="loading-spinner" style="display: none;">
		<img id="spinnerImage" src="/assets/kominfo/spinner-kominfo-trp.svg" alt="Loading Spinner">
	</div>

	@if (session()->has('error'))
		<div class="alert alert-danger">
			Blok Nomor tersebut sudah ada yang mengajukan silahkan input Blok Nomor Lain.
		</div>
	@endif
	@if (Session::get('message') != '')
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif
	{{--
<!-- <x-perizinan /> --> --}}
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
	<div>

	</div>
	<!-- End Section Detail Permohonan -->
	<div class="card">
		<form action="{{ url('penomoran/savepenyesuaian') }}" id="frm" method="POST" enctype="multipart/form-data">
			{{-- <form action="#" id="frm" method="POST" enctype="multipart/form-data"> --}}
			@csrf
			<input type="hidden" id="id_jenislayanan" name="id_jenislayanan" value="">
			<input type="hidden" id="id_jeniskodeakses" name="id_jeniskodeakses" value="">
			<input type="hidden" id="id_kodeakses" name="id_kodeakses" value="">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						@if ($penambahan)
							<h6 class="card-title font-weight-semibold py-3">Permohonan Penetapan Nomor Tambahan</h6>
						@elseif($pengembalian)
							<h6 class="card-title font-weight-semibold py-3">Pengembalian Penomoran</h6>
						@elseif($penyesuaian)
							<h6 class="card-title font-weight-semibold py-3">Perubahan Penetapan Penomoran</h6>
						@else
							<h6 class="card-title font-weight-semibold py-3">Permohonan Penetapan Nomor Baru</h6>
						@endif
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col">
						<fieldset>
							<div class="form-group row">
								<label class="col-lg-4 col-form-label">Alasan Perubahan<span class="text-danger">*</span></label>
								<div class="col-lg-8">
									<select name="reasonrevise" class="form-control required" data-toggle="tooltip" data-placement="bottom"
										title="Pilih Alasan Permohonan Perubahan" required>
										<option value="">Silakan Pilih..</option>
										<option value="Perubahan Nama dan/atau Alamat Badan Hukum">Perubahan Nama dan/atau
											Alamat Badan Hukum</option>
										<option value="Perubahan Ketentuan Peraturan Perundang-undangan">Perubahan Ketentuan
											Peraturan Perundang-undangan</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 col-form-label">Perizinan<span class="text-danger">*</span></label>
								<div class="col-lg-8">
									<select name="perizinan" class="form-control required" data-toggle="tooltip" data-placement="bottom"
										title="Pilih Perizinan Izin Penyelenggaraan" required>
										<option value="">Silakan Pilih..</option>
										<option value="jasa">Izin Penyelenggaraan Jasa</option>
										<option value="jaringan">Izin Penyelenggaraan Jaringan</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 col-form-label">KBLI<span class="text-danger">*</span></label>
								<div class="col-lg-8">
									<select class="form-control required" name="jeniskbli" id="jeniskbli" data-toggle="tooltip"
										data-placement="bottom" title="Pilih Perizinan KBLI" required>
										<option value="">Silakan Pilih..</option>
									</select>
								</div>
							</div>
							<div class="form-group row" id="PilihNomor">
								<label class="col-lg-4 col-form-label">Jenis Layanan<span class="text-danger">*</span></label>
								<div class="col-lg-8">
									<select class="form-control required" name="jenislayanan" data-toggle="tooltip" data-placement="bottom"
										title="Pilih Jenis Layanan" required>
										<option value="">Silakan Pilih..</option>
									</select>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col">
						<div class="form-group row">
							<label class="col-lg-4 col-form-label">Jenis Penomoran<span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<select class="form-control required" name="jeniskodeakses" id="jeniskodeakses" data-toggle="tooltip"
									data-placement="bottom" title="Pilih Jenis Penomoran" required>
									<option value="">Silakan Pilih..</option>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-4 col-form-label" id="lbl_kdakses">Kode Akses<span class="text-danger">*</span></label>
							<div class="col-lg-8" id="availno_opt">
								<select class="form-control form-control-select2 required" id="availno" name="availno"
									data-toggle="tooltip" data-placement="bottom" title="Pilih Kode Akses" required>
									<option value="" selected>Silakan Pilih..
									</option>
								</select>
							</div>

							{{-- <div class="col-lg-8 d-none" id="PilihKodeWilayah">
                                <table class="table table-custom table-sm">
                                    <thead>
                                        <tr>
                                            <th style="border-top: none;background: #fafafa;text-align: center;">Wilayah
                                                Penomoran</th>
                                            <th style="border-top: none;background: #fafafa;text-align: center;">Blok Nomor
                                            </th>
                                            <th></th>
                                        </tr>

                                    </thead>
                                    <tbody id="bloknomor-lists">
                                        @for ($i = 0; $i < 1; $i++)
                                            <tr class="bloknomor-item">
                                                <td style="width: 60%;">
                                                    <select name="bloknomor[{{ $i }}][kode_wilayah]"
                                                        class="form-control pilih-kodewilayah">
                                                        <option value="">Pilih Kode Wilayah</option>
                                                        @foreach ($kodeWilayah as $wilayah)
                                                            <option value="{{ $wilayah->kode_wilayah }}">
                                                                {{ $wilayah->kode_wilayah }} - {{ $wilayah->nama_wilayah }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="width: 30%;">
                                                    <input type="text" class="form-control pilih-bloknomor"
                                                        name="bloknomor[{{ $i }}][prefix]"
                                                        placeholder="Prefix Awal" />
                                                </td>
                                                <td style="width: 10%;">
                                                    <div class="col-lg-2">
                                                        <button type="button" class="btn btn-success add-bloknomor"
                                                            id="add-bloknomor"><i class="icon-plus3"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <div>
                                    <label class="col-lg col-form-label">*) Wilayah Penomoran
                                        Berdasarkan Putusan Menteri Komunikasi dan Informatika Nomor 14 Tahun 2018 tentang
                                        Rencana
                                        Dasar Teknis (Fundamental Technical Plan/FTP) Telekomunikasi Nasional</label>
                                </div>
                            </div> --}}
						</div>
						<div class="form-group row">
							<label class="col-lg-4 col-form-label">No SK Penetapan<span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="hidden" id="NoSKPenetapanPenomoran_hide" name="NoSKPenetapanPenomoran_hide">
								<input type="text" name="NoSKPenetapanPenomoran" id="NoSKPenetapanPenomoran"
									class="form-control h-auto required" data-toggle="tooltip" data-placement="bottom"
									title="Masukkan No SK Penetapan" required>
							</div>
						</div>
						{{-- <div class="col-lg-12 row">
                            <div class="col-lg-4 form-group">
                                <label class="col-form-label">No SK Penetapan<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-8 form-group">
                                <input type="text" name="NoSKPenetapanPenomoran" id="NoSKPenetapanPenomoran"
                                    class="form-control h-auto required" required>
                            </div>
                        </div> --}}
						<div class="form-group row">
							<label class="col-lg-4 col-form-label">Tanggal Penetapan<span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="hidden" id="DateSKPenetapanPenomoran_hide" name="DateSKPenetapanPenomoran_hide">
								<input type="date" name="DateSKPenetapanPenomoran" id="DateSKPenetapanPenomoran"
									class="form-control h-auto required" data-toggle="tooltip" data-placement="bottom"
									title="Masukkan Tanggal Penetapan" required>
							</div>
						</div>
						{{-- <div class="col-lg-12 row">
                            <div class="col-lg-4 form-group">
                                <label class="col-form-label">Tanggal Penetapan<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-8 form-group">
                                <input type="date" name="DateSKPenetapanPenomoran" id="DateSKPenetapanPenomoran"
                                    class="form-control h-auto required" required>
                            </div>
                        </div> --}}

					</div>
					{{-- <div class="col-lg-12">
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Perizinan</label>
                                <div class="col-lg-4">
                                    <select name="perizinan" class="form-control">
                                        <option value="">Silakan Pilih..</option>
                                        <option value="jasa">Izin Penyelenggaraan Jasa</option>
                                        <option value="jaringan">Izin Penyelenggaraan Jaringan</option>
                                    </select>
                                </div>
                                <label class="col-lg-2 col-form-label">Jenis Penomoran</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="jeniskodeakses" id="jeniskodeakses">
                                        <option value="">Silakan Pilih..</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">KBLI</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="jeniskbli" id="jeniskbli">
                                        <option value="">Silakan Pilih..</option>
                                    </select>
                                </div>
                                <label class="col-lg-2 col-form-label d-none" id="lbl_kdakses">Kode Akses</label>
                                <div class="col-lg-4 d-none" id="availno_opt">
                                    <select class="form-control form-control-select2" id="availno" name="availno">
                                        <option value="" selected>Pilih Jenis penomoran terlebih dulu
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-4 d-none" id="PilihKodeWilayah">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <select class="form-control form-control-select2" id="iPilihKodeWilayah"
                                                name="kode_wilayah[]" onselect="setpilihnomor()">
                                                <option value="" selected hidden>Pilih Kode Wilayah terlebih dulu
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="iNoPrefixAwal"
                                                placeholder="Prefix Awal" name="prefix[]">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="button" class="btn btn-success addBlokNomor"><i
                                                    class="icon-plus3"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 d-none" id="PilihKodeWilayah">

                                    <select class="form-control form-control-select2" id="iPilihKodeWilayah"
                                        name="kode_wilayah" onselect="setpilihnomor()">
                                        <option value="" selected hidden>Pilih Kode Wilayah terlebih dulu
                                        </option>
                                    </select>
                                    <div class="mt-1 spinner-border loading text-primary" role="status"
                                        id="iPilihKodeWilayah-loading">
                                        <!-- <span class="sr-only">Loading...</span> -->
                                    </div>
                                    <div class="form-group d-none col-lg-2" id="NoPrefixAwal">

                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="iNoPrefixAwal"
                                                placeholder="Prefix Awal" name="prefix">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row" id="PilihNomor">
                                <label class="col-lg-2 col-form-label">Jenis Layanan</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="jenislayanan">
                                        <option value="">Silakan Pilih..</option>
                                    </select>
                                </div>
                            </div>


                        </fieldset>
                    </div> --}}
				</div>
			</div>
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Kelengkapan dan Pernyataan</h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-12">
						<fieldset>

							@if ($penambahan)
								<div class="form-group row">
									<label class="col-lg-6 col-form-label">Laporan Penggunaan Penomoran Existing <span
											class="text-danger">*</span></label>
									<div class="col-lg-6">
										<input type="file" name="LaporanPenggunaanPenomoran" id="LaporanPenggunaanPenomoran"
											class="form-control h-auto required" accept="application/pdf" data-toggle="tooltip"
											data-placement="bottom" title="Unggah Dokumen Laporan Penggunaan Penomoran" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-6 col-form-label">Dokumen Izin Perizinan Berusaha<span
											class="text-danger">*</span></label>
									<div class="col-lg-6">
										<input type="file" name="DokumenIzin" id="DokumenIzin" class="form-control h-auto required"
											accept="application/pdf" data-toggle="tooltip" data-placement="bottom"
											title="Unggah Dokumen Perizinan Berusaha" required>
									</div>
								</div>
								<div class="form-group row d-none" id="RProdukBriefBaru">
									<label class="col-lg-6 col-form-label">Penjelasan Singkat (<i>Product Brief</i>) untuk
										Layanan Baru <span class="text-danger">*</span>
									</label>
									<div class="col-lg-6">
										<input type="file" name="ProdukBriefBaru" id="ProdukBriefBaru" class="form-control h-auto required"
											accept="application/pdf" data-toggle="tooltip" data-placement="bottom"
											title="Unggah Dokumen Product Brief" required>
									</div>
								</div>
								<div class="form-group row d-none" id="RSuratDukungan">
									<label class="col-lg-6 col-form-label">Surat dukungan dari calon pengguna untuk
										pengajuan
										kode akses call center
									</label>
									<div class="col-lg-6">
										<input type="file" name="SuratDukungan" id="SuratDukungan" class="form-control h-auto required"
											accept="application/pdf" data-toggle="tooltip" data-placement="bottom"
											title="Unggah Dokumen Surat Dukungan Dari Calon Pengguna" required>
									</div>
								</div>
							@endif

							@if ($pengembalian)
								<div class="row">
									<div class="col-6">
										<div class="col-lg-12 row">
											<div class="col-lg-4 form-group">
												<label class="col-form-label">No SK Penetapan<span class="text-danger">*</span></label>
											</div>
											<div class="col-lg-8 form-group">
												<input type="hidden" id="NoSKPenetapanPenomoran_hide" name="NoSKPenetapanPenomoran_hide">
												<input type="text" name="NoSKPenetapanPenomoran" id="NoSKPenetapanPenomoran"
													class="form-control h-auto required" data-toggle="tooltip" data-placement="bottom"
													title="Masukkan No SK Penetapan" required>
											</div>
										</div>
										<div class="col-lg-12 row">
											<div class="col-lg-4 form-group">
												<label class="col-form-label">Tanggal Penetapan<span class="text-danger">*</span></label>
											</div>
											<div class="col-lg-8 form-group">
												<input type="hidden" id="DateSKPenetapanPenomoran_hide" name="DateSKPenetapanPenomoran_hide">
												<input type="date" name="DateSKPenetapanPenomoran" id="DateSKPenetapanPenomoran"
													class="form-control h-auto required" data-toggle="tooltip" data-placement="bottom"
													title="Masukkan Tanggal Penetapan" required>
											</div>
										</div>
										<div class="col-lg-12 row">
											<div class="col-lg-4 form-group">
												<label class="col-form-label">SK Penetapan Penomoran<span class="text-danger">*</span></label>
											</div>
											<div class="col-lg-8 form-group">
												<input type="file" name="SKPenetapanPenomoran" id="SKPenetapanPenomoran"
													class="form-control h-auto required" accept="application/pdf" data-toggle="tooltip"
													data-placement="bottom" title="Unggah SK Penetapan" required>
											</div>
										</div>

									</div>
									<div class="col-6">
										<div class="form-group">
											<label class="col-lg-6 col-form-label">Alasan Pengembalian<span class="text-danger">*</span></label>
										</div>
										<div class="form-group row">
											<div class="col-lg-12">
												<textarea rows="4" cols="3" class="form-control" id="ReasonRemoval_SK"
												 placeholder="Alasan Pengembalian" name="ReasonRemoval_SK" data-toggle="tooltip" data-placement="bottom"
												 title="Masukkan Alasan Pengembalian" required></textarea>
											</div>
										</div>
									</div>
								</div>
							@endif

							@if ($penyesuaian)
								<div class="row">
									<div class="col-6">
										<div class="form-group row">
											<div class="col-lg-12">
												<label class="col-form-label">SK Penetapan Penomoran<span class="text-danger">*</span></label>
											</div>
											<div class="col-lg-12">
												<input type="file" name="SKPenetapanPenomoran" id="SKPenetapanPenomoran"
													class="form-control h-auto required" accept="application/pdf" data-toggle="tooltip"
													data-placement="bottom" title="Unggah SK Penetapan" required>
												<small>Jika tidak memiliki SK Penetapan Penomoran, harap unggah Surat pernyataan. Unduh format surat <a
														target="_blank"
														href="/storage/lampiran/penomoran/SURAT_PERNYATAAN_TIDAK_MEMILIKI_SK_PENOMORAN_R2.docx">Disini</a></small>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-12">
												<label class="col-form-label">SK Perizinan Berusaha<span class="text-danger">*</span></label>
											</div>
											<div class="col-lg-12">
												<input type="file" name="SKPerizinanBerusaha" id="SKPerizinanBerusaha"
													class="form-control h-auto required" accept="application/pdf" data-toggle="tooltip"
													data-placement="bottom" title="Unggah SK Perizinan Berusaha" required>
											</div>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group row">
											<div class="col-lg-12">
												<label class="col-form-label">Dokumen Pendukung Perubahan Penetapan
													Penomoran<span class="text-danger">*</span></label>
											</div>
											<div class="col-lg-12">
												<input type="file" name="DOKPendukung" id="DOKPendukung" class="form-control h-auto required"
													accept="application/pdf" data-toggle="tooltip" data-placement="bottom" title="Unggah Dokumen Pendukung"
													required>
											</div>
										</div>
									</div>
								</div>
							@endif
							<div class="dropdown-divider"></div>
							<div class="form-group row">
								<label class="col-lg-12 col-form-label">Dengan ini saya menyatakan bahwa seluruh data yang
									disampaikan adalah BENAR. Jika dikemudian hari data yang disampaikan terbukti
									tidak benar, maka kami siap menerima akibat hukum sesuai dengan ketentuan
									perundang-undangan.</label>
							</div>
							<div class="form-group row">
								<div class="col-lg-8">
									<label class="custom-control custom-checkbox custom-control-inline">
										<input type="checkbox" id="check_pernyataan" class="custom-control-input" data-toggle="tooltip"
											data-placement="bottom" title="Harap Centang Pernyataan" required>
										<span class="custom-control-label">YA, Saya Setuju.</span>
									</label>
								</div>
							</div>
						</fieldset>
						<div class="text-right">
							<a onclick="history.back();" class="btn btn-light"><i class="icon-backward2 ml-2"></i>
								Kembali
							</a>
							<button id="submitButton" type="submit" class="btn btn-indigo">Kirim Permohonan <i
									class="icon-paperplane ml-2"></i></button>
						</div>
					</div>
				</div>
			</div>

		</form>
	</div>

@endsection

@section('custom-js')
	<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
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
		$(document).ready(function() {

			var submitButton = document.getElementById('submitButton');
			var loadingSpinner = document.getElementById('loadingSpinner');
			var myForm = document.getElementById('frm');

			function showLoadingSpinner() {
				// loadingSpinner.style.display = 'block';
				var spinner = document.getElementById('loadingSpinner');
				spinner.style.display = 'flex';
			}
			submitButton.addEventListener('click', function(event) {
				event.preventDefault();
				if ($("#frm")[0].checkValidity()) {

					if (!isCheckboxChecked()) {
						alert("Mohon centang pernyataan.");
					} else {
						showLoadingSpinner();
						submitForm();
					};

				} else {
					$('#frm :input[required="required"]').each(function() {
						if (!this.validity.valid) {
							$(this).focus();
							$(this).tooltip();
							$(this).tooltip('show');
							// alert(
							//     'Mohon lengkapi persyaratan yang dibutuhkan dan lakukan checklist setelah melengkapi persyaratan.'
							// );
							return false;
						}
					});
				}
				return false;
			});

			function onSubmit() {
				if ($("#frm")[0].checkValidity()) {} else {
					$('#frm :input[required="required"]').each(function() {
						if (!this.validity.valid) {
							$(this).focus();
							$(this).tooltip();
							$(this).tooltip('show');
							// alert(
							//     'Mohon lengkapi persyaratan yang dibutuhkan dan lakukan checklist setelah melengkapi persyaratan.'
							// );
							return false;
						}
					});
				}
				return false;
			}

			function isCheckboxChecked() {
				var checkbox = document.querySelector('.custom-control-input');
				return checkbox.checked;
			}

			function hideLoadingSpinner() {
				loadingSpinner.style.display = 'none';
			}

			function submitForm() {

				var selectedValue = document.getElementById("check_pernyataan").value;

				if (selectedValue === "null") {
					alert("Mohon centang pernyataan.");
				} else {
					myForm.submit();
				}
			}

			function GetKodeWilayah(short_name) {
				var jenispenomoran = short_name;
				var jenislayanan = $("#JenisLayanan").val();
				if (jenispenomoran == "Blok Nomor") {

					$.ajax({
						type: "POST",
						url: "{{ url('penomoran') }}/getKodeWeilayah",
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						data: JSON.stringify({
							data: jenispenomoran
						}),
						contentType: "application/json; charset=utf-8",
						dataType: "json",
						beforeSend: function() {
							$('#iPilihKodeWilayah-loading').show();
						},
						success: function(e) {
							var tempoption = "";
							var tempoption = "<option value="
							" selected>-- Pilih Kode Wilayah --</option>";
							$.each(e, function(key, value) {
								tempoption += "<option value='" + value.kode_wilayah + "'>" +
									value.kode_wilayah + " - " + value.nama_wilayah +
									"</option>";
							});
							$("#iPilihKodeWilayah").html(tempoption);
							$("#iPilihKodeWilayah").removeAttr("disabled");
							$('#iPilihKodeWilayah-loading').hide();
							$('#iPilihKodeWilayah').select2();
							$('#iPilihKodeWilayah').addClass("select2");
							$("#PilihKodeWilayah").removeClass("d-none");
							$("#NoPrefixAwal").removeClass("d-none");
							// $("#iPilihKodeWilayah").addClass("required");
							// $('#iPilihKodeWilayah').prop('required', true);
							// $('#NoPrefixAwal').prop('required', true);
							// $("#NoPrefixAwal").addClass("required");
							$("#PlilihNomor").addClass("d-none");
						},
						failure: function(errMsg) {
							alert(errMsg);
						}
					});
				} else {
					$("#PlilihNomor").removeClass("d-none");
					// $("#PilihKodeWilayah").removeClass("required");
					// $("#PilihKodeWilayah").addClass("d-none");
					// $("#NoPrefixAwal").removeClass("required");
					// $('#iPilihKodeWilayah').prop('required', false);
					// $('#NoPrefixAwal').prop('required', false);
					$("#NoPrefixAwal").addClass("d-none");
					$('#availno-loading').show();
					$.ajax({
						type: "POST",
						url: "{{ url('penomoran') }}/getnomor",
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						data: JSON.stringify({
							data: jenispenomoran,
							datajenislayanan: jenislayanan
						}),
						contentType: "application/json; charset=utf-8",
						dataType: "json",
						success: function(e) {
							var tempoption = "";
							var tempoption = "<option>-- Pilih Kode Akses --</option>";
							$.each(e, function(key, value) {
								tempoption += "<option value='" + value.kode_akses +
									"'> " + value.kode_akses + " </option>";
							});
							$("#availno").html(tempoption);
							$("#availno").removeAttr("disabled");
							$('#availno-loading').hide();
						},
						failure: function(errMsg) {
							alert(errMsg);
						}
					});
				}
			};
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
							var noSK = document.getElementById("NoSKPenetapanPenomoran");
							var tglSK = document.getElementById("DateSKPenetapanPenomoran");

							// Set values to the input fields
							tglSK.value = 'dd/mm/yyyy';
							noSK.value = '';

							$('select[name="jeniskbli"]').empty();
							$('select[name="jeniskbli"]').append(
								'<option value="">-- Pilih KBLI --</option>');
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
							var noSK = document.getElementById("NoSKPenetapanPenomoran");
							var tglSK = document.getElementById("DateSKPenetapanPenomoran");

							// Set values to the input fields
							tglSK.value = 'dd/mm/yyyy';
							noSK.value = '';

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
					$('select[name="jenislayanan"]').empty();
				}
			});
			$('select[name="jenislayanan"]').on('change', function() {
				var izinlayanan = $(this).val();
				$(this).tooltip('dispose');
				var id_jenislayanan_var = document.getElementById("id_jenislayanan");
				id_jenislayanan_var.value = $(this).val();
				console.log(id_jenislayanan_var.value);
				if (id_jenislayanan_var.value ==
					'059000000052') {
					$('#RProdukBriefBaru').addClass("d-none");
					$("#ProdukBriefBaru").prop('required', false);
					$('#RSuratDukungan').removeClass("d-none");
					$("#SuratDukungan").prop('required', true);
				} else if (id_jenislayanan_var.value ==
					'059000000033') {
					$('#RProdukBriefBaru').removeClass("d-none");
					$("#ProdukBriefBaru").prop('required', true);
					$('#RSuratDukungan').addClass("d-none");
					$("#SuratDukungan").prop('required', false);
				} else {
					$('#RProdukBriefBaru').addClass("d-none");
					$("#ProdukBriefBaru").prop('required', false);
					$('#RSuratDukungan').addClass("d-none");
					$("#SuratDukungan").prop('required', false);
				}
				// console.log(izin);
				if (izinlayanan) {
					$.ajax({
						url: '/api/getjeniskodeakses_nomor/' + izinlayanan,
						type: "GET",
						dataType: "json",
						success: function(data) {
							console.log(data);

							$('select[name="jeniskodeakses"]').empty();
							$('select[name="jeniskodeakses"]').append(
								'<option value="">-- Pilih Jenis Penomoran --</option>'
							);
							var noSK = document.getElementById("NoSKPenetapanPenomoran");
							var tglSK = document.getElementById("DateSKPenetapanPenomoran");

							// Set values to the input fields
							tglSK.value = 'dd/mm/yyyy';
							noSK.value = '';
							$.each(data, function(key, value) {

								$('select[name="jeniskodeakses"]').append(
									'<option value="' + value.short_name + '">' +
									value
									.full_name + '</option>');
							});


						}
					});
				} else {
					$('select[name="jeniskodeakses"]').empty();
				}
			});
			$('select[name="jeniskodeakses"]').on('change', function() {
				var jenis_kodeakses = $(this).val();
				$(this).tooltip('dispose');
				var id_jeniskodeakses_var = document.getElementById("id_jeniskodeakses");
				id_jeniskodeakses_var.value = $(this).val();

				var noSK = document.getElementById("NoSKPenetapanPenomoran");
				var tglSK = document.getElementById("DateSKPenetapanPenomoran");

				// Set values to the input fields
				tglSK.value = 'dd/mm/yyyy';
				noSK.value = '';
				tglSK.disabled = false;
				noSK.disabled = false;
				// alert($(this).val());
				// console.log(id_jeniskodeakses_var.value);
				// GetKodeWilayah(id_jeniskodeakses_var.value);
				if (jenis_kodeakses) {
					if (id_jeniskodeakses_var.value == 'Blok Nomor') {
						console.log(id_jeniskodeakses_var.value);

						$('#availno_opt').addClass("d-none");
						$('#lbl_kdakses').removeClass("d-none");
						$("#PilihKodeWilayah").removeClass("d-none");
						$("#NoPrefixAwal").removeClass("d-none");
						// $("#availno").prop('required', false);
						// $(this).parents("#availno").remove();

						var x = document.getElementById("lbl_kdakses");
						x.innerHTML = "Daftar Blok Nomor";
					} else {
						$('#availno_opt').removeClass("d-none");
						$('#lbl_kdakses').removeClass("d-none");
						$("#PilihKodeWilayah").addClass("d-none");
						$("#NoPrefixAwal").addClass("d-none");
						// $("#availno").prop('required', true);
						$('select[name="availno"]').html('<option value="" disabled>Loading...</option>');

						var x = document.getElementById("lbl_kdakses");
						x.innerHTML = "Kode Akses";
						$.ajax({
							url: '/api/getkodeakses_nomor_re/' + jenis_kodeakses,
							type: "GET",
							dataType: "json",
							success: function(data) {
								// console.log(data);

								$('select[name="availno"]').prop('disabled', false);
								$('select[name="availno"]').empty();
								$('select[name="availno"]').append(
									'<option value="">-- Pilih Kode Akses --</option>'
								);
								var noSK = document.getElementById("NoSKPenetapanPenomoran");
								var tglSK = document.getElementById("DateSKPenetapanPenomoran");

								// Set values to the input fields
								tglSK.value = 'dd/mm/yyyy';
								noSK.value = '';
								$.each(data, function(key, value) {

									$('select[name="availno"]').append(
										'<option value="' + value.id + '">' + value
										.kode_akses + '</option>');
								});


							}
						});
					}

				} else {
					$('select[name="availno"]').empty();
				}
			});
			$('select[name="availno"]').on('change', function() {
				var id_kodeakses = $(this).val();
				$(this).tooltip('dispose');
				var id_kodeakses_var = document.getElementById("id_kodeakses");
				id_kodeakses_var.value = $(this).val();
				var noSK = document.getElementById("NoSKPenetapanPenomoran");
				var tglSK = document.getElementById("DateSKPenetapanPenomoran");
				var noSK_ = document.getElementById("NoSKPenetapanPenomoran_hide");
				var tglSK_ = document.getElementById("DateSKPenetapanPenomoran_hide");

				// Set values to the input fields
				tglSK.value = 'dd/mm/yyyy';
				noSK.value = '';
				tglSK.disabled = false;
				noSK.disabled = false;
				noSK_.value = '';
				tglSK_.value = '';

				$.ajax({
					url: '/api/getskinfo_nomor_re/' + id_kodeakses,
					type: "GET",
					dataType: "json",
					success: function(data) {
						// console.log(data);

						if (Array.isArray(data) && data.length > 0) {
							var responseData = data[0]; // Access the first object in the array

							// Check the keys present in the responseData object
							console.log(Object.keys(responseData));

							if ('tanggal_penetapan' in responseData && 'nomor_penetapan' in
								responseData) {
								var noSK = document.getElementById("NoSKPenetapanPenomoran");
								var tglSK = document.getElementById("DateSKPenetapanPenomoran");

								// Set values to the input fields
								tglSK.value = responseData.tanggal_penetapan;
								noSK.value = responseData.nomor_penetapan;
								tglSK_.value = responseData.tanggal_penetapan;
								noSK_.value = responseData.nomor_penetapan;
								// alert(responseData.tanggal_penetapan, responseData
								//     .nomor_penetapan);

								// tglSK.disabled = true;
								// noSK.disabled = true;
							} else {
								// Handle case when expected keys are not present in the object
								console.log('Keys not found in the object.');
							}
						} else {
							// Handle case when no data is returned or the data structure is unexpected
							console.log('Invalid or empty data received.');
						}


					}
				});
			});
			// $(".addBlokNomor").click(function(e) {
			//     e.preventDefault();
			//     var jenispenomoran = 'Blok Nomor';

			//     $("#PilihKodeWilayah").prepend(`<div class="row">
		//                         <div class="col-lg-6">
		//                             <select class="form-control form-control-select2" id="iPilihKodeWilayah"
		//                                 name="kode_wilayah[]" onselect="setpilihnomor()">
		//                                 <option value="" selected hidden>Pilih Kode Wilayah terlebih dulu
		//                                 </option>
		//                             </select>
		//                         </div>
		//                         <div class="col-lg-4">
		//                             <input type="text" class="form-control" id="iNoPrefixAwal"
		//                                 placeholder="Prefix Awal" name="prefix[]">
		//                         </div>
		//                         <div class="col-lg-2">
		//                             <button type="button" class="btn btn-danger removeBlokNomor"><i
		//                                     class="icon-minus3"></i></button>
		//                         </div>
		//                     </div>`);
			//     $.ajax({
			//         type: "POST",
			//         url: "{{ url('penomoran') }}/getKodeWeilayah",
			//         headers: {
			//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			//         },
			//         data: JSON.stringify({
			//             data: jenispenomoran
			//         }),
			//         contentType: "application/json; charset=utf-8",
			//         dataType: "json",
			//         beforeSend: function() {
			//             $('#iPilihKodeWilayah-loading').show();
			//         },
			//         success: function(e) {
			//             var tempoption = "";
			//             var tempoption =
			//                 "<option value='' selected>-- Pilih Kode Wilayah --</option>";
			//             $.each(e, function(key, value) {
			//                 tempoption += "<option value='" + value.kode_wilayah +
			//                     "'>" +
			//                     value.kode_wilayah + " - " + value.nama_wilayah +
			//                     "</option>";
			//             });
			//             $("#iPilihKodeWilayah").html(tempoption);
			//             // $("#iPilihKodeWilayah").removeAttr("disabled");
			//             $('#iPilihKodeWilayah-loading').hide();
			//             $('#iPilihKodeWilayah').select2();
			//             $('#iPilihKodeWilayah').addClass("select2");
			//             // $('#iPilihKodeWilayah').prop('required', true);
			//             // $('#NoPrefixAwal').prop('required', true);
			//             // $("#PilihKodeWilayah").removeClass("d-none");
			//             // $("#NoPrefixAwal").removeClass("d-none");
			//             // $("#PlilihNomor").addClass("d-none");
			//         },
			//         failure: function(errMsg) {
			//             alert(errMsg);
			//         }
			//     });
			// });
			$(document).on('click', '.btn-delete-bloknomor', function(e) {
				e.preventDefault();
				let row_item = $(this).parent().parent();
				$(row_item).remove();
			})

			function onDeleteBlokNomor(e) {
				// remove selected item
				e.parentNode.parentNode.remove();
				// recons index
				$('.cakupanwilayahtelsus_skrk-item').each(function(index, element) {
					let bloknomor_kdwilayah = $(this).find('.pilih-kodewilayah');
					let bloknomor_prefix = $(this).find('.pilih-bloknomor');
					// let AlamatUlo = $(this).find('.AlamatUlo-cakupanwilayahtelsus_skrk');
					bloknomor_kdwilayah.attr('name', 'bloknomor[' + index + '][kode_wilayah]');
					bloknomor_prefix.attr('name', 'bloknomor[' + index + '][prefix]');
				});
			}
			$(".add-bloknomor").click(function(e) {
				e.preventDefault();
				// alert("Tambah");
				var kodewilayahs = {!! json_encode($kodeWilayah) !!};
				start = 0;
				totalBlokNomor = 0;
				options = ``;

				for (let item of kodewilayahs) {
					options += `<option value="` + item.kode_wilayah + `">` + item.kode_wilayah + ' - ' +
						item.nama_wilayah +
						`</option>`;
				}

				initSelect2();

				function initSelect2() {
					$('.pilih-kodewilayah').each(function(index, element) {
						$(this).select2({
							placeholder: "Pilih Kode Wilayah"
						})
					})
				}

				function countTotalBlokNomor() {
					return document.querySelectorAll('.bloknomor-item').length;
				}

				this.totalBlokNomor = countTotalBlokNomor() + 1;
				const inputRow =
					`
					<tr class="bloknomor-item">
                        <td>
							<select
								name="bloknomor[` + this.totalBlokNomor + `][kode_wilayah]"
								class="form-control pilih-kodewilayah"
							><option value="">Pilih Kode Wilayah</option>` + options + ` </select>
						</td>
						<td>
							<input type="text" class="form-control pilih-bloknomor" name="bloknomor[` + this
					.totalBlokNomor + `][prefix]" />
						</td>
						
						<td>
							<button
								class="btn btn-danger btn-samll btn-delete-bloknomor" id="btn-delete-bloknomor"
								type="button"
							>&times;</button>
						</td>
					<tr>
				`;
				$('#bloknomor-lists').append(inputRow);
				initSelect2();
			})

			function onDeleteBlokNomor(e) {
				// remove selected item
				e.parentNode.parentNode.remove();
				// recons index
				$('.cakupanwilayahtelsus_skrk-item').each(function(index, element) {
					let bloknomor_kdwilayah = $(this).find('.pilih-kodewilayah');
					let bloknomor_prefix = $(this).find('.pilih-bloknomor');
					// let AlamatUlo = $(this).find('.AlamatUlo-cakupanwilayahtelsus_skrk');
					bloknomor_kdwilayah.attr('name', 'bloknomor[' + index + '][kode_wilayah]');
					bloknomor_prefix.attr('name', 'bloknomor[' + index + '][prefix]');
				});
			}

			const addBlokNomor = function() {

				var kodewilayahs = {!! json_encode($kodeWilayah) !!};
				start = 0;
				totalBlokNomor = 0;
				options = ``;

				for (let item of kodewilayahs) {
					options += `<option value="` + item.kode_wilayah + `">` + item.nama_wilayah + ` - ` + item
						.nama_wilayah + `</option>`;
				}

				initSelect2();

				function initSelect2() {
					$('.pilih-kodewilayah').each(function(index, element) {
						$(this).select2({
							placeholder: "Pilih Kode Wilayah"
						})
					})
				}

				function countTotalBlokNomor() {
					return document.querySelectorAll('.bloknomor-item').length;
				}

				$('#add-BlokNomor').on('click', function() {
					this.totalRencanaUsaha = countTotalBlokNomor() + 1;
					const inputRow =
						`
					<tr class="bloknomor-item">
                        <td>
							<select
								name="bloknomor[` + this.totalRencanaUsaha + `][kode_wilayah]"
								class="form-control pilih-kodewilayah"
								required
							><option value="">Pilih Kode Wilayah</option>` + options + ` </select>
						</td>
						<td>
							<input type="text" class="form-control pilih-bloknomor" name="bloknomor[` + this
						.totalRencanaUsaha + `][prefix]" required />
						</td>
						
						<td>
							<button
								class="btn btn-danger btn-samll btn-delete-bloknomor"
								type="button"
								onclick="javascript:onDeleteBlokNomor(this);return false;"
							>&times;</button>
						</td>
					<tr>
				`;
					$('#bloknomor-lists').append(inputRow);
					initSelect2();
				});
			}
			addBlokNomor();
		});
	</script>

@endsection
