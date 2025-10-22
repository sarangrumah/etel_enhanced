@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
	<!-- Quick stats boxes -->

	<style>
		.switch {
			position: relative;
			display: inline-block;
			width: 40px;
			height: 24px;
		}

		.switch input {
			opacity: 0;
			width: 0;
			height: 0;
		}

		.slider {
			position: absolute;
			cursor: pointer;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: #ccc;
			-webkit-transition: .4s;
			transition: .4s;
		}

		.slider:before {
			position: absolute;
			content: "";
			height: 26px;
			width: 26px;
			left: 4px;
			bottom: 4px;
			background-color: white;
			-webkit-transition: .4s;
			transition: .4s;
		}

		input:checked+.slider {
			background-color: #2196F3;
		}

		input:focus+.slider {
			box-shadow: 0 0 1px #2196F3;
		}

		input:checked+.slider:before {
			-webkit-transform: translateX(26px);
			-ms-transform: translateX(26px);
			transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
			border-radius: 34px;
		}

		.slider.round:before {
			border-radius: 50%;
		}
	</style>

	<div class="row">

		<div class="col-lg">
			<!-- Members online -->

			<!-- /members online -->
			<!-- </a> -->

		</div>

		<div class="col-lg">
			<!-- Current server load -->

			<!-- /current server load -->
		</div>
	</div>
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
			<!--  <div  class="pull-right">

																	<a href="{{ route('admin.masterholiday') }}" class="btn btn-primary"><i class="icon-backward2">Kembali</i></a>

													</div> -->

			<div class="card-header d-flex py-0">
				<h6 class="card-title font-weight-semibold py-3">Form Edit Daftar Hari Libur</h6>

				{{-- <div class="d-inline-flex align-items-center ml-auto">
              <div class="dropdown ml-2">
                  <a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
                      <i class="icon-more2"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                      <a href="#" class="dropdown-item"><i class="icon-printer"></i> Print report</a>
                      <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export report</a>
                  </div>
              </div> 
          </div> --}}
			</div>

			<div class="card-body">
				<form id="formhistoryperizinan" method="post" action="{{ route('admin.masterholiday.update', $dataholiday->id) }}">
					@csrf

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group row">
								<div class="col-lg-2">
									<Label>Tanggal Libur</Label>
								</div>
								<div class="col-lg-8">
									<input type="date" class="form-control" name="off_day" value="{{ $dataholiday->off_day }}"></input>
								</div>
								<div class="col-lg-2">
									<div class="custom-control custom-switch">
										<input type="checkbox" class="custom-control-input" name="is_active" id="customSwitch1" checked>
										<label class="custom-control-label" for="customSwitch1">Status Libur</label>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-lg-2">
									<Label>Kategori Off Day</Label>
								</div>
								<div class="col-lg-10">
									<select name="id_kategori" data-placeholder="Silakan Pilih" class="form-control form-control-select2" required>
										<option value="null" disabled selected>-- Silakan Pilih --</option>
										<option value="Libur Nasional" @if ($dataholiday->kategori == 'Libur Nasional') selected @endif>Libur Nasional </option>
										<option value="Uji Laik Operasi" @if ($dataholiday->kategori == 'Uji Laik Operasi') selected @endif>Uji Laik Operasi </option>
										<option value="Lainnya" @if ($dataholiday->kategori == 'Lainnya') selected @endif>Lainnya </option>
									</select>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-lg-2">
									<Label>Deskripsi</Label>
								</div>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="desc" value="{{ $dataholiday->desc }}"></input>
								</div>
							</div>
						</div>

					</div>

					<div class="modal-footer">
						<a href="{{ route('admin.masterholiday') }}" class="btn btn-secondary border-transparent"><i
								class="icon-backward2 ml-2"></i> Kembali </a>

						<button type="submit" class="btn btn-success">Simpan</button>

					</div>
				</form>
			</div>

		</div>
		<div class="text-right pagination-flat" style="float:right">

		</div>
		<!-- /latest orders -->
	</div>
@endsection
