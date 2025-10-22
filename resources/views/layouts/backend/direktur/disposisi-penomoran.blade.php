@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
    <div class="form-group">

        <!-- Section Detail Permohonan -->


        <!-- Section Detail Perusahaan -->
        <div>
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Informasi Pemohon </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col">
                            <legend class="text-uppercase font-size-sm font-weight-bold">Data Perusahaan/Instansi
                            </legend>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NIB </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $detailnib['nib'] }}</label>
                                    </div>
                                    <div class="col-lg">
                                        {{-- <input type="text" class="form-control border-right-0"
                                            value="{{ $detailnib->path_berkas_nib }}" placeholder="Dokumen NIB" disabled> --}}
                                        <span>
                                            <a target="_blank" href="{{ asset($detailnib->path_berkas_nib) }}"
                                                class="btn btn-teal" type="button">Lihat Dokumen</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NPWP </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ $detailnib['npwp_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Nama </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ $detailnib['nama_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Telp/Mobile </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['hp_user_proses']) ? $penanggungjawab['hp_user_proses'] : '-' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">NIK </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['no_ktp']) ? $penanggungjawab['no_ktp'] : '-' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Email </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['email_user_proses']) ? $penanggungjawab['email_user_proses'] : '-' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Nama </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penanggungjawab['nama_user_proses']) ? $penanggungjawab['nama_user_proses'] : '-' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Telp </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ $detailnib['nomor_telpon_perseroan'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section Detail Perusahaan -->

        <div>
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Informasi Permohonan </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col">

                            <legend class="text-uppercase font-size-sm font-weight-bold">Data Permohonan
                            </legend>

                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">No Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">: {{ $penomoran['id_izin'] }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
                                    <div class="col-lg">
                                        @if ($penomoran['updated_date'] == null)
                                            <label class="col-lg col-form-label">: - </label>
                                        @else
                                            <label class="col-lg col-form-label">:
                                                {{ $date_reformat->date_lang_reformat_long($penomoran['updated_date']) }}
                                            </label>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['jenis_permohonan']) ? $penomoran['jenis_permohonan'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Status Permohonan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_izin']['name_status_bo']) ? $penomoran['kode_izin']['name_status_bo'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">

                            <legend class="text-uppercase font-size-sm font-weight-bold">Data Perizinan</legend>

                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Perizinan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['jenis_izin']) ? $penomoran['jenis_izin'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">KBLI</label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['full_kbli']) ? $penomoran['full_kbli'] : '' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Layanan </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['jenis_layanan']) ? $penomoran['jenis_layanan'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Section Detail Permohonan -->
        <form method="post" id="formDisposisi"
            action="{{ route('admin.koordinator.disposisipenomoranpost', [$id, $penomoran['id_kode_akses']]) }}">
            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Evaluasi Penomoran </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Data Penomoran</legend>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Jenis Penomoran</label>
                                <div class="col-lg">
                                    <label class="col-lg col-form-label">: {!! isset($penomoran['kode_akses']['jeniskodeakses']['full_name_html'])
                                        ? $penomoran['kode_akses']['jeniskodeakses']['full_name_html']
                                        : '' !!}</label>
                                </div>
                            </div>
                        </div>
                        @if (isset($penomoran['kode_akses']['kode_akses']))
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Kode Akses </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_akses']['kode_akses']) ? $penomoran['kode_akses']['kode_akses'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Prefix </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_akses']['prefix']) ? $penomoran['kode_akses']['prefix'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Kode Wilayah </label>
                                    <div class="col-lg">
                                        <label class="col-lg col-form-label">:
                                            {{ isset($penomoran['kode_akses']['kode_wilayah']) ? $penomoran['kode_akses']['kode_wilayah'] : '' }}</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>


                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <fieldset>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Disposisi ke : </label>
                                    <div class="col-lg">
                                        <select name="id_user_disposisi" id="selectdisposisi"
                                            class="form-control form-control-select2" required>
                                            <option value="null" disabled selected>-- Silakan Pilih --</option>
                                            @if (count($user) > 0)
                                                @foreach ($user as $key => $users)
                                                    <option id="select_{{ $key }}" value="{{ $users['id'] }}">
                                                        {{ $users['nama'] }} |
                                                        {{ $users['short_desc'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                @if ($penomoran['status_permohonan'] == '903')
                                    <div class="form-group row">
                                        <textarea name="catatan" rows="3" cols="3" class="form-control" placeholder="Catatan Disposisi"></textarea>
                                    </div>
                                @else
                                    <div class="form-group row" hidden>
                                        <textarea name="catatan" rows="3" cols="3" class="form-control" placeholder="Catatan Disposisi"></textarea>
                                    </div>
                                @endif
                            </fieldset>
                        </div>
                    </div>
                    <input type="hidden" id="id_izin" name="id_izin" value="{{ $id }}">
                    <input type="hidden" id="id_kode_akses" name="id_kode_akses"
                        value="{{ $penomoran['id_kode_akses'] }}">
                    <input type="hidden" id="id_penomoran" name="id_penomoran" value="{{ $penomoran['id'] }}">



                </div>
            </div>

            <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Riwayat Permohonan</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts/backend/historyperizinan/historypenomoran', [
                        'history_penomoran' => $penomoranlog,
                    ])
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('admin.koordinator') }}" class="btn btn-secondary border-transparent"><i
                        class="icon-backward2 ml-2"></i> Kembali </a>
                <!-- <button type="button" class="btn btn-secondary border-transparent">Kembali </button> -->
                <!-- <button type="button" onclick="logPermohonan();return false;" class="btn btn-info">Riwayat Permohonan </button> -->
                <!-- <a target="_blank" href="{{ route('admin.historyperizinan', $penomoran['id_izin']) }}" class="btn btn-info">Riwayat Permohonan </a> -->
                <!-- <button type="submit" onclick="submitdisposisi();return false;" class="btn btn-indigo">Kirim Disposisi <i class="icon-paperplane ml-2"></i></button> -->
                <button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModal"
                    class="btn btn-indigo">Kirim Disposisi <i class="icon-paperplane ml-2"></i></button>
            </div>

        </form>
    </div>

    <div class="modal" id="submitModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Disposisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan mengirim disposisi ini ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnSubmit" onclick="submitdisposisi();return false;"
                        class="btn btn-primary notif-button">Kirim</button>
                    <div class="spinner-border loading text-primary" role="status" hidden>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="detailLog" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Riwayat Permohonan</h5>
                    <hr />
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-log">
                    <?php
                    
                    ?>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        // $(document).ready(function(){
        // 	$("select[name='id_user_disposisi'] option:eq(1)").attr("selected", "selected");
        // })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function submitdisposisi() {
            if ($('#selectdisposisi').val() == '') {
                alert('Silakan memilih Evaluator');
                $('#submitModal').modal('toggle');
            } else {
                $('.notif-button').attr("hidden", true);
                $('.loading').attr("hidden", false);
                $('#formDisposisi').submit();
                $("#btnSubmit").attr("disabled", true);
                $("#btnSubmitKoreksi").attr("disabled", true);
            }
        }

        function logPermohonan() {
            var innerhtml = '';
            var id_izin = $('#id_izin').val();
            $.ajax({
                /* the route pointing to the post function */
                url: ' {{ route('admin.koordinator.getlogizin') }} ',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    id_izin: id_izin
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function(data) {
                    if (data == 'is_empty') {
                        innerhtml += "<p>Belum ada Riwayat</p>";
                        $('#modal-body-log').html(innerhtml)
                        $('#detailLog').modal('show');
                    } else {
                        innerhtml += '<div class="timeline timeline-left" >';
                        innerhtml += '<div class="timeline-container" >';
                        $.each(data, function(index, value) {
                            innerhtml += '<div class="timeline-row" >';
                            innerhtml +=
                                '<div class="timeline-icon" style="text-align:center;padding-top:7px;">' +
                                (index + 1) + '</div>';
                            innerhtml += '<div class="card"><div class="card-body">' + value
                                .created_at + '</div></div>';
                            innerhtml += '<div class="card"><div class="card-body">Status : ' + value
                                .status_permohonan + '</div></div>';
                            innerhtml += '</div>';
                        })
                        innerhtml += '</div>';
                        innerhtml += '</div>';


                        $('#modal-body-log').html(innerhtml)
                        $('#detailLog').modal('show');
                    };
                }
            });
        }
    </script>
@endpush
