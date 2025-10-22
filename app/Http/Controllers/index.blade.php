@extends('layouts.frontend.main')
@section('title', $kategori->name)
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnReset').hide();
        });
    </script>
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script>

    <script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="/global_assets/js/kominfo/form_option_kominfo.js"></script>
    <script src="/global_assets/js/demo_pages/form_select2.js"></script>

@endsection
@section('content')
    <!-- Quick stats boxes -->
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Sorry!</strong> There were more problems with your HTML input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            Persyaratan telah dikirim harap menunggu proses verifikasi, Terima kasih.
        </div>
    @endif
    {{-- @if ($user->jenis_pu == 'NBH' && $status_evaluasi != '1') --}}
    @if (Auth::user()->jenis_pu == 'NPT' && $status_evaluasi != '1')
        <div class="alert alert-warning alert-block">

            <strong>Akun Anda belum terverifikasi, Sebelum mengajukan permohonan pernomoran pastikan Anda harus melengkapi
                Kelengkapan Data Penanggung Jawab dan Data Instansi</strong>

        </div>
    @elseif($status_evaluasi != '1')
        <div class="alert alert-warning alert-block">

            <strong>Akun Anda belum terverifikasi, Sebelum mengajukan permohonan perizinan pastikan Anda harus melengkapi
                Kelengkapan Data Penanggung Jawab dan Data Badan Hukum / Instansi</strong>

        </div>
    @endif


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8">
                    <h6 class="card-title font-weight-semibold py-3">{{ ucwords(strtolower($kategori->desc)) }} </h6>
                </div>
                {{-- <div class="d-inline-flex align-items-center ml-auto">
                    <div class="dropdown ml-2">
                        <a href="javascript:void(0)"
                            class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                            data-toggle="dropdown">
                            <i class="icon-more2"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"></a>
                            <td><button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#tambahData">
                                    @if (Auth::user()->jenis_pu == 'NPT')
                                        Permohonan Penomoran
                                    @else
                                        Tambah Data Perizinan
                                    @endif
                                    <i class="icon-file-plus mr-2"></i>
                                </button></td>
                        </div>
                    </div>
                </div> --}}
            </div>

        </div>
        @if (session('message'))
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="card-body">
            <div class="table-responsive border-top-0">
                <table class="table text-nowrap datatable-button-init-basic" id="table">
                    <thead>
                        <tr>
                            <th>Permohonan</th>
                            <th class="text-center">Tanggal Permohonan</th>
                            <th class="text-center">Batas Verifikasi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izin as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <a class="text-body font-weight-semibold"
                                                href="javascript:void(0)">{{ $item['id_izin'] }}</a>
                                            <div class="text-muted font-size-sm">{{ $item['kbli'] }} -
                                                {{ $item['jenis_izin'] }}
                                            </div>
                                            <div class="text-muted font-size-sm">{!! $item['jenis_layanan_html'] !!}</div>
                                            <div class="text-muted font-size-sm">{{ $item['id_proyek'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                @if (!isset($item['updated_at']))
                                    <td class="text-center"> - </td>
                                @else
                                    <td class="text-center">
                                        {{ $date_reformat->dateday_lang_reformat_long($item['updated_at']) }}
                                    </td>
                                @endif
                                <td class="text-center"><span
                                        class="badge badge-success-100 text-success">{{ $item->batas_verifikasi }}</span>
                                </td>
                                <td><span class="badge badge-success-100 text-success">{{ $item->status_fo }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <a href="javascript:void(0)"
                                            class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                            data-toggle="dropdown">
                                            <i class="icon-menu7"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($item['jenis_perizinan'] != 'K03')
                                                @if ($item['status_checklist'] == '00')
                                                    <a href="{{ url('pb/pemenuhan-persyaratan/') . '/' . $item->id_izin }}"
                                                        class="dropdown-item"><i class="icon-file-upload"></i> Pemenuhan
                                                        Persyaratan</a>
                                                @elseif($item['status_checklist'] == '43')
                                                    <a href="{{ url('pb/koreksi-persyaratan/') . '/' . $item->id_izin }}"
                                                        class="dropdown-item"><i class="icon-pencil"></i> Perbaikan
                                                        Persyaratan</a>
                                                @elseif($item['status_checklist'] == '51')
                                                    <a href="{{ url('pb/exnted-izinprinsip/') . '/' . $item->id_izin }}"
                                                        class="dropdown-item"><i class="icon-plus"></i> Perpanjangan Izin
                                                        Prinsip</a>
                                                    <a href="{{ url('pb/pemenuhan-persyaratan/ip') . '/' . $item->id_izin }}"
                                                        class="dropdown-item"><i class="icon-plus"></i> Pengajuan Uji Laik
                                                        Operasi</a>
                                                @elseif($item['status_checklist'] == '01')
                                                    <a href="{{ url('pb/pemenuhan-persyaratan/') . '/' . $item->id_izin }}"
                                                        class="dropdown-item"><i class="icon-pencil"></i> Pemenuhan
                                                        Persyaratan</a>
                                                @endif
                                                @if ($item['layanan_penomoran'] == '1')
                                                    <a href="javascript:void(0)" data2="{{ $item->id_izin }}"
                                                        data3="{{ $item->jenis_layanan }}"
                                                        class="dropdown-item triger-btn"><i
                                                            class="icon-file-eye"></i>Permohonan
                                                        Penomoran</a>
                                                @endif
                                                <a href="{{ url('pb/historyperizinan/') . '/' . $item->id_izin }}"
                                                    class="dropdown-item" target="_blank"><i class="icon-history"></i>
                                                    Riwayat Permohonan</a>
                                                @if ($item['status_checklist'] == '10')
                                                    <a href="{{ url('komitmen/penyesuaian') . '/' . $item->id_izin }}"
                                                        class="dropdown-item" target="_blank"><i class="icon-history"></i>
                                                        Penyesuaian Komitmen</a>
                                                @endif
                                            @else
                                                @if ($item['layanan_penomoran'] == '1')
                                                    <a href="{{ url('/penomoran/') . '/' . $item->id_izin }}"
                                                        class="dropdown-item"><i class="icon-file-upload"></i> Permohonan
                                                        Kode
                                                        Akses</a>
                                                @else
                                                    <a href="{{ url('/') }}" class="dropdown-item"><i
                                                            class="icon-file-upload"></i> Pemenuhan Persyaratan</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- <table class="table datatable-button-init-basic" id="table">
                                                                                                                                                                                                                        <thead>
                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                <th>Permohonan</th>
                                                                                                                                                                                                                                <th class="text-center">Status</th>
                                                                                                                                                                                                                                <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                        </thead>
                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                            @foreach ($izin as $item)
    <tr>
                                                                                                                                                                                                                                    <td>
                                                                                                                                                                                                                                        KBLI : {{ $item->kbli }} <br>
                                                                                                                                                                                                                                        Id Proyek : {{ $item->id_proyek }} <br>
                                                                                                                                                                                                                                        Kode Izin : {{ $item->id_izin }} <br>
                                                                                                                                                                                                                                        Jenis Izin : {{ $item->jenis_izin }} <br>
                                                                                                                                                                                                                                        Jenis Layanan : {{ $item->jenis_layanan }} <br>

                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                    <td>
                                                                                                                                                                                                                                        @php
                                                                                                                                                                                                                                            echo $item->status_fo;
                                                                                                                                                                                                                                        @endphp
                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                    <td>
                                                                                                                                                                                                                                        <div class="dropdown">
                                                                                                                                                                                                                                            <a href="javascript:void(0)"
                                                                                                                                                                                                                                                class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                                                                                                                                                                                                                                data-toggle="dropdown">
                                                                                                                                                                                                                                                <i class="icon-menu7"></i>
                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                                                                                                                                {{-- <a href="{{ url('pb/pemenuhan-persyaratan/').'/'.$item->id_izin }}" class="dropdown-item"><i class="icon-file-upload"></i> Pemenuhan
                                        Persyaratan</a> --}}
                                                                                                                                                                                                                                                <a href="javascript:void(0)" class="dropdown-item"><i class="icon-file-pdf"></i> Riwayat Permohonan</a>
                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                </tr>
    @endforeach
                                                                                                                                                                                                                            {{-- <tr>
					<td>
						<div class="d-flex align-items-center">
							<div>
								<a href="javascript:void(0)" class="text-body font-weight-semibold">CA122021003</a>
								<div class="text-muted font-size-sm">IZIN PENYELENGGARAAN TELEKOMUNIKASI KHUSUS UNTUK KEPERLUAN BADAN HUKUM</div>
								<div class="text-muted font-size-sm">61992 - Aktivitas Telekomunikasi Khusus Untuk Keperluan Sendiri</div>
								<div class="text-muted font-size-sm">Aktivitas Telekomunikasi Khusus Untuk Keperluan</div>
							</div>
						</div>
					</td>
					<td class="text-center">12 Januari 2022</td>
					<td class="text-center">3 Hari</td>
					<td class="text-center"><span class="badge badge-success-100 text-success">Menunggu Hasil Evaluasi</span></td>
					<td class="text-center">
						<div class="dropdown">
							<a href="javascript:void(0)" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
								<i class="icon-menu7"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a href="javascript:void(0)" class="dropdown-item"><i class="icon-file-eye"></i> Informasi Perizinan</a>
								<a href="javascript:void(0)" class="dropdown-item"><i class="icon-file-pdf"></i> Riwayat Permohonan</a>
							</div>
						</div>
					</td>
				</tr>
                <tr>
					<td>
						<div class="d-flex align-items-center">
							<div>
								<a href="javascript:void(0)" class="text-body font-weight-semibold">CX122021002</a>
								<div class="text-muted font-size-sm">IZIN PENYELENGGARAAN TELEKOMUNIKASI KHUSUS UNTUK KEPERLUAN BADAN HUKUM</div>
								<div class="text-muted font-size-sm">61992 - Aktivitas Telekomunikasi Khusus Untuk Keperluan Sendiri</div>
								<div class="text-muted font-size-sm">Aktivitas Telekomunikasi Khusus Untuk Keperluan</div>
							</div>
						</div>
					</td>
					<td class="text-center">11 Januari 2022</td>
					<td class="text-center">3 Hari</td>
					<td class="text-center"><span class="badge badge-success-100 text-success">Selesai</span></td>
					<td class="text-center">
						<div class="dropdown">
							<a href="javascript:void(0)" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
								<i class="icon-menu7"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a href="javascript:void(0)" class="dropdown-item"><i class="icon-file-eye"></i> Informasi Perizinan</a>
								<a href="javascript:void(0)" class="dropdown-item"><i class="icon-file-pdf"></i> Riwayat Permohonan</a>
							</div>
						</div>
					</td>
				</tr> --}}
                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                    </table> -->
    </div>

    <!-- Modal -->
    <div id="modal_theme_primary" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-indigo text-white">
                    <h6 class="modal-title">Pilih KBLI</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <div class="mb-3">
                            <p>Perizinan</p>
                            <select class="form-control select-data-array-jenisperizinan" data-fouc></select>
                        </div>
                        <div class="mb-3">
                            <p>KBLI</p>
                            <select class="form-control select-data-array-kbli" data-fouc></select>
                        </div>
                        <div class="mb-3">
                            <p>Jenis Layanan</p>
                            <select class="form-control select-data-array-jenislayanan" data-fouc>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Buat Izin baru</button>
                </div>
            </div>
        </div>
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
                            <div class="KBLItelsus" hidden>
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
    <div id="tambahDataIzin" class="modal fade" tabindex="-1">
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
                                    <option value="jasa">IZIN PENYELENGGARAAN JASA TELEKOMUNIKASI</option>
                                    <option value="jaringan">IZIN PENYELENGGARAAN JARINGAN TELEKOMUNIKASI</option>
                                    <option value="telsus">IZIN PENYELENGGARAAN TELEKOMUNIKASI KHUSUS BADAN HUKUM</option>
                                    <option value="telsusip">IZIN PENYELENGGARAAN TELEKOMUNIKASI KHUSUS INSTANSI PEMERINTAH
                                    </option>
                                    {{-- <option value="telsus">IZIN PENYELENGGARAAN PENOMORAN TELEKOMUNIKASI NON PENYELENGGARA</option> --}}
                                </select>
                            </div>
                            <div id="KBLIjasa" hidden>
                                <div class="mb-3">
                                    <p>KBLI</p>
                                    <select name="kbli" class="form-control">
                                        <option value="">Silakan Pilih..</option>
                                        @foreach ($kblijasa as $kbliJasa)
                                            <option value="{{ $kbliJasa->id }}">{{ $kbliJasa->name }} -
                                                {{ $kbliJasa->desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="KBLIjaringan" hidden>
                                <div class="mb-3">
                                    <p>KBLI</p>
                                    <select name="kbli" class="form-control">
                                        <option value="">Silakan Pilih..</option>
                                        @foreach ($kblijaringan as $kbliJaringan)
                                            <option value="{{ $kbliJaringan->id }}">{{ $kbliJaringan->name }} -
                                                {{ $kbliJaringan->desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="KBLItelsus" hidden>
                                <div class="mb-3">
                                    <p>KBLI</p>
                                    <select name="kbli" class="form-control">
                                        <option value="">Silakan Pilih..</option>
                                        @foreach ($kblitelsus as $kbliTelsus)
                                            <option value="{{ $kbliTelsus->id }}">{{ $kbliTelsus->name }} -
                                                {{ $kbliTelsus->desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="KBLItelsusip" hidden>
                                <div class="mb-3">
                                    <p>KBLI</p>
                                    <select name="kbli" class="form-control">
                                        <option value="">Silakan Pilih..</option>
                                        @foreach ($kblitelsusip as $kbliTelsusip)
                                            <option value="{{ $kbliTelsusip->id }}">{{ $kbliTelsusip->name }} -
                                                {{ $kbliTelsusip->desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div id="KBLIpenomoran" hidden>
                                <div class="mb-3">
                                    <p>KBLI</p>
                                    <select name="kbli" class="form-control">
                                        <option value="">Silakan Pilih..</option>
                                        @foreach ($kblinomor as $kbliNomor)
                                            <option value="{{ $kbliNomor->id }}">{{ $kbliNomor->name }} -
                                                {{ $kbliNomor->desc }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div id="jenisLayanan">
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
@endsection

@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_get_by_date_jasa').submit(function(e) {
                e.preventDefault();

                $('#btnSubmit').val("Mencari ...");


                var formData = new FormData(this);

                // console.log(formData)
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/pb/get_by_date_jasa') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        table = $('#table').DataTable({
                            destroy: true,
                            data: data,
                            columns: [{
                                    data: null,
                                    render: function(data, type, row) {
                                        // Combine the first and last names into a single table field
                                        var view =
                                            "<div class='d-flex align-items-center'><div><a class='text-body font-weight-semibold' href='javascript:void(0)'>" +
                                            data.id_izin +
                                            "</a><div class='text-muted font-size-sm'>" +
                                            data.kbli + " - " + data
                                            .jenis_izin +
                                            "</div><div class='text-muted font-size-sm'>" +
                                            data.jenis_layanan +
                                            "</div><div class='text-muted font-size-sm'>" +
                                            data.id_proyek +
                                            "</div></div></div>"
                                        return view;
                                    },
                                    editField: ['id_izin', 'jenis_izin', 'kbli',
                                        'jenis_layanan_html', 'id_proyek'
                                    ]
                                },
                                {
                                    data: 'status_fo',
                                    "render": function(data, type, row) {
                                        var button =
                                            "<span class='badge badge-success-100 text-success'>" +
                                            data + "</spam>"
                                        return button;
                                    },
                                },
                                {
                                    data: 'id_izin',
                                    "render": function(data, type, row) {
                                        var button =
                                            "<div class='dropdown'><a href='javascript:void(0)' class='btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill' data-toggle='dropdown'> <i class='icon-menu7'></i></a> <div class='dropdown-menu dropdown-menu-right'> <a href='{{ url('pb/pemenuhan-persyaratan/') }}/" +
                                            data +
                                            "' class='dropdown-item'><i class='icon-file-upload'></i> Pemenuhan  Persyaratan</a> <a href='{{ url('pb/historyperizinan/') }}/" +
                                            data +
                                            "' class='dropdown-item' target='_blank'><i class='icon-history'></i> Riwayat Permohonan</a> </div> </div>"
                                        return button;
                                    },
                                }
                            ],
                            "order": [
                                [1, 'asc']
                            ]
                        });
                        $('#btnReset').show();
                        $('#btnSubmit').val("Cari");

                    },
                    error: function(data) {
                        console.log(data);

                    }
                });
            });

            $('#form_get_by_date_jaringan').submit(function(e) {
                e.preventDefault();

                $('#btnSubmit').val("Mencari ...");


                var formData = new FormData(this);

                // console.log(formData)
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/pb/get_by_date_jaringan') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        table = $('#table').DataTable({
                            destroy: true,
                            data: data,
                            columns: [{
                                    data: null,
                                    render: function(data, type, row) {
                                        // Combine the first and last names into a single table field
                                        var view =
                                            "<div class='d-flex align-items-center'><div><a class='text-body font-weight-semibold' href='javascript:void(0)'>" +
                                            data.id_izin +
                                            "</a><div class='text-muted font-size-sm'>" +
                                            data.kbli + " - " + data
                                            .jenis_izin +
                                            "</div><div class='text-muted font-size-sm'>" +
                                            data.jenis_layanan +
                                            "</div><div class='text-muted font-size-sm'>" +
                                            data.id_proyek +
                                            "</div></div></div>"
                                        return view;
                                    },
                                    editField: ['id_izin', 'jenis_izin', 'kbli',
                                        'jenis_layanan_html', 'id_proyek'
                                    ]
                                },
                                {
                                    data: 'status_fo',
                                    "render": function(data, type, row) {
                                        var button =
                                            "<span class='badge badge-success-100 text-success'>" +
                                            data + "</spam>"
                                        return button;
                                    },
                                },
                                {
                                    data: 'id_izin',
                                    "render": function(data, type, row) {
                                        var button =
                                            "<div class='dropdown'><a href='javascript:void(0)' class='btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill' data-toggle='dropdown'> <i class='icon-menu7'></i></a> <div class='dropdown-menu dropdown-menu-right'> <a href='{{ url('pb/pemenuhan-persyaratan/') }}/" +
                                            data +
                                            "' class='dropdown-item'><i class='icon-file-upload'></i> Pemenuhan  Persyaratan</a> <a href='{{ url('pb/historyperizinan/') }}/" +
                                            data +
                                            "' class='dropdown-item' target='_blank'><i class='icon-history'></i> Riwayat Permohonan</a> </div> </div>"
                                        return button;
                                    },
                                }
                            ],
                            "order": [
                                [1, 'asc']
                            ]
                        });
                        $('#btnReset').show();
                        $('#btnSubmit').val("Cari");

                    },
                    error: function(data) {
                        console.log(data);

                    }
                });
            });

            $('select[name="perizinan"]').on('change', function() {
                var izin = $(this).val();
                console.log(izin);
                if (izin == 'penomoran') {
                    $('#penomoranSelect').attr('hidden', false);
                    $('#KBLIpenomoran').attr('hidden', false);
                    $('#KBLIjasa').attr('hidden', true);
                    $('#KBLIjaringan').attr('hidden', true);
                    $('.KBLItelsus').attr('hidden', true);
                    $('#KBLItelsusip').attr('hidden', true);
                    $('#jenisLayanan').attr('hidden', false);
                    $('select[name="jenislayanan"]').val('Silakan Pilih...');
                } else if (izin == 'jasa') {
                    $('#penomoranSelect').attr('hidden', true);
                    $('#KBLIpenomoran').attr('hidden', true);
                    $('#KBLIjasa').attr('hidden', false);
                    $('#KBLIjaringan').attr('hidden', true);
                    $('.KBLItelsus').attr('hidden', true);
                    $('#KBLItelsusip').attr('hidden', true);
                    $('#jenisLayanan').attr('hidden', false);
                    $('select[name="jenislayanan"]').val('Silakan Pilih...');
                } else if (izin == 'jaringan') {
                    $('#penomoranSelect').attr('hidden', true);
                    $('#KBLIpenomoran').attr('hidden', true);
                    $('#KBLIjasa').attr('hidden', true);
                    $('#KBLIjaringan').attr('hidden', false);
                    $('.KBLItelsus').attr('hidden', true);
                    $('#KBLItelsusip').attr('hidden', true);
                    $('#jenisLayanan').attr('hidden', false);
                    $('select[name="jenislayanan"]').val('Silakan Pilih...');
                } else if (izin == 'telsus') {
                    $('#penomoranSelect').attr('hidden', true);
                    $('#KBLIpenomoran').attr('hidden', true);
                    $('#KBLIjasa').attr('hidden', true);
                    $('#KBLIjaringan').attr('hidden', true);
                    $('.KBLItelsus').attr('hidden', false);
                    $('#KBLItelsusip').attr('hidden', true);
                    $('#jenisLayanan').attr('hidden', false);
                    $('select[name="jenislayanan"]').val('Silakan Pilih...');
                } else if (izin == 'telsusip') {
                    $('#penomoranSelect').attr('hidden', true);
                    $('#KBLIpenomoran').attr('hidden', true);
                    $('#KBLIjasa').attr('hidden', true);
                    $('#KBLIjaringan').attr('hidden', true);
                    $('.KBLItelsus').attr('hidden', true);
                    $('#KBLItelsusip').attr('hidden', false);
                    $('#jenisLayanan').attr('hidden', false);
                    $('select[name="jenislayanan"]').val('Silakan Pilih...');
                } else {
                    $('#penomoranSelect').attr('hidden', true);
                    $('#KBLIpenomoran').attr('hidden', true);
                    $('#KBLIjasa').attr('hidden', true);
                    $('#KBLIjaringan').attr('hidden', true);
                    $('.KBLItelsus').attr('hidden', true);
                    $('#KBLItelsusip').attr('hidden', true);
                    $('#jenisLayanan').attr('hidden', true);
                }
            });

            $('select[name="kbli"]').on('change', function() {
                var kbli = $(this).val();
                console.log(kbli)
                if (kbli) {
                    $.ajax({
                        url: '/api/getjenislayanan/' + kbli,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // console.log(url);
                            // console.log(data);
                            // $('select[name="jenislayanan"]').attr('hidden', false);
                            $('select[name="jenislayanan"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="jenislayanan"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .name + '</option>');
                                console.log(value.id + ": " + value.name);
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
