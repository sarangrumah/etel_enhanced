<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    {{--
    <meta http-equiv="Content-Security-Policy"
        content="default-src 'self'; img-src https://*; child-src 'none'; text/html; charset=UTF-8"> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>KOMINFO - e-Telekomunikasi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Global stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" integrity="sha384-qG0E00yS7hr8A2CPVjXFNSt9f5rWICyFvnzrUzKScqX4BbzZOPQkp3WiaU29YFsO" crossorigin="anonymous">
    <link href="/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/landing.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/global_assets/css/extras/jquery-ui.css">
    <!-- /global stylesheets -->

    <link rel="stylesheet" href="/global_assets/css/extras/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- Core JS files -->
    <script src="/global_assets/js/main/jquery.min.js"></script>
    <script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>


    <!-- /core JS files -->

    <!-- Theme JS files -->
    <!-- <script src="global_assets/js/plugins/visualization/echarts/echarts.min.js"></script> -->
    <!-- <script src="global_assets/js/plugins/maps/echarts/world.js"></script> -->

    <script src="/assets/js/app.js"></script>
    <!-- <script src="global_assets/js/demo_charts/pages/dashboard_6/light/area_gradient.js"></script> -->
    <!-- <script src="global_assets/js/demo_charts/pages/dashboard_6/light/map_europe_effect.js"></script> -->
    <!-- <script src="global_assets/js/demo_charts/pages/dashboard_6/light/progress_sortable.js"></script> -->
    <!-- <script src="global_assets/js/demo_charts/pages/dashboard_6/light/bars_grouped.js"></script> -->
    <!-- <script src="global_assets/js/demo_charts/pages/dashboard_6/light/line_label_marks.js"></script> -->
    @yield('js')
    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
	<div class="navbar navbar-expand-xl navbar-light navbar-static px-0">
		<div class="d-flex pl-3">
			<div class="navbar-brand wmin-0 mr-1">
				<a href="#" class="d-inline-block">
					<img src="{{url('global_assets/images/logo_kominfo_text.png')}}" class="d-none d-sm-block" alt="">
					<img src="{{url('global_assets/images/logo_kominfo_text.png')}}" class="d-sm-none" alt="">
				</a>
			</div>
		</div>
		<?php 
		if (Auth::guard('admin')->check()) {
            
			?>
		<div
			class="d-flex w-100 w-xl-auto overflow-auto overflow-xl-visible scrollbar-hidden border-top border-top-xl-0 order-1 order-xl-0">
			<ul class="navbar-nav navbar-nav-underline flex-row text-nowrap mx-auto">
				<li class="nav-item"></li>
					<a href="{{route('admin.dashboard')}}" class="navbar-nav-link">
						<i class="icon-home4 mr-2"></i>
						Beranda
					</a>
				</li>

				<li class="nav-item dropdown nav-item-dropdown-xl">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-make-group mr-2"></i>
						Administrasi
					</a>

					<div class="dropdown-menu dropdown-scrollable-xl">
						<a href="{{route('admin.user')}}" class="dropdown-item rounded">Daftar Pengguna</a>
						<a href="{{route('admin.masterholiday')}}" class="dropdown-item rounded">Daftar Hari Libur</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item rounded">Daftar Perizinan</a>
						<a href="#" class="dropdown-item rounded">Daftar KBLI</a>
						<a href="#" class="dropdown-item rounded">Daftar Izin Layanan</a>
					</div>
				</li>

				<li class="nav-item dropdown nav-item-dropdown-xl">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-strategy mr-2"></i>
						Manajemen Perizinan
					</a>

					<div class="dropdown-menu dropdown-scrollable-xl">
						<a href="{{route('admin.koordinator.evaluasiregistrasi')}}"
							class="dropdown-item rounded">Evaluasi Register</a>
						@if(Session::get('id_jabatan') == 1)
						<div class="dropdown-divider"></div>
						<a href="{{route('admin.direktur.ulo')}}" class="dropdown-item rounded">Uji Laik Operasi</a>
						<a href="{{route('admin.direktur.sk-ulo')}}" class="dropdown-item rounded">Surat Keterangan
							Laik Operasi</a>
						<div class="dropdown-divider"></div>
						<a href="{{route('admin.direktur.penomoran')}}" class="dropdown-item rounded">Penomoran</a>
						<a href="{{route('admin.direktur.sk-penomoran')}}" class="dropdown-item rounded">Surat Penetapan
							Penomoran</a>
						@elseif(Session::get('id_jabatan') == 2)
						<a href="{{route('admin.koordinator.ulo')}}" class="dropdown-item rounded">Uji Laik Operasi</a>
						@elseif(Session::get('id_jabatan') == 3)
						<a href="{{route('admin.subkoordinator.ulo')}}" class="dropdown-item rounded">Uji Laik
							Operasi</a>
						@elseif(Session::get('id_jabatan') == 4)
						<a href="{{route('admin.evaluator.ulo')}}" class="dropdown-item rounded">Uji Laik Operasi</a>
						@endif

						<a href="{{route('admin.pencabutan-penomoran')}}" class="dropdown-item rounded">Pencabutan
							Penomoran</a>
						<a href="{{route('admin.history-penomoran')}}" class="dropdown-item rounded">Manajemen Data
							Alokasi Penomoran</a>

						<?php /*
							<div class="dropdown-divider"></div>
							$id_departemen = Session::get('id_departemen');
							if ($id_departemen == 1) {
								?><a href="{{route('admin.dashboard')}}" class="dropdown-item rounded">Perizinan Jasa</a>
						<?php
							}else if($id_departemen == 2){
								?><a href="{{route('admin.dashboard')}}" class="dropdown-item rounded">Perizinan Jaringan</a>
						<?php
							}else if($id_departemen == 3){
								?><a href="{{route('admin.dashboard')}}" class="dropdown-item rounded">Perizinan Telekomunikasi Khusus Berbadan
							Hukum</a>
						<?php
							}
							*/
							?>
					</div>
				</li>

				<li class="nav-item dropdown nav-item-dropdown-xl">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-loop3 mr-2"></i>
						Laporan
					</a>

					<div class="dropdown-menu dropdown-scrollable-xl">
						<a href="{{ url('/admin/semua-penomoran') }}" class="dropdown-item rounded">Laporan
							Penomoran</a>
						<a href="{{ url('/admin/semua-penetapan') }}" class="dropdown-item rounded">Laporan Penetapan
							Penomoran</a>
						<a href="{{ route('rekap-sklo') }}" class="dropdown-item rounded">Laporan Penetapan SKLO</a>
					</div>
				</li>

				<li class="nav-item dropdown nav-item-dropdown-xl">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-stats-dots mr-2"></i>
						Survey IKM
					</a>

					<div class="dropdown-menu dropdown-scrollable-xl">
						<a href="/admin/svmgmt" class="dropdown-item rounded">Edit Survey</a>
						<a href="/admin/qsmgmt" class="dropdown-item rounded">Edit Question</a>
						<a href="/admin/bgdt-hasil-survey" class="dropdown-item rounded">Hasil Survey</a>
						<a href="/admin/responder/list" class="dropdown-item rounded">List Responder</a>
					</div>
				</li>

				<li class="nav-item dropdown nav-item-dropdown-xl">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-stats-dots mr-2"></i>
						Big Data
					</a>

					<div class="dropdown-menu dropdown-scrollable-xl">
						<a href="/admin/bigdata/perizinan" class="dropdown-item rounded">Permohonan Perizinan</a>
						{{-- <a href="/admin/bigdata/survey" class="dropdown-item rounded">Survey IKM & IIPP</a> --}}
						<a href="/admin/bigdata/survey-jastel" class="dropdown-item rounded">Survey IKM & IIPP JASTEL</a>
						<a href="/admin/bigdata/survey-jartel" class="dropdown-item rounded">Survey IKM & IIPP JARTEL</a>
						<a href="/admin/bigdata/survey-telsus" class="dropdown-item rounded">Survey IKM & IIPP TELSUS</a>
						<a href="/admin/bigdata/survey-penomoran" class="dropdown-item rounded">Survey IKM & IIPP PENOMORAN</a>
						<a href="/admin/bigdata/survey-ulo" class="dropdown-item rounded">Survey IKM & IIPP Uji Laik Operasi</a>
					</div>
				</li>
			</ul>
		</div>
		<?php
		}
		?>

		@if(Session::get('id_user') != '')
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
						<img src="{{url('global_assets/images/pie-chart.png')}}" class="rounded-circle mr-xl-2"
							height="25" alt="">
						<span class="d-none d-xl-block">{{Session::get('nama')}}</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="{{route('admin.edituser',Session::get('id_user'))}}" class="dropdown-item"><i
								class="icon-cog5"></i> Atur Kata Sandi</a>
						<a href="{{url('admin/logout')}}" class="dropdown-item"><i class="icon-switch2"></i> Keluar</a>
					</div>
				</li>
			</ul>
		</div>
        @else
        @auth
            <div class="d-flex w-100 w-xl-auto overflow-auto overflow-xl-visible scrollbar-hidden border-top border-top-xl-0 order-1 order-xl-0">
                <ul class="navbar-nav flex-row text-nowrap">
                    <li class="nav-item">
                        <a href="{{ url('/landing') }}" class="navbar-nav-link active">
                            <i class="icon-home4 mr-2"></i>
                            Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="navbar-nav-link active">
                            <i class="icon-list2 mr-2"></i>
                            Permohonan
                        </a>
                    </li>

                    <li class="nav-item nav-item-dropdown-xl dropdown">
                        <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-office mr-2"></i>
                            Instansi Pemerintah
                        </a>

                        <div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
                            <div class="dropdown-content-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3 mb-md-0">
                                        <div class="font-weight-semibold border-bottom pb-2 mb-2">Pendaftaran Data</div>
                                        <a href="{{ url('/ip/registerpt') }}" class="dropdown-item rounded">Kelengkapan Data
                                            Instansi</a>
                                        <a href="{{ url('/ip/registerpj') }}" class="dropdown-item rounded">Kelengkapan Data
                                            Penanggung Jawab</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('penomoran-baru') }}" class="navbar-nav-link">
                            <i class="icon-stack2 mr-2"></i>
                            Pengajuan UMKU
                        </a>

                        {{-- <div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
                        <div class="dropdown-content-body">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div href="{{ url('penomoran-baru')}}"
                                        class="font-weight-semibold border-bottom pb-2 mb-2">Penomoran</div>
                                    <a href="{{ url('penomoran-baru')}}" class="dropdown-item rounded">Permohonan
                                        Baru</a>
                                    <a href="{{ url('penomoran-baru')}}" class="dropdown-item rounded">Permohonan
                                        Penambahan Nomor</a>
                                    <a href="javascript:void(0)" class="dropdown-item rounded">Permohonan
                                        Penyesuaian</a>
                                    <a href="javascript:void(0)" class="dropdown-item rounded">Permohonan
                                        Pengembalian</a>
                                </div>

                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="font-weight-semibold border-bottom pb-2 mb-2">Rekap</div>
                                    <a href="javascript:void(0)" class="dropdown-item rounded">Penomoran Aktif</a>
                                    <a href="javascript:void(0)" class="dropdown-item rounded">Penomoran Idle</a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    </li>
                    <li class="nav-item nav-item-dropdown-lg mega-menu-full">
                        <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-stack2 mr-2"></i>
                            Perizinan Berusaha
                        </a>

                        <div class="dropdown-menu dropdown-scrollable-lg wmin-lg-300 p-0">
                            <div class="dropdown-content-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <div class="font-weight-semibold border-bottom pb-2 mb-2">Jasa Telekomunikasi</div>
                                        <a href="{{ url('/pb/permohonan/jasa') }}" class="dropdown-item rounded">Pemenuhan
                                            Persyaratan</a>
                                        <!-- <a href="{{ url('/pemenuhanpersyaratan/jasa') }}" class="dropdown-item rounded">Pemenuhan Persyaratan</a> -->
                                        <a href="{{ url('/pb/koreksipersyaratan/jasa') }}"
                                            class="dropdown-item rounded">Perbaikan Persyaratan</a>
                                        <a href="{{ url('/pb/penetapan/jasa') }}"
                                            class="dropdown-item rounded">Penetapan</a>
                                    </div>

                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <div class="font-weight-semibold border-bottom pb-2 mb-2">Jaringan Telekomunikasi
                                        </div>
                                        <a href="{{ url('/pb/permohonan/jaringan') }}"
                                            class="dropdown-item rounded">Pemenuhan Persyaratan</a>
                                        {{-- <a href="{{ url('/pb/permohonan/jaringan') }}"
                                        class="dropdown-item rounded">Permohonan Baru</a> --}}
                                        <!-- <a href="{{ url('/pemenuhanpersyaratan/jaringan') }}" class="dropdown-item rounded">Pemenuhan Persyaratan</a> -->
                                        <a href="{{ url('/pb/koreksipersyaratan/jaringan') }}"
                                            class="dropdown-item rounded">Perbaikan Persyaratan</a>
                                        <a href="{{ url('/pb/penetapan/jaringan') }}"
                                            class="dropdown-item rounded">Penetapan</a>
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <div class="font-weight-semibold border-bottom pb-2 mb-2">Telekomunikasi Khusus
                                        </div>
                                        <a href="{{ url('/pb/permohonan/telsus') }}"
                                            class="dropdown-item rounded">Pemenuhan
                                            Persyaratan</a>
                                        <a href="{{ url('/pb/koreksipersyaratan/telsus') }}"
                                            class="dropdown-item rounded">Perbaikan Persyaratan</a>
                                        <a href="{{ url('/pb/penetapan/telsus') }}"
                                            class="dropdown-item rounded">Penetapan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item nav-item-dropdown-xl dropdown">
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
                </ul>
            </div>
            <div class="d-flex flex-xl-1 justify-content-xl-end order-0 order-xl-1 pr-3">
			<ul class="navbar-nav navbar-nav-underline flex-row">
                <li class="nav-item nav-item-dropdown-xl dropdown dropdown-user h-100">
                    <a href="javascript:void(0)"
                        class="navbar-nav-link navbar-nav-link-toggler d-flex align-items-center h-100 dropdown-toggle"
                        data-toggle="dropdown">
                        <!-- {{-- <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?f=y&d=mp" --}} -->
                        <img src="/global_assets/images/logo_kominfo.png" class="rounded-circle mr-xl-2" height="38"
                            alt="">
                        <span class="d-none d-xl-block">{{ Auth::user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        {{-- <a href="javascript:void(0)" class="dropdown-item"><i class="icon-user-plus"></i> Profil
                        Saya</a> --}}
                        {{-- <a href="javascript:void(0)" class="dropdown-item"><i class="icon-office"></i> Profil
                        Perusahaan</a> --}}
                        <a href="javascript:void(0)" class="dropdown-item"><i class="icon-cog5"></i> Atur kata Sandi</a>
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
			</ul>
		    </div>
        @else
        <div class="d-flex flex-xl-1 justify-content-xl-end order-0 order-xl-1 pr-3">
			<ul class="navbar-nav navbar-nav-underline flex-row">
                <li class="nav-item button">
                    <a href="{{ route('register') }}" class="navbar-nav-link">Daftar</a>
                </li>
                <li class="nav-item button">
                    <a href="{{ route('login') }}" class="navbar-nav-link">Masuk</a>
                </li>
            </ul>
        </div>
        @endauth
		@endif
        <div class="d-flex w-100 w-xl-auto overflow-auto overflow-xl-visible scrollbar-hidden border-top border-top-xl-0 order-1 order-xl-0">
            <ul class="navbar-nav navbar-nav-underline flex-row">
                <li class="nav-item nav-item-dropdown-xl dropdown dropdown-user h-100">
                    <a class="navbar-nav-link navbar-nav-link-toggler d-flex align-items-center h-100 dropdown-toggle" data-toggle="dropdown">
                        Informasi
                    </a>

                    <div class="dropdown-menu">
                        <a href="{{ url('/standar-pelayanan') }}" class="dropdown-item"> Standar Pelayanan</a>
                        <a href="{{ url('/informasi-jastel') }}" class="dropdown-item"> Perizinan Jasa Telekomunikasi</a>
                        <a href="{{ url('/informasi-jartel') }}" class="dropdown-item"> Perizinan Jaringan Telekomunikasi</a>
                        <a href="{{ url('/informasi-telsus') }}" class="dropdown-item"> Perizinan Telekomunikasi Khusus</a>
                        <a href="{{ url('/informasi-penomoran') }}" class="dropdown-item"> Penomoran</a>
                        {{-- <a href="javascript:void(0)" class="dropdown-item"> Hasil Nilai Survey IKM & IPP</a> --}}
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/panduan') }}" class="navbar-nav-link">Panduan</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/faq') }}" class="navbar-nav-link">FAQ</a>
                </li>
            </ul>
        </div>
	</div>
	<!-- /main navbar -->

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
                <div class="content container">
                    @yield('content')
                </div>
                <!-- /content area -->

                <!-- Footer -->
                <footer class="section footer-classic context-dark bg-image">
                    <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                        <div><a class="brand"><img class="brand-logo-light img-fluid" src="/global_assets/images/landing/logo_footer.svg" alt="footer logo"></a>
                            <ul class="list-unstyled p-4">
                            <li class="media">
                                <img src="/global_assets/images/landing/icon_point.svg" width="25" height="25" alt="footer icon">
                                <div class="media-body">
                                <p>Jalan Medan Merdeka Barat No. 9 Jakarta Pusat DKI Jakarta 10110 Indonesia</p>
                                </div>
                            </li>
                            <li class="media">
                                <img src="/global_assets/images/landing/icon_www.svg" width="25" height="25" alt="footer icon">
                                <div class="media-body">
                                <p>www.kominfo.go.id</p>
                                </div>
                            </li>
                            </ul>
                        </div>
                        </div>
                        <div class="col-md-4 offset-md-1 col-sm-12">
                        <h2>Sistem Perizinan Telekomunikasi</h2>
                        <h4>Kontak:</h4>
                        <ul class="list-unstyled">
                            <li class="media">
                                <img src="/global_assets/images/landing/icon_point.svg" width="25" height="25" alt="footer icon">
                                <div class="media-body">
                                <p><span>PTSP</span></p><p>Medan Merdeka Barat No. 9 Jakarta Pusat DKI Jakarta 10110 Indonesia</p>
                                </div>
                            </li>
                            <li class="media">
                                <img src="/global_assets/images/landing/icon_phone2.svg" width="25" height="25" alt="footer icon">
                                <div class="media-body">
                                <h4>159</h4>
                                </div>
                            </li>
                            <li class="media">
                                <img src="/global_assets/images/landing/icon_email.svg" width="25" height="25" alt="footer icon">
                                <div class="media-body">
                                <p>e-telekomunikasi@kominfo.go.id</p>
                                </div>
                            </li>
                        </ul>
                        </div>
                        <div class="col-md-3 offset-md-1 col-sm-12">
                        <h2>Social Media</h5>
                        <ul class="nav-list list-unstyled list-inline">
                            <li class="list-inline-item"><img src="/global_assets/images/landing/logo_ig.svg" width="25" height="25" alt="Instagram"></li>
                            <li class="list-inline-item"><img src="/global_assets/images/landing/logo_fb.svg" width="25" height="25" alt="Facebook"></li>
                            <li class="list-inline-item"><img src="/global_assets/images/landing/logo_twt.svg" width="25" height="25" alt="Twitter"></li>
                            <li class="list-inline-item"><img src="/global_assets/images/landing/logo_yt.svg" width="25" height="25" alt="Youtube"></li>
                        </ul>
                        </div>
                    </div>
                    </div>
                </footer>
                <!-- /footer -->
            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
    @yield('custom-js')
</body>

</html>
