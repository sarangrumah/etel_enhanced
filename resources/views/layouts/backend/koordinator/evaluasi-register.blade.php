@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
    <div class="form-group">

        <form id="formEvaluasi" method="post" action="{{ route('admin.koordinator.evaluasiregistrasipost', $id) }}">
            @csrf
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Evaluasi Registrasi Penanggung Jawab </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id_user" value="{{ $id }}">
                    <fieldset>
                        <div class="form-group">
                            <div class="col-lg">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p class="font-weight-semibold">Nama Penanggung Jawab</p>
                                        <input type="text" name="nama_pj" value="{{ $user->name ? $user->name : '' }}"
                                            disabled="disabled" class="form-control" required placeholder="Nama Lengkap">
                                    </div>

                                    <div class="col-6">
                                        <p class="font-weight-semibold">E-Mail Penanggung Jawab</p>
                                        <input type="text"
                                            value="{{ $user->email_user_proses ? $user->email_user_proses : '' }}"
                                            disabled="disabled" class="form-control" required placeholder="E-Mail">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">No. Telp/Handphone Penanggung Jawab</p>
                                        <input type="text" name="no_telp_pj" disabled="disabled"
                                            value="{{ $user->hp_user_proses ? $user->hp_user_proses : '' }}"
                                            class="form-control" required placeholder="No. Telp/Handphone">
                                    </div>

                                    <div class="col-6">
                                        <p class="font-weight-semibold">Dokumen Surat Tugas</p>
                                        <div class="input-group">
                                            <input type="text" disabled="disabled" name="dokumen_surat_tugas_pj"
                                                value="{{ $user->file_surat_tugas ? $user->file_surat_tugas : '' }}"
                                                class="form-control border-right-0" placeholder="Dokumen Surat Tugas">
                                            <span class="input-group-append">
                                                <button class="btn btn-teal" type="button">Lihat Dokumen</button>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Alamat</p>
                                        <input type="text" name="alamat_pj" disabled="disabled"
                                            value="{{ $user->alamat_user_proses ? $user->alamat_user_proses : '' }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Provinsi</p>
                                        <input type="text" name="provinsi" disabled="disabled"
                                            value="{{ $user->nama_provinsi ? $user->nama_provinsi : '' }}"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Kota/Kabupaten</p>
                                        <input type="text" name="kabupaten" disabled="disabled"
                                            value="{{ $user->nama_kab ? $user->nama_kab : '' }}" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Kecamatan</p>
                                        <input type="text" name="kecamtan" disabled="disabled"
                                            value="{{ $user->nama_kecamatan ? $user->nama_kecamatan : '' }}"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Kelurahan/Desa</p>
                                        <input type="text" name="kelurahan" disabled="disabled"
                                            value="{{ $user->nama_kelurahan ? $user->nama_kelurahan : '' }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Kode Pos</p>
                                        <input type="text" name="provinsi" disabled="disabled"
                                            value="{{ $user->kode_pos ? $user->kode_pos : '' }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Nomor KTP/Paspor Penanggung Jawab</p>
                                        <input type="text" name="no_ktp" disabled="disabled"
                                            value="{{ $user->no_ktp ? $user->no_ktp : '' }}" class="form-control">
                                    </div>

                                    <div class="col-6">
                                        <p class="font-weight-semibold">Dokumen KTP Penanggung Jawab</p>
                                        <div class="input-group">
                                            <input type="text" name="file_ktp" disabled="disabled"
                                                value="{{ $user->file_ktp ? $user->file_ktp : '' }}"
                                                class="form-control border-right-0"
                                                placeholder="Dokumen KTP Penanggung Jawab">
                                            <span class="input-group-append">
                                                <button class="btn btn-teal" type="button">Lihat Dokumen</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="font-weight-semibold">Jabatan</p>
                                        <input type="text" name="jabatan" disabled="disabled"
                                            value="{{ $user->jabatan ? $user->jabatan : '' }}" class="form-control">
                                    </div>

                                    <div class="col-6">
                                        <p class="font-weight-semibold">Kartu Pegawai/Surat Keterangan Bekerja</p>
                                        <div class="input-group">
                                            <input type="text" name="kartu_pegawai" disabled="disabled"
                                                value="{{ $user->file_kartu_pegawai ? $user->file_kartu_pegawai : '' }}"
                                                class="form-control">
                                            <span class="input-group-append">
                                                <button class="btn btn-teal" type="button">Lihat Dokumen</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                </div>
            </div>
            <div class="form-group">
                <div class="card">
                    <div class="card-header bg-indigo text-white header-elements-inline">
                        <div class="row">
                            <div class="col-lg">
                                <h6 class="card-title font-weight-semibold py-3">Catatan Hasil Evaluasi </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <textarea form="formEvaluasi" rows="3" cols="3" name="catatan_evaluasi" id="catatan_evaluasi"
                            class="form-control" placeholder="Hasil Evaluasi" required></textarea>
                    </div>
                </div>
            </div>


            <input type="hidden" name="is_setuju" id="is_setuju" value="1">

        </form>

        <div class="form-group text-right">
            <a href="{{ route('admin.evaluator') }}" class="btn btn-secondary border-transparent"><i
                    class="icon-backward2 ml-2"></i> Kembali </a>
            <button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModalTolak"
                class="btn btn-warning">Tolak</button>
            <button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModal"
                class="btn btn-indigo">Setujui</button>
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
                    <p>Apakah anda yakin akan menyetujui evaluasi ini ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="submitevaluasi();return false;"
                        class="btn btn-primary notif-button">Kirim</button>
                    <div class="spinner-border loading text-primary" role="status" hidden>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="submitModalTolak" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Evaluasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menolak evaluasi ini ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="submitTolakevaluasi();return false;"
                        class="btn btn-primary notif-button">Kirim</button>
                    <div class="spinner-border loading text-primary" role="status" hidden>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function submitevaluasi() {
            $('#is_setuju').val(1);
            $('#catatan_evaluasi').val();
            $('.notif-button').attr("hidden", true);
            $('.loading').attr("hidden", false);
            $('#formEvaluasi').submit();
        }

        function submitTolakevaluasi() {
            $('#is_setuju').val(0);
            $('#catatan_evaluasi').val();
            $('.notif-button').attr("hidden", true);
            $('.loading').attr("hidden", false);
            $('#formEvaluasi').submit();
        }
    </script>
@endpush
