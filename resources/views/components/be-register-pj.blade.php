<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="global_assets/js/demo_pages/form_layouts.js"></script>
<div>
    <form action="#">
        <fieldset>
            <div class="form-group">
                <div class="col-lg">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="font-weight-semibold">Nama Penanggung Jawab</p>
                            <input type="text" class="form-control" value="{{ $datapj->nama_user_proses }}" required
                                placeholder="Nama Lengkap" disabled>
                        </div>
                        {{-- <div class="col-lg-1 text-center">
                        <p class="font-weight-semibold text-center">Koreksi</p>
						<div class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
							<input type="checkbox" class="custom-control-input" id="c_namapj" checked>
							<label class="custom-control-label" for="c_namapj"></label>
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
                            <p class="font-weight-semibold">E-Mail Penanggung Jawab</p>
                            <input type="text" class="form-control" value="{{ $datapj->email }}" required
                                placeholder="E-Mail" disabled>
                        </div>

                        {{-- <div class="col-lg-1 text-center">
                        <p class="font-weight-semibold text-center">Koreksi</p>
						<div class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
							<input type="checkbox" class="custom-control-input" id="c_emailpj" checked>
							<label class="custom-control-label" for="c_emailpj"></label>
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
                            <p class="font-weight-semibold">No. Telp/Handphone Penanggung Jawab</p>
                            <input type="text" class="form-control" value="{{ $datapj->hp_user_proses }}" required
                                placeholder="No. Telp/Handphone" disabled>
                        </div>

                        {{-- <div class="col-lg-1 text-center">
                        <p class="font-weight-semibold text-center">Koreksi</p>
						<div class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
							<input type="checkbox" class="custom-control-input" id="c_telppj" checked>
							<label class="custom-control-label" for="c_telppj"></label>
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
                            <p class="font-weight-semibold">Dokumen Surat Tugas</p>
                            <div class="input-group">
                                <input type="text" class="form-control border-right-0"
                                    value="{{ $datapj->file_surat_tugas }}" placeholder="Dokumen Surat Tugas" disabled>
                                <span class="input-group-append">
                                    <a target="_blank" href="{{ asset($datapj->file_surat_tugas) }}"
                                        class="btn btn-teal" type="button">Lihat Dokumen</a>
                                </span>
                            </div>
                        </div>

                        {{-- <div class="col-lg-1 text-center">
                        <p class="font-weight-semibold text-center">Koreksi</p>
						<div class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
							<input type="checkbox" class="custom-control-input" id="c_surattugas" checked>
							<label class="custom-control-label" for="c_surattugas"></label>
						</div>
					</div>
                    <div class="col-lg-5">
						<p class="font-weight-semibold">Catatan</p>
						<input type="text" class="form-control">
					</div> --}}
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
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Alamat</p>
                                            <input type="text" class="form-control"
                                                value="{{ $datapj->alamat_user_proses }}" disabled>
                                        </div>
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Provinsi</p>
                                            <input type="text" class="form-control"
                                                value="{{ $datapj->nama_provinsi }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Kota/Kabupaten</p>
                                            <input type="text" class="form-control" value="{{ $datapj->nama_kab }}"
                                                disabled>
                                        </div>
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Kecamatan</p>
                                            <input type="text" class="form-control"
                                                value="{{ $datapj->nama_kecamatan }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Kelurahan/Desa</p>
                                            <input type="text" class="form-control"
                                                value="{{ $datapj->nama_kelurahan }}" disabled>
                                        </div>
                                        <div class="col-6">
                                            <p class="font-weight-semibold">Kode Pos</p>
                                            <input type="text" class="form-control" value="{{ $datapj->kode_pos }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="card-footer d-flex justify-content-between">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
						    	        <input type="checkbox" class="custom-control-input" id="c_alamatpj" checked>
						    	        <label class="custom-control-label" for="c_alamatpj">Koreksi</label>
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
                            <p class="font-weight-semibold">Nomor KTP/Paspor Penanggung Jawab</p>
                            <input type="text" class="form-control" value="{{ $datapj->no_ktp }}" disabled>
                        </div>

                        {{-- <div class="col-lg-1 text-center">
                        <p class="font-weight-semibold text-center">Koreksi</p>
						<div class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
							<input type="checkbox" class="custom-control-input" id="c_ktppj" checked>
							<label class="custom-control-label" for="c_ktppj"></label>
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
                            <p class="font-weight-semibold">Dokumen KTP Penanggung Jawab</p>
                            <div class="input-group">
                                <input type="text" class="form-control border-right-0"
                                    value="{{ $datapj->file_ktp }}" placeholder="Dokumen KTP Penanggung Jawab"
                                    disabled>
                                <span class="input-group-append">
                                    <a target="_blank" href="{{ asset($datapj->file_ktp) }}" class="btn btn-teal"
                                        type="button">Lihat Dokumen</a>
                                </span>
                            </div>
                        </div>

                        {{-- <div class="col-lg-1 text-center">
                        <p class="font-weight-semibold text-center">Koreksi</p>
                        <div class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                            <input type="checkbox" class="custom-control-input" id="c_uploadktp" checked>
                            <label class="custom-control-label" for="c_uploadktp"></label>
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
                            <p class="font-weight-semibold">Jabatan</p>
                            <input type="text" class="form-control" value="{{ $datapj->jabatan }}" required
                                placeholder="Jabatan" disabled>
                        </div>

                        {{-- <div class="col-lg-1 text-center">
                        <p class="font-weight-semibold text-center">Koreksi</p>
                        <div class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                            <input type="checkbox" class="custom-control-input" id="c_jabatanpj" checked>
                            <label class="custom-control-label" for="c_jabatanpj"></label>
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
                            <p class="font-weight-semibold">Kartu Pegawai/Surat Keterangan Bekerja</p>
                            <div class="input-group">
                                <input type="text" class="form-control border-right-0"
                                    value="{{ $datapj->file_kartu_pegawai }}"
                                    placeholder="Dokumen KTP Penanggung Jawab" disabled>
                                <span class="input-group-append">
                                    <a target="_blank" href="{{ asset($datapj->file_kartu_pegawai) }}"
                                        class="btn btn-teal" type="button">Lihat Dokumen</a>
                                </span>
                            </div>
                        </div>

                        {{-- <div class="col-lg-1 text-center">
                        <p class="font-weight-semibold text-center">Koreksi</p>
                        <div class="text-center custom-control custom-switch custom-switch-square custom-control-danger justify-content-center mb-3">
                            <input type="checkbox" class="custom-control-input" id="c_surattugaspj" checked>
                            <label class="custom-control-label" for="c_surattugaspj"></label>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <p class="font-weight-semibold">Catatan</p>
                        <input type="text" class="form-control">
                    </div> --}}
                    </div>
                </div>
            </div>
        </fieldset>

    </form>
</div>
