@extends('layouts.frontend.main')
@section('title', 'Dashboard')
@section('js')

	{{-- <script src="/assets/js/app.js"></script> --}}
	{{-- <script src="/global_assets/js/main/jquery.min.js"></script>
<script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<link rel="stylesheet" href="/global_assets/css/extras/jquery-ui.css">
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/global_assets/js/demo_pages/datatables_basic.js"></script>
<script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script> --}}
	{{-- <script type="text/javascript" src="/global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script>
--}}

	{{-- <script src="global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script> --}}
	{{-- <script src="global_assets/js/plugins/notifications/sweet_alert.min.js"></script> --}}
	{{-- <script src="global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script> --}}

	{{-- <script src="global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script> --}}
	{{-- <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script> --}}

	{{-- <script src="global_assets/js/kominfo/form_option_kominfo.js"></script> --}}
	{{-- <script src="global_assets/js/demo_pages/form_select2.js"></script> --}}

	{{-- <script src="global_assets/js/demo_pages/components_popups.js"></script> --}}

	<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	{{-- <script src="/global_assets/js/extras/dataTables.dateTime.min.js"></script> --}}
	{{-- <script src="/global_assets/js/extras/moment.min.js"></script> --}}
	<!-- <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script> -->

	{{-- <script type="text/javascript">
	$(document).ready(function() {
			$('#btnReset').hide();

			// var minDate, maxDate;

			// // Custom filtering function which will search data in column four between two values
			// $.fn.dataTable.ext.search.push(
			// 	function( settings, data, dataIndex ) {
			// 		var min = minDate.val();
			// 		var max = maxDate.val();


			// 		console.log(moment(min, "DD-MM-YYYY").format('DD MMM YYYY'));
			// 		console.log("========")		
			// 		console.log(moment(max, "DD-MM-YYYY").format('DD MMM YYYY'));
			// 		var date = new Date( data[1] );

			// 		if (
			// 			( moment(min, "DD-MM-YYYY").format('DD MMM YYYY') === null && moment(max, "DD-MM-YYYY").format('DD MMM YYYY') === null ) ||
			// 			( moment(min, "DD-MM-YYYY").format('DD MMM YYYY') === null && date <= moment(max, "DD-MM-YYYY").format('DD MMM YYYY') ) ||
			// 			( moment(min, "DD-MM-YYYY").format('DD MMM YYYY') <= date   && moment(max, "DD-MM-YYYY").format('DD MMM YYYY') === null ) ||
			// 			( moment(min, "DD-MM-YYYY").format('DD MMM YYYY') <= date   && date <= moment(max, "DD-MM-YYYY").format('DD MMM YYYY') )
			// 		) {
			// 			return true;
			// 		}
			// 		return false;
			// 	}
			// );
			// // Create date inputs
			// minDate = new DateTime($('#min'), {
			// 	format: 'DD-MM-YYYY'
			// });
			// maxDate = new DateTime($('#max'), {
			// 	format: 'DD-MM-YYYY'
			// });

			// // DataTables initialisation
			// var table = $('#table').DataTable();

			// // Refilter the table
			// $('#min, #max').on('change', function () {
			// 	table.draw();
			// });
		});
</script> --}}

@endsection
@section('content')
	<div class="row">
		<div class="col-lg">
			<!-- Members online -->
			<div class="card bg-primary text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ $proses }}</h3>
						{{-- <a href="javascript:void(0)"
						class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>/ --}}
					</div>

					<div>
						<div class="font-size-sm opacity-75">Permohonan Dalam Proses</div>
					</div>
				</div>
				<!-- /members online -->
			</div>

		</div>
		<!-- /quick stats boxes -->

		<div class="col-lg">
			<!-- Members online -->
			<div class="card bg-success text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ $done }}</h3>
						{{-- <a href="javascript:void(0)"
						class="badge badge-dark badge-pill align-self-center ml-auto">baru</a> --}}
					</div>

					<div>
						<div class="font-size-sm opacity-75">Permohonan Selesai</div>
					</div>
				</div>
			</div>
			<!-- /members online -->
		</div>
	</div>
	<!-- /quick stats boxes -->

	@if (Session::get('message') != '')
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif

	@if (Auth::user()->jenis_pu == 'NPT' && $status_evaluasi != '1')
		<div class="alert alert-warning alert-block">
			<strong>{{ $status_evaluasi_msg }}</strong>
		</div>
	@elseif($status_evaluasi != '1')
		<div class="alert alert-warning alert-block">
			<strong>{{ $status_evaluasi_msg }}</strong>
		</div>
	@endif
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-lg-8">
					<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Dalam Proses</h6>
				</div>
				<div class="d-inline-flex align-items-center ml-auto">
					<div class="dropdown ml-2">
						@if ($status_evaluasi == '0')
							@if (Auth::user()->jenis_pu == 'NPT')
								<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#" data-popup="tooltip"
										title="Akun Anda belum terverifikasi" data-placement="left">Permohonan
										Penomoran <i class="icon-file-plus mr-2"></i></button></td>
							@elseif (Auth::user()->jenis_pu == 'PTB')
								<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#" data-popup="tooltip"
										title="Akun Anda belum terverifikasi" data-placement="left">Tambah
										Permohonan Izin <i class="icon-file-plus mr-2"></i></button>
								</td>
								<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#" data-popup="tooltip"
										title="Akun Anda belum terverifikasi" data-placement="left">Permohonan
										Penomoran <i class="icon-file-plus mr-2"></i></button>
								</td>
							@elseif (Auth::user()->jenis_pu == 'TKB')
								<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#" data-popup="tooltip"
										title="Akun Anda belum terverifikasi" data-placement="left">Tambah
										Permohonan Izin <i class="icon-file-plus mr-2"></i></button>
								</td>
							@elseif (Auth::user()->jenis_pu == 'TKI')
								<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#" data-popup="tooltip"
										title="Akun Anda belum terverifikasi" data-placement="left">Tambah
										Permohonan Izin <i class="icon-file-plus mr-2"></i></button>
								</td>
							@endif
						@else
							@if (Auth::user()->jenis_pu == 'NPT' && $status_evaluasi == '1')
								<td><button type="button" class="btn btn-secondary" data-toggle="dropdown">Permohonan
										Penomoran <i class="icon-file-plus mr-2"></i></button></td>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="{{ url('/penomoran/barunpt') }}" class="dropdown-item"><i class="icon-database-add"></i> Nomor Baru</a>
									<a href="{{ url('/penomoran/addnpt') }}" class="dropdown-item"><i class="icon-database-insert"></i> Nomor
										Tambahan</a>
									<a href="{{ url('/penomoran/penyesuaiannpt') }}" class="dropdown-item"><i class="icon-database-diff"></i>
										Perubahan Penetapan</a>
									<a href="{{ url('/penomoran/pengembaliannpt') }}" class="dropdown-item"><i class="icon-database-remove"></i>
										Pengembalian
										Nomor</a>
								</div>
							@elseif (Auth::user()->jenis_pu == 'PTB' && $status_evaluasi == '1')
								<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahData">Tambah
										Permohonan Izin <i class="icon-file-plus mr-2"></i></button></td>
								<td><button type="button" class="btn btn-secondary" data-toggle="dropdown">Permohonan
										Penomoran <i class="icon-file-plus mr-2"></i></button></td>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="{{ url('/penomoran/baru') }}" class="dropdown-item"><i class="icon-database-add"></i>
										Nomor Baru</a>
									<a href="{{ url('/penomoran/add') }}" class="dropdown-item"><i class="icon-database-insert"></i>
										Nomor
										Tambahan</a>
									<a href="{{ url('/penomoran/penyesuaian') }}" class="dropdown-item"><i class="icon-database-diff"></i>
										Perubahan Penetapan</a>
									<a href="{{ url('/penomoran/pengembalian') }}" class="dropdown-item"><i class="icon-database-remove"></i>
										Pengembalian
										Nomor</a>
								</div>
								</td>
							@elseif (Auth::user()->jenis_pu == 'TKB' && $status_evaluasi == '1')
								<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahData">Tambah
										Permohonan <i class="icon-file-plus mr-2"></i></button></td>
							@elseif (Auth::user()->jenis_pu == 'TKI' && $status_evaluasi == '1')
								<td><button type="button" class="btn btn-secondary" data-toggle="modal"
										data-target="#tambahData_nomor">Tambah Permohonan <i class="icon-file-plus mr-2"></i></button></td>
							@endif
						@endif
					</div>
				</div>
			</div>

		</div>

		<div class="table-responsive border-top-0">

			<table class="table text-nowrap datatable-button-init-basic" id="table">
				<thead>
					<tr>
						<th>Permohonan</th>
						<th class="text-center">Tanggal Permohonan</th>
						<th class="text-center">Status</th>
						<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
					</tr>
				</thead>
				<tbody id="tBoodyDataAll">
					@foreach ($izin as $item)
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div>
										<a class="text-body font-weight-semibold" href="javascript:void(0)">{{ $item['id_izin'] }}</a>
										@if (Auth::user()->jenis_pu == 'NPT' && $status_evaluasi == '1')
											<div class="text-muted font-size-sm">{{ $item['jenis_permohonan'] }}</div>
											<div class="text-muted font-size-sm">{!! $item['jenis_kode_akses'] !!}</div>
											<div class="text-muted font-size-sm">Kode Akses :
												{{ isset($item->kode_akses) ? $item->kode_akses : '-' }}
											</div>
										@elseif (Auth::user()->jenis_pu == 'PTP' && $status_evaluasi == '1')
											<div class="text-muted font-size-sm">{{ $item['jenis_izin'] }}</div>
											<div class="text-muted font-size-sm">{!! $item['jenis_layanan_html'] !!}</div>
										@elseif (Auth::user()->jenis_pu == 'TKI' && $status_evaluasi == '1')
											<div class="text-muted font-size-sm">{{ $item['kbli'] }} -
												{{ $item['jenis_izin'] }}</div>
											<div class="text-muted font-size-sm">{!! $item['jenis_layanan_html'] !!}</div>
										@else
											@if ($item['jenis_perizinan'] == '02')
												<div class="text-muted font-size-sm">{{ $item['kbli'] }} -
													{{ $item['jenis_izin'] }}</div>
												<div class="text-muted font-size-sm">{!! $item['jenis_layanan_html'] !!}</div>
											@elseif ($item['jenis_perizinan'] == 'K02')
												<div class="text-muted font-size-sm">{{ $item['kbli'] }} -
													{{ $item['jenis_izin'] }}</div>
												<div class="text-muted font-size-sm">{!! $item['jenis_layanan_html'] !!}</div>
											@else
												<div class="text-muted font-size-sm">{{ $item['jenis_permohonan'] }}</div>
												<div class="text-muted font-size-sm">{!! $item['jenis_kode_akses'] !!}</div>
												<div class="text-muted font-size-sm">Kode Akses :
													{{ isset($item->kode_akses) ? $item->kode_akses : '-' }}
												</div>
											@endif
										@endif
										{{-- <div class="text-muted font-size-sm">{{ $item['id_proyek'] }}</div> --}}
									</div>
								</div>
							</td>
							@if (!isset($item['updated_at']))
								<td class="text-center"> - </td>
							@else
								<td class="text-center">
									{{ $date_reformat->dateday_lang_reformat_long($item['updated_at']) }}</td>
							@endif
							<td class="text-center"><span class="badge badge-success-100 text-success">{{ $item->status_fo }}</span></td>
							<td>
								<div class="dropdown">
									<a href="javascript:void(0)"
										class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
										data-toggle="dropdown">
										<i class="icon-menu7"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right">

										@if ($item['jenis_perizinan'] != 'K03')
											@if (
												$item['status_checklist'] == '00' ||
													$item['status_checklist'] == '02' ||
													$item['status_checklist'] == '03' ||
													$item['status_checklist'] == '04')
												<a href="{{ url('pb/pemenuhan-persyaratan/') . '/' . $item->id_izin }}" class="dropdown-item"><i
														class="icon-file-upload"></i> Pemenuhan
													Persyaratan</a>
											@elseif($item['status_checklist'] == '43')
												<a href="{{ url('pb/koreksi-persyaratan/') . '/' . $item->id_izin }}" class="dropdown-item"><i
														class="icon-pencil"></i> Perbaikan
													Persyaratan</a>
											@elseif($item['status_checklist'] == '51')
												@if ($item['kd_izin'] !== '059000030066')
													<a href="{{ url('pb/exnted-izinprinsip/') . '/' . $item->id_izin }}" class="dropdown-item"><i
															class="icon-plus"></i> Perpanjangan Izin
														Prinsip</a>
												@endif
												<a href="{{ url('pb/pemenuhan-persyaratan/ip') . '/' . $item->id_izin }}" class="dropdown-item"><i
														class="icon-plus"></i> Pengajuan Uji Laik
													Operasi</a>
												@if ($item['notallowed_return'] != '1')
													<a href="{{ url('pb/pemenuhan-persyaratan/ipreturn') . '/' . $item->id_izin }}" class="dropdown-item"><i
															class="icon-plus"></i> Pengajuan Pengembalian Izin
														Prinsip</a>
												@endif
											@elseif($item['status_checklist'] == '10' && $item['kd_izin'] == '059000020066')
												<a href="{{ url('ulo/pengajuan-ulo') . '/' . $item->id_izin }}" class="dropdown-item"><i
														class="icon-plus"></i> Pengajuan Tanggal Uji
													Laik
													Operasi</a>
											@elseif($item['status_checklist'] == '01')
												<a href="{{ url('pb/pemenuhan-persyaratan/') . '/' . $item->id_izin }}" class="dropdown-item"><i
														class="icon-pencil"></i> Pemenuhan
													Persyaratan</a>
											@endif
											<a href="{{ url('pb/historyperizinan/') . '/' . $item->id_izin }}" class="dropdown-item"
												target="_blank"><i class="icon-history"></i>
												Riwayat Permohonan</a>
											@if (
												($item['status_checklist'] == '50' || $item['status_checklist'] == '51') &&
													$item['status_penyesuaian'] == null &&
													$item['status_komitmen'] == 0 &&
													$item['kd_izin'] != '059000010066')
												<a href="{{ url('komitmen/perubahan') . '/' . $item->id_izin }}" class="dropdown-item" target="_blank"><i
														class="icon-history"></i>
													Perubahan Komitmen</a>
											@elseif (
												($item['status_checklist'] == '50' || $item['status_checklist'] == '51') &&
													$item['status_penyesuaian'] == null &&
													$item['status_komitmen'] == 1)
												<a href="{{ url('komitmen/penyesuaian') . '/' . $item->id_izin }}" class="dropdown-item"
													target="_blank"><i class="icon-history"></i>
													Penyesuaian Komitmen</a>
											@endif
										@else
											@if ($item['jenis_perizinan'] == 'K03' && $item['status_checklist'] == '00')
												<a href="{{ url('/penomoran/') . '/' . $item->id_izin }}" class="dropdown-item"><i
														class="icon-file-upload"></i> Permohonan Kode
													Akses</a>
											@elseif ($item['jenis_perizinan'] == 'K03')
												<a href="{{ url('penomoran/evaluasi-penomoran') . '/' . $item->id_izin }}" class="dropdown-item"><i
														class="icon-history"></i> Detail
													Permohonan</a>
											@elseif($item['status_checklist'] == '10')
												<a href="{{ url('ulo/pengajuan-ulo') . '/' . $item->id_izin }}" class="dropdown-item"><i
														class="icon-plus"></i> Pengajuan Tanggal Uji
													Laik
													Operasi</a>
											@else
												<a href="{{ url('pb/historyperizinan/') . '/' . $item->id_izin }}" class="dropdown-item"
													target="_blank"><i class="icon-history"></i>
													Riwayat Permohonan</a>
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
	</div>
	{{-- </div> --}}

	<div id="tambahData" class="modal fade" tabindex="-1">
		@if (Auth::user()->jenis_pu == 'PTB')
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
										<option value="jasa">Izin Penyelenggaraan Jasa</option>
										<option value="jaringan">Izin Penyelenggaraan Jaringan</option>
										{{-- <option value="penomoran">Permohonan Penomoran</option> --}}
										{{-- <option value="telsus">Izin Penyelenggaraan Telekomunikasi Khusus</option> --}}
									</select>
								</div>

								<div id="KBLIjasa" hidden>
									<div class="mb-3">
										<p>KBLI</p>
										<select name="kbli" class="form-control">
											<option value="">Silakan Pilih..</option>
											@foreach ($kblijasa as $kbli)
												<option value="{{ $kbli->id }}">{{ $kbli->name }} -
													{{ $kbli->desc }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div id="KBLIjaringan" hidden>
									<div class="mb-3">
										<p>KBLI</p>
										<select name="kbli" class="form-control">
											<option value="">Silakan Pilih..</option>
											@foreach ($kblijaringan as $kbli)
												<option value="{{ $kbli->id }}">{{ $kbli->name }} -
													{{ $kbli->desc }}</option>
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
		@endif
		@if (Auth::user()->jenis_pu == 'TKB')
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
										{{-- <option value="jasa">Izin Penyelenggaraan Jasa</option>
								<option value="jaringan">Izin Penyelenggaraan Jaringan</option> --}}
										<option value="telsus">Izin Penyelenggaraan Telekomunikasi Khusus</option>
									</select>
								</div>
								{{-- <div id="KBLIjasa" hidden>
							<div class="mb-3">
								<p>KBLI</p>
								<select name="kbli" class="form-control">
									<option value="">Silakan Pilih..</option>
									@foreach ($kblijasa as $kbli)
									<option value="{{ $kbli->id }}">{{ $kbli->name }} -
										{{ $kbli->desc }}</option>
									@endforeach
								</select>
							</div>
						</div> --}}
								{{-- <div id="KBLIjaringan" hidden>
							<div class="mb-3">
								<p>KBLI</p>
								<select name="kbli" class="form-control">
									<option value="">Silakan Pilih..</option>
									@foreach ($kblijaringan as $kbli)
									<option value="{{ $kbli->id }}">{{ $kbli->name }} -
										{{ $kbli->desc }}</option>
									@endforeach
								</select>
							</div>
						</div> --}}
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
								{{-- <div id="KBLIpenomoran" hidden>
							<div class="mb-3">
								<p>KBLI</p>
								<select name="kbli" class="form-control">
									<option value="">Silakan Pilih..</option>
									@foreach ($kblinomor as $kblinomor)
									<option value="{{$kblinomor->id}}">{{$kblinomor->name}} - {{$kblinomor->desc}}
									</option>
									@endforeach
								</select>
							</div>
						</div> --}}
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
		@endif
		@if (Auth::user()->jenis_pu == 'TKI')
			<div class="modal-dialog">
				<form action="{{ route('pb_submitpersyarataniptelsus') }}" method="POST">
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
										{{-- <option value="jasa">Izin Penyelenggaraan Jasa</option>
								<option value="jaringan">Izin Penyelenggaraan Jaringan</option> --}}
										<option value="telsus">Izin Penyelenggaraan Telekomunikasi Khusus Instansi
											Pemerintah</option>
									</select>
								</div>
								{{-- <div id="KBLIjasa" hidden>
							<div class="mb-3">
								<p>KBLI</p>
								<select name="kbli" class="form-control">
									<option value="">Silakan Pilih..</option>
									@foreach ($kblijasa as $kbli)
									<option value="{{ $kbli->id }}">{{ $kbli->name }} -
										{{ $kbli->desc }}</option>
									@endforeach
								</select>
							</div>
						</div> --}}
								{{-- <div id="KBLIjaringan" hidden>
							<div class="mb-3">
								<p>KBLI</p>
								<select name="kbli" class="form-control">
									<option value="">Silakan Pilih..</option>
									@foreach ($kblijaringan as $kbli)
									<option value="{{ $kbli->id }}">{{ $kbli->name }} -
										{{ $kbli->desc }}</option>
									@endforeach
								</select>
							</div>
						</div> --}}
								<div id="KBLItelsus" hidden>
									<div class="mb-3">
										<p>KBLI</p>
										<select name="kbli" class="form-control">
											<option value="">Silakan Pilih..</option>
											@foreach ($kblitelsusip as $kbli)
												<option value="{{ $kbli->id }}">{{ $kbli->name }} -
													{{ $kbli->desc }}</option>
											@endforeach
										</select>
									</div>
								</div>
								{{-- <div id="KBLIpenomoran" hidden>
							<div class="mb-3">
								<p>KBLI</p>
								<select name="kbli" class="form-control">
									<option value="">Silakan Pilih..</option>
									@foreach ($kblinomor as $kblinomor)
									<option value="{{$kblinomor->id}}">{{$kblinomor->name}} - {{$kblinomor->desc}}
									</option>
									@endforeach
								</select>
							</div>
						</div> --}}
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
		@endif
		@if (Auth::user()->jenis_pu == 'NBH')
			<div class="modal-dialog">
				<form action="{{ route('pb_submitpersyarataniptelsus') }}" method="POST">
					@csrf
					<div class="modal-content">
						<div class="modal-header bg-indigo text-white">
							<h6 class="modal-title">Pilih KBLI</h6>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<div class="mb-4">
								<div id="jenisLayanan">
									<div class="mb-3">
										<p>Jenis Layanan</p>
										<select class="form-control" name="jenislayanan">
											<option value="">Silakan Pilih..</option>
											@foreach ($kblitelsusip as $kblitelsusip)
												<option value="{{ $kblitelsusip->id }}">{{ $kblitelsusip->name }}
													{{-- {{ $kblitelsusip->desc }} --}}
												</option>
											@endforeach
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
		@endif
		@if (Auth::user()->jenis_pu == 'NPT')
			<div class="modal-dialog">
				<form action="{{ route('pb_submitpersyaratanip') }}" method="POST">
					@csrf
					<div class="modal-content">
						<div class="modal-header bg-indigo text-white">
							<h6 class="modal-title">Pilih Jenis Penomoran</h6>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<div class="mb-4">
								<div class="mb-3">
									{{-- <p>Perizinan</p>
							<select name="perizinan" class="form-control">
								<option value="">Silakan Pilih..</option>
								<option value="penomoran">Permohonan Penomoran</option>
							</select> --}}
									{{--
						</div>
						<div id="KBLItelsus" hidden>
							<div class="mb-3">
								<p>KBLI</p>
								<select name="kbli" class="form-control">
									<option value="">Silakan Pilih..</option>
									@foreach ($kblitelsus as $kbli)
									<option value="{{$kbli->id}}">{{$kbli->name}} - {{$kbli->desc}}</option>
									@endforeach
								</select>
							</div>
						</div> --}}
									{{-- <div id="KBLIpenomoran" hidden>
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
						</div> --}}
									<div id="jenisLayanan">
										<div class="mb-3">
											<p>Jenis Layanan</p>
											<select class="form-control" name="jenislayanan">
												<option value="">Silakan Pilih..</option>
												@foreach ($kblinomor as $kblinomor)
													<option value="{{ $kblinomor->id }}">{{ $kblinomor->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
								<button type="submit" class="btn btn-primary">Buat Permohonan baru</button>
							</div>
						</div>
				</form>
			</div>
		@endif
		@if (Auth::user()->jenis_pu == 'PTP')
			<div class="modal-dialog">
				<form action="{{ route('pb_submitpersyaratanip') }}" method="POST">
					@csrf
					<div class="modal-content">
						<div class="modal-header bg-indigo text-white">
							<h6 class="modal-title">Pilih Jenis Penomoran</h6>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<div class="mb-4">
								<div class="mb-3">
									<div id="jenisLayanan">
										<div class="mb-3">
											<p>Jenis Layanan</p>
											<select class="form-control" name="jenislayanan">
												<option value="">Silakan Pilih..</option>
												@foreach ($kblinomor_pt as $kblinomor_pt)
													<option value="{{ $kblinomor_pt->id }}">{{ $kblinomor_pt->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
								<button type="submit" class="btn btn-primary">Buat Permohonan baru</button>
							</div>
						</div>
				</form>
			</div>
		@endif

	</div>
	<div id="tambahData_nomor" class="modal fade" tabindex="-1">

		<div class="modal-dialog">
			@if (Auth::user()->jenis_pu == 'TKI')
				<form action="{{ route('pb_submitpersyarataniptelsus') }}" method="POST">
				@else
					<form action="{{ route('pb_submitpersyaratanip') }}" method="POST">
			@endif

			@csrf
			<div class="modal-content">
				<div class="modal-header bg-indigo text-white">
					@if (Auth::user()->jenis_pu == 'TKI')
						<h6 class="modal-title">Pilih Jenis Layanan</h6>
					@else
						<h6 class="modal-title">Pilih Jenis Penomoran</h6>
					@endif

					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="mb-4">
						<div class="mb-3">
							<div id="jenisLayanan_nomor">
								<div class="mb-3">
									@if (Auth::user()->jenis_pu == 'TKI')
										<p>Jenis Layanan</p>
									@else
										<p>Jenis Penomoran</p>
									@endif
									<select class="form-control" name="jenislayanan_nomor">
										<option value="">Silakan Pilih..</option>
										@if (Auth::user()->jenis_pu == 'TKI')
											@foreach ($kblitelsusip as $kblitelsus_ip)
												<option value="{{ $kblitelsus_ip->id }}">{{ $kblitelsus_ip->name }}
												</option>
											@endforeach
										@else
											@foreach ($kblinomor_pt as $kblinomor_pt)
												<option value="{{ $kblinomor_pt->id }}">{{ $kblinomor_pt->name }}
												</option>
											@endforeach
										@endif

									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Buat Permohonan baru</button>
					</div>
				</div>
				</form>
			</div>

		</div>
		<div id="tambahData_ip" class="modal fade" tabindex="-1">

			<div class="modal-dialog">
				<form action="{{ route('pb_submitpersyarataniptelsus') }}" method="POST">
					@csrf
					<div class="modal-content">
						<div class="modal-header bg-indigo text-white">
							<h6 class="modal-title">Pilih Jenis Layanan</h6>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<div class="mb-4">
								<div class="mb-3">
									<div id="jenisLayanan_ip">
										<div class="mb-3">
											<p>Jenis Penomoran</p>
											<select class="form-control" name="jenislayanan_ip">
												<option value="">Silakan Pilih..</option>
												@foreach ($kblitelsusip as $kblitelsus_ip)
													<option value="{{ $kblitelsus_ip->id }}">{{ $kblitelsus_ip->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
								<button type="submit" class="btn btn-primary">Buat Permohonan baru</button>
							</div>
						</div>
				</form>
			</div>

		</div>
		<div id="modalCekPenomoran" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<form action="{{ url('penomoran/baru') }}" method="POST" enctype="multipart/form-data">
					@csrf
					{{-- <input type="hidden" id="vId_proyek" name="vId_proyek"> --}}
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
													<option value="" selected hidden>Pilih jenis penomoran terlebih
														dulu
													</option>
												</select>
												<div class="mt-1 spinner-border loading text-primary" role="status" id="jenisnomor-loading">
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
	</div>
	<script type="text/javascript">
		// $(document).on("change", 'select[name="perizinan"]',
		//     function() {
		//         //alert($(this).find("option:selected").text());
		//     });
		$(document).ready(function() {


			$('#form_get_by_date').submit(function(e) {
				e.preventDefault();

				$('#btnSubmit').val("Mencari ...");


				var formData = new FormData(this);

				// console.log(formData)
				$.ajax({
					type: 'POST',
					url: "{{ url('/pb/get_by_date') }}",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					tBoodyDataAll,
					success: (data) => {
						console.log(data);
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
										'jenis_layanan', 'id_proyek'
									]
								},
								{
									data: 'updated_at',
									"render": function(data, type, row) {
										const myArray = data.split("T");
										const thbl = myArray[0].split("-");
										// console.log(myArray[0]);

										switch (thbl[1]) {
											case "01":
												teks = "Januari";
												break;
											case "02":
												teks = "Februari";
												break;
											case "3":
												teks = "Maret";
												break;
											case "04":
												teks = "April";
												break;
											case "05":
												teks = "Mei";
												break;
											case "06":
												teks = "Juni";
												break;
											case "07":
												teks = "Juli";
												break;
											case "08":
												teks = "Agustus";
												break;
											case "09":
												teks = "September";
												break;
											case "10":
												teks = "Oktober";
												break;
											case "11":
												teks = "November";
												break;
											case "12":
												teks = "Desember";
												break;
											default:
												teks = "Bulan Tidak Valid";
										}
										const jam = myArray[1].split(".");
										var all = thbl[2] + " " + teks + " " +
											thbl[0] + " - " + jam[0]
										return all
									}
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
											"<div class='dropdown'><a href='javascript:void(0)' class='btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill' data-toggle='dropdown'> <i class='icon-menu7'></i></a> <div class='dropdown-menu dropdown-menu-right'> <a href='javascript:void(0)' class='dropdown-item'><i class='icon-file-eye'></i> Informasi Perizinan</a> <a href='{{ url('pb/historyperizinan/') }}/" +
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
						// console.log(data);

					}
				});
			});

			$('select[name="perizinan"]').on('change', function() {
				// $('#perizinan').change(function() {
				alert($(this).find("option:selected").text());
				var izin = $(this).val();
				console.log(izin);
				if (izin == 'penomoran') {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', true);
					$('#KBLIjaringan').attr('hidden', true);
					$('#KBLItelsus').attr('hidden', true);
					$('#jenisLayanan').attr('hidden', true);
					$('select[name="jenislayanan"]').val('Silakan Pilih...');
				} else if (izin == 'jasa') {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', false);
					$('#KBLIjaringan').attr('hidden', true);
					$('#KBLItelsus').attr('hidden', true);
					$('#jenisLayanan').attr('hidden', false);
					$('select[name="jenislayanan"]').val('Silakan Pilih...');
				} else if (izin == 'jaringan') {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', true);
					$('#KBLIjaringan').attr('hidden', false);
					$('#KBLItelsus').attr('hidden', true);
					$('#jenisLayanan').attr('hidden', false);
					$('select[name="jenislayanan"]').val('Silakan Pilih...');
				} else if (izin == 'telsus') {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', true);
					$('#KBLIjaringan').attr('hidden', true);
					$('#KBLItelsus').attr('hidden', false);
					$('#jenisLayanan').attr('hidden', false);
					$('select[name="jenislayanan"]').val('Silakan Pilih...');
				} else {
					$('#penomoranSelect').attr('hidden', true);
					$('#KBLIpenomoran').attr('hidden', true);
					$('#KBLIjasa').attr('hidden', true);
					$('#KBLIjaringan').attr('hidden', true);
					$('#KBLItelsus').attr('hidden', true);
					$('#jenisLayanan').attr('hidden', true);
				}
			});

			$('select[name="kbli"]').on('change', function() {
				var kbli = $(this).val();
				var izin = $('select[name="perizinan"]').val();
				// console.log(kbli)
				if (kbli) {
					$.ajax({
						url: '/api/getjenislayanan/' + izin + '/' + kbli,
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


			$('#tBoodyDataAll').on('click', '.triger-btn', function() {
				// var id_proyek = $(this).attr('data');
				var id_izin = $(this).attr('data2');
				var jenislayanan = $(this).attr('data3');
				// $("#vId_proyek").val(id_proyek);
				$("#vId_izin").val(id_izin);
				$("#modalCekPenomoran").modal("show");
				getNumber(jenislayanan);
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
							tempoption += "<option value='" + value.short_name + "'> " +
								value
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

		});
	</script>
@endsection
