@extends('layouts.backend.main')

@section('content')
	<div>
		@if (Session::get('message') != '')
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{{ Session::get('message') }}</strong>
			</div>
		@endif

		<div class="card">
			<div class="card-header d-flex py-0">
				<h6 class="card-title font-weight-semibold py-3">Agenda Tim Kelayakan</h6>
				<button class="btn btn-primary btn-sm ml-auto" data-toggle="modal" data-target="#addAgendaModal">Tambah Agenda</button>
			</div>

			<div class="card-body">
				<div class="table-responsive border-top-0">
					<table class="table text-nowrap datatable-basic" id="table">
						<thead>
							<tr>
								<th class="col-1" hidden></th>
								<th class="text-center">#</th>
								<th class="text-center">Agenda</th>
								<th class="text-center">Tanggal Kegiatan</th>
								<th class="text-center">Lokasi</th>
								<th class="text-center">Status</th>
								<th class="text-center col-1"><i class="icon-arrow-down12"></i></th>
							</tr>
						</thead>
						<tbody>
							@if (isset($events) && count($events) > 0)
								@foreach ($events as $event)
									<tr>
										<td class="text-center" hidden></td>
										<td class="text-center">{{ $event['id'] }}</td>
										<td class="text-center">{{ $event['title'] ?? '-' }}</td>
										<td class="text-center">{{ $date_reformat->dateday_lang_reformat_long($event['start']) }} -
											{{ $date_reformat->dateday_lang_reformat_long($event['end']) }}</td>
										<td class="text-center"><span class="badge badge-success-100 text-success">{{ $event['locate'] }}</span></td>

										@if ($event['is_active'] === 1)
											<td class="text-center"><span class="badge badge-success-100 text-success">Aktif</span></td>
										@elseif ($event['is_active'] === 2)
											<td class="text-center"><span class="badge badge-success-100 text-danger">Tidak Aktif</span></td>
										@endif
										<td class="text-center">
											<div class="dropdown">
												<a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill"
													data-toggle="dropdown">
													<i class="icon-menu7"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="#" class="dropdown-item" data-toggle="modal" data-target="#editAgendaModal"
														data-id="{{ $event['id'] }}" data-title="{{ $event['title'] }}" data-start="{{ $event['start'] }}"
														data-end="{{ $event['end'] }}" data-locate="{{ $event['locate'] }}"><i class="icon-pencil"></i> Ubah
														Agenda</a>
													@if ($event['is_active'] === 1)
														<a href="#" class="dropdown-item" data-toggle="modal" data-target="#deactivateAgendaModal"
															data-id="{{ $event['id'] }}"><i class="icon-x"></i> Nonaktifkan Agenda</a>
													@endif
													@if ($event['is_active'] === 2)
														<a href="#" class="dropdown-item" data-toggle="modal" data-target="#deactivateAgendaModal"
															data-id="{{ $event['id'] }}"><i class="icon-x"></i> Aktifkan Agenda</a>
													@endif
												</div>
											</div>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
				{{-- <div class="text-right pagination-flat">
					@if ($paginate->count() > 0)
						{{ $paginate->links() }}
					@endif
				</div> --}}
			</div>
		</div>
		{{-- <div class="text-right pagination-flat" style="float:right">
			{{ $paginate->links() }}
		</div> --}}
	</div>

	<!-- Add Agenda Modal -->
	<div class="modal fade" id="addAgendaModal" tabindex="-1" role="dialog" aria-labelledby="addAgendaModalLabel"
		aria-hidden="true">
		<form id="addAgendaForm" method="POST" action="{{ route('admin.schedule.store') }}">
			@csrf
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addAgendaModalLabel">Tambah Agenda</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="title">Agenda</label>
							<input type="text" class="form-control" id="title" name="title" required>
						</div>
						<div class="form-group">
							<label for="start">Tanggal Kegiatan</label>
							<input type="date" class="form-control" id="start" name="start" required>
						</div>
						<div class="form-group">
							<label for="end">Tanggal Selesai</label>
							<input type="date" class="form-control" id="end" name="end">
						</div>
						<div class="form-group">
							<label for="locate">Lokasi</label>
							<input type="text" class="form-control" id="locate" name="locate" required>
						</div>
						<div class="form-group">
							<label for="is_active">Aktif</label>
							<input type="checkbox" id="edit_is_active" name="is_active" value="1" checked>
							<small class="form-text text-muted">Centang jika agenda ini aktif.</small>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Tambah</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	<!-- Edit Agenda Modal -->
	<div class="modal fade" id="editAgendaModal" tabindex="-1" role="dialog" aria-labelledby="editAgendaModalLabel"
		aria-hidden="true">
		<form id="editAgendaForm" method="POST" action="{{ route('admin.schedule.update', 'agenda_id_placeholder') }}">
			@csrf
			@method('POST')
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editAgendaModalLabel">Ubah Agenda</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id" id="edit_agenda_id">
						<div class="form-group">
							<label for="edit_title">Agenda</label>
							<input type="text" class="form-control" id="edit_title" name="title" required>
						</div>
						<div class="form-group">
							<label for="edit_start">Tanggal Kegiatan</label>
							<input type="date" class="form-control" id="edit_start" name="start" required>
						</div>
						<div class="form-group">
							<label for="edit_end">Tanggal Selesai</label>
							<input type="date" class="form-control" id="edit_end" name="end">
						</div>
						<div class="form-group">
							<label for="edit_locate">Lokasi</label>
							<input type="text" class="form-control" id="edit_locate" name="locate" required>
						</div>
						<input type="hidden" name="is_active" value="0">
						<div class="form-group">
							<label for="is_active">Aktif</label>
							<input type="checkbox" id="edit_is_active" name="is_active" value="1" checked>
							<small class="form-text text-muted">Centang jika agenda ini aktif.</small>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	<!-- Deactivate Agenda Modal -->
	<div class="modal fade" id="deactivateAgendaModal" tabindex="-1" role="dialog"
		aria-labelledby="deactivateAgendaModalLabel" aria-hidden="true">
		<form id="deactivateAgendaForm" method="POST"
			action="{{ route('admin.schedule.destroy', 'agenda_id_placeholder') }}">
			@csrf
			@method('POST')
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="deactivateAgendaModalLabel">Nonaktifkan Agenda</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Apakah Anda yakin ingin menonaktifkan agenda ini?</p>
						<input type="hidden" name="id" id="deactivate_agenda_id">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-danger">Nonaktifkan</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	@push('scripts')
		<script>
			// Populate edit modal
			$('#editAgendaModal').on('show.bs.modal', function(event) {
				var button = $(event.relatedTarget);
				var id = button.data('id');
				var title = button.data('title');
				var start = button.data('start');
				var end = button.data('end');
				var locate = button.data('locate');
				var isActive = button.data('is_active'); // Assume you have it passed from the button

				var modal = $(this);
				modal.find('#edit_agenda_id').val(id);
				modal.find('#edit_title').val(title);
				modal.find('#edit_start').val(start);
				modal.find('#edit_end').val(end);
				modal.find('#edit_locate').val(locate);
				modal.find('#edit_is_active').prop('checked', isActive); // Set the checkbox based on the value
				modal.find('#is_active').prop('checked', isActive == 1);
				var actionUrl = "{{ route('admin.schedule.update', 'agenda_id_placeholder') }}";
				actionUrl = actionUrl.replace('agenda_id_placeholder', id);
				modal.find('form').attr('action', actionUrl);
			});

			// Populate deactivate modal
			$('#deactivateAgendaModal').on('show.bs.modal', function(event) {
				var button = $(event.relatedTarget);
				var id = button.data('id');
				var modal = $(this);
				modal.find('#deactivate_agenda_id').val(id);
				var actionUrl = "{{ route('admin.schedule.destroy', 'agenda_id_placeholder') }}";
				actionUrl = actionUrl.replace('agenda_id_placeholder', id);
				modal.find('form').attr('action', actionUrl);
			});
		</script>
	@endpush
@endsection
