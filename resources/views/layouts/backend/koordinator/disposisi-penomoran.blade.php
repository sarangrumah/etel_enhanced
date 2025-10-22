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
	@if (Session::get('message') != '')
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif
	<div class="form-group">

		<!-- Section Detail Permohonan -->

		<!-- Section Detail Perusahaan -->
		<div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Informasi Pemohon </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="col">
							<legend class="text-uppercase font-size-sm font-weight-bold">Data Perusahaan/Instansi
							</legend>
							@if ($detailnib['status_badan_hukum'] != '03')
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">NIB </label>
											<div class="input-group col-lg-8">
												<input type="text" class="form-control" value="{{ $detailnib['nib'] }}" disabled>
												<span class="input-group-append">
													{{-- <button class="btn btn-light" type="button">Button</button>
                                                     --}}
													<a target="_blank" href="{{ asset($detailnib->path_berkas_nib) }}" class="btn btn-teal" type="button">Lihat
														Dokumen</a>
												</span>
											</div>
										</div>
									</div>
								</div>
							@endif
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">Nama </label>
										<div class="col-lg">
											<input type="text" class="form-control" value="{{ $detailnib['nama_perseroan'] }}" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">NPWP </label>
										<div class="col-lg">
											<input type="text" class="form-control" value="{{ $detailnib['npwp_perseroan'] }}" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">No Telp/Mobile </label>
										<div class="col-lg">
											<input type="text" class="form-control"
												value="{{ isset($detailnib['nomor_telpon_perseroan']) ? $detailnib['nomor_telpon_perseroan'] : '-' }}"
												disabled>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col">
							<legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">NIK </label>
										<div class="col-lg">
											<input type="text" class="form-control"
												value="{{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">Email </label>
										<div class="col-lg">
											<input type="text" class="form-control"
												value="{{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}"
												disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">Nama </label>
										<div class="col-lg">
											<input type="text" class="form-control"
												value="{{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}"
												disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">No Telp </label>
										<div class="col-lg">
											<input type="text" class="form-control"
												value="{{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}" disabled>
										</div>
									</div>
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
							<h6 class="card-title font-weight-semibold py-3">Informasi Permohonan </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="col-lg-6">

							<legend class="text-uppercase font-size-sm font-weight-bold">Data Permohonan
							</legend>

							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">No Permohonan </label>
										<div class="col-lg">
											<input type="text" class="form-control" value="{{ $penomoran['id_izin'] }}" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
										<div class="col-lg">
											@if ($penomoran['updated_date'] == null)
												<input type="text" class="form-control" value="-" disabled>
											@else
												<input type="text" class="form-control"
													value="{{ $date_reformat->date_lang_reformat_long($penomoran['updated_date']) }}" disabled>
											@endif
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">Jenis Permohonan </label>
										<div class="col-lg">
											@if ($penomoran['jenis_permohonan'] == 'Perubahan Penetapan')
												<input type="text" class="form-control" value="{{ isset($note) ? $note : '' }}" disabled>
											@else
												<input type="text" class="form-control"
													value="{{ isset($penomoran['jenis_permohonan']) ? $penomoran['jenis_permohonan'] : '' }}" disabled>
											@endif
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">Status Permohonan </label>
										<div class="col-lg">
											<input type="text" class="form-control"
												value="{{ isset($penomoran['kode_izin']['name_status_bo']) ? $penomoran['kode_izin']['name_status_bo'] : '' }}"
												disabled>
										</div>
									</div>
								</div>
							</div>
						</div>
						@if ($penomoran['status_badan_hukum'] != '03')
							<div class="col-lg-6">

								<legend class="text-uppercase font-size-sm font-weight-bold">Data Perizinan</legend>

								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Perizinan </label>
											<div class="col-lg">
												<input type="text" class="form-control"
													value="{{ isset($penomoran['jenis_izin']) ? $penomoran['jenis_izin'] : '' }}" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">KBLI</label>
											<div class="col-lg">
												<input type="text" class="form-control"
													value="{{ isset($penomoran['full_kbli']) ? $penomoran['full_kbli'] : '' }}" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Jenis Layanan </label>
											<div class="col-lg">
												<input type="text" class="form-control" value="{!! $penomoran['jenis_layanan_html_nomor'] !!}" disabled>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>

		</div>
		<!-- End Section Detail Permohonan -->
		<form method="post" id="formDisposisi"
			action="{{ route('admin.koordinator.disposisipenomoranpost', [$id, $penomoran['id_kode_akses']]) }}">

			<?php
			
			// $file = explode('/', $penomoran['dok_pengguna_penomoran']);
			if (isset($penomoran['dok_pengguna_penomoran']) && $penomoran['dok_pengguna_penomoran'] != '') {
			    $file = explode('/', $penomoran['dok_pengguna_penomoran']);
			    // $file = $_file[3];
			} else {
			    $file = '';
			}
			if (isset($penomoran['dok_izin_penyelenggaraan']) && $penomoran['dok_izin_penyelenggaraan'] != '') {
			    $_file4 = explode('/', $penomoran['dok_izin_penyelenggaraan']);
			    $file4 = $_file4[3];
			} else {
			    $file4 = '';
			}
			if (isset($penomoran['dok_kode_akses_konten']) && $penomoran['dok_kode_akses_konten'] != '') {
			    $_file5 = explode('/', $penomoran['dok_kode_akses_konten']);
			    $file5 = $_file5[3];
			} else {
			    $file5 = '';
			}
			if (isset($penomoran['pe_dok_sk']) && $penomoran['pe_dok_sk'] != '') {
			    $_file6 = explode('/', $penomoran['pe_dok_sk']);
			    $file6 = $_file6[3];
			} else {
			    $file6 = '';
			}
			if (isset($penomoran['pe_dok_perizinan_terakhir']) && $penomoran['pe_dok_perizinan_terakhir'] != '') {
			    $_file7 = explode('/', $penomoran['pe_dok_perizinan_terakhir']);
			    $file7 = $_file7[3];
			} else {
			    $file7 = '';
			}
			if (isset($penomoran['pe_dok_pendukung']) && $penomoran['pe_dok_pendukung'] != '') {
			    $_file8 = explode('/', $penomoran['pe_dok_pendukung']);
			    $file8 = $_file8[3];
			} else {
			    $file8 = '';
			}
			
			?>

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Evaluasi Permohonan </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Penomoran</legend>
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-lg-4 col-form-label">Jenis Penomoran</label>
								<div class="col-lg-8">

									<input type="text" class="form-control"
										value="{{ isset($penomoran['kode_akses']['jenis_penomoran']) ? $penomoran['kode_akses']['jenis_penomoran'] : '' }}"
										disabled>

								</div>
							</div>
							@if (
								$penomoran['kode_akses']['jenis_penomoran'] != 'Blok Nomor' &&
									strtolower($penomoran['jenis_permohonan']) == 'perubahan penetapan')
								<div class="form-group row">
									<label class="col-lg-4 col-form-label">Kode Akses</label>
									<div class="col-lg-8">
										<input type="text" class="form-control"
											value="{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}"
											disabled>
									</div>
								</div>
							@endif
						</div>
						@if (
							$penomoran['kode_akses']['jenis_penomoran'] != 'Blok Nomor' &&
								strtolower($penomoran['jenis_permohonan']) != 'perubahan penetapan')
							<div class="col-lg-6">
								<div class="row">
									<label class="col-lg-4 col-form-label">Kode Akses </label>
									<div class="col-lg-8">
										{{-- <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}</label> --}}
										<input type="text" class="form-control"
											value="{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}"
											disabled>
									</div>
								</div>
							</div>
						@endif
						@if (
							$penomoran['kode_akses']['jenis_penomoran'] != 'Blok Nomor' &&
								strtolower($penomoran['jenis_permohonan']) == 'perubahan penetapan')
							<div class="col-lg-6">
								<div class="col-12 row">
									<div class="col-lg-4 form-group">
										<label class="col-form-label">No SK Penetapan </label>
									</div>
									<div class="col-lg-8 form-group">
										<input disabled="disabled" type="text" class="form-control" placeholder="{{ $penomoran['pe_no_sk'] }}">
									</div>
								</div>
								<div class="col-lg-12 row">
									<div class="col-lg-4 form-group">
										<label class="col-form-label">Tanggal Penetapan </label>
									</div>
									<div class="col-lg-8 form-group">
										<input disabled="disabled" type="text" class="form-control"
											placeholder="{{ $date_reformat->date_lang_reformat_long($penomoran['pe_date_sk']) }}">
									</div>
								</div>
							</div>
						@endif
						{{-- @if (isset($penomoran['kode_akses']['kode_akses']))
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Kode Akses </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Prefix </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_akses']['prefix']) ? $penomoran['kode_akses']['prefix'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Kode Wilayah </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_akses']['kode_wilayah']) ? $penomoran['kode_akses']['kode_wilayah'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        @endif --}}
					</div>

					@if ($penomoran['kode_akses']['jenis_penomoran'] == 'Blok Nomor')
						<div class="form-group row">
							<label class="col-lg-2 col-form-label">Daftar Blok Nomor </label>
							<div class="col-lg-4" id="PilihKodeWilayah">
								<table class="text-center table table-custom table-sm">
									<thead>
										<tr>
											<th style="border-top: none;background: #fafafa;text-align: center;">
												Wilayah</th>
											<th style="border-top: none;background: #fafafa;text-align: center;">
												Kode
												Wilayah</th>
											<th style="border-top: none;background: #fafafa;text-align: center;">
												Blok Nomor
											</th>
										</tr>

									</thead>
									<tbody id="bloknomor-lists">
										@foreach ($penomoran_bloknomor as $item)
											<tr class="bloknomor-item">
												<td style="width: 50%;">
													<div class="font-size-sm">
														{{ $item['nama_wilayah'] }}
													</div>
												</td>
												<td style="width: 25%;">
													<div class="font-size-sm">
														{{ $item['kode_wilayah'] }}
													</div>
												</td>
												<td style="width: 25%;">
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
					@endif

					@csrf
					@if ($penomoran['jenis_permohonan'] == 'Penetapan Nomor Tambahan')
						<legend class="text-uppercase font-size-sm font-weight-bold">Kelengkapan</legend>
						<div class="form-group row">

							@if (isset($penomoran['dok_izin_penyelenggaraan']) && $penomoran['dok_izin_penyelenggaraan'] != '')
								<div class="col-lg-6">
									<div class="row">
										<div class="col-12">
											<p class="font-weight-semibold">Dokumen Perizinan Berusaha</p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control" placeholder="{{ $file4 }}">
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
										<p class="font-weight-semibold">Laporan Penggunaan Penomoran Yang Pernah Ditetapkan
										</p>
										<div class="input-group">
											<input disabled="disabled" type="text" class="form-control" placeholder="{{ $file[3] }}">
											<span class="input-group-append">
												<a target="_blank" href="{{ asset($penomoran['dok_pengguna_penomoran']) }}" class="btn btn-teal"
													type="button">Lihat Dokumen</a>
											</span>
										</div>
									</div>
								</div>
							</div>
							@if (isset($penomoran['dok_kode_akses_konten']) && $penomoran['dok_kode_akses_konten'] != '')
								<div class="col-lg-6">
									<div class="row">
										<div class="col-12">
											<p class="font-weight-semibold">Penjelasan Singkat (<i>Product Brief</i>) untuk
												Layanan Baru </p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control" placeholder="{{ $file5 }}">
												<span class="input-group-append">
													<a target="_blank" href="{{ asset($penomoran['dok_kode_akses_konten']) }}" class="btn btn-teal"
														type="button">Lihat Dokumen</a>
												</span>
											</div>
										</div>
									</div>
								</div>
							@endif
						</div>

						{{-- @if (strtolower($penomoran['kd_izin']) == '059000000033')
                            <div class="form-group row">
                                <?php
																																if (isset($penomoran['dok_kode_akses_konten'])) {
																																    $_file2 = explode('/', $penomoran['dok_kode_akses_konten']);
																																    $file2 = $_file2[3];
																																} else {
																																    $file2 = '';
																																}
																																
																																$file2 = $file2;
																																?>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Penjelasan Singkat (<i>Product Brief</i>) untuk
                                                Layanan Baru</p>
                                            <div class="input-group">
                                                <input disabled="disabled" type="text" class="form-control"
                                                    placeholder="{{ $file2 }}">
                                                <span class="input-group-append">
                                                    <a target="_blank"
                                                        href="{{ asset($penomoran['dok_kode_akses_konten']) }}"
                                                        class="btn btn-teal" type="button">Lihat Dokumen</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif --}}

						@if (strtolower($penomoran['kd_izin']) == '059000000052')
							<div class="form-group row">
								<?php
								if (isset($penomoran['dok_call_center'])) {
								    $_file3 = explode('/', $penomoran['dok_call_center']);
								    $file3 = $_file3[3];
								} else {
								    $file3 = '';
								}
								
								$file3 = $file3;
								
								?>
								<div class="col-lg-12">
									<div class="row">
										<div class="col-6">
											<p class="font-weight-semibold">Surat dukungan dari calon pengguna untuk
												pengajuan kode
												akses call center</p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control" placeholder="{{ $file3 }}">
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
					@elseif(strtolower($penomoran['jenis_permohonan']) == 'perubahan penetapan')
						<legend class="text-uppercase font-size-sm font-weight-bold">Kelengkapan</legend>

						<div class="form-group">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-6">
										<p class="font-weight-semibold">SK Penetapan Penomoran</p>
										<div class="input-group">
											<input disabled="disabled" type="text" class="form-control" placeholder="{{ $file6 }}">
											<span class="input-group-append">
												<a target="_blank" href="{{ asset($penomoran['pe_dok_sk']) }}" class="btn btn-teal" type="button">Lihat
													Dokumen</a>
											</span>
										</div>
									</div>

								</div>
							</div>
						</div>
						@if (isset($penomoran['pe_dok_perizinan_terakhir']) && $penomoran['pe_dok_perizinan_terakhir'] != '')
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-6">
											<p class="font-weight-semibold">SK Perizinan Berusaha</p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control" placeholder="{{ $file7 }}">
												<span class="input-group-append">
													<a target="_blank" href="{{ asset($penomoran['pe_dok_perizinan_terakhir']) }}" class="btn btn-teal"
														type="button">Lihat Dokumen</a>
												</span>
											</div>
										</div>

									</div>
								</div>
							</div>
						@endif
						@if (isset($penomoran['dok_kode_akses_konten']) && $penomoran['dok_kode_akses_konten'] != '')
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-6">
											<p class="font-weight-semibold">Penjelasan Singkat (<i>Product Brief</i>) untuk
												Layanan Baru </p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control" placeholder="{{ $file5 }}">
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

						<div class="form-group">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-6">
										<p class="font-weight-semibold">Dokumen Pendukung Perubahan Penetapan Penomoran</p>
										<div class="input-group">
											<input disabled="disabled" type="text" class="form-control" placeholder="{{ $file8 }}">
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
					@elseif(strtolower($penomoran['jenis_permohonan']) == 'pengembalian penomoran')
						<legend class="text-uppercase font-size-sm font-weight-bold">Kelengkapan</legend>
						<div class="form-group row">
							<div class="col-6">
								<div class="col-12 row">
									<div class="col-lg-4 form-group">
										<label class="col-form-label">No SK Penetapan </label>
									</div>
									<div class="col-lg-8 form-group">
										<input disabled="disabled" type="text" class="form-control" placeholder="{{ $penomoran['pe_no_sk'] }}">
									</div>
								</div>
								<div class="col-lg-12 row">
									<div class="col-lg-4 form-group">
										<label class="col-form-label">Tanggal Penetapan </label>
									</div>
									<div class="col-lg-8 form-group">
										<input disabled="disabled" type="text" class="form-control"
											placeholder="{{ $date_reformat->date_lang_reformat_long($penomoran['pe_date_sk']) }}">
									</div>
								</div>
								<div class="col-lg-12 row">
									<div class="col-lg-4 form-group">
										<label class="col-form-label">SK Penetapan Penomoran </label>
									</div>
									<div class="col-lg-8 form-group">
										<div class="input-group">
											<input disabled="disabled" type="text" class="form-control" placeholder="{{ $file6 }}">
											<span class="input-group-append">
												<a target="_blank" href="{{ asset($penomoran['pe_dok_sk']) }}" class="btn btn-teal" type="button">Lihat
													Dokumen</a>
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
					@endif
					<legend class="text-uppercase font-size-sm font-weight-bold">Proses Evaluasi</legend>
					<div class="form-group row">
						<div class="col-lg-12">
							<fieldset>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Disposisi ke : </label>
									<div class="col-lg">
										<select name="id_user_disposisi" id="selectdisposisi" class="form-control form-control-select2" required>
											<option value="null" disabled selected>-- Silakan Pilih --</option>
											@if (count($user) > 0)
												@foreach ($user as $key => $users)
													<option id="select_{{ $key }}" value="{{ $users['id'] }}">
														{{ $users['nama'] }} |
														{{ $users['short_desc'] }}
													</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								@if ($penomoran['status_permohonan'] == '903')
									<div class="form-group row">
										<textarea name="catatan" rows="3" cols="3" class="form-control" placeholder="Catatan Disposisi"></textarea>
									</div>
								@else
									<div class="form-group row" hidden>
										<textarea name="catatan" rows="3" cols="3" class="form-control" placeholder="Catatan Disposisi"></textarea>
									</div>
								@endif
							</fieldset>
						</div>
					</div>
					<input type="hidden" id="id_izin" name="id_izin" value="{{ $id }}">
					<input type="hidden" id="id_kode_akses" name="id_kode_akses" value="{{ $penomoran['id_kode_akses'] }}">
					<input type="hidden" id="id_penomoran" name="id_penomoran" value="{{ $penomoran['id'] }}">

				</div>
			</div>

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Riwayat Permohonan</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					@include('layouts/backend/historyperizinan/historypenomoran', [
						'history_penomoran' => $penomoranlog,
					])
				</div>
			</div>

			<div class="text-right">
				<a href="{{ route('admin.koordinator') }}" class="btn btn-secondary border-transparent"><i
						class="icon-backward2 ml-2"></i> Kembali </a>
				<!-- <button type="button" class="btn btn-secondary border-transparent">Kembali </button> -->
				<!-- <button type="button" onclick="logPermohonan();return false;" class="btn btn-info">Riwayat Permohonan </button> -->
				<!-- <a target="_blank" href="{{ route('admin.historyperizinan', $penomoran['id_izin']) }}" class="btn btn-info">Riwayat Permohonan </a> -->
				<!-- <button type="submit" onclick="submitdisposisi();return false;" class="btn btn-indigo">Kirim Disposisi <i class="icon-paperplane ml-2"></i></button> -->
				<button type="submit" onclick="return validateForm();" class="btn btn-indigo">Kirim Disposisi <i
						class="icon-paperplane ml-2"></i></button>
			</div>

		</form>
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
					<button type="button" id="btnSubmit" onclick="submitdisposisi();return false;"
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
		// $(document).ready(function(){
		// 	$("select[name='id_user_disposisi'] option:eq(1)").attr("selected", "selected");
		// })
		// $(document).ready(function() {
		//     var loadingSpinner = document.getElementById('loadingSpinner');

		//     function showLoadingSpinner() {
		//         // loadingSpinner.style.display = 'block';
		//         var spinner = document.getElementById('loadingSpinner');
		//         spinner.style.display = 'flex';
		//     }

		// });
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var loadingSpinner = document.getElementById('loadingSpinner');

		function showLoadingSpinner() {
			// loadingSpinner.style.display = 'block';
			var spinner = document.getElementById('loadingSpinner');
			spinner.style.display = 'flex';
		}

		function submitdisposisi() {
			if ($('#selectdisposisi').val() == '') {
				alert('Silakan memilih Evaluator');
				$('#submitModal').modal('toggle');
			} else {
				showLoadingSpinner();
				$('.notif-button').attr("hidden", true);
				$('.loading').attr("hidden", false);
				$('#formDisposisi').submit();
				$("#btnSubmit").attr("disabled", true);
				$("#btnSubmitKoreksi").attr("disabled", true);
			}
		}

		function validateForm() {
			var selectedValue = document.getElementById("selectdisposisi").value;

			if (selectedValue === "null") {
				alert("Pilih Evaluator terlebih dahulu.");
				return false; // Prevent form submission
			} else {
				// You can perform additional validation or actions here
				$('#submitModal').modal('show');
				return false; // Allow form submission
			}
		}

		function logPermohonan() {
			var innerhtml = '';
			var id_izin = $('#id_izin').val();
			$.ajax({
				/* the route pointing to the post function */
				url: ' {{ route('admin.koordinator.getlogizin') }} ',
				type: 'POST',
				/* send the csrf-token and the input to the controller */
				data: {
					id_izin: id_izin
				},
				dataType: 'JSON',
				/* remind that 'data' is the response of the AjaxController */
				success: function(data) {
					if (data == 'is_empty') {
						innerhtml += "<p>Belum ada Riwayat</p>";
						$('#modal-body-log').html(innerhtml)
						$('#detailLog').modal('show');
					} else {
						innerhtml += '<div class="timeline timeline-left" >';
						innerhtml += '<div class="timeline-container" >';
						$.each(data, function(index, value) {
							innerhtml += '<div class="timeline-row" >';
							innerhtml +=
								'<div class="timeline-icon" style="text-align:center;padding-top:7px;">' +
								(index + 1) + '</div>';
							innerhtml += '<div class="card"><div class="card-body">' + value
								.created_at + '</div></div>';
							innerhtml += '<div class="card"><div class="card-body">Status : ' + value
								.status_permohonan + '</div></div>';
							innerhtml += '</div>';
						})
						innerhtml += '</div>';
						innerhtml += '</div>';


						$('#modal-body-log').html(innerhtml)
						$('#detailLog').modal('show');
					};
				}
			});
		}
	</script>
@endpush
