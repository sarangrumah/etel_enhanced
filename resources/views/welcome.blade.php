<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>KOMINFO - e-Licensing</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/all.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="global_assets/js/main/jquery.min.js"></script>
	<script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="global_assets/js/plugins/visualization/echarts/echarts.min.js"></script>
	<script src="global_assets/js/plugins/maps/echarts/world.js"></script>

	<script src="assets/js/app.js"></script>
	<script src="global_assets/js/demo_charts/pages/dashboard_6/light/area_gradient.js"></script>
	<script src="global_assets/js/demo_charts/pages/dashboard_6/light/map_europe_effect.js"></script>
	<script src="global_assets/js/demo_charts/pages/dashboard_6/light/progress_sortable.js"></script>
	<script src="global_assets/js/demo_charts/pages/dashboard_6/light/bars_grouped.js"></script>
	<script src="global_assets/js/demo_charts/pages/dashboard_6/light/line_label_marks.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-expand-xl navbar-light navbar-static px-0">
		<div class="d-flex flex-1 pl-3">
			<div class="navbar-brand wmin-0 mr-1">
				<a href="index.html" class="d-inline-block">
					<img src="global_assets/images/logo_kominfo_text.png" class="d-none d-sm-block" alt="">
					<img src="global_assets/images/logo_kominfo_text.png" class="d-sm-none" alt="">
				</a>
			</div>
		</div>

		<div
			class="d-flex w-100 w-xl-auto overflow-auto overflow-xl-visible scrollbar-hidden border-top border-top-xl-0 order-1 order-xl-0">
			<ul class="navbar-nav navbar-nav-underline flex-row text-nowrap mx-auto">
				<li class="nav-item">
					<a href="index.html" class="navbar-nav-link active">
						<i class="icon-home4 mr-2"></i>
						Beranda
					</a>
				</li>

				<li class="nav-item dropdown nav-item-dropdown-xl">
					<a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-make-group mr-2"></i>
						Perizinan
					</a>

					<div class="dropdown-menu dropdown-scrollable-xl">
						<a href="javascript:void(0)" class="dropdown-item rounded">Registrasi</a>
						<div class="dropdown-divider"></div>
						<a href="javascript:void(0)" class="dropdown-item rounded">Perizinan</a>
						<a href="javascript:void(0)" class="dropdown-item rounded">Penomoran</a>
						<a href="javascript:void(0)" class="dropdown-item rounded">Persyaratan</a>
						<a href="javascript:void(0)" class="dropdown-item rounded">Uji Laik Operasi</a>
					</div>
				</li>

				<li class="nav-item dropdown nav-item-dropdown-xl">
					<a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-strategy mr-2"></i>
						Manajemen Perizinan
					</a>

					<div class="dropdown-menu dropdown-scrollable-xl">
						<a href="javascript:void(0)" class="dropdown-item rounded">Jasa</a>
						<a href="javascript:void(0)" class="dropdown-item rounded">Jaringan</a>
						<a href="javascript:void(0)" class="dropdown-item rounded">Telekomunikasi Khusus Berbadan Hukum</a>
					</div>
				</li>

				<li class="nav-item dropdown nav-item-dropdown-xl">
					<a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-loop3 mr-2"></i>
						Reporting
					</a>

					<div class="dropdown-menu dropdown-scrollable-xl">
						<a href="javascript:void(0)" class="dropdown-item rounded">Rekap Penomoran</a>
						<a href="{{ route('rekap-sklo') }}" class="dropdown-item rounded">Rekap SKLO</a>
					</div>
				</li>
			</ul>
		</div>

		<div class="d-flex flex-xl-1 justify-content-xl-end order-0 order-xl-1 pr-3">
			<ul class="navbar-nav navbar-nav-underline flex-row">
				{{-- <li class="nav-item">
					<a href="#notifications" class="navbar-nav-link navbar-nav-link-toggler" data-toggle="modal">
						<i class="icon-bell2"></i>
						<span class="badge badge-mark border-pink bg-pink"></span>
					</a>
				</li> --}}

				<li class="nav-item nav-item-dropdown-xl dropdown dropdown-user h-100">
					<a href="javascript:void(0)"
						class="navbar-nav-link navbar-nav-link-toggler d-flex align-items-center h-100 dropdown-toggle"
						data-toggle="dropdown">
						<img src="global_assets/images/demo/users/face11.jpg" class="rounded-circle mr-xl-2" height="38"
							alt="">
						<span class="d-none d-xl-block">Victoria</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="javascript:void(0)" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
						<a href="javascript:void(0)" class="dropdown-item"><i class="icon-coins"></i> My balance</a>
						<a href="javascript:void(0)" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span
								class="badge badge-primary badge-pill ml-auto">58</span></a>
						<div class="dropdown-divider"></div>
						<a href="javascript:void(0)" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
						<a href="javascript:void(0)" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
				{{-- <div class="page-header">
					<div class="page-header-content container header-elements-md-inline">
						<div class="d-flex">
							<div class="page-title">
								<h4 class="font-weight-semibold">@yield('title')</h4>
							</div>
							<a href="javascript:void(0)" class="header-elements-toggle text-body d-md-none"><i class="icon-more"></i></a>
						</div>
					</div>
				</div> --}}
				<!-- /page header -->

				<!-- Content area -->
				<div class="content container pt-0">
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
							&copy; 2022. <a href="javascript:void(0)">KOMINFO - e-Telekomunikasi</a> by <a href="javascript:void(0)"
								target="_blank">URMedia</a>
						</span>

						<ul class="navbar-nav ml-lg-auto">
							<li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i
										class="icon-lifebuoy mr-2"></i> Support</a></li>
							<li class="nav-item"><a href="https://demo.interface.club/limitless/docs/" class="navbar-nav-link"
									target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
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
								<img src="global_assets/images/demo/users/face1.jpg" width="36" height="36" class="rounded-circle"
									alt="">
							</a>
							<div class="flex-1">
								<a href="javascript:void(0)" class="font-weight-semibold">James</a> has completed the task <a
									href="javascript:void(0)">Submit documents</a> from <a href="javascript:void(0)">Onboarding</a> list

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
								<img src="global_assets/images/demo/users/face3.jpg" width="36" height="36" class="rounded-circle"
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
								Subscription <a href="javascript:void(0)">#466573</a> from 10.12.2021 has been cancelled. Refund case <a
									href="javascript:void(0)">#4492</a> created

								<div class="font-size-sm text-muted mt-1">4 hours ago</div>
							</div>
						</div>
					</div>

					<div class="bg-light text-muted py-2 px-3">Older notifications</div>
					<div class="p-3">
						<div class="d-flex mb-3">
							<a href="javascript:void(0)" class="mr-3">
								<img src="global_assets/images/demo/users/face4.jpg" width="36" height="36" class="rounded-circle"
									alt="">
							</a>
							<div class="flex-1">
								<a href="javascript:void(0)" class="font-weight-semibold">Christine</a> commented on your community <a
									href="javascript:void(0)">post</a> from 10.12.2021

								<div class="font-size-sm text-muted mt-1">2 days ago</div>
							</div>
						</div>

						<div class="d-flex mb-3">
							<a href="javascript:void(0)" class="mr-3">
								<img src="global_assets/images/demo/users/face24.jpg" width="36" height="36" class="rounded-circle"
									alt="">
							</a>
							<div class="flex-1">
								<a href="javascript:void(0)" class="font-weight-semibold">Mike</a> added 1 new file(s) to <a
									href="javascript:void(0)">Product management</a> project

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
								All hands meeting will take place coming Thursday at 13:45. <a href="javascript:void(0)">Add to calendar</a>

								<div class="font-size-sm text-muted mt-1">2 days ago</div>
							</div>
						</div>

						<div class="d-flex mb-3">
							<a href="javascript:void(0)" class="mr-3">
								<img src="global_assets/images/demo/users/face25.jpg" width="36" height="36" class="rounded-circle"
									alt="">
							</a>
							<div class="flex-1">
								<a href="javascript:void(0)" class="font-weight-semibold">Nick</a> requested your feedback and approval in
								support request <a href="javascript:void(0)">#458</a>

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
								<span class="font-weight-semibold">HR department</span> requested you to complete internal survey by Friday

								<div class="font-size-sm text-muted mt-1">3 days ago</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /notifications -->

</body>

</html>
