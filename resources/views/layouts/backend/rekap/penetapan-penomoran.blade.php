@extends('layouts.backend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
@endsection
@section('content')
	<div class="form-group">

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
							@if (isset($detailnib))
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
														<a target="_blank" href="{{ asset($detailnib->path_berkas_nib) }}" class="btn btn-teal"
															type="button">Lihat Dokumen</a>
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
							@elseif (isset($penomoran_ulang))
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">NIB </label>
											<div class="input-group col-lg-8">
												<input type="text" class="form-control" value="{{ $penomoran_ulang->nib }}" disabled>
												<span class="input-group-append">
													{{-- <button class="btn btn-light" type="button">Button</button>
                                                     --}}
													<a target="_blank" href="{{ asset($penomoran_ulang->berkas_nib) }}" class="btn btn-teal"
														type="button">Lihat
														Dokumen</a>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Alamat </label>
											<div class="col-lg">
												{{-- <input type="text" class="form-control"
													value="{{ strtoupper($penomoran_ulang->alamat_institusi) . ', ' . $penomoran_ulang->detail_loc . ' ' . $penomoran_ulang->kodepos }}"
													disabled> --}}
												<textarea disabled="disabled" rows="4" cols="3" class="form-control"
												 placeholder="{{ strtoupper($penomoran_ulang->alamat_institusi) . ', ' . $penomoran_ulang->detail_loc . ' ' . $penomoran_ulang->kodepos }}"></textarea>
											</div>
										</div>
									</div>
								</div>
							@endif
						</div>
						<div class="col">
							<legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>

							@if (isset($detailnib))
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
													value="{{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}"
													disabled>
											</div>
										</div>
									</div>
								</div>
							@elseif (isset($penomoran_ulang))
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<label class="col-lg-4 col-form-label">Email </label>
											<div class="col-lg">
												<input type="text" class="form-control"
													value="{{ isset($penomoran_ulang->email_institusi) ? $penomoran_ulang->email_institusi : '-' }}" disabled>
											</div>
										</div>
									</div>
								</div>
							@endif
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
						@if ($penomoran['kode_akses']['jenis_penomoran'] != 'Blok Nomor')
							@if ($penomoran['jenis_permohonan'] == 'Perubahan Penetapan')
								<div class="form-group row">
									<label class="col-lg-4 col-form-label">Kode Akses</label>
									<div class="col-lg-8">
										<input type="text" class="form-control"
											value="{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}"
											disabled>
									</div>
								</div>
							@endif
						@endif
					</div>
					@if ($penomoran['kode_akses']['jenis_penomoran'] != 'Blok Nomor')
						@if ($penomoran['jenis_permohonan'] == 'Perubahan Penetapan')
							<div class="col-lg-6">
								<div class="col-12 row">
									<div class="col-lg-4 form-group">
										<label class="col-form-label">No SK Penetapan </label>
									</div>
									<div class="col-lg-8 form-group">
										<input type="text" class="form-control" name="no_sk" id="no_sk"
											value="{{ $penomoran['pe_no_sk'] }}" disabled>
									</div>
								</div>
								<div class="col-lg-12 row">
									<div class="col-lg-4 form-group">
										<label class="col-form-label">Tanggal Penetapan </label>
									</div>
									<div class="col-lg-8 form-group">
										<input type="date" class="form-control" name="tgl_sk" id="tgl_sk"
											value="{{ $penomoran['pe_date_sk'] }}" disabled>
									</div>
								</div>
							</div>
						@else
							<div class="col-lg-6">
								<div class="col-12 row">
									<div class="col-lg-4 form-group">
										<label class="col-form-label">Kode Akses</label>
									</div>
									<div class="col-lg-8">
										<input type="text" class="form-control"
											value="{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}"
											disabled>
									</div>
								</div>
							</div>
						@endif
					@endif
				</div>

				@if ($penomoran['kode_akses']['jenis_penomoran'] == 'Blok Nomor')
					<div class="form-group row">
						<div class="col-lg-12">
							<div class="row">
								<label class="col-lg-2 col-form-label">Daftar Blok Nomor </label>
								<div class="col-lg-8" id="PilihKodeWilayah">
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
												<th style="border-top: none;background: #fafafa;text-align: center;">
													Status Evaluasi
												</th>
											</tr>

										</thead>
										<tbody id="bloknomor-lists">
											@foreach ($penomoran_bloknomor as $item => $d)
												<input type="hidden" name="bloknomor[{{ $item }}][bn_kode_wilayah]"
													value={{ $d['kode_wilayah'] }}>
												<input type="hidden" name="bloknomor[{{ $item }}][bn_prefix_awal]"
													value={{ $d['prefix_awal'] }}>
												<tr class="bloknomor-item">
													<td style="width: 40%;">
														<div class="font-size-sm">
															{{-- {{ $d['nama_wilayah'] }} --}}
															<input type="text" id="nama_wilayah[{{ $item }}]" class="form-control"
																value="{{ $d['nama_wilayah'] }}" disabled>
														</div>
													</td>
													<td style="width: 10%;">
														<div class="font-size-sm">
															{{-- {{ $d['kode_wilayah'] }} --}}
															<input type="text" id="kode_wilayah[{{ $item }}]" class="form-control"
																value="{{ $d['kode_wilayah'] }}" disabled>
														</div>
													</td>
													<td style="width: 10%;">
														<div class="font-size-sm">
															{{-- {{ $d['prefix_awal'] }} --}}
															<input type="text" id="prefix_awal[{{ $item }}]" class="form-control"
																value="{{ $d['prefix_awal'] }}" disabled>
														</div>
													</td>
													<td style="width: 15%;">
														<div>
															<select name="bloknomor[{{ $item }}][is_deleted]"
																id="bloknomor[{{ $item }}][is_deleted]" onchange="updateDatabase({{ $item }})"
																class="form-control bloknomor-isdeleted" data-placeholder="Silakan Pilih" disabled>
																<option value="" selected>Pilih Evaluasi</option>
																<option value="1" @if ($d['status_evaluasi_bloknomor'] == '1') selected @endif>
																	Setuju</option>
																<option value="2" @if ($d['status_evaluasi_bloknomor'] == '2') selected @endif>
																	Ditolak</option>
															</select>
														</div>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				@else
					{{-- <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Kode Akses </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control"
                                            value="{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
				@endif

				@if ($penomoran['jenis_permohonan'] == 'Penetapan Nomor Tambahan')
					<legend class="text-uppercase font-size-sm font-weight-bold">Kelengkapan</legend>
					<div class="form-group row">
						<?php
						// $file = explode('/', $penomoran['dok_pengguna_penomoran']);
						if (isset($penomoran['dok_pengguna_penomoran']) && $penomoran['dok_pengguna_penomoran'] != '') {
						    $file = explode('/', $penomoran['dok_pengguna_penomoran']);
						    $file = $file[3];
						} else {
						    $file = '';
						}
						if (isset($penomoran['dok_izin_penyelenggaraan']) && $penomoran['dok_izin_penyelenggaraan'] != '') {
						    $_file4 = explode('/', $penomoran['dok_izin_penyelenggaraan']);
						    $file4 = $_file4[3];
						} else {
						    $file4 = '';
						}
						?>
						@if (isset($penomoran['dok_izin_penyelenggaraan']) && $penomoran['dok_izin_penyelenggaraan'] != '')
							<div class="col-lg-6">
								<div class="row">
									<div class="col-12">
										<p class="font-weight-semibold">Dokumen Perizinan Berusaha</p>
										<div class="input-group">
											<input disabled="disabled" type="text" class="form-control " placeholder="{{ $file4 }}">
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
										<input disabled="disabled" type="text" class="form-control " placeholder="{{ $file }}">
										<span class="input-group-append">
											<a target="_blank" href="{{ asset($penomoran['dok_pengguna_penomoran']) }}" class="btn btn-teal"
												type="button">Lihat Dokumen</a>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					@if (strtolower($penomoran['kd_izin']) == '059000000033')
						<div
							class="form-group row<?= strtolower($penomoran['jenis_layanan']) == 'sertifikat penyelenggaraan jasa konten sms premium' ? 'd-blok' : 'd-none' ?>">
							<?php
							if (isset($penomoran['dok_kode_akses_konten']) && $penomoran['dok_kode_akses_konten'] != '') {
							    $_file2 = explode('/', $penomoran['dok_kode_akses_konten']);
							    $file2 = $_file2[3];
							} else {
							    $file2 = '';
							}
							?>
							<div class="col-6">
								<div class="row">
									<div class="col-12">
										<p class="font-weight-semibold">Penjelasan Singkat (Produk brief) Layanan Baru
										</p>
										<div class="input-group">
											<input disabled="disabled" type="text" class="form-control " placeholder="{{ $file2 }}">
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

					@if (strtolower($penomoran['kd_izin']) == '059000000052')
						<div class="form-group row">
							<?php
							if (isset($penomoran['dok_call_center']) && $penomoran['dok_call_center'] != '') {
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
											<input disabled="disabled" type="text" class="form-control " placeholder="{{ $file3 }}">
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
					{{-- <hr class="" /> --}}
					{{-- <div class="form-group row">
                            <div class="col-lg-12">
                                
                                <label for="berkas_tambahan">Berkas Hasil Evaluasi Permohonan Nomor Tambahan</label>
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control "
                                        placeholder="{{ $path_bkpm[2] }}">
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($penomoran['path_dok_evaluasi_tambahan']) }}"
                                            class="btn btn-teal" type="button">Lihat Dokumen</a>
                                    </span>
                                </div>
                            </div>
                        </div> --}}

					{{-- <hr class="" /> --}}
				@elseif($penomoran['jenis_permohonan'] == 'Perubahan Penetapan')
					<?php
					// $file_sk = explode('/', $penomoran['pe_dok_sk']);
					
					if (isset($penomoran['pe_dok_sk']) && $penomoran['pe_dok_sk'] != '') {
					    $file_sk = explode('/', $penomoran['pe_dok_sk']);
					    $file_sk = $file_sk[3];
					} else {
					    $file_sk = '';
					}
					// $file_skizin = explode('/', $penomoran['pe_dok_perizinan_terakhir']);
					
					if (isset($penomoran['pe_dok_perizinan_terakhir']) && $penomoran['pe_dok_perizinan_terakhir'] != '') {
					    $file_skizin = explode('/', $penomoran['pe_dok_perizinan_terakhir']);
					    $file_skizin = $file_skizin[3];
					} else {
					    $file_skizin = '';
					}
					// $file_dokduk = explode('/', $penomoran['pe_dok_pendukung']);
					if (isset($penomoran['pe_dok_pendukung']) && $penomoran['pe_dok_pendukung'] != '') {
					    $file_dokduk = explode('/', $penomoran['pe_dok_pendukung']);
					    $file_dokduk = $file_dokduk[3];
					} else {
					    $file_dokduk = '';
					}
					?>
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Kelengkapan</legend>
					<div class="col-lg-6">
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
							<div class="col-lg-12 form-group">
								<label class="col-form-label">SK Penetapan Penomoran </label>
								{{-- </div>
                            <div class="col-lg-8 form-group"> --}}
								<div class="input-group">
									<input disabled="disabled" type="text" class="form-control border-right-0"
										placeholder="{{ $file_sk }}">
									<span class="input-group-append">
										<a target="_blank" href="{{ asset($penomoran['pe_dok_sk']) }}" class="btn btn-teal" type="button">Lihat
											Dokumen</a>
									</span>
								</div>
							</div>
						</div>
						@if (isset($penomoran['pe_dok_perizinan_terakhir']) && $penomoran['pe_dok_perizinan_terakhir'] != '')
							<div class="col-lg-12 row">
								<div class="col-lg-12 form-group">
									<label class="col-form-label">SK Perizinan Berusaha </label>
									<div class="input-group">
										<input disabled="disabled" type="text" class="form-control border-right-0"
											placeholder="{{ $file_skizin }}">
										<span class="input-group-append">
											<a target="_blank" href="{{ asset($penomoran['pe_dok_perizinan_terakhir']) }}" class="btn btn-teal"
												type="button">Lihat Dokumen</a>
										</span>
									</div>
								</div>
							</div>
						@endif

						<div class="col-lg-12 row">
							<div class="col-lg-12 form-group">
								<label class="col-form-label">Dokumen Pendukung Perubahan Penetapan Penomoran </label>
								{{-- </div>
                            <div class="col-lg-8 form-group"> --}}
								<div class="input-group">
									<input disabled="disabled" type="text" class="form-control border-right-0"
										placeholder="{{ $file_dokduk }}">
									<span class="input-group-append">
										<a target="_blank" href="{{ asset($penomoran['pe_dok_pendukung']) }}" class="btn btn-teal"
											type="button">Lihat Dokumen</a>
									</span>
								</div>
							</div>
						</div>
						{{-- <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-4 col-form-label" id="lbl_kdakses">Kode Akses dalam
                                        Data Penetapan</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-8" id="PilihKodeWilayah">
                                        <table class="table table-custom table-sm">

                                            <tbody id="bloknomor-lists">
                                                @if (isset($vw_kodeakses_additional))
                                                    @foreach ($vw_kodeakses_additional as $item => $d)
                                                        <tr class="kodeakses_hapus-item">
                                                            <td style="width: 38%;">
                                                                <input disabled type="text"
                                                                    class="form-control pilih-bloknomor"
                                                                    placeholder="{{ isset($d['kode_akses']) ? $d['kode_akses'] : '' }}"
                                                                    value={{ isset($d['kode_akses']) ? $d['kode_akses'] : '' }} />
                                                            </td>
                                                            <td style="width: 60%;">
                                                                <select class="form-control pilih-status_pe_sk" disabled>
                                                                    <option value="1"
                                                                        @if ($d['status_permohonan'] == '302') selected @endif>
                                                                        Penetapan Ulang</option>
                                                                    <option value="2"
                                                                        @if ($d['status_permohonan'] == '301') selected @endif>
                                                                        Pencabutan</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}
					</div>

					<hr class="" />
				@elseif($penomoran['jenis_permohonan'] == 'Pengembalian Penomoran')
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Kelengkapan</legend>
					<div class="form-group row">
						<?php
						$file_sk = explode('/', $penomoran['pe_dok_sk']);
						?>
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-lg-4 col-form-label">No SK Penetapan </label>
								<div class="col-lg-8">
									<input name="no_sk" id="no_sk" type="text" class="form-control"
										value="{{ $penomoran['pe_no_sk'] }}" disabled>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 col-form-label">Tanggal Penetapan </label>
								<div class="col-lg-8">
									<input type="date" class="form-control" name="tgl_sk" id="tgl_sk"
										value="{{ $penomoran['pe_date_sk'] }}" disabled>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 col-form-label">Lampiran Penetapan </label>
								<div class="col-lg-8">
									<div class="input-group">
										<input disabled="disabled" type="text" class="form-control border-right-0"
											placeholder="{{ $file_sk[3] }}">
										<span class="input-group-append">
											<a target="_blank" href="{{ asset($penomoran['pe_dok_sk']) }}" class="btn btn-teal" type="button">Lihat
												Dokumen</a>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-8 col-form-label" id="lbl_kdakses">Kode Akses dalam
									Data Penetapan</label>
								<div class="col-lg-12" id="PilihKodeWilayah">
									<table class="table table-custom table-sm">

										<tbody id="bloknomor-lists">
											@for ($i = 0; $i < 1; $i++)
												<tr class="kodeakses_hapus-item">
													<td style="width: 38%;">
														<input type="hidden" name="kodeakses_hapus[{{ $i }}][kode_akses]"
															value={{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}>
														<input type="hidden" name="kodeakses_hapus[{{ $i }}][status_pe_sk]" value="2">
														<input disabled type="text" class="form-control pilih-bloknomor" {{-- name="kodeakses_hapus[{{ $i }}][kode_akses]" --}}
															placeholder="{{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}"
															value={{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }} />
													</td>
													<td style="width: 60%;">
														<select {{-- name="kodeakses_hapus[{{ $i }}][status_pe_sk]" --}} class="form-control pilih-status_pe_sk" disabled>
															<option value="1">Penetapan Ulang</option>
															<option value="2" selected>Pencabutan</option>
														</select>
													</td>
													{{-- <td style="width: 2%;">
                                                        <button type="button" class="btn btn-success add-kodeakses"
                                                            id="add-kodeakses"><i class="icon-plus3"></i></button>
                                                    </td> --}}
												</tr>
											@endfor
											@if (isset($vw_kodeakses_additional))
												@foreach ($vw_kodeakses_additional_nonarray as $item => $d)
													{{-- @for ($i = 0; $i < $vw_kodeakses_additional_count; $i++) --}}
													<tr class="kodeakses_hapus-item">
														<td style="width: 38%;">
															<input disabled type="text" class="form-control pilih-bloknomor"
																name="kodeakses_re[{{ $d }}][kode_akses]"
																placeholder="{{ isset($d['kode_akses']) ? $d['kode_akses'] : '' }}"
																value={{ isset($d['kode_akses']) ? $d['kode_akses'] : '' }}
																@if ($penomoran['kode_akses']['kode_akses'] == $d['kode_akses'])  @endif />
														</td>
														<td style="width: 60%;">
															<select disabled name="kodeakses_re[{{ $d }}][status_pe_sk]"
																class="form-control pilih-status_pe_sk" @if ($penomoran['kode_akses']['kode_akses'] == $d['kode_akses'])  @endif>
																<option value="1" @if ($d['status_permohonan'] == '302') selected @endif>
																	Penetapan Ulang</option>
																<option value="2" @if ($d['status_permohonan'] == '301') selected @endif>
																	Pencabutan</option>
															</select>
														</td>
														{{-- @if ($penomoran['kode_akses']['kode_akses'] == $d['kode_akses'])
                                                            <td style="width: 2%;">
                                                                <button type="button"
                                                                    class="btn btn-success btn-small add-kodeakses"
                                                                    id="add-kodeakses"><i class="icon-plus3"></i></button>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <button
                                                                    class="btn btn-danger btn-small btn-delete-kodeakses"
                                                                    id="btn-delete-kodeakses" type="button"><i
                                                                        class="icon-minus3"></i></button>
                                                            </td>
                                                        @endif --}}
													</tr>
													{{-- @endfor --}}
												@endforeach
											@endif
										</tbody>
									</table>
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
				@elseif($penomoran['jenis_permohonan'] == 'Penetapan Ulang Penomoran Telekomunikasi')
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Kelengkapan</legend>
					<div class="form-group">
						<?php
						$file_berkastambahan = explode('/', $penomoran_ulang->berkas_tambahan);
						?>
						<div class="col-lg-12">
							<div class="form-group row">
								<label class="col-lg-2 col-form-label">Data Dukung Penetapan Ulang </label>
								<div class="col-lg-10">
									<div class="input-group">
										<input disabled="disabled" type="text" class="form-control border-right-0"
											placeholder="{{ $file_berkastambahan[3] }}">
										<span class="input-group-append">
											<a target="_blank" href="{{ asset($penomoran_ulang->berkas_tambahan) }}" class="btn btn-teal"
												type="button">Lihat
												Dokumen</a>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<div class="form-group row">
								<label class="col-lg-2 col-form-label">Dasar Penetapan Ulang </label>
								<div class="col-lg-10">
									<textarea disabled="disabled" rows="4" cols="3" class="form-control" id="ReasonRemoval_SK"
									 placeholder="{{ $penomoran_ulang->dasar_penetapanulang }}" name="ReasonRemoval_SK" required></textarea>
								</div>
							</div>
						</div>
					</div>
				@endif

				<legend class="text-uppercase font-size-sm font-weight-bold">Proses Evaluasi</legend>
				<div class="form-group row">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-6">
								<label class="col-form-label">Evaluator</label>
								<input type="text" class="form-control"
									value="{{ isset($penomoran['evaluator_name']) ? $penomoran['evaluator_name'] : '' }}" disabled>
							</div>
						</div>
					</div>
				</div>
				@if ($penomoran['jenis_permohonan'] == 'Penetapan Nomor Tambahan')
					<?php
					if (isset($penomoran['path_dok_evaluasi_tambahan'])) {
					    $_file_berkas = explode('/', $penomoran['path_dok_evaluasi_tambahan']);
					    $file_berkas = $_file_berkas[2];
					} else {
					    $file_berkas = '';
					}
					
					$file_berkas = $file_berkas;
					?>
					<div class="form-group row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-6">
									<label for="berkas_tambahan">Berita Acara Pemeriksaan Nomor Yang Pernah
										Ditetapkan</label>
									{{-- </div> --}}
									{{-- <div class="col-lg-4"> --}}
									<div class="input-group">
										<input disabled="disabled" type="text" class="form-control " placeholder="{{ $file_berkas }}">
										<span class="input-group-append">
											<a target="_blank" href="{{ asset($penomoran['path_dok_evaluasi_tambahan']) }}" class="btn btn-teal"
												type="button">Lihat Dokumen</a>
										</span>
									</div>

								</div>
							</div>

						</div>
					</div>
				@endif

				{{-- <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="row">
                            <label class="col-lg-3 " for="berkas_tambahan">Berkas Berita Acara
                                Penggunaan Penomoran</label>
                            <div class="input-group row">
                                <input type="file" class="form-control" name="berkas_tambahan" id="berkas_tambahan"
                                    accept="application/pdf">
                                <span class="input-group-append">
                                    <a target="_blank" href="{{ asset($penomoran['path_dok_evaluasi_tambahan']) }}"
                                        class="btn btn-teal" type="button">Lihat Dokumen</a>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div> --}}
				{{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="col-form-label">Status Hasil Evaluasi</label>
                                <select name="status_sk" id="status_sk" data-placeholder="Silakan Pilih"
                                    class="form-control" disabled>
                                    
                                    <option value='1' selected>Disetujui</option>
                                    <option value='0'>Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div> --}}
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

		{{-- <div class="card">

            <div class="card-body">
                <form method="post" id="formEvaluasi"
                    action="{{ route('admin.direktur.penetapanpenomoranpost', [$id, $penomoran['id_kode_akses']]) }}">
                    @csrf
                    <input type="hidden" name="id_izin" value="{{ $penomoran['id_izin'] }}">
                    <div class="text-right">
                        <a href="{{ URL::previous() }}" class="btn btn-secondary border-transparent"><i
                                class="icon-backward2 ml-2"></i> Kembali </a>
                        <a href="{{ route('admin.sk.draftpenomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}"
                            target="_blank" class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a>

                        <button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModal"
                            class="btn btn-indigo">Persetujuan Penetapan Penomoran</button>
                    </div>
                </form>
            </div>
        </div> --}}
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
					<p>Apakah anda yakin akan menyetujui Permohonan Penomoran ini ?</p>
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

@endsection
<script>
	$(document).ready(function() {

	})

	function submitdisposisi() {
		$('.notif-button').attr("hidden", true);
		$('.loading').attr("hidden", false);
		$('#formEvaluasi').submit();
		$("#btnSubmit").attr("disabled", true);
	}
</script>
