@extends('layouts.frontend.main')
@section('js')
    {{-- <script src="../global_assets/js/plugins/forms/selects/select.min.js"></script> --}}
    <script src="../global_assets/js/demo_pages/form_layouts.js"></script>

    <script src="../../../../global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js"></script>
    <script src="../../../../global_assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>

    <script src="../../../../global_assets/js/demo_pages/uploader_bootstrap.js"></script>
    <script src="//cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
@endsection
@section('content')
    <!-- Vertical form options -->
    <div class="row">
        <div class="col-lg-12">

            <!-- Basic layout-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Layanan Bantuan e-Telekomunikasi</h5>
                </div>

                <div class="card-body">
                    <form action="/simpanlayanan" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Jenis Layanan:</label>
                            <select name='jenis_layanan' data-placeholder="Select a state..." class="form-control select">
                                <option disabled selected>Silahkan Pilih Jenis Layanan..</option>
                                <option value="Masalah">Masalah</option>
                                <option value="Pertanyaan">Pertanyaan</option>
                                <option value="Panduan">Panduan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label>Nama Anda:</label>
                            <input name='nama_pengirim_layanan' type="text" class="form-control"
                                placeholder="Masukkan Nama Anda" required>
                        </div>

                        <div class="form-group">
                            <label>No. Telp:</label>
                            <input name='telp_pengirim_layanan' type="text" class="form-control"
                                placeholder="Masukkan No Telp Anda" required>
                        </div>

                        <div class="form-group">
                            <label>e-Mail Anda:</label>
                            <input name='email_pengirim_layanan' type="text" class="form-control"
                                placeholder="Masukkan e-Mail Anda" required>
                        </div>

                        {{-- <div class="form-group">
                            <div class="col-lg-6">
                                <input type="file" name="lampiran_layanan_path" id="lampiran_layanan_path"
                                    class="form-control h-auto required" accept="application/pdf" required>
                            </div>
                        </div> --}}


                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label font-weight-semibold">Lampiran:</label>
                            <div class="col-lg-10">
                                <input id='lampiran_layanan' name='lampiran_layanan' type="file" class="file-input"
                                    multiple="multiple" data-fouc>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Subyek/Judul Layanan:</label>
                            <input name='judul_pesan_layanan' type="text" class="form-control"
                                placeholder="Masukkan Subyek/Judul Layanan" required>
                        </div>

                        <div class="form-group">
                            <label>Pesan Anda:</label>
                            <textarea name='pesan_layanan' id='pesan_layanan' rows="5" cols="5" class="form-control" placeholder="Masukkan Pesan Anda" required></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-secondary">Kirim <i
                                    class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /basic layout -->

        </div>
    </div>
    <!-- /vertical form options -->
    <script type="text/javascript">
        $(document).ready(function() {

            CKEDITOR.replace('pesan_layanan_pre');
            CKEDITOR.replace('pesan_layanan');
        });
    </script>
@endsection
