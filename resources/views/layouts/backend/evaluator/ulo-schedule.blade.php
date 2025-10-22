@extends('layouts.backend.main')
@section('js')
	<script nonce="unique-nonce-value" src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script nonce="unique-nonce-value" src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
	<script nonce="unique-nonce-value" src="{{ url('assets/js/vendor/ui/fullcalendar/main.min.js') }}"></script>
	<script nonce="unique-nonce-value" src="{{ url('global_assets/js/demo_pages/fullcalendar_basic.js') }}"></script>
	{{-- <script src="{{ url('assets/demo/pages/components_tooltips.js') }}"></script> --}}
@endsection
@section('content')
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
				<div class="page-header page-header-light shadow">
					<div class="page-header-content d-lg-flex">
						<div class="d-flex">
							<h4 class="page-title mb-0">
								Jadwal Uji Laik Operasi - <span class="fw-normal">Direktorat Telekomunikasi</span>
							</h4>

							<a href="#page_header"
								class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
								data-bs-toggle="collapse">
								<i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /page header -->

				<!-- Content area -->
				<div class="content">

					<!-- Basic view -->
					<div class="card">
						{{-- <div class="card-header">
							<h5 class="mb-0">Basic view</h5>
						</div> --}}

						<div class="card-body">
							<p class="mb-3">Jadwal berikut merupakan hasil verifikasi oleh tim Direktorat Telekomunikasi berdasarkan
								pangajuan tanggal Uji Laik Operasi yang diajukan oleh pemohon.</p>
							{{-- <div id="tooltip"
								style="display:none; position:absolute; background-color: rgba(255, 255, 255, 0.9); border: 1px solid #ccc; padding: 5px; z-index: 999;">
							</div> --}}

							<div class="fullcalendar-basic"></div>
						</div>
					</div>
					<!-- /basic view -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
@endsection
{{-- <script nonce="unique-nonce-value" type="text/javascript">
	// < style >
	// 	.calendar - tooltip {
	// 		max - width: 200 px;
	// 		font - size: 14 px;
	// 		line - height: 1.5;
	// 	} </style>
</script> --}}
