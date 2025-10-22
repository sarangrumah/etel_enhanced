<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>KOMINFO - e-Licensing</title>

	<!-- Global stylesheets -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900"
		integrity="sha384-qG0E00yS7hr8A2CPVjXFNSt9f5rWICyFvnzrUzKScqX4BbzZOPQkp3WiaU29YFsO" crossorigin="anonymous">
	<link href="/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/all.min.css" rel="stylesheet" type="text/css">
	{{-- <link rel="stylesheet" href="/global_assets/css/extras/jquery-ui.css"> --}}
	<!-- /global stylesheets -->

	{{-- <link rel="stylesheet" href="/global_assets/css/extras/dataTables.dateTime.min.css"> --}}

	<!-- Core JS files -->
	<script src="/global_assets/js/main/jquery.min.js"></script>
	<script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>

	<!-- /core JS files -->

	<!-- Theme JS files -->
	<!-- <script src="global_assets/js/plugins/visualization/echarts/echarts.min.js"></script> -->
	<!-- <script src="global_assets/js/plugins/maps/echarts/world.js"></script> -->

	<script src="/assets/js/app.js"></script>
	@yield('js')
	<!-- <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script> -->
	<!-- <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->
	<link rel="stylesheet" href="/global_assets/css/extras/jquery-ui.css">
	<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="/global_assets/js/demo_pages/datatables_basic.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script src="/assets/js/vendor/tables/datatables/extensions/col_reorder.min.js"></script>
	<script type="text/javascript" src="/global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script>
	<style>
		.card-header[class*="bg-"] {
			padding-top: 0px;
			padding-bottom: 0px;
		}
	</style>
	<!-- /theme JS files -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-expand-xl navbar-light navbar-static px-0">
		<div class="d-flex flex-1 pl-3">
			<div class="navbar-brand wmin-0 mr-1">
				<a href="{{ url('/landing') }}" class="d-inline-block">
					<img src="/global_assets/images/logo_kominfo_text.png" class="d-none d-sm-block" alt="">
					<img src="/global_assets/images/logo_kominfo_text.png" class="d-sm-none" alt="">
				</a>
			</div>
		</div>

		<div class="d-flex flex-xl-1 justify-content-xl-end order-0 order-xl-1 pr-3">
			<ul class="navbar-nav navbar-nav-underline flex-row">
				@auth
					<li class="nav-item nav-item-dropdown-xl dropdown dropdown-user h-100">
						<a href="javascript:void(0)"
							class="navbar-nav-link navbar-nav-link-toggler d-flex align-items-center h-100 dropdown-toggle"
							data-toggle="dropdown">
							<!-- {{-- <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?f=y&d=mp" --}} -->
							<img src="/global_assets/images/logo_kominfo.png" class="rounded-circle mr-xl-2" height="38" alt="">
							<span class="d-none d-xl-block">{{ Auth::user()->name }}</span>
						</a>

						<div class="dropdown-menu dropdown-menu-right">
							{{-- <a href="javascript:void(0)" class="dropdown-item"><i class="icon-user-plus"></i> Profil
                            Saya</a> --}}
							{{-- <a href="javascript:void(0)" class="dropdown-item"><i class="icon-office"></i> Profil
                            Perusahaan</a> --}}
							<a href="{{ route('password.request') }}" class="dropdown-item"><i class="icon-cog5"></i> Atur
								kata Sandi</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('logout') }}"
								onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
								<i class="icon-switch2"></i> Keluar
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</li>
				@else
					<li class="nav-item">
						<a href="{{ route('login') }}" class="navbar-nav-link">Login</a>
					</li>
				@endauth
			</ul>
		</div>
	</div>
	<!-- /main navbar -->
	<!-- Secondary navbar -->
	@auth

		<div class="navbar navbar-expand navbar-light px-0 px-lg-3">
			<div class="overflow-auto overflow-lg-visible scrollbar-hidden flex-1">
				<ul class="navbar-nav flex-row text-nowrap">
					<li class="nav-item">
						<a href="{{ url('/') }}" class="navbar-nav-link active">
							<i class="icon-home4 mr-2"></i>
							Dashboard
						</a>
					</li>

					<li class="nav-item nav-item-dropdown-lg mega-menu-full">
						<a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
							<i class="icon-office mr-2"></i>
							Kelengkapan Data
						</a>

						<div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
							<div class="dropdown-content-body">
								<div class="row">
									<div class="col-md-12 mb-3 mb-md-0">
										<div class="font-weight-semibold border-bottom pb-2 mb-2">Pendaftaran Data</div>
										<a href="{{ url('/ip/registerpt') }}" class="dropdown-item rounded">Kelengkapan Data
											Institusi</a>
										<a href="{{ url('/ip/registerpj') }}" class="dropdown-item rounded">Kelengkapan Data
											Penanggung Jawab</a>
										<a href="{{ url('/ip/updateemail') }}" class="dropdown-item rounded">Ajukan Perubahan e-Mail</a>
										<a href="{{ url('/ip/updatenib') }}" class="dropdown-item rounded">Ajukan Perubahan NIB</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					@if (Auth::user()->jenis_pu != 'NPT')
						<li class="nav-item nav-item-dropdown-lg mega-menu-full">
							<a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
								<i class="icon-stack2 mr-2"></i>
								Perizinan Berusaha
							</a>

							<div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
								<div class="dropdown-content-body">
									<div class="row">
										@if (Auth::user()->jenis_pu == 'PTB')
											<div class="col-md-4 mb-3 mb-md-0">
												<div class="font-weight-semibold border-bottom pb-2 mb-2">Jasa
													Telekomunikasi
												</div>
												<a href="{{ url('/pb/permohonan/jasa') }}" class="dropdown-item rounded">Pemenuhan
													Persyaratan</a>
												<!-- <a href="{{ url('/pemenuhanpersyaratan/jasa') }}" class="dropdown-item rounded">Pemenuhan Persyaratan</a> -->
												<a href="{{ url('/pb/koreksipersyaratan/jasa') }}" class="dropdown-item rounded">Perbaikan Persyaratan</a>
												<a href="{{ url('/pb/penetapan/jasa') }}" class="dropdown-item rounded">Penetapan</a>
											</div>

											<div class="col-md-4 mb-3 mb-md-0">
												<div class="font-weight-semibold border-bottom pb-2 mb-2">Jaringan
													Telekomunikasi
												</div>
												<a href="{{ url('/pb/permohonan/jaringan') }}" class="dropdown-item rounded">Pemenuhan Persyaratan</a>
												<a href="{{ url('/pb/koreksipersyaratan/jaringan') }}" class="dropdown-item rounded">Perbaikan
													Persyaratan</a>
												<a href="{{ url('/pb/penetapan/jaringan') }}" class="dropdown-item rounded">Penetapan</a>
											</div>

											<div class="col-md-4 mb-3 mb-md-0">
												<div class="font-weight-semibold border-bottom pb-2 mb-2">Penetapan Izin Penyelenggaraan
												</div>
												<a href="{{ url('/pb/penetapan/jasa') }}" class="dropdown-item rounded">Penetapan Penyelenggaraan Jasa
													Telekomunikasi</a>
												<a href="{{ url('/pb/penetapan/jaringan') }}" class="dropdown-item rounded">Penetapan Penyelenggaraan
													Jaringan Telekomunikasi</a>
											</div>
											{{-- <div class="col-md-4 mb-3 mb-md-0">
                                                <div class="font-weight-semibold border-bottom pb-2 mb-2">Penyelenggara
                                                    Telekomunikasi Penomoran
                                                </div>
                                                <a href="{{ url('penomoran-baru') }}"
                                                    class="dropdown-item rounded">Permohonan Penomoran</a>
                                                <a href="{{ url('penomoran-baru') }}"
                                                    class="dropdown-item rounded">Pengembalian Penomoran</a>
                                                <a href="{{ url('/pb/penetapan/penomoran') }}"
                                                    class="dropdown-item rounded">Penyesuaian Penomoran</a>
                                            </div> --}}
										@elseif (Auth::user()->jenis_pu == 'TKB')
											<div class="col-md-6 mb-3 mb-md-0">
												<div class="font-weight-semibold border-bottom pb-2 mb-2">Telekomunikasi
													Khusus
												</div>
												<a href="{{ url('/pb/permohonan/telsus') }}" class="dropdown-item rounded">Pemenuhan
													Persyaratan</a>
												<a href="{{ url('/pb/koreksipersyaratan/telsus') }}" class="dropdown-item rounded">Perbaikan
													Persyaratan</a>
												<a href="{{ url('/pb/penetapan/telsus') }}" class="dropdown-item rounded">Penetapan</a>
											</div>

											<div class="col-md-6 mb-3 mb-md-0">
												<div class="font-weight-semibold border-bottom pb-2 mb-2">Penetapan Izin Penyelenggaraan
												</div>
												<a href="{{ url('/pb/penetapan/telsus') }}" class="dropdown-item rounded">Penetapan Penyelenggaraan
													Telekomunikasi Khusus</a>
											</div>
										@elseif (Auth::user()->jenis_pu == 'TKI')
											<div class="col-md-6 mb-3 mb-md-0">
												<div class="font-weight-semibold border-bottom pb-2 mb-2">Telekomunikasi
													Khusus
												</div>
												<a href="{{ url('/pb/permohonan/TELSUS_INSTANSI') }}" class="dropdown-item rounded">Pemenuhan
													Persyaratan</a>
												<a href="{{ url('/pb/koreksipersyaratan/TELSUS_INSTANSI') }}" class="dropdown-item rounded">Perbaikan
													Persyaratan</a>
												<a href="{{ url('/pb/penetapan/TELSUS_INSTANSI') }}" class="dropdown-item rounded">Penetapan</a>
											</div>

											<div class="col-md-6 mb-3 mb-md-0">
												<div class="font-weight-semibold border-bottom pb-2 mb-2">Penetapan Izin Penyelenggaraan
												</div>
												<a href="{{ url('/pb/penetapan/TELSUS_INSTANSI') }}" class="dropdown-item rounded">Penetapan
													Penyelenggaraan Telekomunikasi Khusus</a>
											</div>
										@endif

									</div>
								</div>
							</div>
						</li>
						@if (Auth::user()->jenis_pu == 'PTB')
							<li class="nav-item nav-item-dropdown-lg mega-menu-full">
								<a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
									<i class="icon-stack2 mr-2"></i>
									Penomoran Telekomunikasi
								</a>

								<div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
									<div class="dropdown-content-body">
										<div class="row">
											<div class="col-md-12 mb-3 mb-md-0">
												<a href="{{ url('/pb/dashboard_penomoran') }}" class="dropdown-item rounded">Daftar Permohonan</a>
												<a href="{{ url('/pb/dashboard_penomoran_tetap') }}" class="dropdown-item rounded">Daftar Penetapan /
													Pencabutan
													Penomoran</a>
											</div>

										</div>
									</div>
								</div>
							</li>
						@endif
						<li class="nav-item nav-item-dropdown-lg mega-menu-full">
							<a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
								<i class="icon-stack2 mr-2"></i>
								Permohonan Uji Laik Operasi
							</a>

							<div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
								<div class="dropdown-content-body">
									<div class="row">
										<div class="col-md-12 mb-3 mb-md-0">
											<a href="{{ url('/ulo/permohonan') }}" class="dropdown-item rounded">Pengajuan
												Baru</a>
											<a href="javascript:void(0)" class="dropdown-item rounded">Penetapan</a>
										</div>
									</div>
								</div>
							</div>
						</li>
					@else
						<li class="nav-item nav-item-dropdown-lg mega-menu-full">
							<a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
								<i class="icon-stack2 mr-2"></i>
								Penomoran Telekomunikasi
							</a>
							<div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
								<div class="dropdown-content-body">
									<div class="row">
										<div class="col-md-12 mb-3 mb-md-0">
											<a href="{{ url('/dashboard_penomoran') }}" class="dropdown-item rounded">Daftar Permohonan</a>
											<a href="{{ url('/dashboard_penomoran_tetap') }}" class="dropdown-item rounded">Daftar Penetapan/Pencabutan
												Penomoran</a>
										</div>
									</div>
								</div>
							</div>
						</li>
					@endif
					<li class="nav-item nav-item-dropdown-lg mega-menu-full">
						<a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
							<i class="icon-lifebuoy mr-2"></i>
							Layanan Bantuan
						</a>

						<div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
							<div class="dropdown-content-body">
								<div class="row">
									<div class="col-md-12 mb-3 mb-md-0">
										<a href="{{ url('/layanan') }}" class="dropdown-item rounded">Buat Baru</a>
										<a href="{{ url('/daftarlayanan') }}" class="dropdown-item rounded">Daftar
											Layanan Bantuan</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="nav-item">
						<a href="{{ url('/survei/isi') }}" class="navbar-nav-link">
							<i class="icon-pencil7 mr-2"></i>
							Survei
						</a>
					</li>

					{{-- <li class="nav-item nav-item-dropdown-lg mega-menu-full">
                    <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-stack2 mr-2"></i>
                        Jasa Telekomunikasi
                    </a>

                    <div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
                        <div class="dropdown-content-body">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="font-weight-semibold border-bottom pb-2 mb-2">Persyaratan (Jasa)</div>
                                    <a href="{{ url('/pb/permohonan/jasa') }}" class="dropdown-item rounded">Permohonan
                                        Baru</a>
                                    <a href="{{ url('/pb/koreksipersyaratan/jasa') }}"
                                        class="dropdown-item rounded">Perbaikan Persyaratan</a>
                                    <a href="{{ url('/pb/penetapan/jasa') }}"
                                        class="dropdown-item rounded">Penetapan</a>
                                </div>

                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="font-weight-semibold border-bottom pb-2 mb-2">Uji Laik Operasi (Jasa)
                                    </div>
                                    <a href="{{ url('/ulo/permohonan/jasa') }}" class="dropdown-item rounded">Permohonan
                                        Baru</a>
                                    <a href="{{ url('/ulo/penetapan/jasa') }}"
                                        class="dropdown-item rounded">Penetapan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item nav-item-dropdown-lg mega-menu-full">
                    <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-stack2 mr-2"></i>
                        Jaringan Telekomunikasi
                    </a>

                    <div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
                        <div class="dropdown-content-body">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="font-weight-semibold border-bottom pb-2 mb-2">Persyaratan (Jaringan)
                                    </div>
                                    <a href="{{ url('/pb/permohonan/jaringan') }}"
                                        class="dropdown-item rounded">Permohonan Baru</a>
                                    <a href="{{ url('/pb/koreksipersyaratan/jaringan') }}"
                                        class="dropdown-item rounded">Perbaikan Persyaratan</a>
                                    <a href="{{ url('/pb/penetapan/jaringan') }}"
                                        class="dropdown-item rounded">Penetapan</a>
                                </div>

                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="font-weight-semibold border-bottom pb-2 mb-2">Uji Laik Operasi
                                        (Jaringan)</div>
                                    <a href="{{ url('/ulo/permohonan/jaringan') }}"
                                        class="dropdown-item rounded">Permohonan Baru</a>
                                    <a href="{{ url('/ulo/penetapan/jaringan') }}"
                                        class="dropdown-item rounded">Penetapan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item nav-item-dropdown-lg mega-menu-full">
                    <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-paragraph-justify3 mr-2"></i>
                        Telekomunikasi Khusus
                    </a>

                    <div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
                        <div class="dropdown-content-body">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="font-weight-semibold border-bottom pb-2 mb-2">Persyaratan</div>
                                    <a href="{{ url('/pb/permohonan/telsus') }}"
                                        class="dropdown-item rounded">Permohonan Baru</a>
                                    <a href="{{ url('/pb/koreksipersyaratan/telsus') }}"
                                        class="dropdown-item rounded">Perbaikan Persyaratan</a>
                                    <a href="{{ url('/pb/penetapan/telsus') }}"
                                        class="dropdown-item rounded">Penetapan</a>
                                </div>

                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="font-weight-semibold border-bottom pb-2 mb-2">Uji Laik Operasi (Telsus)
                                    </div>
                                    <a href="{{ url('/ulo/permohonan/telsus') }}"
                                        class="dropdown-item rounded">Permohonan Baru</a>
                                    <a href="{{ url('/ulo/penetapan/telsus') }}"
                                        class="dropdown-item rounded">Penetapan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li> --}}
				</ul>
			</div>
		</div>
	@endauth
	<!-- /secondary navbar -->
	<!-- Page header -->
	{{-- <div class="page-header">
        <div class="page-header-content header-elements-lg-inline">
            <div class="header-elements d-none py-0 mb-3 mb-lg-0">
                <div class="breadcrumb">
                    <h4><a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home4 mr-2"></i> <span
                                class="font-weight-semibold">Beranda</span></a>
                        <span class="breadcrumb-item active">@yield('title')</span>
                    </h4>
                </div>
            </div>
        </div>
    </div> --}}
	<!-- /page header -->

	<!-- Page content -->

	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Content area -->
				<div class="content">
					@yield('content')
				</div>
				<!-- /content area -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<!-- Footer -->
	<div class="navbar navbar-expand-lg navbar-light border-bottom-0 border-top">
		<div class="text-center d-lg-none w-100">
			<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
				data-target="#navbar-footer">
				<i class="icon-unfold mr-2"></i>
				Footer
			</button>
		</div>

		<div class="navbar-collapse collapse" id="navbar-footer">
			<span class="navbar-text">
				&copy; 2022. <a href="javascript:void(0)">KOMINFO - eLicensing</a>
			</span>

			<ul class="navbar-nav ml-lg-auto">
				<li class="nav-item"><a href="/layanan" class="navbar-nav-link" target="_blank"><i
							class="icon-lifebuoy mr-2"></i>Layanan Bantuan</a></li>
				<li class="nav-item"><a href="/storage/guideline-etelekomunikasi.pdf" class="navbar-nav-link" target="_blank"><i
							class="icon-file-text2 mr-2"></i>
						Panduan e-Telekomunikasi</a></li>
			</ul>
		</div>
	</div>
	<!-- /footer -->

	<!-- Notifications -->
	<div id="notifications" class="modal modal-right fade" tabindex="-1" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-dialog-scrollable modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-transparent border-0 align-items-center">
					<h5 class="modal-title font-weight-semibold">Notifications</h5>
					<button type="button" class="btn btn-icon btn-light btn-sm border-0 rounded-pill ml-auto"
						data-dismiss="modal"><i class="icon-cross2"></i></button>
				</div>

				<div class="modal-body p-0">
					<div class="bg-light text-muted py-2 px-3">New notifications</div>
					<div class="p-3">
						<div class="d-flex mb-3">
							<a href="javascript:void(0)" class="mr-3">
								<img src="/global_assets/images/demo/users/face1.jpg" width="36" height="36" class="rounded-circle"
									alt="">
							</a>
							<div class="flex-1">
								<a href="javascript:void(0)" class="font-weight-semibold">James</a> has completed the
								task <a href="javascript:void(0)">Submit documents</a> from <a href="javascript:void(0)">Onboarding</a> list

								<div class="bg-light border rounded p-2 mt-2">
									<label class="custom-control custom-checkbox custom-control-inline mx-1">
										<input type="checkbox" class="custom-control-input" checked disabled>
										<del class="custom-control-label">Submit personal documents</del>
									</label>
								</div>

								<div class="font-size-sm text-muted mt-1">2 hours ago</div>
							</div>
						</div>

						<div class="d-flex mb-3">
							<a href="javascript:void(0)" class="mr-3">
								<img src="/global_assets/images/demo/users/face3.jpg" width="36" height="36" class="rounded-circle"
									alt="">
							</a>
							<div class="flex-1">
								<a href="javascript:void(0)" class="font-weight-semibold">Margo</a> was added to <span
									class="font-weight-semibold">Customer enablement</span> channel by <a href="javascript:void(0)">William
									Whitney</a>

								<div class="font-size-sm text-muted mt-1">3 hours ago</div>
							</div>
						</div>

						<div class="d-flex">
							<div class="mr-3">
								<div class="bg-danger-100 text-danger rounded-pill">
									<i class="icon-undo position-static p-2"></i>
								</div>
							</div>
							<div class="flex-1">
								Subscription <a href="javascript:void(0)">#466573</a> from 10.12.2021 has been
								cancelled. Refund case <a href="javascript:void(0)">#4492</a> created

								<div class="font-size-sm text-muted mt-1">4 hours ago</div>
							</div>
						</div>
					</div>

					<div class="bg-light text-muted py-2 px-3">Older notifications</div>
					<div class="p-3">
						<div class="d-flex mb-3">
							<a href="javascript:void(0)" class="mr-3">
								<img src="/global_assets/images/demo/users/face4.jpg" width="36" height="36" class="rounded-circle"
									alt="">
							</a>
							<div class="flex-1">
								<a href="javascript:void(0)" class="font-weight-semibold">Christine</a> commented on
								your community <a href="javascript:void(0)">post</a> from 10.12.2021

								<div class="font-size-sm text-muted mt-1">2 days ago</div>
							</div>
						</div>

						<div class="d-flex mb-3">
							<a href="javascript:void(0)" class="mr-3">
								<img src="/global_assets/images/demo/users/face24.jpg" width="36" height="36" class="rounded-circle"
									alt="">
							</a>
							<div class="flex-1">
								<a href="javascript:void(0)" class="font-weight-semibold">Mike</a> added 1 new file(s)
								to <a href="javascript:void(0)">Product management</a> project

								<div class="bg-light rounded p-2 mt-2">
									<div class="d-flex align-items-center mx-1">
										<div class="mr-2">
											<i class="icon-file-pdf text-danger icon-2x position-static"></i>
										</div>
										<div class="flex-1">
											new_contract.pdf
											<div class="font-size-sm text-muted">112KB</div>
										</div>
										<div class="ml-2">
											<a href="javascript:void(0)"
												class="btn btn-dark-100 text-body btn-icon btn-sm border-transparent rounded-pill">
												<i class="icon-arrow-down8"></i>
											</a>
										</div>
									</div>
								</div>

								<div class="font-size-sm text-muted mt-1">1 day ago</div>
							</div>
						</div>

						<div class="d-flex mb-3">
							<div class="mr-3">
								<div class="bg-success-100 text-success rounded-pill">
									<i class="icon-calendar3 position-static p-2"></i>
								</div>
							</div>
							<div class="flex-1">
								All hands meeting will take place coming Thursday at 13:45. <a href="javascript:void(0)">Add to
									calendar</a>

								<div class="font-size-sm text-muted mt-1">2 days ago</div>
							</div>
						</div>

						<div class="d-flex mb-3">
							<a href="javascript:void(0)" class="mr-3">
								<img src="/global_assets/images/demo/users/face25.jpg" width="36" height="36" class="rounded-circle"
									alt="">
							</a>
							<div class="flex-1">
								<a href="javascript:void(0)" class="font-weight-semibold">Nick</a> requested your
								feedback and approval
								in support request <a href="javascript:void(0)">#458</a>

								<div class="font-size-sm text-muted mt-1">3 days ago</div>
							</div>
						</div>

						<div class="d-flex">
							<div class="mr-3">
								<div class="bg-primary-100 text-primary rounded-pill">
									<i class="icon-people position-static p-2"></i>
								</div>
							</div>
							<div class="flex-1">
								<span class="font-weight-semibold">HR department</span> requested you to complete
								internal survey by Friday

								<div class="font-size-sm text-muted mt-1">3 days ago</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /notifications -->
	@yield('custom-js')
</body>

</html>
