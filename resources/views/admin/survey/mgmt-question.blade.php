@extends('layouts.backend.main')
@section('js')
<script src="../../../../global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="../../../../global_assets/js/demo_pages/datatables_advanced.js"></script>
<script src="../../../../global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="../../../../global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="../../../../global_assets/js/demo_pages/form_select2.js"></script>
@endsection
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white header-elements-inline">
        <h5 class="card-title py-3">Manajemen Pertanyaan</h5>
    </div>
    <form method="POST" action="{{ route('admin.qsmgmt.store') }}" class="form-horizontal">
    @csrf
    <div class="card-body">
        <fieldset class="mb-3">

            <div class="form-group form-group-floating row">
                <label class="col-form-label col-lg-3">Pertanyaan</label>
                <div class="col-lg-8">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Pertanyaan Anda" name="question_name">
                    </div>
                </div>
            </div>

            <div class="form-group form-group-floating row">
                <label class="col-form-label col-lg-3">Keterangan</label>
                <div class="col-lg-8">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Keterangan Pertanyaan Anda" name="question_desc">
                    </div>
                </div>
            </div>

            <div class="form-group form-group-floating row">
                <label class="col-form-label col-lg-3">Bobot</label>
                <div class="col-lg-8">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Bobot Pertanyaan" name="weight">
                    </div>
                </div>
            </div>

            <div class="form-group form-group-floating row">
                <label class="col-form-label col-lg-3">Unsur</label>
                <div class="col-lg-2">
                    <div>
                        <select class="form-control select" data-fouc name="unsur" required>
                            <option value="" class="disabled">-- Silahkan Pilih Unsur --</option>
                            <option value="1">Persyaratan</option>
                            <option value="2">Prosedur</option>
                            <option value="3">Waktu Penyelesaian</option>
                            <option value="4">Biaya/Tarif</option>
                            <option value="5">Produk Spesifikasi Jenis Pelayanan</option>
                            <option value="6">Kompetensi Pelaksana</option>
                            <option value="7">Perilaku Pelaksana</option>
                            <option value="8">Penanganan Pengaduan, Saran dan Masukan</option>
                            <option value="9">Sarana dan Prasarana</option>
                            <option value="10">Pengalaman Korupsi</option>
                            <option value="11">Cara Pandang Terhadap Korupsi</option>
                            <option value="12">Lingkungan Kerja</option>
                            <option value="13">Sistem Administrasi</option>
                            <option value="14">Pencegahan Korupsi</option>
                            <option value="15">Perilaku Individu</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-3">Kategori Pertanyaan</label>
                <div class="col-lg-2">
                    <div>
                        <select class="form-control select" data-fouc name="category">
                            <option value="" class="disabled">-- Silahkan Pilih Kategori --</option>
                            <option value="1">Umum</option>
                            <option value="2">Khusus</option>
                            <option value="3">Ulo</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-3">Tipe Pertanyaan</label>
                <div class="col-lg-2">
                    <div>
                        <select class="form-control select" data-fouc name="id_tb_mst_question_type">
                            <option value="" class="disabled">-- Silahkan Pilih Opsi --</option>
                            <option value="1">Pilihan Ganda 2 Opsi</option>
                            <option value="2">Pilihan Ganda 4 Opsi</option>
                            <option value="3">Essai</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-floating row">
                <label class="col-form-label col-lg-3">Opsi</label>
                <div class="col-lg-2">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Opsi 1 Anda" name="question_text_1">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Opsi 2 Anda" name="question_text_2">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Opsi 3 Anda" name="question_text_3">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Opsi 4 Anda" name="question_text_4">
                    </div>
                </div>
            </div>

            <div class="form-group form-group-floating row">
                <label class="col-form-label col-lg-3">Nilai yang diharapkan</label>
                <div class="col-lg-8">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Nilai yang diharapkan Anda" name="expected_result">
                    </div>
                </div>
            </div>

            <div class="form-group form-group-floating row">
                <label class="col-form-label col-lg-3">Nilai Minimum</label>
                <div class="col-lg-8">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Nilai Minimum Pertanyaan" name="min_result">
                    </div>
                </div>
            </div>

            <div class="form-group form-group-floating row">
                <label class="col-form-label col-lg-3">Nilai Maksimum</label>
                <div class="col-lg-8">
                    <div>
                        <input type="text" class="form-control form-control-outline" placeholder="Masukkan Nilai Maksimum Pertanyaan" name="max_result">
                    </div>
                </div>
            </div>

        </fieldset>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
        </div>
    </div>
    </form>
</div>
<div class="card">

    <div class="card-header bg-primary text-white header-elements-inline py-0">
        <h5 class="card-title py-3">Daftar Pertanyaan</h5>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Pertanyaan</th>
                <th class="text-center">Tipe Pertanyaan</th>
                <th class="text-center">Unsur</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Ekspetasi Nilai</th>
                {{-- <th class="text-center">Status</th> --}}
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($question as $item)
            <tr>
                <td>
                    <div>
                        <a href="#">{{$item->question_name}}</a>
                    </div>
                    <div>
                        {{$item->question_desc}}
                    </div>
                </td>
                <td class="text-center">
                    <div>
                        {{$item->categoryName->quest_type_name ?? '-'}}
                    </div>
                </td>
                <td class="text-center">
                    <div>
                        {{$item->unsurType->unsur_name ?? '='}}
                    </div>
                </td>
                <td class="text-center">{{$item->category==1?'Umum':'Khusus'}}</td>
                <td class="text-center">{{$item->expected_result}}</td>
                {{-- <td class="text-center"><span class="badge badge-success">{{$item->is_active == 1?'Aktif':'Tidak Aktif'}}}</span></td> --}}
                <td class="text-center">
                    <div class="list-icons">
                        <div class="dropdown">
                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                {{-- <a href="#" class="dropdown-item"><i class="icon-pencil6"></i> Perbaharui
                                    Survei</a> --}}
                                <form method="POST" action="{{ route('admin.qsmgmt.delete', $item->id) }}">
                                @csrf
                                @method("DELETE")

                                <div class="form-group">
                                    <button type="submit" class="dropdown-item" value=""><i class="icon-lock"></i> Hapus dari daftar</button>
                                </div>
                            </form>
                                {{-- <a href="#" class="dropdown-item"><i class="icon-medal2"></i> Hasil Survei</a> --}}
                            </div>

                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection