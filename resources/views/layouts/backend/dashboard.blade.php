
@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
<!-- Quick stats boxes -->
<div class="row">
    <div class="col-lg">
        <!-- Members online -->
        <div class="card bg-indigo text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Registrasi Baru</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
        <!-- /members online -->
    </div>

    <div class="col-lg">
		<!-- Members online -->
		<div class="card bg-teal text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Perizinan Baru</div>
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
		<div class="card bg-pink text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Penomoran Baru</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
		<!-- /current server load -->
	</div>

    <div class="col-lg">
		<!-- Current server load -->
		<div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Persyaratan Baru</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
		<!-- /current server load -->
	</div>

	<div class="col-lg">
		<!-- Today's revenue -->
		<div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Uji Laik Operasi Baru</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
		<!-- /today's revenue -->
	</div>
</div>
<!-- /quick stats boxes -->	

<!-- Latest orders -->
<div class="card">
	<div class="card-header d-flex py-0">
		<h6 class="card-title font-weight-semibold py-3">List Perizinan Dalam Proses</h6>
	
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

	<div class="table-responsive border-top-0">
		<table class="table text-nowrap">
			<thead>
				<tr>
					<th>Perusahaan</th>
					<th class="text-center">Tanggal Permohonan</th>
					<th class="text-center">Jenis Perizinan</th>
					<th class="text-center">Jenis Layanan</th>
                    <th class="text-center">Status</th>
					<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="d-flex align-items-center">
							<div>
								<a href="#" class="text-body font-weight-semibold">KLM Royal Dutch Airlines</a>
								<div class="text-muted font-size-sm">May 21st</div>
							</div>
						</div>
					</td>
					<td class="text-center">June 12th</td>
					<td class="text-center">UPS Express</td>
					<td class="text-center">UPS Express</td>
					<td class="text-center"><span class="badge badge-success-100 text-success">Delivered</span></td>
					<td class="text-center">
						<div class="dropdown">
							<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
								<i class="icon-menu7"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Informasi Perizinan</a>
								<a href="#" class="dropdown-item"><i class="icon-history"></i> Riwayat Permohonan</a>
							</div>
						</div>
					</td>
				</tr>
                <tr>
					<td>
						<div class="d-flex align-items-center">
							<div>
								<a href="#" class="text-body font-weight-semibold">KLM Royal Dutch Airlines</a>
								<div class="text-muted font-size-sm">May 21st</div>
							</div>
						</div>
					</td>
					<td class="text-center">June 12th</td>
					<td class="text-center">UPS Express</td>
					<td class="text-center">UPS Express</td>
					<td class="text-center"><span class="badge badge-success-100 text-success">Delivered</span></td>
					<td class="text-center">
						<div class="dropdown">
							<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
								<i class="icon-menu7"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Informasi Perizinan</a>
								<a href="#" class="dropdown-item"><i class="icon-history"></i> Riwayat Permohonan</a>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<!-- /latest orders -->
@endsection