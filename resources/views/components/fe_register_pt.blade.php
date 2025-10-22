<div>
    <form action="{{ url('/ip/registerpt') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="vKey" id="vKey" value="{{ $oss->nib_id }}">
        <fieldset>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        {{-- <div class="col-6">
                            <p class="font-weight-semibold">Nomor Induk Berusaha (NIB) / Nama Instansi<span
                                    class="text-danger">*</span>
                            </p>
                            <input type="text" name="vNib" id="vNib" value="{{ $oss->nib }}" readonly
                                class="form-control">
                            <span class="form-text text-muted">NIB adalah Nomor Induk berusaha yang diperolah dari
                                oss.go.id. Untuk Non Penyelenggara Telekomunikasi tidak perlu melakukan pengisian NIB
                                tetapi diisi dengan Nama Instansi..</span>
                        </div> --}}
                        <div class="col-6">
                            @if (Auth::user()->jenis_pu == 'TKI')
                                <p class="font-weight-semibold">ID K/L/D/I<span class="text-danger">*</span>
                                </p>
                            @elseif (Auth::user()->jenis_pu == 'NPT')
                                <p class="font-weight-semibold">ID Instansi<span class="text-danger">*</span>
                                </p>
                            @else
                                <p class="font-weight-semibold">Nomor Induk Berusaha (NIB)<span class="text-danger">*</span>
                                </p>
                            @endif
                            @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                                @if (isset($oss->nib))
                                    <div class="input-group">
                                        <input type="text" name="vNib" id="vNib" value="{{ $oss->nib }}" readonly class="form-control">
                                        <span class="input-group-append">
                                            <a target="_blank" href="{{ asset($oss->path_berkas_nib) }}" class="btn btn-teal" type="button">Lihat
                                                Dokumen</a>
                                        </span>
                                    </div>
                                @else
                                    <input type="text" name="vNib" id="vNib" class="form-control"
                                        value="{{ isset($oss->nib) ? $oss->nib : '' }}" required>
                                @endif
                            @else
                                @if (isset($oss->nib))
                                    <div class="input-group">
                                        <input type="text" name="vNib" id="vNib" value="{{ $oss->nib }}" readonly class="form-control">
                                        {{-- <span class="input-group-append">
                                            <a target="_blank" href="{{ asset($oss->path_berkas_nib) }}"
                                                class="btn btn-teal" type="button">Lihat Dokumen</a>
                                        </span> --}}
                                    </div>
                                @else
                                    <input type="text" name="vNib" id="vNib" class="form-control"
                                        value="{{ isset($oss->nib) ? $oss->nib : '' }}" required>
                                @endif
                            @endif
                        </div>
                        @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                            <div class="col-6">
                                <p class="font-weight-semibold">Unggah Dokumen NIB <span class="text-danger">*</span>
                                </p>
                                <input type="file" name="vDokumenNib" id="vDokumenNib" class="form-control h-auto justify-content-center"
                                    accept="application/pdf" onchange="validatePdf(this)" required>
                                <small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
                                <small for="" class="text-danger">*Maksimum File : 5Mb</small>
                            </div>
                        @endif
                        {{-- <div class="col-12">
                            <span class="form-text text-muted">NIB adalah Nomor Induk berusaha yang diperolah dari
                                oss.go.id. Untuk Non Penyelenggara Telekomunikasi dan Instansi Pemerintah tidak perlu
                                melakukan pengisian NIB
                                tetapi diisi dengan Nama Instansi</span>
                        </div> --}}

                    </div>

                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="col-lg-8 col-form-label font-weight-semibold" id="lbl_kdakses">KBLI yang dimiliki</label>
                    <div class="col-lg-6" id="PilihKBLI">
                        <table class="table table-custom table-sm">

                            <tbody id="kbli-lists">
                                <tr class="kbli-item">
                                    <td style="width: 60%;">
                                        <select class="form-control pilih-kbli">
                                            @foreach ($kbli as $kb)
                                                <option value="{{ $kb->name }}">
                                                    {{ $kb->name . ' - ', $kb->desc }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="width: 2%;">
                                        <button type="button" class="btn btn-success add-kbli" id="add-kbli"><i class="icon-plus3"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                        <p class="font-weight-semibold">Nama Badan Hukum/Perusahaan<span class="text-danger">*</span>
                        </p>
                        <input type="text" value="{{ isset($oss->nama_perseroan_noinit) ? $oss->nama_perseroan_noinit : '' }}"
                            name="vNamaPerusahaan" id="vNamaPerusahaan" class="form-control" required
                            placeholder="Nama Lengkap Badan Hukum/Perusahaan">
                        <span class="form-text text-muted">Pengisian Nama Badan Hukum/Perusahaan tidak perlu menggunakan awalan seperti
                            (PT. / CV. / dan sejenisnya.) .</span>
                    @elseif (Auth::user()->jenis_pu == 'TKI')
                        <p class="font-weight-semibold">Nama Lengkap K/L/D/I <span class="text-danger">*</span></p>
                        <input type="text" value="{{ isset($oss->nama_perseroan_noinit) ? $oss->nama_perseroan_noinit : '' }}"
                            name="vNamaPerusahaan" id="vNamaPerusahaan" class="form-control" required placeholder="Nama Lengkap K/L/D/I">
                    @else
                        <p class="font-weight-semibold">Nama Lengkap Instansi<span class="text-danger">*</span>
                        </p>
                        <input type="text" value="{{ isset($oss->nama_perseroan_noinit) ? $oss->nama_perseroan_noinit : '' }}"
                            name="vNamaPerusahaan" id="vNamaPerusahaan" class="form-control" required placeholder="Nama Lengkap Instansi">
                        <span class="form-text text-muted">Pengisian Nama Badan Hukum non-Penyelenggara perlu menggunakan awalan seperti
                            (PT. / CV. / dan sejenisnya.) .</span>
                    @endif

                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                        <p class="font-weight-semibold">Jenis Badan Hukum/Perusahaan<span class="text-danger">*</span>
                        </p>
                    @elseif (Auth::user()->jenis_pu == 'TKI')
                        <p class="font-weight-semibold">Jenis Badan Hukum/Perusahaan<span class="text-danger">*</span>
                        </p>
                    @else
                        <p class="font-weight-semibold">Jenis Instansi/Badan Hukum/Perusahaan<span class="text-danger">*</span></p>
                    @endif
                    @if (isset($oss->nama_perseroan))
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="JInstansi" id="JInstansi" value="{{ $oss->jenis_perseroan_name }}" readonly
                                    class="form-control" disabled>
                            </div>
                            <div class="col-lg-6">
                                <select data-placeholder="Pilih Jenis Instansi/Badan Hukum/Perusahaan" name="vJenisInstansi"
                                    id="vJenisInstansi" class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                    @if (Auth::user()->jenis_pu == 'TKI')
                                        @foreach ($instansi_nbh as $key => $vi)
                                            <option value="{{ $vi->oss_kode }}" {{ $oss->jenis_perseroan == $vi->oss_kode ? 'selected' : '' }}>
                                                {{ $vi->name }}
                                            </option>
                                        @endforeach
                                    @elseif (Auth::user()->jenis_pu == 'NPT')
                                        @foreach ($instansi_npt as $key => $vi)
                                            <option value="{{ $vi->oss_kode }}" {{ $oss->jenis_perseroan == $vi->oss_kode ? 'selected' : '' }}>
                                                {{ $vi->name }}
                                            </option>
                                        @endforeach
                                    @elseif (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                                        @foreach ($instansi_bh as $key => $vi)
                                            <option value="{{ $vi->oss_kode }}" {{ $oss->jenis_perseroan == $vi->oss_kode ? 'selected' : '' }}>
                                                {{ $vi->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    @else
                        <div>
                            <select data-placeholder="Pilih Jenis Instansi" name="vJenisInstansi" id="vJenisInstansi"
                                class="form-control form-control-select2" data-fouc required>
                                <option></option>

                                @if (Auth::user()->jenis_pu == 'TKI')
                                    @foreach ($instansi_nbh as $key => $vi)
                                        <option value="{{ $vi->oss_kode }}" {{ $oss->jenis_perseroan == $vi->oss_kode ? 'selected' : '' }}>
                                            {{ $vi->name }}
                                        </option>
                                    @endforeach
                                @elseif (Auth::user()->jenis_pu == 'NPT')
                                    @foreach ($instansi_npt as $key => $vi)
                                        <option value="{{ $vi->oss_kode }}" {{ $oss->jenis_perseroan == $vi->oss_kode ? 'selected' : '' }}>
                                            {{ $vi->name }}
                                        </option>
                                    @endforeach
                                @elseif (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                                    @foreach ($instansi_bh as $key => $vi)
                                        <option value="{{ $vi->oss_kode }}" {{ $oss->jenis_perseroan == $vi->oss_kode ? 'selected' : '' }}>
                                            {{ $vi->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif

                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <p class="font-weight-semibold">Alamat<span class="text-danger">*</span></p>
                    <span class="form-text text-muted">* Pengisian Alamat pada isian tidak perlu menggunakan Kelurahan hingga
                        Provinsi</span>
                    <input type="text" value="{{ isset($oss->alamat_perseroan_init) ? $oss->alamat_perseroan_init : '' }}"
                        name="vAlamat" id="vAlamat" class="form-control" required>

                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        @if (isset($oss->provinsi_name))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Provinsi (Sebelumnya)</p>
                                <input type="text" name="SelectedProvinsi" id="SelectedProvinsi" value="{{ $oss->provinsi_name }}"
                                    readonly class="form-control" disabled>
                            </div>
                            <div class="col-6">
                                <p class="font-weight-semibold">Provinsi<span class="text-danger">*</span></p>
                                <select data-placeholder="Pilih Provinsi" name="vProvinsi" id="vProvinsi"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                    @foreach ($provinsi as $vp)
                                        {{-- <option value="{{ $vp->id }}">{{ $vp->name }}</option> --}}
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
                                        {{-- <option value="{{ $vp->id }}">{{ $vp->name }}</option> --}}
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
                        @if (isset($oss->kabupaten_name))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kota/Kabupaten (Sebelumnya)</p>
                                <input type="text" name="SelectedKota" id="SelectedKota" value="{{ $oss->kabupaten_name }}" readonly
                                    class="form-control" disabled>
                            </div>
                            <div class="col-6">
                                <p class="font-weight-semibold">Kota/Kabupaten<span class="text-danger">*</span></p>
                                <select data-placeholder="Pilih Kota/Kabupaten" name="vKotaKabupaten" id="vKotaKabupaten"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status" id="vKotaKabupaten-loading">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <p class="font-weight-semibold">Kota/Kabupaten<span class="text-danger">*</span></p>
                                <select data-placeholder="Pilih Kota/Kabupaten" name="vKotaKabupaten" id="vKotaKabupaten"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status" id="vKotaKabupaten-loading">
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
                        @if (isset($oss->kecamatan_name))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kecamatan (Sebelumnya)</p>
                                <input type="text" name="SelectedKecamatan" id="SelectedKecamatan" value="{{ $oss->kecamatan_name }}"
                                    readonly class="form-control" disabled>
                            </div>
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kecamatan<span class="text-danger">*</span>
                                </p>
                                <select data-placeholder="Pilih Kecamatan" name="vKecamatan" id="vKecamatan"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status" id="vKecamatan-loading">
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
                                <div class="mt-1 spinner-border loading text-primary" role="status" id="vKecamatan-loading">
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
                        @if (isset($oss->kelurahan_perseroan))
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kelurahan/Desa (Sebelumnya)</p>
                                <input type="text" name="SelectedKelurahan" id="SelectedKelurahan"
                                    value="{{ $oss->kelurahan_perseroan }}" readonly class="form-control" disabled>
                            </div>
                            <div class="col-lg-6">
                                <p class="font-weight-semibold">Kelurahan/Desa<span class="text-danger">*</span></p>
                                <select data-placeholder="Pilih Kelurahan/Desa" name="vKelurahan" id="vKelurahan"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status" id="vKelurahan-loading">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @else
                            <div class="col-12">
                                <p class="font-weight-semibold">Kelurahan/Desa<span class="text-danger">*</span></p>
                                <select data-placeholder="Pilih Kelurahan/Desa" name="vKelurahan" id="vKelurahan"
                                    class="form-control form-control-select2" data-fouc required>
                                    <option></option>
                                </select>
                                <div class="mt-1 spinner-border loading text-primary" role="status" id="vKelurahan-loading">
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
                        <div class="col-4">

                            <p class="font-weight-semibold">Kode Pos<span class="text-danger">*</span></p>
                            <input type="text" name="vKodePos" id="vKodePos" class="form-control"
                                value="{{ isset($oss->kode_pos_perseroan) ? $oss->kode_pos_perseroan : '' }}" required>
                        </div>
                        <div class="col-lg-4">
                            @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                                <p class="font-weight-semibold">No Telepon Badan Hukum/Perusahaan<span class="text-danger">*</span></p>
                            @elseif (Auth::user()->jenis_pu == 'TKI')
                                <p class="font-weight-semibold">No Telepon K/D/L/I<span class="text-danger">*</span></p>
                            @else
                                <p class="font-weight-semibold">No Telepon Instansi/Badan Hukum/Perusahaan<span class="text-danger">*</span>
                                </p>
                            @endif
                            <input type="text" name="vNoTlp" id="vNoTlp" class="form-control"
                                value="{{ isset($oss->nomor_telpon_perseroan) ? $oss->nomor_telpon_perseroan : '' }}" required>
                            @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                                <span class="form-text text-muted">* Sesuai Nomor Telepon pada Dokumen NIB.</span>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                                <p class="font-weight-semibold">Email Badan Hukum/Perusahaan<span class="text-danger">*</span></p>
                            @elseif (Auth::user()->jenis_pu == 'TKI')
                                <p class="font-weight-semibold">Email K/D/L/I<span class="text-danger">*</span></p>
                            @else
                                <p class="font-weight-semibold">Email Instansi/Badan Hukum/Perusahaan<span class="text-danger">*</span></p>
                            @endif
                            <input type="email" name="vEmail" id="vEmail" class="form-control"
                                value="{{ isset($oss->email_perusahaan) ? $oss->email_perusahaan : '' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-6">
                            @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                                <p class="font-weight-semibold">Nomor NPWP Badan Hukum/Perusahaan<span class="text-danger">*</span></p>
                            @elseif (Auth::user()->jenis_pu == 'TKI')
                                <p class="font-weight-semibold">Nomor NPWP K/D/L/I<span class="text-danger">*</span></p>
                            @else
                                <p class="font-weight-semibold">Nomor NPWP Instansi/Badan Hukum/Perusahaan<span class="text-danger">*</span>
                                </p>
                            @endif
                            @if (isset($oss->npwp_perseroan))
                                <div class="input-group">
                                    <input type="text" name="vNpwp" id="vNpwp"
                                        value="{{ isset($oss->npwp_perseroan) ? $oss->npwp_perseroan : '' }}" class="form-control">
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($oss->path_berkas_npwp) }}" class="btn btn-teal" type="button">Lihat
                                            Dokumen</a>
                                    </span>
                                </div>
                            @else
                                <input type="text" name="vNpwp" id="vNpwp" class="form-control"
                                    value="{{ isset($oss->npwp_perseroan) ? $oss->npwp_perseroan : '' }}" required>
                            @endif

                        </div>
                        <div class="col-6">
                            @if (Auth::user()->jenis_pu == 'PTB' || Auth::user()->jenis_pu == 'TKB' || Auth::user()->jenis_pu == 'PTP')
                                <p class="font-weight-semibold">Unggah NPWP Badan Hukum/Perusahaan<span class="text-danger">*</span></p>
                            @elseif (Auth::user()->jenis_pu == 'TKI')
                                <p class="font-weight-semibold">Unggah NPWP K/D/L/I<span class="text-danger">*</span></p>
                            @else
                                <p class="font-weight-semibold">Unggah NPWP Instansi/Badan Hukum/Perusahaan<span class="text-danger">*</span>
                                </p>
                            @endif
                            <input type="file" name="vUploadNpwp" id="vUploadNpwp" class="form-control h-auto justify-content-center"
                                accept="application/pdf" onchange="validatePdf(this)" required>
                            <small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
                            <small for="" class="text-danger">*Maksimum File : 5Mb</small>
                        </div>
                    </div>
                    <span class="form-text text-muted">Pastikan Anda telah memasukkan NPWP dengan benar. NPWP
                        instansi
                        akan dicek validitasnya dengan database Ditjen Pajak. Apabila NPWP perusahaan Anda tidak
                        valid,
                        maka Anda tidak dapat mengajukan permohonan.</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-semibold">Nomor Akta Terakhir Perusahaan / Dokumen SK Kemenkumham / Dasar Hukum
                                Pembentukan Instansi Pemerintah<span class="text-danger">*</span></p>
                            {{-- <input type="text" name="vAktaTerakhir" id="vAktaTerakhir" class="form-control"
                                value="{{ isset($oss->no_pengesahan) ? $oss->no_pengesahan : '' }}"> --}}

                            @if (isset($oss->no_pengesahan))
                                <div class="input-group">
                                    <input type="text" name="vAktaTerakhir" id="vAktaTerakhir"
                                        value="{{ isset($oss->no_pengesahan) ? $oss->no_pengesahan : '' }}" class="form-control">
                                    <span class="input-group-append">
                                        <a target="_blank" href="{{ asset($oss->path_berkas_kemenkumham) }}" class="btn btn-teal"
                                            type="button">Lihat Dokumen</a>
                                    </span>
                                </div>
                            @else
                                <input type="text" name="vAktaTerakhir" id="vAktaTerakhir" class="form-control"
                                    value="{{ isset($oss->no_pengesahan) ? $oss->no_pengesahan : '' }}" required>
                            @endif
                        </div>

                        <div class="col-6">
                            <p class="font-weight-semibold">Unggah Akta Terakhir Perusahaan / Dokumen SK Kemenkumham / Dasar Hukum
                                Pembentukan
                                Instansi Pemerintah<span class="text-danger">*</span>
                            </p>
                            <input type="file" name="vUngahSk" id="vUngahSk" class="form-control h-auto justify-content-center"
                                accept="application/pdf" onchange="validatePdf(this)" required>
                            <small for="" class="text-danger mr-2">*Wajib Diisi Format PDF</small>
                            <small for="" class="text-danger">*Maksimum File : 5Mb</small>
                        </div>
                    </div>
                    <span class="form-text text-muted">Pastikan Anda telah memasukkan No Akta Terakhir Perusahaan / Dokumen SK
                        Kemenkumham / Dasar Hukum Pembentukan
                        Instansi Pemerintah dengan benar dan memiliki kesesuaian dengan dokumen yang diunggah. Akta Terakhir Perusahaan /
                        Dokumen SK Kemenkumham / Dasar Hukum Pembentukan
                        Instansi Pemerintah akan dicek validitasnya melalui proses verifikasi. Apabila ada ketidaksesuaian, maka Anda
                        tidak dapat mengajukan permohonan.</span>
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
                        <input type="checkbox" name="chekCheklis" id="chekCheklis" class="custom-control-input" required>
                        <span class="custom-control-label">Dengan membubuhkan cek list, saya telah membaca dan
                            menyetujui ketentuan di atas.</span>
                    </label>
                </div>
            </div>
            <div class="form-group text-right">
                <a href="{{ url('/') }}" class="btn btn-light">Kembali </a>
                <button type="submit" id="btnSubmitRegisPt" class="btn btn-primary">Kirim Pendaftaran <i
                        class="icon-paperplane ml-2"></i></button>
            </div>
        </fieldset>

    </form>
</div>
<script>
    function validatePdf(fileInput) {
        const file = fileInput.files[0];
        const allowedMimeType = 'application/pdf';
        const maxFileSize = 5 * 1024 * 1024; // 5MB

        if (file) {
            if (file.type !== allowedMimeType) {
                alert('Hanya file dengan format PDF yang diizinkan.');
                fileInput.value = ''; // Clear the input
                return;
            }

            if (file.size > maxFileSize) {
                alert('Ukuran file tidak boleh melebihi 5MB.');
                fileInput.value = ''; // Clear the input
                return;
            }
        }
    }
</script>
