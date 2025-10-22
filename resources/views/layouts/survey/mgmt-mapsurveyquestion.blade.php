@extends('main')
@section('js')
<script src="../../../../global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="../../../../global_assets/js/demo_pages/datatables_advanced.js"></script>
<script src="https://cdn.jsdelivr.net/gh/RubaXa/Sortable/Sortable.min.js"></script>
@endsection
@section('content')
<style>
    .form-check{
        background: white;
    }
    tbody tr td.action{
        display: block;
        padding: 16px;
        border-bottom: none;
    }
    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    /* Hide the browser's default checkbox */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 30px;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
<div class="card">
    <div class="card-header bg-primary text-white header-elements-inline">
        <h5 class="card-title">Survei</h5>
    </div>

    <div class="card-body">
        <fieldset class="mb-3">

            <div class="form-group row">
                <label class="col-form-label col-lg-3">Nama Survei</label>
                <div class="col-lg-8">
                    <div>
                        <input type="text" class="form-control form-control-outline"
                            placeholder="Indeks Kepuasan Masyarakat" value="{{$survey->survey_name}}" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Keterangan</label>
                <div class="col-sm-9">
                    <div>
                        <input type="text" class="form-control form-control-outline"
                            placeholder="Masukkan Keterangan Survei" value="{{$survey->survey_desc}}" readonly>
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
                        <input type="text" class="form-control daterange-single" value="{{$survey->period_start}}" readonly>
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
                        <input type="text" class="form-control daterange-single" value="{{$survey->period_end}}" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-3">Nilai yang diharapkan</label>
                <div class="col-sm-9">
                    <div>
                        <input type="text" class="form-control form-control-outline" value="{{$survey->expected_result}}" readonly>
                    </div>
                </div>
            </div>

        </fieldset>
    </div>
</div>
<div class="card">

    <div class="card-header bg-primary text-white header-elements-inline py-0">
        <h5 class="card-title py-3">Daftar Pertanyaan</h5>
        <div class="header-elements">
            {{-- <button type="button" class="btn btn-indigo" data-toggle="modal" data-target="#modal_tambah">Tambah
                Survei</button> --}}
        </div>
    </div>
    <div class="card">
        <form method="POST" action="{{ route('svmgmt.add-question', $id) }}" class="form-horizontal">
        @csrf
        <table class="table datatable-show-all">
            <thead>
                <tr>
                    <th class="text-center">Actions</th>
                    <th>Pertanyaan</th>
                    <th class="text-center">Tipe Pertanyaan</th>
                    <th class="text-center">Ekspetasi Survei</th>
                </tr>
            </thead>
            <tbody  id="question">
                @foreach ($question as $item)
                <tr class="list-action">
                    <td class="text-center action">
                        {{-- <input class="form-check-input" name="question_id[]" value="{{$item->id}}" type="checkbox" {{$item->checked?'checked':''}}> --}}
                        <label class="container">
                        <input type="checkbox" name="question_id[]" value="{{$item->id}}" {{$item->checked?'checked':''}}>
                        <span class="checkmark"></span>
                        </label>
                    </td>
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
                            {{$item->categoryName->quest_type_name}}
                        </div>
                    </td>
                    <td class="text-center">{{$item->expected_result}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-body">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
        <!-- CHECKBOX LIST -->
        {{-- <form method="POST" action="{{ route('svmgmt.add-question', $id) }}" class="form-horizontal">
            @csrf
            <div class="card rounded border-0 shadow-sm position-relative">
                <div class="card-body p-5">
                    <div id="question">
                    @foreach ($question as $item)
                        <div class="form-check mb-3 list-action">
                            <input class="form-check-input" name="question_id[]" value="{{$item->id}}" type="checkbox" {{$item->checked?'checked':''}}>
                            <label class="form-check-label"><span class="fst-italic pl-1">{{$item->question_name}}</span></label>
                        </div>
                    @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form> --}}
    </div>
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
<script>
Sortable.create(question, {
  animation: 200,
  handle: '.list-action'
});
</script>
@endsection