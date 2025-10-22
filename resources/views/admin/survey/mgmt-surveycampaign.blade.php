@extends('layouts.backend.main')
@section('js')
<script src="../../../../global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="../../../../global_assets/js/demo_pages/datatables_advanced.js"></script>
@endsection
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white header-elements-inline py-0">
        <h3 class="card-title py-3">Daftar Survei Direktorat Telekomunikasi (Ditjen PPI)</h3>
        <div class="header-elements">
            <button type="button" class="btn btn-indigo" data-toggle="modal" data-target="#modal_tambah">Tambah
                Survei</button>
        </div>
    </div>
    <table class="table datatable-show-all">
        <thead>
            <tr>
                <th>Survei Detail</th>
                <th class="text-center">Periode Awal</th>
                <th class="text-center">Periode Akhir</th>
                <th class="text-center">Jenis Perizinan</th>
                <th class="text-center">Hasil Akhir</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($survey as $item)
            <tr>
                <td>{{$item->survey_name}}<br><a href="{{route('admin.svmgmt.show', $item->id)}}">{{$item->survey_desc}}</a></td>
                <td class="text-center">{{$item->period_start}}</td>
                <td class="text-center">{{$item->period_end}}</td>
                <td class="text-center">{{$item->jenis_perizinan == 1? 'Jasa/Jaringan/Telsus' : 'Penomoran'}}</td>
                <td class="text-center">3,21</td>
                <td class="text-center"><span class="badge badge-success">{{$item->is_active == 1?'Active':'Deactive'}}</span></td>
                <td class="text-center">
                    <div class="list-icons">
                        <div class="dropdown">
                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item" onclick="edit({{$item->id}})"><i class="icon-pencil6"></i> Perbaharui Survei</a>
                                <a href="#" class="dropdown-item" onclick="setActive({!! $item->id, ', ',$item->is_active?'1':'0' !!})">
                                    <i class="icon-lock4"></i> {{ $item->is_active == 1 ? "Nonaktifkan":"Aktifkan" }}
                                </a>
                                <a href="{{route('admin.svmgmt.preview', $item->id)}}" target="_blank" class="dropdown-item"><i class="icon-medal2"></i> Preview Survei</a>
                            </div>

                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
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

            <form method="POST" action="{{ route('admin.svmgmt.store') }}" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Nama Survei</label>
                        <div class="col-lg-9">
                            <div>
                                <input type="text" class="form-control form-control-outline" name="survey_name"
                                    placeholder="Masukkan Nama Survei">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Keterangan</label>
                        <div class="col-sm-9">
                            <div>
                                <input type="text" class="form-control form-control-outline" name="survey_desc"
                                    placeholder="Masukkan Keterangan Survei">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Jenis Perizinan</label>
                        <div class="col-sm-9">
                            <div>
                                <select name="jenis_perizinan" class="form-control form-control-outline">
                                    <option value="1">Jasa/Jaringan/Telsus</option>
                                    <option value="2">Penomoran</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Kategori</label>
                        <div class="col-sm-9">
                            <div>
                                <select name="category" class="form-control form-control-outline">
                                    <option value="1">IKM KINERJA (PERFOMANCE)</option>
                                    <option value="2">IKM TINGKAT HARAPAN (EXPECTATION)</option>
                                    <option value="3">IPP</option>
                                    <option value="4">PERTANYAAN TERBUKA</option>
                                    <option value="5">IN-DEPTH QUESTIONS</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Periode Awal</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="period_start" name="period_start" value="2022-08-01">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Periode Akhir</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="period_end"  name="period_end" value="2022-08-10">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Nilai yang diharapkan</label>
                        <div class="col-sm-9">
                            <div>
                                <input type="text" class="form-control form-control-outline" name="expected_result"
                                    placeholder="Masukkan Nilai">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="is_related_izin" value="123">
                    <input type="hidden" name="is_survey_initiator" value="123">
                    <input type="hidden" name="is_active" value="0">
                    <input type="hidden" name="created_by" value="1">
                    <input type="hidden" name="updated_by" value="1">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
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

            <form method="POST" action="#" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Nama Survei</label>
                        <div class="col-lg-8">
                            <div>
                                <input type="text" class="form-control form-control-outline"
                                    placeholder="Indeks Kepuasan Masyarakat" id="survey_name" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Keterangan</label>
                        <div class="col-sm-9">
                            <div>
                                <input type="text" class="form-control form-control-outline"
                                    placeholder="Masukkan Keterangan Survei" id="survey_desc" disabled>
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
                                <input type="text" class="form-control daterange-single" value="03/18/2013" id="period_start" disabled>
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
                                <input type="text" class="form-control daterange-single" value="03/18/2013" id="period_end" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Nilai survei</label>
                        <div class="col-sm-9">
                            <div>
                                <input type="text" class="form-control form-control-outline" placeholder="3,21" id="expected_result" disabled>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#period_start').datepicker({
            uiLibrary: 'bootstrap4',
			format: 'yyyy-mm-dd'
        });
        $('#period_end').datepicker({
            uiLibrary: 'bootstrap4',
			format: 'yyyy-mm-dd'
        });
        $('.modal').on('hidden.bs.modal', function () {
            location.reload();
        });
    });
    
    function getSurvey(id, callback) {
        $.ajax({
            type: "GET",
            url: "{{ url('admin/svmgmt') }}/"+id+"/edit",
            success: callback,
            failure: function(errMsg) {
                alert(errMsg);
            }
        });
    }

    function edit(id) {
        getSurvey(id, function(e) {
            $('#modal_tambah').modal("show")
    
            $('#modal_tambah form').attr('action', "{{ url('admin/svmgmt/update') }}/"+id);
            // $('<input>').attr({
            //     type: 'hidden',
            //     name: '_method',
            //     value: 'PUT'
            // }).appendTo('#modal_tambah form');
    
            $('#modal_tambah input[name=survey_name]').val(e.survey_name)
            $('#modal_tambah input[name=survey_desc]').val(e.survey_desc)
            $('#modal_tambah input[name=period_start]').val(e.period_start)
            $('#modal_tambah input[name=period_end]').val(e.period_end)
            $('#modal_tambah input[name=expected_result]').val(e.expected_result)
            
            $('#modal_tambah button[type=submit]').html("Edit")
        });
    }

    function setActive(id, status) {
        getSurvey(id, function(e) {
            $('#modal_nonaktif').modal("show")
    
            $('#modal_nonaktif form').attr('action', "{{ url('admin/svmgmt/update') }}/"+id);
            // $('<input>').attr({
            //     type: 'hidden',
            //     name: '_method',
            //     value: 'PUT'
            // }).appendTo('#modal_nonaktif form');

            $('<input>').attr({
                type: 'hidden',
                name: 'is_active',
                value: status==1?0:1
            }).appendTo('#modal_nonaktif form');
    
            $('#modal_nonaktif #survey_name').val(e.survey_name)
            $('#modal_nonaktif #survey_desc').val(e.survey_desc)
            $('#modal_nonaktif #period_start').val(e.period_start)
            $('#modal_nonaktif #period_end').val(e.period_end)
            $('#modal_nonaktif #expected_result').val(e.expected_result)

            $('#modal_nonaktif button[type=submit]').html(status==1?"Nonaktifkan":"Aktifkan")
        });
    }
</script> 

@endsection