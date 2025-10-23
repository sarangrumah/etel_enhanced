<div>
    <form action="{{ url('/ip/registerpj') }}" method="post" enctype="multipart/form-data">
        @csrf
        <fieldset>
            <div class="form-group">
                <div class="col-lg-12">
                    <p class="font-weight-semibold">Nama Penanggung Jawab<span class="text-danger">*</span></p>
                    <input type="text" name="vNamaPj" id="vNamaPj" class="form-control" required
                        placeholder="Nama Lengkap"
                        value="{{ isset($oss->nama_user_proses) ? $oss->nama_user_proses : '' }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <p class="font-weight-semibold">E-Mail Penanggung Jawab<span class="text-danger">*</span></p>
                    <input type="email" name="vEmailPj" id="vEmailPj" class="form-control" disabled
                        placeholder="E-Mail"
                        value="{{ isset($oss->email_user_proses) ? $oss->email_user_proses : '' }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <p class="font-weight-semibold">No. Telp/Handphone Penanggung Jawab<span
                            class="text-danger">*</span></p>
                    <input type="text" name="vNoPj" id="vNoPj" class="form-control" required
                        placeholder="No. Telp/Handphone"
                        value="{{ isset($oss->hp_user_proses) ? $oss->hp_user_proses : '' }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        @if (isset($oss->user_file_surat_tugas))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Surat Tugas</p>
                                <div class="input-group">
                                    <input type="text" name="DSuratTugas" id="DSuratTugas"
                                        value="{{ $oss->user_file_surat_tugas }}" readonly class="form-control"
                                        required>
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($oss->user_file_surat_tugas) }}"
                                            class="btn btn-teal" type="button">Lihat Dokumen</a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Unggah Surat Tugas<span class="text-danger">*</span>
                                </p>
                                <input type="file" name="vSuratTugas" id="vSuratTugas" onchange="validatePdf(this)"
                                    class="form-control h-auto justify-content-center"
                                    value="{{ isset($oss->user_file_surat_tugas) ? $oss->user_file_surat_tugas : '' }}"
                                    required>
                            </div>
                        @else
                            <div class="col-12">
                                <p class="font-weight-semibold">Unggah Surat Tugas<span class="text-danger">*</span>
                                </p>
                                <input type="file" name="vSuratTugas" id="vSuratTugas" onchange="validatePdf(this)"
                                    class="form-control h-auto justify-content-center" accept="application/pdf"
                                    required>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        @if (isset($oss->user_no_ktp))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Nomor KTP/Paspor Penanggung Jawab</p>
                                <div class="input-group">
                                    <input type="text" name="vKtpPj" id="vKtpPj" value="{{ $oss->user_no_ktp }}"
                                        class="form-control" required>
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($oss->user_file_ktp) }}" class="btn btn-teal"
                                            type="button">Lihat Dokumen</a>
                                    </span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Unggah KTP/Paspor Penanggung Jawab</p>
                                <input type="file" name="vBerkasKtp" id="vBerkasKtp" onchange="validatePdf(this)"
                                    class="form-control h-auto justify-content-center" accept="application/pdf"
                                    value="{{ isset($oss->user_no_ktp) ? $oss->user_no_ktp : '' }}" required>
                            </div>
                        @else
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Nomor KTP/Paspor Penanggung Jawab<span
                                        class="text-danger">*</span>
                                </p>
                                <input type="text" name="vKtpPj" id="vKtpPj"
                                    class="form-control h-auto justify-content-center"
                                    value="{{ isset($oss->user_no_ktp) ? $oss->user_no_ktp : '' }}" required>
                            </div>
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Unggah KTP/Paspor Penanggung Jawab<span
                                        class="text-danger">*</span>
                                </p>
                                <input type="file" name="vBerkasKtp" id="vBerkasKtp" onchange="validatePdf(this)"
                                    class="form-control h-auto justify-content-center" accept="application/pdf"
                                    value="{{ isset($oss->user_no_ktp) ? $oss->user_no_ktp : '' }}" required>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <p class="font-weight-semibold">Jabatan<span class="text-danger">*</span></p>
                    <input type="text" name="vJabatan" id="vJabatan" class="form-control" required
                        placeholder="Jabatan" value="{{ isset($oss->user_jabatan) ? $oss->user_jabatan : '' }}"
                        required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        @if (isset($oss->user_file_kartu_pegawai))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kartu Pegawai/Surat Keterangan Bekerja Sebelumnya
                                </p>
                                <div class="input-group">
                                    <input type="text" name="dKartuPegawai" id="dKartuPegawai"
                                        value="{{ $oss->user_file_kartu_pegawai }}" class="form-control" required>
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($oss->user_file_kartu_pegawai) }}"
                                            class="btn btn-teal" type="button">Lihat Dokumen</a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Unggah Kartu Pegawai/Surat Keterangan Bekerja
                                </p>
                                <input type="file" name="vKartuPegawai" id="vKartuPegawai" onchange="validatePdf(this)"
                                    class="form-control h-auto justify-content-center" accept="application/pdf"
                                    value="{{ isset($oss->user_file_kartu_pegawai) ? $oss->user_file_kartu_pegawai : '' }}"
                                    required>
                            </div>
                        @else
                            <div class="col-12">
                                <p class="font-weight-semibold">Unggah Kartu Pegawai/Surat Keterangan Bekerja<span
                                        class="text-danger">*</span>
                                </p>
                                <input type="file" name="vKartuPegawai" id="vKartuPegawai" onchange="validatePdf(this)"
                                    class="form-control h-auto justify-content-center" accept="application/pdf"
                                    required>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <p class="font-weight-semibold">Alamat<span class="text-danger">*</span>
                        <span class="form-text text-muted">* Sesuai alamat KTP.</span></p>
                        <input type="text"
                            value="{{ isset($oss->alamat_user_proses) ? $oss->alamat_user_proses : '' }}"
                            name="vAlamat" id="vAlamat" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        @if (isset($oss->user_name_provinsi))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Provinsi (Sebelumnya)</p>
                                <input type="text" name="SelectedProvinsi" id="SelectedProvinsi"
                                    value="{{ $oss->user_name_provinsi }}" readonly class="form-control" disabled>
                            </div>
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Provinsi<span class="text-danger">*</span></p>
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
                        @else
                            <div class="col-12">
                                <p class="font-weight-semibold">Provinsi<span class="text-danger">*</span></p>
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
                        @endif

                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        @if (isset($oss->user_name_kabupaten))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kota/Kabupaten (Sebelumnya)</p>
                                <input type="text" name="SelectedKota" id="SelectedKota"
                                    value="{{ $oss->user_name_kabupaten }}" readonly class="form-control" disabled>
                            </div>
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kota/Kabupaten<span class="text-danger">*</span></p>
                                <select data-placeholder="Pilih Kota/Kabupaten" name="vKotaKabupaten"
                                    id="vKotaKabupaten" class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status"
                                    id="vKotaKabupaten-loading">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <p class="font-weight-semibold">Kota/Kabupaten<span class="text-danger">*</span></p>
                                <select data-placeholder="Pilih Kota/Kabupaten" name="vKotaKabupaten"
                                    id="vKotaKabupaten" class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status"
                                    id="vKotaKabupaten-loading">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        @if (isset($oss->user_name_kecamatan))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kecamatan (Sebelumnya)</p>
                                <input type="text" name="SelectedKecamatan" id="SelectedKecamatan"
                                    value="{{ $oss->user_name_kecamatan }}" readonly class="form-control" disabled>
                            </div>
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kecamatan<span class="text-danger">*</span>
                                </p>
                                <select data-placeholder="Pilih Kecamatan" name="vKecamatan" id="vKecamatan"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status"
                                    id="vKecamatan-loading">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <p class="font-weight-semibold">Kecamatan<span class="text-danger">*</span>
                                </p>
                                <select data-placeholder="Pilih Kecamatan" name="vKecamatan" id="vKecamatan"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status"
                                    id="vKecamatan-loading">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        @if (isset($oss->user_name_kelurahan))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kelurahan/Desa (Sebelumnya)</p>
                                <input type="text" name="SelectedKelurahan" id="SelectedKelurahan"
                                    value="{{ $oss->user_name_kelurahan }}" readonly class="form-control" disabled>
                            </div>
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kelurahan/Desa<span class="text-danger">*</span></p>
                                <select data-placeholder="Pilih Kelurahan/Desa" name="vKelurahan" id="vKelurahan"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status"
                                    id="vKelurahan-loading">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <p class="font-weight-semibold">Kelurahan/Desa<span class="text-danger">*</span></p>
                                <select data-placeholder="Pilih Kelurahan/Desa" name="vKelurahan" id="vKelurahan"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status"
                                    id="vKelurahan-loading">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <p class="font-weight-semibold">Kode Pos<span class="text-danger">*</span></p>
                        <input type="text" name="vKodePos" id="vKodePos" class="form-control"
                            value="{{ isset($oss->user_kode_pos) ? $oss->user_kode_pos : '' }}" required>
                    </div>
                </div>
            </div>

            <div class="dropdown-divider"></div>
            <div class="form-group col-lg-12 row">
                <label class="col-form-label">Dengan ini saya menyatakan : </label>
            </div>
            <div class="form-group col-lg-12 row">
                <label class="col-form-label">Informasi dan dokumen yang dilampirkan adalah benar sesuai dengan
                    dokumen
                    asli. Apabila informasi dan dokumen yang dilampirkan tidak benar dan tidak sesuai dengan dokumen
                    asli, maka saya bersedia dikenakan sanksi berupa masuk ke dalam daftar hitam (blacklist) hingga
                    sanksi yang diatur dalam peraturan perundang-undangan.</label>
            </div>
            <div class="form-group col-lg-12 row">
                <div class="col-lg-8">
                    <label class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" name="chekCheklis" id="chekCheklis" class="custom-control-input"
                            required>
                        <span class="custom-control-label">Dengan membubuhkan cek list, saya telah membaca dan
                            menyetujui ketentuan di atas.</span>
                    </label>
                </div>
            </div>

            <div class="form-group text-right">
                <a href="{{ url('/') }}" class="btn btn-light">Kembali </a>
                <button type="submit" class="btn btn-primary">Kirim Pendaftaran <i
                        class="icon-paperplane ml-2"></i></button>
            </div>
        </fieldset>
    </form>
</div>
