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
    <div class="navbar navbar-expand-xl navbar-dark navbar-static px-0">
        <div class="d-flex flex-1 pl-3">
            <div class="navbar-brand wmin-0 mr-1">
                <a href="{{ url('/landing') }}" class="d-inline-block">
                    <img src="/global_assets/images/landing/logo.svg" alt="logo">
                </a>
            </div>
            <ul class="navbar-nav navbar-nav-underline flex-row">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="navbar-nav-link">Beranda</a>
                </li>
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
                        <a href="javascript:void(0)" class="dropdown-item"> Hasil Nilai Survey IKM & IPP</a>
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

        <div class="d-flex flex-xl-1 justify-content-xl-end order-0 order-xl-1 pr-3">
            <ul class="navbar-nav navbar-nav-underline flex-row">
                @auth
                <li class="nav-item nav-item-dropdown-xl dropdown dropdown-user h-100">
                    <a href="javascript:void(0)"
                        class="navbar-nav-link navbar-nav-link-toggler d-flex align-items-center h-100 dropdown-toggle"
                        data-toggle="dropdown">
                        <span class="d-none d-xl-block">{{ Auth::user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        {{-- <a href="javascript:void(0)" class="dropdown-item"><i class="icon-user-plus"></i> Profil
                            Saya</a> --}}
                        {{-- <a href="javascript:void(0)" class="dropdown-item"><i class="icon-office"></i> Profil
                            Perusahaan</a> --}}
                        <a href="javascript:void(0)" class="dropdown-item"><i class="icon-cog5"></i> Atur kata Sandi</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <i class="icon-switch2"></i> Keluar
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @else
                <li class="nav-item button">
                    <a href="{{ route('register') }}" class="navbar-nav-link">Daftar</a>
                </li>
                <li class="nav-item button">
                    <a href="{{ route('login') }}" class="navbar-nav-link">Masuk</a>
                </li>
                @endauth
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
