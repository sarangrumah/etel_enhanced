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
                    <form action="/updatelayanan/{{ $help->id }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label>Jenis Layanan:</label>
                            <select name='jenis_layanan' data-placeholder="Select a state..." class="form-control select">
                                <option disabled>Silahkan Pilih Jenis Layanan..</option>
                                <option value="Masalah" @if ($help->jenis_layanan == 'Masalah') selected @endif>Masalah</option>
                                <option value="Pertanyaan" @if ($help->jenis_layanan == 'Pertanyaan') selected @endif>Pertanyaan
                                </option>
                                <option value="Panduan" @if ($help->jenis_layanan == 'Panduan') selected @endif>Panduan</option>
                                <option value="Lainnya" @if ($help->jenis_layanan == 'Lainnya') selected @endif>Lainnya</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label>Status Layanan:</label>
                            <select name='status' data-placeholder="Select a state..." class="form-control select">
                                <option disabled>Silahkan Pilih Jenis Layanan..</option>
                                <option value="Open" @if ($help->status == 'Open') selected @endif>Open</option>
                                <option value="WIA" @if ($help->status == 'WIA') selected @endif>WIA (Waiting
                                    Confirmation)</option>
                                <option value="Closed" @if ($help->status == 'Closed') selected @endif>Closed</option>
                                <option value="Cancelled" @if ($help->status == 'Cancelled') selected @endif>Cancelled
                                </option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label>Nama Anda:</label>
                            <input name='nama_pengirim_layanan' type="text" class="form-control"
                                placeholder="Masukkan Nama Anda" value="{{ $help->nama_pengirim_layanan }}">
                        </div>

                        <div class="form-group">
                            <label>No. Telp:</label>
                            <input name='telp_pengirim_layanan' type="text" class="form-control"
                                placeholder="Masukkan No Telp Anda" value="{{ $help->telp_pengirim_layanan }}">
                        </div>

                        <div class="form-group">
                            <label>e-Mail Anda:</label>
                            <input name='email_pengirim_layanan' type="text" class="form-control"
                                placeholder="Masukkan e-Mail Anda" value="{{ $help->email_pengirim_layanan }}">
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-form-label font-weight-semibold">Lampiran:</label>
                            <div class="input-group">
                                <input disabled="disabled" type="text" class="form-control border-right-0"
                                    placeholder="{{ isset($help->filename) ? $help->filename : '' }}">
                                {{-- <span class="input-group-append"> --}}
                                <?php 
                                                    if (isset($help->lampiran_layanan_path) && $help->lampiran_layanan_path != '') {
                                                        ?><a target="_blank" href="{{ asset($help->lampiran_layanan_path) }}"
                                    class="btn btn-teal" type="button">Lihat Dokumen</a>
                                <?php
                                                    }else{
                                                        ?><a href="#" class="btn btn-teal" type="button">Lihat
                                    Dokumen</a>
                                <?php
                                                    }
                                                    ?>
                                {{-- </span> --}}
                            </div>
                            {{-- <div class="col-lg-10">
                                <input for='lampiran_layanan' id='lampiran_layanan' name='lampiran_layanan' type="file"
                                    class="file-input" multiple="multiple" data-fouc>
                            </div> --}}
                        </div>

                        <div class="form-group">
                            <label>Subyek/Judul Layanan:</label>
                            <input name='judul_pesan_layanan' type="text" class="form-control"
                                placeholder="Masukkan Subyek/Judul Layanan" value="{{ $help->judul_pesan_layanan }}">
                        </div>

                        <div class="form-group">
                            <label>Pesan Anda:</label>
                            <textarea name='pesan_layanan' id='pesan_layanan' rows="5" cols="5" class="form-control" placeholder="Masukkan Pesan Anda"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Pesan Anda Sebelumnya:</label>
                            <textarea name='pesan_layanan_pre' id='pesan_layanan_pre' rows="5" cols="5" class="form-control disabled" placeholder="Masukkan Pesan Anda">{!! $help->pesan_layanan !!}</textarea>
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
