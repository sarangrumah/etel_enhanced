@extends('layouts.frontend.main')
@section('title', 'Dashboard')
@section('js')
    <script src="../global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="../global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script src="../global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="../global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script>

    <script src="../global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="../global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="../global_assets/js/kominfo/form_option_kominfo.js"></script>
    <script src="../global_assets/js/demo_pages/form_select2.js"></script>

@endsection
@section('content')
    <!-- Quick stats boxes -->
    {{-- <div class="alert alert-danger alert-styled-left alert-dismissible">
    <span class="font-weight-semibold">Menunggu proses verikasi internal KOMINFO.</span>
</div> --}}

    {{-- asdasdasd --}}
    {{-- <div class="row">
    <div class="col-lg">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">Lihat Data</a>
                </div>
                <div>
                    <div class="font-size-sm opacity-75">Permohonan Dalam Proses</div>
                </div>
            </div>
            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card bg-indigo text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">Lihat Data</a>
                </div>
                <div>
                    <div class="font-size-sm opacity-75">Permohonan Selesai</div>
                </div>
            </div>
            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
    </div>
</div> --}}
    {{-- asdasdasd --}}
    <!-- /quick stats boxes -->

    @if (session()->has('success'))
        <div class="alert alert-success">
            Persyaratan telah dikirim harap menunggu proses verifikasi, Terima kasih.
        </div>
    @endif
    @if (Session::get('error') != '')
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ Session::get('error') }}</strong>
        </div>
    @endif
    {{-- @if (Auth::user()->jenis_pu == 'NBH' && $status_evaluasi != '1') --}}
    @if (Auth::user()->jenis_pu != 'BH' && $status_evaluasi != '1')
        <div class="alert alert-warning alert-block">
            <strong>User Anda belum terverifikasi, Sebelum mengajukan permohonan perizinan pastikan Anda harus melengkapi
                Kelengkapan data Penganggung Jawab dan Data Perusahaan</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8">
                    <h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Pengajuan Penomoran</h6>
                </div>
                <div class="d-inline-flex align-items-center ml-auto">
                    <div class="dropdown ml-2">
                        <a href="javascript:void(0)"
                            class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                            data-toggle="dropdown">
                            <i class="icon-more2"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"></a>
                            @if (Auth::user()->jenis_pu == 'BH')
                                <a href="javascript:void(0)" class="dropdown-item"><i class="icon-database-refresh"></i>
                                    Perbaharui Data </a>
                            @endif
                            @if (Auth::user()->jenis_pu == 'NBH' && $status_evaluasi == '1')
                                <a href="javascript:void(0)" class="dropdown-item" onclick="return false;"
                                    data-toggle="modal" data-target="#tambahData"><i class="icon-file-plus"></i></b> Tambah
                                    Data Perizinan</a>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3 ml-lg-auto">
                <button type="button" class="btn btn-indigo btn-labeled btn-labeled-left btn-lg float-right"
                    data-toggle="modal" data-target="#modal_theme_primary"><b><i class="icon-file-plus"></i></b>
                    Permohonan Kode Akses </button>
            </div> --}}
            </div>

            <!-- <p><button type="button" class="btn btn-primary btn-labeled btn-labeled-left btn-lg"><b><i class="icon-pin-alt"></i></b> Large size</button></p> -->
        </div>

        <table class="table datatable-button-init-basic">
            <thead>
                <!-- <tr>
                                                                <th>Proyek</th>
                                                                <th>Lokasi Proyek</th>
                                                                {{-- <th class="text-center">Tanggal Permohonan</th>
                    <th class="text-center">Batas Verifikasi</th>
                    <th class="text-center">Status</th> --}}
                                                                <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                                                            </tr> -->
                <tr>
                    <th>Permohonan</th>
                    <th class="text-center">Tanggal Permohonan</th>
                    <th class="text-center">Jenis Layanan</th>
                    <th class="text-center">Batas Verifikasi</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                </tr>
            </thead>
            <tbody id="TrTable">
                @if (count($penomoran) == 0)
                    <tr>
                        <td colspan="4"> Belum ada pengajuan permohonan Penomoran</td>
                    </tr>
                @endif
                @foreach ($penomoran as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    {{-- @if ($item->status_checklist == 20)
                                        <p class="text-body font-weight-semibold">{{ $item->id_izin }}</p>
                                    @elseif($item->status_checklist == 903)
                                        <p class="text-body font-weight-semibold">{{ $item->id_izin }}</p>
                                    @else
                                        <p class="text-body font-weight-semibold">{{ $item->id_izin }}</p>
                                    @endif --}}
                                    <p class="text-body font-weight-semibold">{{ $item->id_proyek }}</p>
                                    <div class="text-muted font-size-sm">
                                        {{ isset($item->nama_perseroan) ? $item->nama_perseroan : '' }}
                                    </div>
                                    <div class="text-muted font-size-sm">
                                        {{ isset($item->jenis_izin) ? $item->jenis_izin : '' }}</div>
                                    <div class="text-muted font-size-sm">{{ $item->kbli }} -
                                        {{ $item->kbli_name }}</div>
                                    <div class="text-muted font-size-sm">{!! $item->jenis_layanan_html !!}</div>
                                    <!-- <div class="text-muted font-size-sm">{{ isset($item->jenis_permohonan) ? $item->jenis_permohonan : '' }}</div> -->
                                    <div class="text-muted font-size-sm">
                                        {!! isset($item->kode_akses['jenis_kode_akses']['full_name_html'])
                                            ? $item->kode_akses['jenis_kode_akses']['full_name_html']
                                            : '' !!}</div>
                                    <div class="text-muted font-size-sm">
                                        {!! isset($item->jenis_kode_akses) ? $item->jenis_kode_akses : '' !!}</div>
                                    <div class="text-muted font-size-sm">Kode Akses :
                                        {{ isset($item->kode_akses) ? $item->kode_akses : '' }}
                                    </div>
                                </div>

                        </td>
                        @if (!isset($item->updated_at))
                            <td class="text-center"> - </td>
                        @else
                            <td class="text-center"> {{ $date_reformat->dateday_lang_reformat_long($item->updated_at) }}
                            </td>
                        @endif

                        <td class="text-center">
                            <!-- <p class="text-body font-weight-semibold">{{ $item->status_fo }}</p> -->
                            <span
                                class="badge badge-success-100 text-success">{{ isset($item->jenis_permohonan) ? $item->jenis_permohonan : '' }}</span>
                        </td>
                        <td class="text-center">3 Hari</td>
                        <td><span class="badge badge-success-100 text-success">{{ $item->status_fo }}</span></td>
                        <td>
                            <div class="dropdown">
                                <a href="javascript:void(0)"
                                    class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                    data-toggle="dropdown">
                                    <i class="icon-menu7"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- <a href="{{ url('penomoran/baru/' . $item->id_proyek . '/' . $item->id_izin) }}" class="dropdown-item"><i class="icon-file-eye"></i>Permohonan Penomoran</a> -->
                                    @if ($item->status_izin_oss == null)
                                        <a href="javascript:void(0)" data="{{ $item->id_proyek }}"
                                            data2="{{ $item->id_izin }}" data3="{{ $item->jenis_layanan }}"
                                            class="dropdown-item triger-btn"><i class="icon-file-eye"></i>Permohonan
                                            Penomoran</a>
                                    @elseif($item->status_izin_oss == '50')
                                        <a href="{{ url('penomoran/penyesuaian/' . $item->id_proyek . '/' . $item->id_izin . '/' . $item->idtrxkodeakses) }}"
                                            class="dropdown-item"><i class="icon-file-check"></i> Penyesuaian</a>
                                        <a href="{{ url('penomoran/pengembalian/' . $item->id_proyek . '/' . $item->id_izin . '/' . $item->idtrxkodeakses) }}"
                                            class="dropdown-item"><i class="icon-file-upload"></i> Pengembalian</a>
                                    @endif
                                    @if ($item->status_checklist == '50')
                                        <a href="{{ url('penomoran/penyesuaian/' . $item->id_proyek . '/' . $item->id_izin . '/' . $item->idtrxkodeakses) }}"
                                            class="dropdown-item"><i class="icon-file-check"></i> Penyesuaian</a>
                                        <a href="{{ url('penomoran/pengembalian/' . $item->id_proyek . '/' . $item->id_izin . '/' . $item->idtrxkodeakses) }}"
                                            class="dropdown-item"><i class="icon-file-upload"></i> Pengembalian</a>
                                    @endif
                                    {{-- <a href="{{ url('pb/historyperizinanpenomoran/').'/'.$item->id_izin }}"
                                class="dropdown-item" target="_blank"><i class="icon-history"></i> Riwayat
                                Permohonan</a> --}}
                                    <a href="{{ url('log-penomoran/' . $item->id_izin) }}" class="dropdown-item"
                                        target="_blank"><i class="icon-history"></i> Riwayat Permohonan</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div id="tambahData" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('pb_submitpersyaratanip') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-indigo text-white">
                        <h6 class="modal-title">Pilih KBLI</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <div class="mb-3">
                                <p>Perizinan</p>
                                <select name="perizinan" class="form-control">
                                    <option value="">Silakan Pilih..</option>
                                    <option value="telsus">Telekomunikasi Khusus</option>
                                    <option value="penomoran">Permohonan Penomoran</option>
                                </select>
                            </div>
                            <div id="KBLItelsus" hidden>
                                <div class="mb-3">
                                    <p>KBLI</p>
                                    <select name="kbli" class="form-control">
                                        <option value="">Silakan Pilih..</option>
                                        @foreach ($kblitelsus as $kbli)
                                            <option value="{{ $kbli->id }}">{{ $kbli->name }} -
                                                {{ $kbli->desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="KBLIpenomoran" hidden>
                                <div class="mb-3">
                                    <p>KBLI</p>
                                    <select name="kbli" class="form-control">
                                        <option value="">Silakan Pilih..</option>
                                        @foreach ($kblinomor as $kblinomor)
                                            <option value="{{ $kblinomor->id }}">{{ $kblinomor->name }} -
                                                {{ $kblinomor->desc }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="jenisLayanan" hidden>
                                <div class="mb-3">
                                    <p>Jenis Layanan</p>
                                    <select class="form-control" name="jenislayanan">
                                        <option value="">Silakan Pilih..</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Buat Izin baru</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalCekPenomoran" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ url('penomoran/baru') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="vId_proyek" name="vId_proyek">
                <input type="hidden" id="vId_izin" name="vId_izin">
                <div class="modal-content">
                    <div class="modal-header bg-indigo text-white">
                        <h6 class="modal-title">Pilih Jenis Penomoran</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <div class="mb-3">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Jenis Penomoran</label>
                                    <div class="col-lg-8">
                                        <div style="position: relative;display: inline;">
                                            <select class="form-control" id="jenisnomors" name="jenisnomor">
                                                <option value="" selected hidden>Pilih jenis penomoran terlebih dulu
                                                </option>
                                            </select>
                                            <div class="mt-1 spinner-border loading text-primary" role="status"
                                                id="jenisnomor-loading">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-indigo">Cek Permohonan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#TrTable').on('click', '.triger-btn', function() {
                var id_proyek = $(this).attr('data');
                var id_izin = $(this).attr('data2');
                var jenislayanan = $(this).attr('data3');
                $("#vId_proyek").val(id_proyek);
                $("#vId_izin").val(id_izin);
                $("#modalCekPenomoran").modal("show");
                getNumber(jenislayanan)
            });

            function getNumber(JenisLayanan) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('penomoran') }}/getjenisnomor",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        data: JenisLayanan
                    }),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    beforeSend: function() {
                        $('#jenisnomor-loading').show();
                    },
                    success: function(e) {
                        var tempoption = "";
                        var tempoption =
                            "<option selected disabled>-- Pilih jenis penomoran terlebih dulu --</option>";
                        $.each(e, function(key, value) {
                            tempoption += "<option value='" + value.short_name + "'> " + value
                                .full_name + " </option>";
                        });
                        $("#jenisnomors").html(tempoption);
                        $("#jenisnomors").removeAttr("disabled");
                        $('#jenisnomor-loading').hide();
                    },
                    failure: function(errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $('select[name="perizinan"]').on('change', function() {
                var izin = $(this).val();
                // console.log(izin); 
                if (izin == 'penomoran') {
                    $('#penomoranSelect').attr('hidden', false);
                    $('#KBLIpenomoran').attr('hidden', false);
                    $('#KBLItelsus').attr('hidden', true);
                    $('#jenisLayanan').attr('hidden', false);
                    $('select[name="jenislayanan"]').val('Silakan Pilih...');
                } else if (izin == 'telsus') {
                    $('#penomoranSelect').attr('hidden', true);
                    $('#KBLIpenomoran').attr('hidden', true);
                    $('#KBLItelsus').attr('hidden', false);
                    $('#jenisLayanan').attr('hidden', false);
                    $('select[name="jenislayanan"]').val('Silakan Pilih...');
                } else {
                    $('#penomoranSelect').attr('hidden', true);
                    $('#KBLIpenomoran').attr('hidden', true);
                    $('#KBLItelsus').attr('hidden', true);
                    $('#jenisLayanan').attr('hidden', true);
                }
            });

            $('select[name="kbli"]').on('change', function() {
                var kbli = $(this).val();
                console.log(kbli)
                if (kbli) {
                    $.ajax({
                        url: 'api/getjenislayanan/' + kbli,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);

                            $('select[name="jenislayanan"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="jenislayanan"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });


                        }
                    });
                } else {
                    $('select[name="jenislayanan"]').empty();
                }
            });
        });
    </script>
@endsection
