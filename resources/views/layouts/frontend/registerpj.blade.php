@extends('layouts.frontend.main')
@section('js')

<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="global_assets/js/demo_pages/form_layouts.js"></script>
@endsection
@section('custom-js')
@endsection
@section('content')
<div class="form-group">
    <div class="card">
		<div class="card-header bg-indigo text-white header-elements-inline">
			<div class="row">
				<div class="col-lg">
					<h6 class="card-title font-weight-semibold py-3">Pendaftaran Penanggung Jawab</h6>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-info alert-styled-left alert-dismissible">
				<span class="font-weight-semibold">Seluruh Dokumen dalam format PDF dan maksimal 5 MB.</span>
			</div>
			<x-fe_register_pj />
		</div>
    </div>
</div>

@endsection
