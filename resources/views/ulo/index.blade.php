@extends('layouts.frontend.main')
@section('title', 'Uji Laik Operasi')

@section('content')
	<!-- Quick stats boxes -->
	@error('message')
		<div class="alert alert-danger alert-styled-left alert-dismissible">
			<span class="font-weight-semibold">{{ $message }}.</span>
		</div>
	@endError

	<div class="row">

		<div class="col-lg">
			<!-- Members online -->

			<div class="card bg-secondary text-white">

				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ $proses }}</h3>
						<a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
					</div>

					<div>
						Permohonan
						<div class="font-size-sm opacity-75">Dalam Proses</div>
					</div>
				</div>

				<div class="container-fluid">
					<div id="members-online"></div>
				</div>
			</div>
			<!-- /members online -->

		</div>

		<div class="col-lg">
			<!-- Current server load -->
			<div class="card bg-teal text-white">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ $selesai }}</h3>
						<a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
					</div>

					<div>
						Permohonan
						<div class="font-size-sm opacity-75">Selesai</div>
					</div>
				</div>

				<div class="container-fluid">
					<div id="members-online"></div>
				</div>
			</div>
			<!-- /current server load -->
		</div>

		<div class="col-lg">
			<!-- Members online -->

			<div class="card bg-pink text-white">

				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0">{{ $tolak }}</h3>
						<a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
					</div>

					<div>
						Permohonan
						<div class="font-size-sm opacity-75">Penolakan</div>
					</div>
				</div>

				<div class="container-fluid">
					<div id="members-online"></div>
				</div>
			</div>
			<!-- /members online -->
		</div>

	</div>

	<div class="card">
		<div class="card-header bg-indigo text-white header-elements-inline">
			<h6 class="card-title font-weight-semibold py-3">Daftar Permohonan Uji Laik Operasi </h6>

			{{-- <div class="d-inline-flex align-items-center ml-auto">
                <div class="dropdown ml-2">
                    <a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
                        <i class="icon-more2"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right"></a>
                        <a href="#" class="dropdown-item"><i class="icon-printer"></i> Print report</a>
                        <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export report</a>
                    </div>
                </div>
            </div> --}}
		</div>

		{{-- <div class="table-responsive border-top-0"> --}}
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
		@if (session('warning'))
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="alert alert-warning">
							{{ session('warning') }}
						</div>
					</div>
				</div>
			</div>
		@endif
		<table class="table text-nowrap datatable-basic" id="table">
			<thead>
				<tr>
					<th>Permohonan</th>
					<th class="text-center">Tanggal Permohonan</th>
					<th class="text-center">Tanggal Pelaksanaan ULO</th>
					<th class="text-center">Status</th>
					<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($izin as $item)
					@if ($item->status_ulo == 50)
						{{-- @elseif($item->status_ulo == 90) --}}
					@else
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div>
										<a class="text-body font-weight-semibold" href="#">{{ $item->id_izin }}</a>
										<div class="text-muted font-size-sm">{{ $item->jenis_izin }}</div>
										<div class="text-muted font-size-sm">{{ $item->full_kbli }}</div>
										<div class="text-muted font-size-sm">{!! $item->jenis_layanan_html !!}</div>
									</div>
								</div>
							</td>
							<td class="text-center">

								@if ($item->tgl_submit)
									{{ $date_reformat->dateday_lang_reformat_long($item->tgl_submit) }}
								@else
									<span class="badge badge-success-100 text-success">Belum mengajukan ULO</span>
								@endif

							</td>
							<td class="text-center">
								@if ($item->tgl_pengajuan)
									{{ $date_reformat->dateday_lang_reformat_long($item->tgl_pengajuan) }}
								@else
									<span class="badge badge-success-100 text-success">Belum mengajukan ULO</span>
								@endif
							</td>
							@if ($item->status_ulo == null)
								<td class="text-center"><span class="badge badge-success-100 text-success">{{ $item->status_fo }}</span></td>
							@else
								<td class="text-center"><span class="badge badge-success-100 text-success">{{ $item->name_status_fo }}</span>
								</td>
							@endif
							<td class="text-center">
								<div class="dropdown">
									<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
										data-toggle="dropdown">
										<i class="icon-menu7"></i>
									</a>

									<div class="dropdown-menu dropdown-menu-right">
										@if ($item->status_ulo == '11')
											<a href="{{ url('ulo/mandiri-ulo') . '/' . $item->id_izin }}" class="dropdown-item"><i
													class="icon-file-upload"></i> Penilaian Mandiri</a>
										@elseif($item->status_checklist == '10' && $item->status_ulo == null)
											<a href="{{ url('ulo/pengajuan-ulo') . '/' . $item->id_izin }}" class="dropdown-item"><i
													class="icon-file-upload"></i> Pengajuan Ulo</a>
											{{-- @if (Auth::user()->jenis_pu == 'NBH')
                                                <a href="javascript:void(0)" 
                                                data-target="#izinprinsip" class="dropdown-item perpanjangip" data-id="{{$item->id_izin}}"><i class="icon-file-upload"></i> Perpanjangan Izin Prinsip</a>
                                                @endif --}}
										@elseif($item->status_ulo == 90)
											<a href="{{ url('ulo/pengajuan-ulo') . '/' . $item->id_izin }}" class="dropdown-item"><i
													class="icon-file-upload"></i> Pengajuan Ulo Kembali</a>
										@endif
										<a href="{{ url('pb/historyperizinan/') . '/' . $item->id_izin }}" target="_blank" class="dropdown-item"><i
												class="icon-history"></i> Riwayat Permohonan</a>
									</div>
								</div>
							</td>
						</tr>
					@endif
				@endforeach
			</tbody>
		</table>
		{{-- </div> --}}
	</div>

	<div id="izinprinsip" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<form action="{{ route('submitperpanjangip') }}" method="POST">
				@csrf
				<div class="modal-content">
					<div class="modal-body">
						<input type="hidden" name="idizin" id="idizin" value="">
						<p class="mb-3">Apakah anda yakin ingin memperpanjang izin prinsip?</p>
						<div class="form-group row">
							<label class="col-lg-4 col-form-label">Nomor Permohonan</label>
							<label class="col-lg-1 col-form-label">:</label>
							<label class="col-lg-7 col-form-label" id="noper"></label>
						</div>
						<div class="form-group row">
							<label class="col-lg-4 col-form-label">Tanggal Berlaku Izin</label>
							<label class="col-lg-1 col-form-label">:</label>
							<label class="col-lg-7 col-form-label" id="tgl_berlaku"></label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Ya</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@section('custom-js')
	<script>
		// $('#table').datatables();
		// Swal.fire({
		//     title: 'Error!',
		//     text: 'Do you want to continue',
		//     icon: 'error',
		//     confirmButtonText: 'Cool'
		// })

		$('body').on('click', '.perpanjangip', function() {
			var id_izin = $(this).data('id');
			console.log(id_izin);
			$.get("/api/getulo/" + id_izin, function(data) {
				const date = new Date(data.tgl_berlaku);
				tanggal = ('0' + (date.getDate() + 1)).slice(-2)
				bulan = ('0' + (date.getMonth() + 1)).slice(-2);
				tahun = date.getFullYear();
				tanggals = tanggal + '/' + bulan + '/' + tahun;
				$('#izinprinsip').modal('show');
				$('#idizin').val(data.id_trx_izin);
				$('#noper').html(data.id_trx_izin);
				$('#tgl_berlaku').html(tanggals);
			})
		});
	</script>
@endsection
