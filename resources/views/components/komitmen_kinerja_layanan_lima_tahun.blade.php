<style>
	.table-custom th,
	.table-custom tr,
	.table-custom td {
		border: 1px solid #ddd;
	}

	.table-custom tr td .form-control {
		padding: 2px 10px;
	}

	.select2-selection--single {
		padding: 0;
	}

	.form-control {
		height: auto;
	}

	.select2-container--default .select2-selection--single {
		border-color: #ddd;
	}
</style>
@php
$is_editable = ($needcorrection ?? false); // add || OR jika terdapat kondisi lainya untuk editable input dibawah
$is_penyesuaian = ($penyesuaian ?? false); // add || OR jika terdapat kondisi lainya untuk editable input dibawah
$tgl_penetapan = $ulo->created_at ?? '';
$roman = ['I', 'II', 'III', 'IV', 'V'];
@endphp
<div class="table-responsive">
	<table class="table table-sm table-custom">
		<thead>
			<tr>
				<th class="text-center" style="vertical-align : middle;text-align:center;">Tahun</th>
				<th class="text-center">Tahun I</th>
				<th class="text-center">Tahun II</th>
				<th class="text-center">Tahun III</th>
				<th class="text-center">Tahun IV</th>
				<th class="text-center">Tahun V</th>
			</tr>
		</thead>

		@if($datajson !== "kosong")
		<?php
			$datajson = json_decode($datajson, true);
		?>

		<tbody id="komitmen-kinerja-lists">
			<tr>
				<td style="width: 15%;">
					<i>Network Availability </i> (%)
				</td>
				{{-- <td>
					<input type="text" {{ $is_editable && !$is_penyesuaian ? '' : 'readonly' }}
						value="{{$datajson['network_availbility']['I']}}" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[network_availbility][I]" required />
				</td>
				<td>
					<input type="text" {{ $is_editable ? '' : 'readonly' }}
						value="{{$datajson['network_availbility']['II']}}" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[network_availbility][II]" required />
				</td>
				<td>
					<input type="text" {{ $is_editable ? '' : 'readonly' }}
						value="{{$datajson['network_availbility']['III']}}" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[network_availbility][III]" required />
				</td>
				<td>
					<input type="text" {{ $is_editable ? '' : 'readonly' }}
						value="{{$datajson['network_availbility']['IV']}}" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[network_availbility][IV]" required />
				</td> --}}
				@foreach ($roman as $item)
					@if ((\App\Helpers\DateHelper::getWorkingDays(date('Y-m-d'), date('Y')."-02-28", []) < 20) && $is_penyesuaian)
                        @if (date('Y', strtotime('+1 year')) >= date("Y", strtotime('+'.$loop->index.' year', strtotime($tgl_penetapan))))
                            @php $is_editable = false @endphp
                        @else
                            @php $is_editable = true @endphp
                        @endif
                    @elseif ($loop->first && $is_penyesuaian)
                        @php $is_editable = false @endphp
                    @elseif($is_penyesuaian)
                        @php $is_editable = true @endphp
                    @endif
					<td>
						<input type="text" {{ $is_editable ? '' : 'readonly' }}
							value="{{$datajson['network_availbility'][$item]}}" class="form-control"
							name="komitmen_kinerja_layanan_lima_tahun[network_availbility][{{$item}}]" required />
					</td>
				@endforeach
			</tr>
			<tr>
				<td style="width: 15%;">
					Pencapaian <i>Mean Time To Restore</i> (Jam)
				</td>
				{{-- <td>
					<input type="text" {{ $is_editable && !$is_penyesuaian ? '' : 'readonly' }}
						value="{{$datajson['mean_time_to_restore']['I']}}" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][I]" required />
				</td>
				<td>
					<input type="text" {{ $is_editable ? '' : 'readonly' }}
						value="{{$datajson['mean_time_to_restore']['II']}}" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][II]" required />
				</td>
				<td>
					<input type="text" {{ $is_editable ? '' : 'readonly' }}
						value="{{$datajson['mean_time_to_restore']['III']}}" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][III]" required />
				</td>
				<td>
					<input type="text" {{ $is_editable ? '' : 'readonly' }}
						value="{{$datajson['mean_time_to_restore']['IV']}}" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][IV]" required />
				</td> --}}
				@foreach ($roman as $item)
					@if ((\App\Helpers\DateHelper::getWorkingDays(date('Y-m-d'), date('Y')."-02-28", []) < 20) && $is_penyesuaian)
                        @if (date('Y', strtotime('+1 year')) >= date("Y", strtotime('+'.$loop->index.' year', strtotime($tgl_penetapan))))
                            @php $is_editable = false @endphp
                        @else
                            @php $is_editable = true @endphp
                        @endif
                    @elseif ($loop->first && $is_penyesuaian)
                        @php $is_editable = false @endphp
                    @elseif($is_penyesuaian)
                        @php $is_editable = true @endphp
                    @endif
					<td>
						<input type="text" {{ $is_editable ? '' : 'readonly' }}
							value="{{$datajson['mean_time_to_restore'][$item]}}" class="form-control"
							name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][{{$item}}]" required />
					</td>
				@endforeach
			</tr>
		</tbody>
		@else
		<tbody id="komitmen-kinerja-lists">
			<tr>
				<td style="width: 15%;">
					<i>Network Availability</i> (%)
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[network_availbility][I]" required />
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[network_availbility][II]" required />
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[network_availbility][III]" required />
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[network_availbility][IV]" required />
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[network_availbility][V]" required />
				</td>
			</tr>
			<tr>
				<td style="width: 15%;">
					Pencapaian <i>Mean Time To Restore </i> (Jam)
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][I]" required />
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][II]" required />
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][III]" required />
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][IV]" required />
				</td>
				<td>
					<input type="text" class="form-control"
						name="komitmen_kinerja_layanan_lima_tahun[mean_time_to_restore][V]" required />
				</td>
			</tr>
		</tbody>
		@endif

	</table>
	{{-- @if($datajson == "kosong")
	<div class="text-right">
		<button class="btn btn-secondary my-2 btn-sm" type="button" id="add-komitmen-kinerja">Tambah Data</button>
	</div>
	@endif --}}
</div>