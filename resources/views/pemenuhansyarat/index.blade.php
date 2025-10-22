@extends('layouts.frontend.main')
@section('title', 'Pemenuhan Persyaratan / '.ucwords(strtolower($kategori->name)))
@section('js')
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
    @error('message')
        <div class="alert alert-danger alert-styled-left alert-dismissible">
            <span class="font-weight-semibold">{{ $message }}.</span>
        </div>
    @endError
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
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8">
                    <h6 class="card-title font-weight-semibold py-3">Daftar Pemenuhan Persyaratan Perizinan Berusaha : <br>
                        {{ ucwords(strtolower($kategori->desc)) }} </h6>
                </div>
                <div class="col-lg-4 ml-lg-auto">
                    <button type="button" onclick="location.reload()"
                        class="btn btn-indigo btn-labeled btn-labeled-left btn-lg float-right"><b><i
                                class="icon-database-refresh"></i></b> Perbaharui Data </button>
                </div>
                @if (Auth::user()->jenis_pu != 'BH')
                    <div class="col-lg-3 ml-lg-auto">
                        <button type="button" class="btn btn-indigo btn-labeled btn-labeled-left btn-lg float-right"><b><i
                                    class="icon-file-plus"></i></b> Tambah Data Perizinan </button>
                    </div>
                @endif
            </div>

            <!-- <p><button type="button" class="btn btn-primary btn-labeled btn-labeled-left btn-lg"><b><i class="icon-pin-alt"></i></b> Large size</button></p> -->
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
        <table class="table datatable-button-init-basic" id="table">
            <thead>
                <tr>
                    <th>Izin</th>
                    {{-- <th class="text-center">Tanggal Permohonan</th> --}}
                    {{-- <th class="text-center">Batas Verifikasi</th> --}}
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
                            Jenis Layanan : {!! $item->jenis_layanan !!} <br>

                        </td>
                        {{-- <td>
                            @php
                                if ($item->status_checklist == '0') {
                                    echo 'Izin Baru';
                                } else if ($item->status_checklist == '10') {
                                    echo 'Sudah Input Persyaratan & menunggu verifikasi';
                                } else if($item->status_checklist == '50'){
                                    echo 'Izin disetujui';
                                }
                                else {
                                    echo $item->status_checklist;
                                }
                            @endphp
                        </td> --}}
                        <td>
                            <div class="dropdown">
                                <a href="javascript:void(0)"
                                    class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
                                    data-toggle="dropdown">
                                    <i class="icon-menu7"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ url('pb/pemenuhan-persyaratan/').'/'.$item->id_izin }}" class="dropdown-item"><i class="icon-file-upload"></i> Pemenuhan
                                        Persyaratan</a>
                                    {{-- <a href="javascript:void(0)" class="dropdown-item"><i class="icon-file-pdf"></i> Riwayat Permohonan</a> --}}
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
        </table>
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
@endsection

@section('custom-js')
    <script>
        $('#table').datatables();
    </script>
@endsection