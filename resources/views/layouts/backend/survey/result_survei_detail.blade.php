@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')

	<div class="content">
		<div>
			@if (Session::get('message') != '')
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{{ Session::get('message') }}</strong>
				</div>
			@endif

			<!-- Latest orders -->
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Ringkasan Survei
							</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="col">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-2 col-form-label">Periode </label>
										<div class="col-lg-10">
											<input type="text" class="form-control"
												value="{{ $list_summary->period_month_desc . '' . $list_summary->period_year }}" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-2 col-form-label">Jumlah Responden </label>
										<div class="col-lg-10">
											<input type="text" class="form-control" value="{{ $list_summary->total_responder }}" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-2 col-form-label">Responden Flag </label>
										<div class="col-lg-10">
											<input type="text" class="form-control" value="{{ $list_summary->total_flag }}" disabled>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="dropdown-divider"></div>
					<div class="form-group row">
						<div class="col">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-2 col-form-label">Rentang Usia </label>
										<div class="col-lg-10 row">
											<label class="col-lg-1 col-form-label">17-25 Tahun </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->AGE01 }}" disabled>
											</div>
											<label class="col-lg-1 col-form-label">26-30 Tahun </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->AGE02 }}" disabled>
											</div>
											<label class="col-lg-1 col-form-label">31-40 Tahun </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->AGE03 }}" disabled>
											</div>
											<label class="col-lg-1 col-form-label">>40 Tahun </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->AGE04 }}" disabled>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-2 col-form-label">Jenis Kelamin</label>
										<div class="col-lg-10 row">
											<label class="col-lg-1 col-form-label">Pria </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->GENDER_LAKI }}" disabled>
											</div>
											<label class="col-lg-1 col-form-label">Perempuan </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->GENDER_PEREMPUAN }}" disabled>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-2 col-form-label">Pendidikan Terakhir</label>
										<div class="col-lg-10 row">
											<label class="col-lg-1 col-form-label">SD </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->STUDY_SD }}" disabled>
											</div>
											<label class="col-lg-1 col-form-label">SMP </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->STUDY_SMP }}" disabled>
											</div>
											<label class="col-lg-1 col-form-label">SMA </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->STUDY_SMA }}" disabled>
											</div>
											<label class="col-lg-1 col-form-label">S1 </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->STUDY_S1 }}" disabled>
											</div>
											<label class="col-lg-1 col-form-label">S2 </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->STUDY_S2 }}" disabled>
											</div>
											<label class="col-lg-1 col-form-label">S3 </label>
											<div class="col-lg-1">
												<input type="text" class="form-control" value="{{ $list_summary->STUDY_S3 }}" disabled>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Penilaian dan Analisa Survei
							</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<h6 class="card-title font-weight-semibold py-3">INDEKS KEPUASAN MASYARAKAT</h6>

						<div class="form-group row">
							<div class="col">
								<div class="form-group col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">Kinerja </label>
										<div class="col-lg-8">
											<input type="text" class="form-control" value="{{ $list_summary->IKM_result_final }}" readonly>
										</div>
									</div>
								</div>
								<div class="form-group col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">Harapan </label>
										<div class="col-lg-8">
											<input type="text" class="form-control"
												value="{{ $list_summary->IKMH_4 . ' atau ' . $list_summary->IKMH_100 }}" readonly>
										</div>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group col-lg-12">
									<div class="row">
										<label class="col-lg-4 col-form-label">Tingkat Kepuasan </label>
										<div class="col-lg-8">
											<input type="text" class="form-control" value="{{ $list_summary->servql }}" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>

						<h6 class="card-title font-weight-semibold py-3">GAP ANALISIS</h6>
						<div class="form-group row">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="text-align: center;">No</th>
											<th style="text-align: center;">Unsur</th>
											<th style="text-align: center;">Pertanyaan</th>
											<th style="text-align: center;">Kinerja</th>
											<th style="text-align: center;">Harapan</th>
											<th style="text-align: center;">GAP</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($list_summary_ikm as $key => $ans_ikm)
											<tr class="@if ($ans_ikm->nilai_gap < 0) table-danger @endif">
												<td style="text-align: center;width: 5%;">
													{{ $ans_ikm->seq }}
												</td>
												<td style="text-align: center;width: 15%;">
													{{ $ans_ikm->unsur }}
												</td>
												<td style="text-align: justify;width: 45%;">
													{{ $ans_ikm->question }}
												</td>
												<td style="text-align: center;width: 5%;">
													{{ $ans_ikm->nilai_kinerja }}
												</td>
												<td style="text-align: center;width: 5%;">
													{{ $ans_ikm->nilai_harapan }}
												</td>
												@if ($ans_ikm->nilai_gap < 0)
													<td style="text-align: center;width: 5%;" class="font-weight-semibold text-danger">
														{{ $ans_ikm->nilai_gap }}
													</td>
												@else
													<td style="text-align: center;width: 5%;">
														{{ $ans_ikm->nilai_gap }}
													</td>
												@endif
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

						<div class="dropdown-divider"></div>

						<h6 class="card-title font-weight-semibold py-3">INDEKS INTEGRITAS PELAYANAN PUBLIK</h6>

						<div class="form-group row">
							<div class="col">
								<div class="form-group col-lg-12">
									<div class="col-lg-6 row">
										<label class="col-lg-4 col-form-label">Nilai </label>
										<div class="col-lg-8">
											<input type="text" class="form-control"
												value="{{ $list_summary->IIPP_4 . ' atau ' . $list_summary->IIPP_10 }}" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="text-align: center;">No</th>
											<th style="text-align: center;">Unsur</th>
											<th style="text-align: center;">Pertanyaan</th>
											<th style="text-align: center;">Nilai</th>
											<th style="text-align: center;">Nilai x Bobot</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($list_summary_iipp as $key => $ans_iipp)
											<tr>
												<td style="text-align: center;width: 5%;">
													{{ $ans_iipp->seq }}
												</td>
												<td style="text-align: center;width: 15%;">
													{{ $ans_iipp->unsur }}
												</td>
												<td style="text-align: justify;width: 45%;">
													{{ $ans_iipp->question }}
												</td>
												<td style="text-align: center;width: 5%;">
													{{ $ans_iipp->nilai }}
												</td>
												<td style="text-align: center;width: 10%;">
													{{ $ans_iipp->nilai_bobot }}
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Kritik & Saran
							</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="col-lg-12 px-3">
							@php
								$questionSequence = 0;
							@endphp
							@foreach ($list_summary_quest02 as $key => $ans_quest02)
								@if ($key == 0 || $list_summary_quest02[$key - 1]->question != $ans_quest02->question)
									@php
										$questionSequence = 1;
									@endphp
								@else
									@if ($key == 0 || $list_summary_quest02[$key - 1]->cat_answer != $ans_quest02->cat_answer)
										@php
											$questionSequence = 1;
										@endphp
									@else
										@php
											$questionSequence++;
										@endphp
									@endif
								@endif
								@if ($key == 0 || $list_summary_quest02[$key - 1]->question != $ans_quest02->question)
									<div class="col-lg-12 row mb-3">
										<div>
											{!! $ans_quest02->seq !!}.
										</div>
										<div class="col-lg">
											{!! $ans_quest02->question !!}
										</div>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-12 row mb-3">
											<label class="col-lg-2 col-form-label text-center">Kategori </label>
											<div class="col-lg-10">
												<input type="text" class="form-control" value="{{ $ans_quest02->cat_answer }}" disabled>
											</div>
										</div>
									</div>
								@else
									@if ($key == 0 || $list_summary_quest02[$key - 1]->cat_answer != $ans_quest02->cat_answer)
										<div class="col-lg-12">
											<div class="col-lg-12 row mb-3">
												<label class="col-lg-2 col-form-label text-center">Kategori </label>
												<div class="col-lg-10">
													<input type="text" class="form-control" value="{{ $ans_quest02->cat_answer }}" disabled>
												</div>
											</div>
										</div>
									@endif
								@endif
								<div class="row mb-3">
									<label class="col-lg-2 col-form-label text-lg-end">&nbsp;</label>
									<div class="col-lg-10 row">
										<div>
											{!! $questionSequence !!}.
										</div>
										<div class="col-lg">
											{!! $ans_quest02->answer !!}
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>

				</div>
			</div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Testimoni
							</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="col-lg-12 px-3">
							@php
								$questionSequence = 0;
							@endphp
							@foreach ($list_summary_quest03 as $key => $ans_quest03)
								<div class="row">
									<div>
										{!! $key + 1 !!}.
									</div>
									<div class="col-lg">
										{!! $ans_quest03->answer !!}
									</div>
								</div>
								@php
									$questionSequence++;
								@endphp
							@endforeach
						</div>
					</div>

				</div>
			</div>
			<!-- /latest orders -->
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {

			if (!$.fn.dataTable.isDataTable('#tableno')) {
				$('#tableno').DataTable({
					columnDefs: [{
						targets: [3, 4], // Hide columns with indices 0 and 4
						visible: false
					}]
				});
			}
		});
	</script>

	<!-- Quick stats boxes -->

@endsection
