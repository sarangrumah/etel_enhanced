@extends('layouts.backend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	{{-- <script src="{{ url('global_assets/js/demo_pages/form_select2.js') }}"></script> --}}
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
	@if (Session::get('message') != '')
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif
	<form method="post" id="formEvaluasi"
		action="{{ route('admin.koordinator.evaluasipenomoranpost', [$id, $penomoran['id_kode_akses']]) }}">
		@csrf
		<input type="hidden" id="id_izin" name="id_izin" value="{{ $penomoran['id_izin'] }}" />
		<input type="hidden" id="id_kodeakses" name="id_kodeakses" value="{{ $penomoran['id_kode_akses'] }}" />
		<div class="form-group">

			<!-- Section Detail Perusahaan -->
			{{-- <div>
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Informasi Perusahaan </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Perusahaan/Instansi
                                    </legend>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab
                                    </legend>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NIB </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['nib'] }}</label>
                                    </div>
                                    <div class="col-lg">
                                        <span>
                                            <a target="_blank" href="{{ asset($detailnib->path_berkas_nib) }}"
                                                class="btn btn-teal" type="button">Lihat Dokumen</a>
                                        </span>
                                    </div>
                                </div>.
                            </div>
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
                                    <label class="col-lg-4 col-form-label">Email </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">

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
                                    <label class="col-lg-4 col-form-label">No Telp </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ $detailnib['nomor_telpon_perseroan'] }}</label>
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
            </div> --}}
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
														<input type="text" class="col-lg form-control" value="{{ $detailnib['nib'] }}" disabled>
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
												<label class="col-lg-4 col-form-label">NPWP </label>
												<div class="col-lg">
													{{-- <label class="col-lg col-form-label">:
                                                {{ $detailnib['npwp_perseroan'] }}</label> --}}
													<input type="text" class="form-control" value="{{ $detailnib['npwp_perseroan'] }}" disabled>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<label class="col-lg-4 col-form-label">Nama </label>
												<div class="col-lg">
													{{-- <label class="col-lg col-form-label">:
                                                {{ $detailnib['nama_perseroan'] }}</label> --}}
													<input type="text" class="form-control" value="{{ $detailnib['nama_perseroan'] }}" disabled>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<label class="col-lg-4 col-form-label">No Telp/Mobile </label>
												<div class="col-lg">
													{{-- <label class="col-lg col-form-label">:
                                                {{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}</label> --}}

													<input type="text" class="form-control"
														value="{{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}"
														disabled>
												</div>
											</div>
										</div>
									</div>
								@elseif(isset($penomoran_ulang))
									@if (isset($penomoran_ulang->nib))
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
									@endif
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<label class="col-lg-4 col-form-label">Nama </label>
												<div class="col-lg">
													<input type="text" class="form-control" value="{{ $penomoran_ulang->nama_institusi }}" disabled>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<label class="col-lg-4 col-form-label">Alamat </label>
												<div class="col-lg">
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
													{{-- <label class="col-lg col-form-label">:
                                                    {{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}
                                                </label> --}}
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
													{{-- <label class="col-lg col-form-label">:
                                                    {{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label> --}}

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
													{{-- <label class="col-lg col-form-label">:
                                                    {{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
                                                </label> --}}
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
													{{-- <label class="col-lg col-form-label">:
                                                    {{ $detailnib['nomor_telpon_perseroan'] }}</label> --}}
													<input type="text" class="form-control"
														value="{{ isset($detailnib['nomor_telpon_perseroan']) ? $detailnib['nomor_telpon_perseroan'] : '-' }}"
														disabled>
												</div>
											</div>
										</div>
									</div>
								@elseif(isset($penomoran_ulang))
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<label class="col-lg-4 col-form-label">Email </label>
												<div class="col-lg">
													<input type="text" class="form-control"
														value="{{ isset($penomoran_ulang->email_institusi) ? $penomoran_ulang->email_institusi : '-' }}"
														disabled>
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

			{{-- <div>
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
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Permohonan
                                    </legend>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Perizinan</legend>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $penomoran['id_izin'] }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Perizinan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['jenis_izin']) ? $penomoran['jenis_izin'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                                    <div class="col-lg">
                                        @if ($penomoran['updated_date'] == null)
                                            <label class="col-lg col-form-label">: - </label>
                                        @else
                                            <label class="col-lg col-form-label">:
                                                {{ $date_reformat->date_lang_reformat_long($penomoran['updated_date']) }}
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">KBLI</label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['full_kbli']) ? $penomoran['full_kbli'] : '' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['jenis_permohonan']) ? $penomoran['jenis_permohonan'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Layanan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['jenis_layanan']) ? $penomoran['jenis_layanan'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Status Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_izin']['name_status_bo']) ? $penomoran['kode_izin']['name_status_bo'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> --}}
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
												{{-- <label class="col-lg col-form-label">: {{ $penomoran['id_izin'] }}</label> --}}
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
													{{-- <label class="col-lg col-form-label">:
                                                    {{ $date_reformat->date_lang_reformat_long($penomoran['updated_date']) }}
                                                </label> --}}
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
												{{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['kode_izin']['name_status_bo']) ? $penomoran['kode_izin']['name_status_bo'] : '' }}</label> --}}
												<input type="text" class="form-control"
													value="{{ isset($penomoran['kode_izin']['name_status_bo']) ? $penomoran['kode_izin']['name_status_bo'] : '' }}"
													disabled>
											</div>
										</div>
									</div>
								</div>
							</div>
							@if (isset($penomoran['jenis_izin']))
								@if ($penomoran['status_badan_hukum'] != '03')
									<div class="col-lg-6">

										<legend class="text-uppercase font-size-sm font-weight-bold">Data Perizinan</legend>

										<div class="form-group">
											<div class="col-lg-12">
												<div class="row">
													<label class="col-lg-4 col-form-label">Perizinan </label>
													<div class="col-lg">
														{{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['jenis_izin']) ? $penomoran['jenis_izin'] : '' }}</label> --}}
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
														{{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['full_kbli']) ? $penomoran['full_kbli'] : '' }}
                                            </label> --}}
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
														{{-- <label class="col-lg col-form-label">:
                                                {{ isset($penomoran['jenis_layanan']) ? $penomoran['jenis_layanan'] : '' }}</label> --}}
														<input type="text" class="form-control" value="{!! $penomoran['jenis_layanan_html_nomor'] !!}" disabled>
													</div>
												</div>
											</div>
										</div>
									</div>
								@endif
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
											<label class="col-form-label">No SK Penetapan</label>
										</div>
										<div class="col-lg-8 form-group">
											<input type="text" class="form-control" name="no_sk" id="no_sk"
												value="{{ $penomoran['pe_no_sk'] }}">
										</div>
									</div>
									<div class="col-lg-12 row">
										<div class="col-lg-4 form-group">
											<label class="col-form-label">Tanggal Penetapan </label>
										</div>
										<div class="col-lg-8 form-group">
											<input type="date" class="form-control" name="tgl_sk" id="tgl_sk"
												value="{{ $penomoran['pe_date_sk'] }}">
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
																	value="{{ $d['nama_wilayah'] }}">
															</div>
														</td>
														<td style="width: 10%;">
															<div class="font-size-sm">
																{{-- {{ $d['kode_wilayah'] }} --}}
																<input type="text" id="kode_wilayah[{{ $item }}]" class="form-control"
																	value="{{ $d['kode_wilayah'] }}">
															</div>
														</td>
														<td style="width: 10%;">
															<div class="font-size-sm">
																{{-- {{ $d['prefix_awal'] }} --}}
																<input type="text" id="prefix_awal[{{ $item }}]" class="form-control"
																	value="{{ $d['prefix_awal'] }}">
															</div>
														</td>
														<td style="width: 15%;">
															<div>
																<select name="bloknomor[{{ $item }}][is_deleted]"
																	id="bloknomor[{{ $item }}][is_deleted]" onchange="updateDatabase({{ $item }})"
																	class="form-control bloknomor-isdeleted" data-placeholder="Silakan Pilih">
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
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Kelengkapan</legend>
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
							if (isset($penomoran['dok_kode_akses_konten']) && $penomoran['dok_kode_akses_konten'] != '') {
							    $_file5 = explode('/', $penomoran['dok_kode_akses_konten']);
							    $file5 = $_file5[3];
							} else {
							    $file5 = '';
							}
							
							$file4 = $file4;
							?>
							@if (isset($penomoran['dok_izin_penyelenggaraan']) && $penomoran['dok_izin_penyelenggaraan'] != '')
								<div class="col-lg-6">
									<div class="row">
										<div class="col-lg-12">
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
							@if (isset($penomoran['dok_kode_akses_konten']) && $penomoran['dok_kode_akses_konten'] != '')
								<div class="col-lg-6">
									<div class="row">
										<div class="col-12">
											<p class="font-weight-semibold">Penjelasan Singkat (<i>Product Brief</i>) untuk
												Layanan Baru </p>
											<div class="input-group">
												<input disabled="disabled" type="text" class="form-control " placeholder="{{ $file5 }}">
												<span class="input-group-append">
													<a target="_blank" href="{{ asset($penomoran['dok_kode_akses_konten']) }}" class="btn btn-teal"
														type="button">Lihat Dokumen</a>
												</span>
											</div>
										</div>
									</div>
								</div>
							@endif
							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-12">
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

						{{-- @if (strtolower($penomoran['kd_izin']) == '059000000033')
                            <div
                                class="form-group row <?= strtolower($penomoran['jenis_layanan']) == 'sertifikat penyelenggaraan jasa konten sms premium' ? 'd-blok' : 'd-none' ?>">
                                <?php
																																if (isset($penomoran['dok_kode_akses_konten']) && $penomoran['dok_kode_akses_konten'] != '') {
																																    $_file2 = explode('/', $penomoran['dok_kode_akses_konten']);
																																    $file2 = $_file2[3];
																																} else {
																																    $file2 = '';
																																}
																																
																																$file2 = $file2;
																																?>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p class="font-weight-semibold">Penjelasan Singkat (Produk brief) Layanan Baru
                                            </p>
                                            <div class="input-group">
                                                <input disabled="disabled" type="text" class="form-control "
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
										<div class="col-lg-6">
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
						if (isset($penomoran['pe_dok_sk']) && $penomoran['pe_dok_sk'] != '') {
						    $file_sk = explode('/', $penomoran['pe_dok_sk']);
						    $file_sk = $file_sk[3];
						} else {
						    $file_sk = '';
						}
						if (isset($penomoran['pe_dok_perizinan_terakhir']) && $penomoran['pe_dok_perizinan_terakhir'] != '') {
						    $file_skizin = explode('/', $penomoran['pe_dok_perizinan_terakhir']);
						    $file_skizin = $file_skizin[3];
						} else {
						    $file_skizin = '';
						}
						if (isset($penomoran['pe_dok_pendukung']) && $penomoran['pe_dok_pendukung'] != '') {
						    $file_dokduk = explode('/', $penomoran['pe_dok_pendukung']);
						    $file_dokduk = $file_dokduk[3];
						} else {
						    $file_dokduk = '';
						}
						?>
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Kelengkapan</legend>
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
								<div class="col-lg-12 form-group">
									<label class="col-form-label">SK Penetapan Penomoran </label>
									{{-- </div>
                                <div class="col-lg-12 form-group"> --}}
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

							@if ($penomoran['status_badan_hukum'] != '03')
								<div class="col-lg-12 row">
									<div class="col-lg-12 form-group">
										<label class="col-form-label">SK Perizinan Berusaha </label>
										{{-- </div>
                                <div class="col-lg-8 form-group"> --}}
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
                                <div class="col-lg-12 form-group"> --}}
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
							// $file_sk = explode('/', $penomoran['pe_dok_sk']);
							if (isset($penomoran['pe_dok_sk']) && $penomoran['pe_dok_sk'] != '') {
							    $file_sk = explode('/', $penomoran['pe_dok_sk']);
							    $file_sk = $file_sk[3];
							} else {
							    $file_sk = '';
							}
							?>
							<div class="col-lg-6">
								<div class="form-group row">
									<label class="col-lg-4 col-form-label">No SK Penetapan </label>
									<div class="col-lg-8">
										<input name="no_sk" id="no_sk" type="text" class="form-control"
											value="{{ $penomoran['pe_no_sk'] }}">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-4 col-form-label">Tanggal Penetapan </label>
									<div class="col-lg-8">
										<input type="date" class="form-control" name="tgl_sk" id="tgl_sk"
											value="{{ $penomoran['pe_date_sk'] }}">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-4 col-form-label">Lampiran Penetapan </label>
									<div class="col-lg-8">
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
														<td style="width: 2%;">
															<button type="button" class="btn btn-success add-kodeakses" id="add-kodeakses"><i
																	class="icon-plus3"></i></button>
														</td>
													</tr>
												@endfor
												@if (isset($vw_kodeakses_additional))
													@foreach ($vw_kodeakses_additional_nonarray as $item => $d)
														{{-- @for ($i = 0; $i < $vw_kodeakses_additional_count; $i++) --}}
														<tr class="kodeakses_hapus-item">
															<td style="width: 38%;">
																<input type="text" class="form-control pilih-bloknomor"
																	name="kodeakses_hapus[{{ $loop->iteration }}][kode_akses]"
																	placeholder="{{ isset($d['kode_akses']) ? $d['kode_akses'] : '' }}"
																	value={{ isset($d['kode_akses']) ? $d['kode_akses'] : '' }}
																	@if ($penomoran['kode_akses']['kode_akses'] == $d['kode_akses']) disabled @endif />
															</td>
															<td style="width: 60%;">
																<select id="kodeakses_hapus[{{ $loop->iteration }}][status_pe_sk]"
																	name="kodeakses_hapus[{{ $loop->iteration }}][status_pe_sk]" class="form-control pilih-status_pe_sk"
																	@if ($penomoran['kode_akses']['kode_akses'] == $d['kode_akses']) disabled @endif>
																	<option value="1" @if ($d['status_permohonan'] == '302') selected @endif>
																		Penetapan Ulang</option>
																	<option value="2" @if ($d['status_permohonan'] == '301') selected @endif>
																		Pencabutan</option>
																</select>
															</td>
															@if ($penomoran['kode_akses']['kode_akses'] == $d['kode_akses'])
																<td style="width: 2%;">
																	<button type="button" class="btn btn-success btn-small add-kodeakses" id="add-kodeakses"><i
																			class="icon-plus3"></i></button>
																</td>
															@else
																<td>
																	<button class="btn btn-danger btn-small btn-delete-kodeakses" id="btn-delete-kodeakses"
																		type="button"><i class="icon-minus3"></i></button>
																</td>
															@endif
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
								<label class="col-lg-2 col-form-label">Evaluator</label>
								<div class="col-lg-4">
									<input type="text" class="form-control"
										value="{{ isset($penomoran['evaluator_name']) ? $penomoran['evaluator_name'] : '' }}" disabled>
								</div>
							</div>
						</div>
					</div>
					@if ($penomoran['jenis_permohonan'] == 'Penetapan Nomor Tambahan')
						<div class="form-group row">
							<div class="col-lg-12">

								<div class="row">
									<div class="col-lg-2">
										<label for="berkas_tambahan">Berita Acara Pemeriksaan Nomor Yang Pernah
											Ditetapkan</label>
									</div>
									<?php
									if (isset($penomoran['path_dok_evaluasi_tambahan'])) {
									    $_file_berkas = explode('/', $penomoran['path_dok_evaluasi_tambahan']);
									    $file_berkas = $_file_berkas[2];
									} else {
									    $file_berkas = '';
									}
									
									$file_berkas = $file_berkas;
									?>
									<div class="col-lg-4">
										<input type="hidden" name="path_dok_evaluasi_tambahan_prv" id="path_dok_evaluasi_tambahan_prv"
											value="{{ asset($penomoran['path_dok_evaluasi_tambahan']) }}">
										<div class="input-group">
											<input type="file" class="form-control h-auto" name="berkas_tambahan" id="berkas_tambahan">
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
					<div class="form-group row">
						<div class="col-lg-12">
							<div class="form-group row">
								<label class="col-lg-2 col-form-label">Status Hasil Evaluasi</label>
								<div class="col-lg-4">
									<select name="status_sk" id="status_sk" data-placeholder="-- Pilih Hasil Evaluasi --"
										class="form-control select" required>
										<option value='null' disabled selected>-- Pilih Hasil Evaluasi --</option>
										<option value='1'>Disetujui</option>
										<option value='0'>Ditolak</option>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-12" style="margin-top: 20px;">
							<fieldset>
								<textarea rows="3" cols="3" class="form-control" id="catatan_hasil_evaluasi"
								 placeholder="Catatan Hasil Evaluasi" name="catatan_hasil_evaluasi"></textarea>
							</fieldset>
						</div>
					</div>
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
				<a type="button" href="{{ route('admin.koordinator') }}" class="btn btn-secondary border-transparent"><i
						class="icon-backward2 ml-2"></i> Kembali </a>

				{{-- <!-- <a target="_blank" href="{{ route('admin.historyperizinan', $penomoran['id_izin']) }}" class="btn btn-info">Riwayat Permohonan </a> --> --}}
				{{-- <a href="{{ route('admin.sk.draftpenomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}"
                    target="_blank" class="btn btn-success">Draf Penetapan <i class="icon-file-pdf ml-2"></i></a> --}}

				<!-- <button type="submit" onclick="return false;" data-toggle="modal" data-target="#penolakanModal" class="btn btn-danger">Tolak Permohonan <i class="icon-cross2 ml-2"></i></button> -->

				<a href="{{ route('admin.sk.draftpenomoran', [$penomoran['id_izin'], $penomoran['id_kode_akses']]) }}"
					target="_blank" class="btn btn-success" id='draftpenomoran'>Draf Penetapan <i
						class="icon-file-pdf ml-2"></i></a>
				{{-- <button type="button" id="btnSubmitModal" data-target="#submitModal" data-toggle="modal"
                    class="btn btn-indigo">Kirim Evaluasi <i class="icon-checkmark ml-2"></i></button> --}}
				<button type="button" id="btnSubmitModal" onclick="return validateForm();" class="btn btn-indigo">Kirim
					Evaluasi <i class="icon-checkmark ml-2"></i></button>

				<button type="button" id="btnSubmitModalKoreksi" data-toggle="modal" data-target="#submitModalKoreksi"
					class="btn btn-warning">Kirim Evaluasi Perbaikan <i class="icon-paperplane ml-2"></i></button>
			</div>
		</div>

	</form>

	<form method="post" id="formPenolakan" action="{{ route('admin.koordinator.evaluasipenomoran.penolakan', $id) }}">
		<!-- Form penolakan -->
		@csrf
		<input type="hidden" name="is_penolakan" value="1">
		<input type="hidden" id="catatan_evaluasi_penolakan" name="catatan_hasil_evaluasi">

	</form>
	<input type="hidden" id="id_izin" name="id_izin" value="{{ $id }}">
	<input type="hidden" name="id_kodeakses" value="{{ $penomoran['id_kode_akses'] }}" />

	<div class="modal" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Setujui Permohonan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan menyetujui permohonan penomoran ini ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" id="btnSubmit" onclick="submitevaluasi();return false;"
						class="btn btn-primary notif-button">Kirim</button>
					<div class="spinner-border loading text-primary" role="status" hidden>
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="submitModalKoreksi" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Kirim Evaluasi Perbaikan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="text-warning">Apakah anda yakin akan mengirim perbaikan evaluasi ini ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitdisposisi();return false;" class="btn btn-primary">Kirim</button>
					<div class="spinner-border loading text-primary" role="status" hidden>
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="penolakanModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Tolak Persyaratan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin akan menolak permohonan izin ini ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitpenolakan();return false;"
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
					<h5 class="modal-title">Informasi Riwayat Pemohonan</h5>
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
	<script type="text/javascript">
		$(document).ready(function() {

			$("#btnSubmitModalKoreksi").hide();
			$("#btnSubmitModal").show();
			// document.getElementById('draftpenomoran').addEventListener('click', function(event) {
			//     event.preventDefault(); // Prevent the default behavior of the link
			//     var formEvaluasi = $('#formEvaluasi').serialize();
			//     // Get the values from the data attributes
			//     var no_sk = document.getElementById('no_sk').value;
			//     var tgl_sk = this.getAttribute('tgl_sk');

			//     // Add the values to the modal form or any other element
			//     var id = document.getElementById('id_izin').value;
			//     var idKodeAkses = document.getElementById('id_kodeakses').value;
			//     // alert(id, no_sk, tgl_sk, idKodeAkses);
			//     // Open the modal
			//     // $('#submitModal').modal('show');
			//     $.ajax({
			//         type: "GET",
			//         url: "{{ route('admin.sk.draftpenomoran-pdf', ['id' => $penomoran['id_izin'], 'idkodeakses' => $penomoran['id_kode_akses']]) }}",
			//         // dataType: "json",
			//         data: {
			//             id: id,
			//             idKodeAkses: idKodeAkses,
			//             tgl_sk: tgl_sk,
			//             no_sk: no_sk,
			//             _token: "{{ csrf_token() }}",

			//             'formEvaluasi': formEvaluasi,
			//         },
			//         success: function(response) {
			//             // Handle success response
			//             // alert(response.data);
			//             console.log(response);
			//             if (response.pdfContent !== undefined && response.pdfContent !== null) {
			//                 // Get the base64-encoded PDF content
			//                 var pdfContent = response.pdfContent;

			//                 // Create a data URL for the PDF
			//                 var pdfDataUrl = 'data:application/pdf;base64,' + pdfContent;

			//                 // Open a new window and write the PDF content to it
			//                 var newTab = window.open(pdfDataUrl, '_blank');

			//                 // Optional: Close the modal or perform other actions if needed
			//                 // $('#submitModal').modal('hide');
			//             } else {
			//                 console.error('PDF content is undefined or null.');
			//             }
			//         },
			//         error: function(xhr, status, error) {
			//             console.error(xhr.responseText);
			//         }
			//     });
			// });
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

			$(document).on('click', '.btn-delete-kodeakses', function(e) {
				e.preventDefault();
				let row_item = $(this).parent().parent();

				let inputValue = row_item.find('.pilih-bloknomor').val();
				// alert(inputValue);
				disactivatedKodeakses(inputValue);
				$(row_item).remove();
			})

			$('#no_sk').blur(function(e) {
				// Get value from the input box
				e.preventDefault();
				// let row_item = $(this).parent().parent();

				// let inputValue = row_item.find('.pilih-bloknomor').val();
				// alert(inputValue);
				updateskinfo();
			});

			$('#tgl_sk').blur(function(e) {
				// Get value from the input box
				e.preventDefault();
				// let row_item = $(this).parent().parent();

				// let inputValue = row_item.find('.pilih-bloknomor').val();
				// alert(inputValue);
				updateskinfo();
			});


			$(".add-kodeakses").click(function(e) {
				e.preventDefault();
				// alert("Tambah");

				start = 0;
				totalBlokNomor = 0;
				options = ``;
				options += `<option value="" selected disabled>-- Pilih Penetapan --</option>`;
				options += `<option value="1">Penetapan Ulang</option>`;
				options += `<option value="2">Pencabutan</option>`;


				// initSelect2();

				// function initSelect2() {
				//     $('.pilih-kodewilayah').each(function(index, element) {
				//         $(this).select2({
				//             placeholder: "Pilih Kode Wilayah"
				//         })
				//     })
				// }

				function countTotalKodeAkses() {
					return document.querySelectorAll('.kodeakses_hapus-item').length;
				}

				this.totalKodeAkses = countTotalKodeAkses();
				const inputRow =
					`
					<tr class="kodeakses_hapus-item">
						<td>
							<input type="text" class="form-control pilih-bloknomor" id="kodeakses_hapus[` + this
					.totalKodeAkses + `][kode_akses]" name="kodeakses_hapus[` + this
					.totalKodeAkses + `][kode_akses]" />
						</td>
                        <td>
							<select
                                id="kodeakses_hapus[` + this.totalKodeAkses + `][status_pe_sk]"
								name="kodeakses_hapus[` + this.totalKodeAkses + `][status_pe_sk]"
                                onchange="insertKodeakses(` + this.totalKodeAkses + `)"
								class="form-control pilih-status_pe_sk" required
							>` + options + ` </select>
						</td>
						
						<td>
							<button
								class="btn btn-danger btn-small btn-delete-kodeakses" id="btn-delete-kodeakses"
								type="button"
							><i class="icon-minus3"></i></button>
						</td>
					<tr>
				`;
				$('#bloknomor-lists').append(inputRow);
				initSelect2();
			})
		});

		function validateAndShowModal() {
			// Add your validation logic here
			var isValid = performValidation(); // Replace this with your actual validation logic

			if (isValid) {
				// If validation passes, show the modal
				$('#submitModal').modal('show');
			} else {
				// Handle the case where validation fails
				alert("Silahkan Pilih Hasil Evaluasi Terlebih Dahulu");
			}
		}

		function performValidation() {
			// Replace this with your actual validation logic
			// For example, check if a specific condition is met
			var inputValue = document.getElementById('status_sk').value;
			// var inputValue2 = document.getElementById('kodeakses_hapus[2][status_pe_sk]').value;
			// alert(inputValue2);
			// function countTotalKodeAkses() {
			//     return document.querySelectorAll('.kodeakses_hapus-item').length;
			// }

			// this.totalKodeAkses = countTotalKodeAkses();
			// for (var i = 0; i < this.totalKodeAkses; i++) {
			//     var dynamicId = "kodeakses_hapus[" + i + "][status_pe_sk]";
			//     // var dynamicId_value = document.getElementById(dynamicId).value;
			//     var selectedValue = document.getElementById(dynamicId);
			//     console.log(dynamicId, selectedValue, selectedValue ? selectedValue.value :
			//         'Element not found');
			//     // alert(selectedValue);

			//     if (selectedValue === "") {
			//         // If any <select> element has an empty value, display an alert and exit the loop
			//         // alert("Please select a value for all dropdowns before submitting.");
			//         // alert(dynamicId);
			//         return inputValue == "";
			//         // inputValue == "";
			//     }
			// }

			return inputValue !== ""; // Return true if the condition is met, false otherwise
		}

		function updateskinfo() {
			var id_izin = document.getElementById('id_izin').value;
			var id_kodeakses = document.getElementById('id_kodeakses').value;
			var no_sk = document.getElementById('no_sk').value;
			var tgl_sk = document.getElementById('tgl_sk').value;
			// alert(id_kodeakses);
			// Make an AJAX request to Laravel backend
			$.ajax({
				type: "POST",
				url: "/admin/updateskinfo-kodeakses",
				// dataType: "json",
				data: {
					id_izin: id_izin,
					id_kodeakses: id_kodeakses,
					tgl_sk: tgl_sk,
					no_sk: no_sk,
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

		function disactivatedKodeakses(kode_akses) {
			// var selectedvalue = document.getElementById('kodeakses_hapus[' + selectElement + '][status_pe_sk]').value;
			// var kode_akses = kode_akses;
			// var kode_wilayah = document.getElementById('kode_wilayah[' + selectElement + ']').value;
			// var prefix_awal = document.getElementById('prefix_awal[' + selectElement + ']').value;
			var id_izin = document.getElementById('id_izin').value;
			// console.log('Selected Element:', selectedElement.value, selectedElement2.value);
			// var selectedValue = selectElement.value;
			// console.log(selectedValue);
			// document.getElementById('otherInput').value;
			// alert(kode_akses);
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

		function insertKodeakses(selectElement) {
			var selectedvalue = document.getElementById('kodeakses_hapus[' + selectElement + '][status_pe_sk]').value;
			var kode_akses = document.getElementById('kodeakses_hapus[' + selectElement + '][kode_akses]').value;
			if (kode_akses === "") {
				alert('Masukkan kode akses terlebih dahulu');
				return;
			}
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
				url: "/admin/update-kodeakses",
				// dataType: "json",
				data: {
					value: selectedvalue,
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

		function updateDatabase(selectElement) {
			var selectedvalue = document.getElementById('bloknomor[' + selectElement + '][is_deleted]').value;
			// alert(selectedvalue);
			var nama_wilayah = document.getElementById('nama_wilayah[' + selectElement + ']').value;
			var kode_wilayah = document.getElementById('kode_wilayah[' + selectElement + ']').value;
			var prefix_awal = document.getElementById('prefix_awal[' + selectElement + ']').value;
			var id_izin = document.getElementById('id_izin').value;
			// console.log('Selected Element:', selectedElement.value, selectedElement2.value);
			// var selectedValue = selectElement.value;
			// console.log(selectedValue);
			// document.getElementById('otherInput').value;

			// Make an AJAX request to Laravel backend
			$.ajax({
				type: "POST",
				url: "/admin/update-bloknomor",
				// dataType: "json",
				data: {
					value: selectedvalue,
					kode_wilayah: kode_wilayah,
					prefix_awal: prefix_awal,
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
	</script>
	<script>
		var loadingSpinner = document.getElementById('loadingSpinner');

		function showLoadingSpinner() {
			// loadingSpinner.style.display = 'block';
			var spinner = document.getElementById('loadingSpinner');
			spinner.style.display = 'flex';
		}

		function validateForm() {
			var selectedValue = document.getElementById("status_sk").value;
			var berkastambahan = document.getElementById("berkas_tambahan");
			// alert(berkastambahan.value);
			var penomoranBloknomor = @json($penomoran_bloknomor ?? null);
			if (Array.isArray(penomoranBloknomor) && penomoranBloknomor !== null) {
				Object.keys(penomoranBloknomor).forEach(function(element) {
					var selectbloknomor_value = document.getElementById("bloknomor[" + element + "][is_deleted]");
					if (selectbloknomor_value) {
						if (selectbloknomor_value.value === "") {
							alert("Pilih Status evaluasi untuk Blok Nomor Terlebih Dahulu");
							return false;
						}
						// or do something with the value
					}
				});
			}
			if (berkastambahan) {
				berkastambahanValue = berkastambahan.value;
			} else {
				berkastambahanValue = "NULL";
			}

			if (selectedValue === "null") {
				alert("Pilih Hasil Evaluasi terlebih dahulu.");
				return false; // Prevent form submission
			} else {
				// You can perform additional validation or actions here
				if (selectedValue === "0") {
					var catatanValue = document.getElementById("catatan_hasil_evaluasi").value;
					if (catatanValue === "" || catatanValue === "NULL") {
						alert("Masukkan Catatan Hasil Evaluasi terlebih dahulu.");
					} else {
						$('#submitModal').modal('show');
						return false; // Allow form submission
					}
				} else {
					// alert(isset(berkastambahanValue));
					if (berkastambahanValue === "NULL" || berkastambahanValue !== "") {
						$('#submitModal').modal('show');
					} else {
						var isPathSet = <?php echo isset($penomoran['path_dok_evaluasi_tambahan']) ? 'true' : 'false'; ?>;
						if (isPathSet) {
							$('#submitModal').modal('show');
						} else {
							alert("Unggah Berita Acara Pemeriksaan Nomor Yang Pernah Ditetapkan terlebih dahulu.");
						}
					}
					return false; // Allow form submission  
				}
			}
		}

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		function submitevaluasi() {
			if ($('#status_sk').val() == 0 && $('#catatan_hasil_evaluasi').val() == '') {
				$('#submitModal').modal('toggle');
				alert('Silakan mengisi catatan hasil evaluasi');
			} else {
				showLoadingSpinner();
				$('.notif-button').attr("hidden", true);
				$('.loading').attr("hidden", false);
				$('#formEvaluasi').submit();
				$("#btnSubmit").attr("disabled", true);
				$("#btnSubmitKoreksi").attr("disabled", true);
			}

		}

		function submitpenolakan() {
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			$('#catatan_evaluasi_penolakan').val($('#catatan_hasil_evaluasi').val());
			$('#formPenolakan').submit();
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
								.status_checklist + '</div></div>';
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
