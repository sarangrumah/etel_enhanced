@extends('layouts.backend.main')
@section('js')
<script src="../../../../global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="../../../../global_assets/js/demo_pages/datatables_advanced.js"></script>
@endsection
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white header-elements-inline">
        <h5 class="card-title">Kelengkapan Survei</h5>
    </div>

    <div class="card-body">
        <fieldset class="mb-3">

            <div class="form-group row">
                <label class="col-form-label col-lg-3">Nama Survei</label>
                <div class="col-lg-8">
                    <div>
                        <input type="text" class="form-control form-control-outline"
                            placeholder="Indeks Kepuasan Masyarakat">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Keterangan</label>
                <div class="col-sm-9">
                    <div>
                        <input type="text" class="form-control form-control-outline"
                            placeholder="Masukkan Keterangan Survei">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Periode Awal</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar5"></i></span>
                        </span>
                        <input type="text" class="form-control daterange-single" value="03/18/2013">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Periode Akhir</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar5"></i></span>
                        </span>
                        <input type="text" class="form-control daterange-single" value="03/18/2013">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Nilai yang diharapkan</label>
                <div class="col-sm-9">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="3,21">
                    </div>
                </div>
            </div>

        </fieldset>
    </div>
</div>
<div class="card">

    <div class="card-header bg-primary text-white header-elements-inline py-0">
        <h5 class="card-title py-3">Daftar Survei Direktorat Telekomunikasi (Ditjen PPI)</h5>
        <div class="header-elements">
            <button type="button" class="btn btn-indigo" data-toggle="modal" data-target="#modal_tambah">Tambah
                Survei</button>
        </div>
    </div>
    <table class="table datatable-show-all">
        <thead>
            <tr>
                <th>Pertanyaan</th>
                <th class="text-center">Tipe Pertanyaan</th>
                <th class="text-center">Ekspetasi Survei</th>
                <th class="text-center">Hasil Akhir</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="#">Bagaimana pendapat saudara tentang kemudahan dalam memperoleh informasi mengenai
                        persyaratan perizinan jasa/jaringan/telsus/penomoran?</a></td>
                <td class="text-center">Pilihan Ganda 2 Opsi</td>
                <td class="text-center">3,21</td>
                <td class="text-center">3,21</td>
                <td class="text-center"><span class="badge badge-success">Aktif</span></td>
                <td class="text-center">
                    <div class="list-icons">
                        <div class="dropdown">
                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                {{-- <a href="#" class="dropdown-item"><i class="icon-pencil6"></i> Perbaharui
                                    Survei</a> --}}
                                <a href="#modal_nonaktif" data-toggle="modal" data-target="#modal_nonaktif"
                                    class="dropdown-item"><i class="icon-lock4"></i> Hapus dari daftar</a>
                                {{-- <a href="#" class="dropdown-item"><i class="icon-medal2"></i> Hasil Survei</a> --}}
                            </div>

                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div id="modal_tambah" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kelengkapan Data Survei</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Nama Survei</label>
                        <div class="col-lg-8">
                            <div>
                                <input type="text" class="form-control form-control-outline"
                                    placeholder="Masukkan Nama Survei">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Keterangan</label>
                        <div class="col-sm-9">
                            <div>
                                <input type="text" class="form-control form-control-outline"
                                    placeholder="Masukkan Keterangan Survei">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Periode Awal</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar5"></i></span>
                                </span>
                                <input type="text" class="form-control daterange-single" value="03/18/2013">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Periode Akhir</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar5"></i></span>
                                </span>
                                <input type="text" class="form-control daterange-single" value="03/18/2013">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Nilai yang diharapkan</label>
                        <div class="col-sm-9">
                            <div>
                                <input type="text" class="form-control form-control-outline"
                                    placeholder="Masukkan Nilai">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Perbaharui Survei</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal_nonaktif" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nonaktifkan Survei</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Nama Survei</label>
                        <div class="col-lg-8">
                            <div>
                                <input type="text" class="form-control form-control-outline"
                                    placeholder="Indeks Kepuasan Masyarakat">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Keterangan</label>
                        <div class="col-sm-9">
                            <div>
                                <input type="text" class="form-control form-control-outline"
                                    placeholder="Masukkan Keterangan Survei">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Periode Awal</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar5"></i></span>
                                </span>
                                <input type="text" class="form-control daterange-single" value="03/18/2013">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Periode Akhir</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar5"></i></span>
                                </span>
                                <input type="text" class="form-control daterange-single" value="03/18/2013">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Nilai survei</label>
                        <div class="col-sm-9">
                            <div>
                                <input type="text" class="form-control form-control-outline" placeholder="3,21">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Nonaktifkan Survei</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection