@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
	<!-- Quick stats boxes -->
	<div class="row">

		<div class="col-lg">

		</div>

	</div>
	<!-- /quick stats boxes -->
	<div>
		<!-- Latest orders -->
		<div class="card">
			<div class="card-header d-flex py-0">
				<h6 class="card-title font-weight-semibold py-3">Daftar FAQ </h6>

				<div class="d-inline-flex align-items-center ml-auto">
					<div class="dropdown ml-2">
						<a href="{{ route('admin.addfaq') }}" class="dropdown-item"><i class="icon-user"></i> Tambah FAQ</a>

					</div>
				</div>
			</div>

			@if (session()->has('flash_notification.message'))
				<div class="container">
					<div class="alert alert-{{ session()->get('flash_notification.level') }}">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{!! session()->get('flash_notification.message') !!}
					</div>
				</div>
			@endif

			<div class="card-body">
				<div class="table-responsive border-top-0">
					<table class="table text-wrap">
						<?php $runningNumber = 1; ?>
						<thead>
							<tr>
								<th>No</th>
								<th class="text-center">Tipe Pertanyaan</th>
								<th class="text-center">Kategori Pertanyaan</th>
								<th class="text-center">Pertanyaan</th>
								<th class="text-center">Jawaban</th>
								<th class="text-center">Dokumen</th>
								<th class="text-center">Status</th>

								<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
							</tr>
						</thead>
						<tbody>
							{{-- @if (count($faqs['data']) > 0) --}}
							@if (isset($faqs['data']))
								@foreach ($faqs['data'] as $faq)
									<tr>
										<td>
											<div class="d-flex align-items-center">
												<div>
													<a href="#" class="text-body font-weight-semibold">{{ $runningNumber++ }}</a>

												</div>
											</div>
										</td>
										<td class="text-center">{{ $faq['type'] }}</td>
										<td class="text-center">{{ $faq['category'] }}</td>
										<td>{!! $faq['question'] !!}</td>
										<td>{!! $faq['answer'] !!}</td>
										<td class="text-center">
											@if (isset($faq['download_link']) && $faq['download_link'] != '')
												<a target="_blank" href="{{ $faq['download_link'] }}">Unduh</a>
											@else
												--
											@endif
										</td>
										<td class="text-center">
											@if (isset($faq['is_active']) && $faq['is_active'] != '')
												@if ($faq['is_active'] == '1')
													<span class="badge badge-success-100 text-success">Aktif</span>
												@else
													<span class="badge badge-success-100 text-danger">Tidak Aktif</span>
												@endif
											@else
												<span class="badge badge-success-100 text-danger">Tidak Aktif</span>
											@endif
										</td>
										<td class="text-center">
											<div class="dropdown">
												<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
													data-toggle="dropdown">
													<i class="icon-menu7"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="{{ route('admin.editfaq', $faq['id']) }}" class="dropdown-item"><i class="icon-pencil"></i> Ubah</a>
													{{-- <a onclick="return false;" href="{{ route('admin.deleteuser',$user['id']) }}" class="dropdown-item deletebutton"><i class="icon-trash"></i> Hapus</a> --}}

												</div>
											</div>
										</td>
									</tr>
								@endforeach
							@endif

						</tbody>
					</table>
				</div>
			</div>

		</div>

		<div class="text-right pagination-flat" style="float:right;">
			@if ($paginate != null && $paginate->count() > 0)
				{{ $paginate->links() }}
			@endif
		</div>

		<!-- /latest orders -->
	</div>
	<script>
		$(document).ready(function() {
			$('.deletebutton').click(function() {
				// console.log($(this).attr('href'));
				if (confirm('Apakah anda yakin akan menghapus FAQ ini ?')) {
					location.href = $(this).attr('href');
				} else {
					return false;
				}
			})
		});
	</script>
@endsection
