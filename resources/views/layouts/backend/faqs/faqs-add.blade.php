@extends('layouts.backend.main')

@section('content')
	<form method="post" id="formFaq" action="{{ route('admin.addfaqspost') }}" enctype="multipart/form-data">
		@csrf
		<div class="form-group">

			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Tambah Pertanyaan</h6>
						</div>
					</div>
				</div>

				<div class="card-body">
					<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
					<script src="/global_assets/js/demo_pages/form_layouts.js"></script>
					<script src="//cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
					<div>
						@if ($errors->any())
							@foreach ($errors->all() as $error)
								<div class="alert alert-danger alert-block">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>{{ $error }}</strong>
								</div>
							@endforeach
						@endif

						@if (session()->has('flash_notification.message'))
							<div class="">
								<div class="alert alert-{{ session()->get('flash_notification.level') }}">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									{!! session()->get('flash_notification.message') !!}
								</div>
							</div>
						@endif

						<fieldset>

							<div class="form-group">
								<div class="col-lg">
									<div class="row">
										<div class="col-6">
											<p class="font-weight-semibold">Tipe Pertanyaan</p>
											<select id="faq_types" id="faq_types" name="faq_types" class="form-control">
												<option value="" disabled selected>-- Pilih Tipe Pertanyaan</option>
												@foreach ($faq_type as $faq_types)
													<option value="{{ $faq_types->short_desc }}">{{ $faq_types->desc }}</option>
												@endforeach
											</select>

										</div>
										<div class="col-6">
											<p class="font-weight-semibold">Kategori Pertanyaan</p>
											<select id="faq_category" id="faq_category" name="faq_category" class="form-control">
												<option value="" disabled selected>-- Pilih Kategori Pertanyaan</option>
												@foreach ($faq_category as $faq_categories)
													<option value="{{ $faq_categories->short_desc }}">{{ $faq_categories->desc }}</option>
												@endforeach
											</select>

										</div>

									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg">
									<div class="row">
										<div class="col-lg-6">
											<p class="font-weight-semibold">Dokumen</p>
											{{-- <input type="text" id="faq_question" name="faq_question" class="form-control" placeholder="Pertanyaan"> --}}
											{{-- <textarea class="form-control" id="faq_document" rows="3"></textarea> --}}
											<input type="file" class="form-control h-auto" name="faq_document" id="faq_document"
												accept="application/pdf">
										</div>
										<div class="col-6">
											<p class="font-weight-semibold">Status</p>
											<select id="faq_status" name="faq_status" class="form-control">
												<option value="" disabled selected>-- Pilih Status Pertanyaan</option>
												<option value="1">Aktif</option>
												<option value="0">Tidak Aktif</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg">
									<div class="row">
										<div class="col-12">
											<p class="font-weight-semibold">Pertanyaan</p>
											<textarea class="form-control" id="faq_question" name="faq_question" rows="3"></textarea>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg">
									<div class="row">
										<div class="col-12">
											<p class="font-weight-semibold">Jawaban</p>
											<textarea class="form-control" id="faq_answer" name="faq_answer" rows="3"></textarea>
										</div>
									</div>
								</div>
							</div>

						</fieldset>
					</div>
				</div>
			</div>

			<div class="form-group text-right">
				<a href="{{ route('admin.user') }}" class="btn btn-light"><i class="icon-backward2 ml-2"></i> Kembali </a>
				<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		CKEDITOR.replace('faq_question');
		CKEDITOR.replace('faq_answer');
	</script>
@endsection
