<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>KOMINFO - e-Licensing</title>

	<!-- Global stylesheets -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900">
	<!-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" nonce="unique-nonce-value"> -->
	<!-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js" nonce="unique-nonce-value"></script> -->
	<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
	<!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->

	<link href="/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/all.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="/global_assets/js/main/jquery.min.js"></script>
	<script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="/assets/js/app.js"></script>
	@yield('js')
	<!-- <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script> -->
	<!-- <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->
	<link rel="stylesheet" href="/global_assets/css/extras/jquery-ui.css">
	<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="/global_assets/js/demo_pages/datatables_basic.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script type="text/javascript" src="/global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script>
	<style nonce="unique-nonce-value">
		.card-header[class*="bg-"] {
			padding-top: 0px;
			padding-bottom: 0px;
		}
	</style>
	<!-- /theme JS files -->
</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-expand-xl navbar-light navbar-static px-0">
		<div class="d-flex flex-1 pl-3">
			<div class="navbar-brand wmin-0 mr-1">
				<a href="#" class="d-inline-block">
					<img src="/global_assets/images/logo_kominfo_text.png" class="d-none d-sm-block" alt="">
					<img src="/global_assets/images/logo_kominfo_text.png" class="d-sm-none" alt="">
				</a>
			</div>
		</div>
		@if (Auth::guard('admin')->check())

			<div
				class="d-flex w-100 w-xl-auto overflow-auto overflow-xl-visible scrollbar-hidden border-top border-top-xl-0 order-1 order-xl-0">
				<ul class="navbar-nav navbar-nav-underline flex-row text-nowrap mx-auto">
					<li class="nav-item">
						<a href="{{ route('admin.dashboard') }}" class="navbar-nav-link">
							<i class="icon-home4 mr-2"></i>
							Beranda
						</a>
					</li>
					@if (Session::get('id_jabatan') != 6)

						<li class="nav-item dropdown nav-item-dropdown-xl">
							<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
								<i class="icon-make-group mr-2"></i>
								Administrasi
							</a>

							<div class="dropdown-menu dropdown-scrollable-xl">
								<a href="{{ route('admin.verifikatornib.evaluasiBimtek') }}" class="dropdown-item rounded">Evaluasi
									BimTek</a>
								<a href="{{ route('admin.verifikatornib.evaluasiregistrasi') }}" class="dropdown-item rounded">Evaluasi
									Register</a>
								<a href="{{ route('admin.user') }}" class="dropdown-item rounded">Daftar Pengguna</a>
								<a href="{{ route('admin.user-activities.index') }}" class="dropdown-item rounded">User Activities</a>
								<a href="{{ route('admin.masterholiday') }}" class="dropdown-item rounded">Daftar Hari
									Libur</a>
								<a href="{{ route('admin.evaluator.manageschedule') }}" class="dropdown-item rounded">Kelola Jadwal ULO</a>
								<a href="{{ route('admin.evaluator.uloschedule') }}" class="dropdown-item rounded">Kalender Jadwal ULO</a>
								<div class="dropdown-divider"></div>
								<a href="#" class="dropdown-item rounded">Daftar Perizinan</a>
								<a href="#" class="dropdown-item rounded">Daftar KBLI</a>
								<a href="#" class="dropdown-item rounded">Daftar Izin Layanan</a>
								<a href="{{ route('admin.faq') }}" class="dropdown-item rounded">Daftar FAQ</a>
							</div>
						</li>
						{{-- <li class="nav-item dropdown nav-item-dropdown-xl">
						<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
							<i class="icon-loop3 mr-2"></i>
							Laporan
						</a>

						<div class="dropdown-menu dropdown-scrollable-xl">
							<a href="/admin/laporan-register" class="dropdown-item rounded">Rekap Log Registrasi
							</a>
						</div>
					</li> --}}

						@if (Session::get('id_jabatan') != 5)
							<li class="nav-item dropdown nav-item-dropdown-xl">
								<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
									<i class="icon-strategy mr-2"></i>
									Manajemen Perizinan
								</a>

								<div class="dropdown-menu dropdown-scrollable-xl">

									@if (Session::get('id_jabatan') == 1)
										<div class="dropdown-divider"></div>
										<a href="{{ route('admin.direktur.ulo') }}" class="dropdown-item rounded">Uji Laik
											Operasi</a>
										<a href="{{ route('admin.direktur.sk-ulo') }}" class="dropdown-item rounded">Surat
											Keterangan
											Laik Operasi</a>
										<div class="dropdown-divider"></div>
										<a href="{{ route('admin.direktur.penyesuaian') }}" class="dropdown-item rounded">Perubahan
											Komitmen</a>
										<a href="{{ route('admin.direktur.penomoran') }}" class="dropdown-item rounded">Penomoran</a>
										<a href="{{ route('admin.direktur.sk-penomoran') }}" class="dropdown-item rounded">Surat
											Penetapan
											Penomoran</a>
									@elseif(Session::get('id_jabatan') == 2)
										<a href="{{ route('admin.koordinator.ulo') }}" class="dropdown-item rounded">Uji
											Laik
											Operasi</a>
									@elseif(Session::get('id_jabatan') == 3)
										<a href="{{ route('admin.subkoordinator.ulo') }}" class="dropdown-item rounded">Uji
											Laik
											Operasi</a>
									@elseif(Session::get('id_jabatan') == 4)
										@if (Session::get('id_departemen') == 5)
											<a href="{{ route('admin.pencabutan-penomoran') }}" class="dropdown-item rounded">Pencabutan
												Penomoran</a>
											{{-- <a href="{{ route('admin.history-penomoran') }}" class="dropdown-item rounded">Manajemen
                                    Data
                                    Alokasi Penomoran</a> --}}
											<a href="{{ route('admin.rekapalokasi') }}" class="dropdown-item rounded">Manajemen
												Data
												Alokasi Penomoran</a>
										@else
											<a href="{{ route('admin.evaluator.ulo') }}" class="dropdown-item rounded">Uji Laik
												Operasi</a>
											<a href="{{ route('admin.evaluator.koreksikomitmen') }}" class="dropdown-item rounded">Koreksi
												Komitmen</a>
										@endif
									@endif

								</div>
							</li>

							<li class="nav-item dropdown nav-item-dropdown-xl">
								<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
									<i class="icon-loop3 mr-2"></i>
									Laporan
								</a>

								<div class="dropdown-menu dropdown-scrollable-xl">
									<a href="/admin/daftarlayanan" class="dropdown-item rounded">Laporan
										Helpdesk</a>
									<a href="/admin/semua-penomoran" class="dropdown-item rounded">Laporan
										Permohonan Penomoran</a>
									<a href="/admin/semua-penetapan" class="dropdown-item rounded">Laporan
										Penetapan / Pencabutan
										Penomoran</a>
									<a href="{{ route('rekap-sklo') }}" class="dropdown-item rounded">Laporan Penetapan
										SKLO</a>
									<a href="/admin/laporan-log" class="dropdown-item rounded">Rekap Log Permohonan </a>
									<a href="/admin/laporan-register" class="dropdown-item rounded">Rekap Log Registrasi
									</a>
									<a href="/admin/laporan-requestkbli" class="dropdown-item rounded">Rekap Log
										Permohonan KBLI </a>
									<a href="/admin/laporan-disposisi" class="dropdown-item rounded">Rekap Log Disposisi
										Ketua Tim </a>
									<a href="/admin/rekappelakuusaha" class="dropdown-item rounded">Rekap Pelaku Usaha </a>
									<a href="/admin/rekapbimtek" class="dropdown-item rounded">Rekap Bimbingan Teknis </a>
									<a href="/admin/laporan-request" class="dropdown-item rounded">Rekap Histori
										Permohonan </a>
								</div>
							</li>

							@if (Session::get('id_departemen') == 5 || Session::get('id_departemen') == 6)
								<li class="nav-item dropdown nav-item-dropdown-xl">
									<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
										<i class="icon-stats-dots mr-2"></i>
										Survey IKM
									</a>

									<div class="dropdown-menu dropdown-scrollable-xl">
										<a href="/admin/survei/respond" class="dropdown-item rounded">Data Respon Survei</a>
										<a href="/admin/survei/result" class="dropdown-item rounded">Data Hasil Survei</a>

										<div class="dropdown-divider"></div>
										<a href="/admin/survei/manage" class="dropdown-item rounded">Manajemen Pertanyaaan
											Survei</a>
										<a href="/admin/survei/preview" class="dropdown-item rounded">Pratinjau Survei</a>
									</div>
								</li>
							@endif
						@endif
					@endif

				</ul>
			</div>

		@endif

		@if (Session::get('id_user') != '')
			<div class="d-flex flex-xl-1 justify-content-xl-end order-0 order-xl-1 pr-3">
				<ul class="navbar-nav navbar-nav-underline flex-row">
					{{-- <li class="nav-item">
					<a href="#notifications" class="navbar-nav-link navbar-nav-link-toggler" data-toggle="modal">
						<i class="icon-bell2"></i>
						<span class="badge badge-mark border-pink bg-pink"></span>
					</a>
				</li> --}}

					<li class="nav-item nav-item-dropdown-xl dropdown dropdown-user h-100">
						<a href="#"
							class="navbar-nav-link navbar-nav-link-toggler d-flex align-items-center h-100 dropdown-toggle"
							data-toggle="dropdown">
							<img src="/global_assets/images/pie-chart.png" class="rounded-circle mr-xl-2" height="25" alt="">
							<span class="d-none d-xl-block">{{ Session::get('nama') }}</span>
						</a>

						<div class="dropdown-menu dropdown-menu-right">
							<a href="{{ route('admin.edituser', Session::get('id_user')) }}" class="dropdown-item"><i
									class="icon-cog5"></i> Atur Kata Sandi</a>
							<a href="/admin/logout" class="dropdown-item"><i class="icon-switch2"></i>
								Keluar</a>
						</div>
					</li>
				</ul>
			</div>
		@endif
	</div>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
				<!-- <div class="page-header">
					<div class="page-header-content container header-elements-md-inline">
						<div class="d-flex">
							<div class="page-title">
								<h4 class="font-weight-semibold">@yield('title')</h4>
							</div>
							<a href="#" class="header-elements-toggle text-body d-md-none"><i class="icon-more"></i></a>
						</div>
					</div>
				</div> -->
				<!-- /page header -->

				<!-- Content area -->
				{{-- @yield('content') --}}
				<div class="content container pt-4">
					@yield('content')
				</div>
				<!-- /content area -->

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
							&copy; 2022. <a href="#">KOMINFO - e-Telekomunikasi</a>
						</span>

						<ul class="navbar-nav ml-lg-auto">
							<li class="nav-item"><a href="/" class="navbar-nav-link" target="_blank"><i
										class="icon-lifebuoy mr-2"></i>Helpdesk</a></li>
							<li class="nav-item"><a href="/" class="navbar-nav-link" target="_blank"><i
										class="icon-file-text2 mr-2"></i>
									Manual Book</a></li>
						</ul>
					</div>
				</div>
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	@stack('scripts')

	</html>
