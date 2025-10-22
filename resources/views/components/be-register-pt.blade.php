<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="global_assets/js/demo_pages/form_layouts.js"></script>
<div>
	<form action="#">
		<fieldset>
			<div class="form-group">
				<div class="col-lg">
					<div class="row">
						@if ($datapt->jenis_pu == 'PTB' || $datapt->jenis_pu == 'TKB' || $datapt->jenis_pu == 'PTP')
							<div class="col-lg-6">
								<p class="font-weight-semibold"> Nomor Induk Berusaha (NIB)</p>
								<input type="text" class="form-control" value="{{ $datapt->nib }}" disabled>
							</div>
							<div class="col-lg-6">
								<p class="font-weight-semibold"> Nama Badan Hukum/Instansi/Perusahaan</p>
								<input type="text" class="form-control" value="{{ $datapt->nama_perseroan_noinit }}" disabled>
							</div>
						@elseif ($datapt->jenis_pu == 'TKI')
							<div class="col-lg-6">
								<p class="font-weight-semibold"> Nama K/D/L/I</p>
								<input type="text" class="form-control" value="{{ $datapt->nama_perseroan_noinit }}" disabled>
							</div>
						@else
							<div class="col-lg-6">
								<p class="font-weight-semibold"> Nama Instansi/Perusahaan</p>
								<input type="text" class="form-control" value="{{ $datapt->nama_perseroan_noinit }}" disabled>
							</div>
						@endif
						{{-- <div class="col-lg-1 text-center">
							<p class="font-weight-semibold text-center">Koreksi</p>
							<div
								class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
								<input type="checkbox" class="custom-control-input" id="c_nib" checked>
								<label class="custom-control-label" for="c_nib"></label>
							</div>
						</div>
						<div class="col-lg-5">
							<p class="font-weight-semibold">Catatan</p>
							<input type="text" class="form-control">
						</div> --}}
					</div>
				</div>
			</div>
			@if ($datapt->jenis_pu == 'PTB' || $datapt->jenis_pu == 'TKB' || $datapt->jenis_pu == 'PTP')
				<div class="form-group">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-12">
								<p class="font-weight-semibold">Dokumen NIB</p>
								<div class="input-group">
									<input type="text" class="form-control border-right-0" value="{{ $datapt->path_berkas_nib }}"
										placeholder="Dokumen NIB" disabled>
									<span class="input-group-append">
										<a target="_blank" href="{{ asset($datapt->path_berkas_nib) }}" class="btn btn-teal" type="button">Lihat
											Dokumen</a>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			@else
			@endif
			{{-- <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <p class="font-weight-semibold">Nama Perusahaan/Instansi Pemerintah</p>
                            <input type="text" class="form-control" required placeholder="Nama Lengkap Perusahaan"
                                value="{{ $datapt->nama_perseroan }}" disabled>
                        </div>
                    </div>
                </div>
            </div> --}}
			<div class="form-group">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-12">
							<p class="font-weight-semibold">Jenis Perusahaan/Instansi Pemerintah</p>
							<input type="text" class="form-control" required placeholder="Jenis Perusahaan/Instansi Pemerintah"
								value="{{ $datapt->jenis_perseroans }}" disabled>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-12">
											<p class="font-weight-semibold">Alamat</p>
											<input type="text" class="form-control" required placeholder="Nama Lengkap Perusahaan"
												value="{{ $datapt->alamat_perseroan }}" disabled>
										</div>
										{{-- <div class="col-6">
											<p class="font-weight-semibold">Provinsi</p>

										</div> --}}
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-6">
											<p class="font-weight-semibold">Kota/Kabupaten</p>
											<input type="text" class="form-control" value="{{ $datapt->kabupaten_name }}" disabled>
										</div>
										<div class="col-6">
											<p class="font-weight-semibold">Kecamatan</p>
											<input type="text" class="form-control" value="{{ $datapt->kecamatan_name }}" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-6">
											<p class="font-weight-semibold">Kelurahan/Desa</p>
											<input type="text" class="form-control" value="{{ $datapt->kelurahan_perseroan }}" disabled>
										</div>
										<div class="col-6">
											<p class="font-weight-semibold">Kode Pos</p>
											<input type="text" class="form-control" value="{{ $datapt->kode_pos_perseroan }}" disabled>
										</div>
									</div>
								</div>
							</div>

						</div>

						{{-- <div class="card-footer d-flex justify-content-between">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-2">
										<div
											class="custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
											<input type="checkbox" class="custom-control-input" id="c_alamatperusahaan"
												checked>
											<label class="custom-control-label" for="c_alamatperusahaan">Koreksi</label>
										</div>
									</div>
									<div class="col-lg-10">
										<input type="text" class="form-control">
									</div>

								</div>
							</div>
						</div> --}}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-12">
							@if ($datapt->jenis_pu == 'PTB' || $datapt->jenis_pu == 'TKB' || $datapt->jenis_pu == 'PTP')
								<p class="font-weight-semibold">No Telepon Badan Hukum/Perusahaan<span class="text-danger">*</span></p>
							@elseif ($datapt->jenis_pu == 'TKI')
								<p class="font-weight-semibold">No Telepon K/D/L/I<span class="text-danger">*</span></p>
							@else
								<p class="font-weight-semibold">No Telepon Instansi/Badan Hukum/Perusahaan</p>
							@endif
							<input type="text" class="form-control" value="{{ $datapt->nomor_telpon_perseroan }}" disabled>
						</div>

						{{-- <div class="col-lg-1 text-center">
							<p class="font-weight-semibold text-center">Koreksi</p>
							<div
								class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
								<input type="checkbox" class="custom-control-input" id="c_telpperusahaan" checked>
								<label class="custom-control-label" for="c_telpperusahaan"></label>
							</div>
						</div>
						<div class="col-lg-5">
							<p class="font-weight-semibold">Catatan</p>
							<input type="text" class="form-control">
						</div> --}}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-12">
							@if ($datapt->jenis_pu == 'PTB' || $datapt->jenis_pu == 'TKB' || $datapt->jenis_pu == 'PTP')
								<p class="font-weight-semibold">No NPWP Badan Hukum/Perusahaan</p>
							@elseif ($datapt->jenis_pu == 'TKI')
								<p class="font-weight-semibold">No NPWP K/D/L/I</p>
							@else
								<p class="font-weight-semibold">No NPWP Instansi/Badan Hukum/Perusahaan</p>
							@endif
							<input type="text" class="form-control" value="{{ $datapt->npwp_perseroan }}" disabled>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-12">
							<p class="font-weight-semibold">Dokumen NPWP</p>
							<div class="input-group">
								<input type="text" class="form-control border-right-0" value="{{ $datapt->path_berkas_npwp }}"
									placeholder="Dokumen NPWP" disabled>
								<span class="input-group-append">
									<a target="_blank" href="{{ asset($datapt->path_berkas_npwp) }}" class="btn btn-teal" type="button">Lihat
										Dokumen</a>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-12">
							{{-- @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                                <p class="font-weight-semibold">No NPWP Badan Hukum/Perusahaan</p>
                            @elseif (Auth::user()->jenis_pu == 'TKI')
                                <p class="font-weight-semibold">No NPWP K/D/L/I</p>
                            @else
                                <p class="font-weight-semibold">No NPWP Instansi/Badan Hukum/Perusahaan</p>
                            @endif --}}
							<p class="font-weight-semibold">Nomor Akta Terakhir Perusahaan / Dokumen SK Kemenkumham / Dasar Hukum
								Pembentukan Instansi Pemerintah</p>
							<div class="input-group">
								<input type="text" class="form-control border-right-0" value="{{ $datapt->no_pengesahan }}"
									placeholder="Dokumen SK Kemenkumham" disabled>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-12">
							<p class="font-weight-semibold">Akta Terakhir Perusahaan / Dokumen SK Kemenkumham / Dasar Hukum Pembentukan
								Instansi Pemerintah</p>
							<div class="input-group">
								<input type="text" class="form-control border-right-0" value="{{ $datapt->path_berkas_kemenkumham }}"
									placeholder="Dokumen SK Kemenkumham" disabled>
								<span class="input-group-append">
									<a target="_blank" href="{{ asset($datapt->path_berkas_kemenkumham) }}" class="btn btn-teal"
										type="button">Lihat Dokumen</a>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- <div class="form-group">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-12">
							<p class="font-weight-semibold">Dokumen NPWP</p>
							<div class="input-group">
								<input type="text" class="form-control border-right-0"
									value="{{$datapt->file_kartu_pegawai}}" placeholder="Dokumen KTP Penanggung Jawab"
									disabled>
								<span class="input-group-append">
									<a target="_blank" href="{{ asset($datapt->file_kartu_pegawai) }}"
										class="btn btn-teal" type="button">Lihat Dokumen</a>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-12">
							<p class="font-weight-semibold">Akta Terakhir Perusahaan/Instansi Pemerintah</p>
							<input type="text" class="form-control">
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-12">
							<p class="font-weight-semibold">Dokumen SK Kemenkumham</p>
							<div class="input-group">
								<input type="text" class="form-control border-right-0"
									placeholder="Dokumen SK Kemenkumham">
								<span class="input-group-append">
									<button class="btn btn-teal" type="button">Lihat Dokumen</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div> --}}
		</fieldset>

	</form>
</div>
