@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
    <!-- Quick stats boxes -->

    <!-- /quick stats boxes -->
    <div>
        @if ($message = Session::get('message'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <!-- Latest orders -->
        <div class="card">
            <div class="card-header d-flex py-0">
                <h6 class="card-title font-weight-semibold py-3">Daftar Penomoran Aktif Rekap Alokasi Penomoran</h6>

            </div>

            <div class="table-responsive border-top-0">
                <table class="table text-nowrap datatable-button-init-basic" id="table">
                    <thead>
                        <tr>
                            <th>Nomor Permohonan</th>
                            <!-- <th>Detil Permohonan Penomoran</th> -->
                            <th class="text-center">Tanggal Penetapan</th>

                            <th class="text-center">Jenis Kode Akses</th>
                            <th class="text-center">Kode Akses</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Catatan</th>
                            <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (isset($penomoran['data']) && count($penomoran['data']) > 0)
                            @foreach ($penomoran['data'] as $penomorans)
                                <?php $datajson = json_encode($penomorans); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>

                                                <a href="#"
                                                    class="text-body font-weight-semibold">{{ $penomorans['id_permohonan'] }}</a>

                                                <div class="text-muted font-size-sm">
                                                    {{ isset($penomorans['nama_perseroan']) ? $penomorans['nama_perseroan'] : '' }}
                                                </div>

                                            </div>

                                        </div>
                                    </td>

                                    <td class="text-center" style="overflow-wrap: break-word;">
                                        {{ $date_reformat->dateday_lang_reformat_long($penomorans['effective_date']) }}</td>


                                    <td class="">
                                        <div>
                                            <div>{!! isset($penomorans['full_name_html']) ? $penomorans['full_name_html'] : '' !!}</div>
                                            {{-- <div>Kode Akses :
                                                {{ isset($penomorans['kode_akses']) ? $penomorans['kode_akses'] : '' }}
                                            </div> --}}
                                        </div>
                                    </td>
                                    <td class="">
                                        <div>
                                            {{-- <div>{!! isset($penomorans['full_name_html']) ? $penomorans['full_name_html'] : '' !!}</div> --}}
                                            {{-- <div>Kode Akses : --}}
                                            {{ isset($penomorans['kode_akses']) ? $penomorans['kode_akses'] : '' }}
                                            {{-- </div> --}}
                                        </div>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge badge-success-100 text-success">{{ isset($penomorans['status']) ? $penomorans['status'] : '' }}</span>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge badge-success-100 text-success">{{ isset($penomorans['catatan_hasil_evaluasi']) ? $penomorans['catatan_hasil_evaluasi'] : '' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if (strtolower($penomorans['catatan_hasil_evaluasi']) != 'idle')
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                                    data-toggle="dropdown">
                                                    <i class="icon-menu7"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">

                                                    <a href="#" onclick="modal( {{ $datajson }} )"
                                                        class="dropdown-item"><i class="icon-pencil"></i>Perbaharui Status
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>

                <div class="text-right pagination-flat" style="float:right">
                    @if (isset($paginate) && $paginate != null && $paginate->count() > 0)
                        {{ $paginate->links() }}
                    @endif
                    <br />
                </div>
            </div>

        </div>

        <!-- /latest orders -->
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function modal(datajson) {
            let data = JSON.parse(JSON.stringify(datajson));
            $('#submitModal').data('json', datajson);
            $('#submitModal').modal('show');
            $('#nomor-permohonan').html(data.id_permohonan);
            $('#datajsonsubmit').val(JSON.stringify(datajson));
            var formattedDate = new Date(data.effective_date);
            var d = formattedDate.getDate();
            var m = formattedDate.getMonth();
            m += 1; // JavaScript months are 0-11
            var y = formattedDate.getFullYear();
            $('#tanggal-penetapan').html(d + " - " + m + " - " + y);
            $('#jenis-kode-akses').html(data.kode_akses.jenis_kode_akses.full_name_html);
            $('#kode-akses').html(data.kode_akses.kode_akses);
            $('#formjsonsubmit').attr('action', '/admin/rilispenomoranpost/' + data.id)
            console.log(data)
            // alert(data)

        }

        function submitrilis() {
            let data = $('#datajsonsubmit').val();
            $('.notif-button').attr("hidden", true);
            $('.loading').attr("hidden", false);

            $.ajax({
                /* the route pointing to the post function */
                url: '/admin/rilispenomoranpost',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    data: data
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function(data) {
                    if (data.status == 'success') {
                        location.reload();
                    } else {
                        $('.notif-button').attr("hidden", false);
                        $('.loading').attr("hidden", true);
                    }

                }
            });

            // $('#formjsonsubmit').submit();
        }
    </script>

    <div class="modal" id="submitModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbaharui Status Penomoran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header bg-indigo text-white header-elements-inline">
                            <div class="row">
                                <div class="col-lg">
                                    <h6 class="card-title font-weight-semibold py-3">Detail Permohonan
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Nomor Permohonan </label>
                                        <div class="col-lg">
                                            <label class="col-lg col-form-label">: <span
                                                    id="nomor-permohonan"></span></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Tanggal Penetapan </label>
                                        <div class="col-lg">
                                            <label class="col-lg col-form-label">: <span
                                                    id="tanggal-penetapan"></span></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Jenis Kode Akses</label>
                                        <div class="col-lg">
                                            <label class="col-lg col-form-label">: <span
                                                    id="jenis-kode-akses"></span></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Kode Akses</label>
                                        <div class="col-lg">
                                            <label class="col-lg col-form-label">: <span id="kode-akses"></span></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Kode Akses</label>
                                        <div class="col-lg">
                                            {{-- <label class="col-lg col-form-label">: <span
                                                id="kode-akses"></span></label> --}}
                                            <option value="null" disabled selected>-- Silakan Pilih --</option>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <p>Apakah anda yakin akan memperbaharui status penomoran ini ?</p>
                    <form action="#" id="formjsonsubmit" method="post">
                        @csrf
                        <textarea name="datajsonsubmit" id="datajsonsubmit" style="display:none;"></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="submitrilis();return false;"
                        class="btn btn-primary notif-button">Perbaharui </button>
                    <div class="spinner-border loading text-primary" role="status" hidden>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
