<!DOCTYPE html>
<html>

<head>
	<title>Surat Keterangan Perubahan Komitmen</title>

	<style type="text/css">
		table,
		th,
		td {
			border: 1px solid black;
			border-collapse: collapse;
		}

		body {
			font-size: 12px
		}
	</style>
</head>

<body>

	<div style="text-align:center !important;"><img style="width:120px;"
			src="{{ public_path('global_assets/images/logo_kominfo.png') }}"></div>
	<div style="text-align:center !important;">
		<br />
		<font size="3">PENETAPAN PERUBAHAN KEWAJIBAN PEMBANGUNAN DAN/ATAU PENYEDIAAN<br />
		PENYELENGGARAAN JARINGAN TETAP TERTUTUP</font><br />

		<font size="3">PT {{$nama_perseroan}}</font><br /><br /><br />
	</div>
	<div>
		<ol>
			<li>Komitmen kewajiban pembangunan dan/atau penyediaan PT {{$nama_perseroan}}. telah ditetapkan dalam Penetapan ….. Nomor …. Tanggal {{date('d F Y')}}.</li>
			<li>PT {{$nama_perseroan}}. telah menyampaikan permohonan perubahan kewajiban pembangunan dan/atau penyediaan melalui surat Nomor …. tanggal …. serta surat pernyataan perubahan kewajiban pembangunan dan/atau penyediaan Penyelenggaraan …. tertanggal …</li>
			<li>Menetapkan perubahan atas Tabel Komitmen kewajiban pembangunan dan/atau penyediaan selama 5 (lima) tahun PT {{$nama_perseroan}}. sebagaimana tercantum dalam Penetapan …. Nomor …. Tanggal sehingga berbunyi sebagai berikut:
				<br /><br />
				<div style="text-align: center">Tabel Komitmen Kewajiban Pembangunan dan/atau Penyediaan</div>
				<br /><br />
				@foreach($map_izin_perubahan as $mi)
				@if ($mi->component_name == 'roll_out_plan_jartup_fo_ter')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th style="text-align: center;">Periode</th>
							<th style="text-align: center;">Jumlah Node</th>
							<th style="text-align: center;">Lokasi Node (Kab/Kota)</th>
							<th style="text-align: center;">Cakupan Wilayah Layanan (Kab/Kota)</th>
							<th style="text-align: center;">Jumlah Kabel Fiber Optik (core)</th>
							<th style="text-align: center;">Kapasitas <i>Bandwidth</i> (Gbps)</th>
							<th style="text-align: center;">Panjang Rute Kabel Fiber Optik (km)</th>
						</tr>
					</thead>
					<tbody id="rolloutplan-lists">
						@if ($mi->form_isian !== 'kosong')
							<?php $mi->form_isian = json_decode($mi->form_isian, true); ?>

							@foreach ($mi->form_isian as $key => $d)
								<tr class="rolloutplan-item">
									<td style="width: 5%; text-align: center;">
										{{ $d['periode'] }}
									</td>
									<td style="width: 5%; text-align: center;">
										{{ $d['jumlah_node'] }}

									</td>
									<td style="width: 15%;">
										@foreach ($cities as $city)
											@foreach ($d['lokasi_node'] as $item)
												@if ($city->id == $item)
													{{$city->name}},
												@endif
											@endforeach
										@endforeach
									</td>
									<td style="width: 15%;">
										@foreach ($cities as $city)
											@foreach ($d['cakupan_wilayah_layanan'] as $item)
												@if ($city->id == $item)
													{{$city->name}},
												@endif
											@endforeach
										@endforeach
									</td>
									<td style="width: 10%; text-align: center;">
										{{ $d['jumlah_kabel_fiber_optik'] }}
									</td>
									<td style="width: 10%; text-align: center;">
										{{ $d['kapasitas_bandwidth'] }}
									</td>
									<td style="width: 10%; text-align: center;">
										{{ $d['panjang_rute_kabel_fiber_optik'] }}
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'roll_out_plan_jartup_satelit')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th style="text-align: center;">Periode</th>
							<th style="text-align: center;">Kapasitas Transponder Satelit</th>
						</tr>
					</thead>
					<tbody id="rolloutplan-lists">
						@if($mi->form_isian !== "kosong")
						<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
						?>

						@foreach($mi->form_isian as $d)
						<tr class="rolloutplan-item">
							<td style="width: 10%;">
								{{$d['periode']}}
							</td>
							<td style="width: 90%;">
								{{$d['kapasitas_transponder_satelit']}}
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'roll_out_plan_jarber_radio_trunking')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th style="text-align: center;">Periode</th>
							<th style="text-align: center;">Jumlah Kanal</th>
							<th style="text-align: center;">Kapasitas Pelanggan yang dilayani</th>
						</tr>
					</thead>
					<tbody id="rolloutplan-lists">
						@if($mi->form_isian !== "kosong")
						<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
						?>

						@foreach($mi->form_isian as $key => $d)
						<tr class="rolloutplan-item">
							<td style="width: 20%;">
								{{$d['periode']}}
							</td>
							<td style="width: 40%;">
								{{$d['jumlah_kanal']}}
							</td>
							<td style="width: 40%;">
								{{$d['kapasitas_pelanggan']}}
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'roll_out_plan_jartaplok_packet_switched')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th style="text-align: center;">Periode</th>
							<th style="text-align: center;">Cakupan Layanan (Kab/Kota)</th>
							<th style="text-align: center;">Port FTTx (jumlah port perangkat yang disediakan)</th>
							<th style="text-align: center;">Kapasitas <i>Bandwidth</i> FTTx (Gbps)</th>
							<th style="text-align: center;">Kapasitas Jumlah Pelanggan FTTx</th>
						</tr>
					</thead>
					<tbody id="rolloutplan-lists">
						@if($mi->form_isian !== "kosong")
						<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
							// var_dump($mi->form_isian);
							// dd($mi->form_isian);
						?>

						@foreach($mi->form_isian as $key => $d)
						<tr class="rolloutplan-item">
							<td style="width: 10%;">
								{{$d['periode']}}
							</td>
							<td style="width: 25%;">
								@foreach ($cities as $city)
									@foreach ($d['cakupan_layanan'] as $item)
										@if ($city->id == $item)
											{{$city->name}},
										@endif
									@endforeach
								@endforeach
							</td>
							<td style="width: 10%;">
								{{$d['port_fttx']}}
							</td>
							<td style="width: 10%;">
								{{$d['kapasitas_bandwidth_fttx']}}
							</td>
							<td style="width: 15%;">
								{{$d['kapasitas_jumlah_pelanggan']}}
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'roll_out_plan_jartaplok_bwa')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th style="text-align: center;">Periode</th>
							<th style="text-align: center;">Jumlah <i>Site</i> (Unit)</th>
							<th style="text-align: center;">Lokasi <i>Site</i> (Kab/Kota)</th>
							<th style="text-align: center;">Minimal Cakupan Layanan (Kab/Kota)</th>
							<th style="text-align: center;">Kapasitas <i>Bandwidth</i> (Mbps)</th>
						</tr>
					</thead>
					<tbody id="rolloutplan-lists">
						@if($mi->form_isian !== "kosong")
						<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
						?>

						@foreach($mi->form_isian as $key => $d)

						<tr class="rolloutplan-item">
							<td style="width: 10%;">
								{{$d['periode']}}
							</td>
							<td style="width: 10%;">
								{{$d['jumlah_site']}}
							</td>
							<td>
								@foreach ($cities as $city)
									@foreach ($d['lokasi_site'] as $item)
										@if ($city->id == $item)
											{{$city->name}},
										@endif
									@endforeach
								@endforeach
							</td>
							<td>
								@foreach ($cities as $city)
									@foreach ($d['minimal_cakupan_layanan'] as $item)
										@if ($city->id == $item)
											{{$city->name}},
										@endif
									@endforeach
								@endforeach
							</td>
							<td>
								{{$d['kapasitas_bandwidth']}}
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'roll_out_plan_jartup_skkl')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th style="text-align: center;">Periode</th>
							<th style="text-align: center;">Jumlah <i>Cable Landing Station</i></th>
							<th style="text-align: center;">Lokasi <i>Cable Landing Station</i> (Kab/Kota)</th>
							<th style="text-align: center;">Rute Jaringan Sistem Komunikasi Kabel Laut</th>
							<th style="text-align: center;">Jumlah Kabel Fiber Optik (core)</th>
							<th style="text-align: center;">Kapasitas <i>Bandwidth</i> (Gbps)</th>
						</tr>
					</thead>
					<tbody id="rolloutplan-lists">
						@if($mi->form_isian != "kosong")
						<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
						?>
						@foreach($mi->form_isian as $key => $d)
						<tr class="rolloutplan-item">
							<td style="width: 5%;">
								{{$d['periode']}}
							</td>
							<td style="width: 10%;">
								{{$d['jumlah_cable_landing_station']}}
							</td>
							<td style="width: 25%;">
								@foreach ($cities as $city)
									@foreach ($d['lokasi_cable_landing_station'] as $item)
										@if ($city->id == $item)
											{{$city->name}},
										@endif
									@endforeach
								@endforeach
							</td>
							<td style="width: 30%;">
								@foreach ($cities as $city)
									@foreach ($d['rute_jaringan_sistem_komunikasi_kabel_laut'] as $item)
										@if ($city->id == $item)
											{{$city->name}},
										@endif
									@endforeach
								@endforeach
							</td>
							<td style="width: 30%;">
								{{$d['jumlah_kabel_fiber_optik']}}
							</td>
							<td style="width: 15%;">
								{{$d['kapasitas_bandwidth']}}
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'roll_out_plan_jartup_mw_link')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th style="text-align: center;">Periode</th>
							<th style="text-align: center;">Minimal Jumlah Hop</th>
							<th style="text-align: center;">Minimal Kapasitas <i>Bandwidth</i> (Mbps)</th>
						</tr>
					</thead>
					<tbody id="rolloutplan-lists">
						@if($mi->form_isian !== "kosong")
						<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
						?>

						@foreach($mi->form_isian as $d)
						<tr class="rolloutplan-item">
							<td style="width: 5%;">
								{{$d['periode']}}
							</td>
							<td style="width: 5%;">
								{{$d['minimal_jumlah_hop']}}
							</td>
							<td style="width: 10%;">
								{{$d['minimal_kapasitas_bandwidth']}}
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'roll_out_plan_jarber_satelit')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th style="text-align: center;">Periode</th>
							<th style="text-align: center;">Kapasitas Transponder Satelit yang disewakan (MHz/Mbps)</th>
							<th style="text-align: center;">Kapasitas Sistem (SSM)</th>
						</tr>
					</thead>
					<tbody id="rolloutplan-lists">
						@if ($mi->form_isian !== 'kosong')
							<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
							?>

							@foreach ($mi->form_isian as $key => $d)
								<tr class="rolloutplan-item">
									<td style="width: 20%;">
										{{ $d['periode'] }}
									</td>
									<td style="width: 40%;">
										{{ $d['kapasitas_transponder_satelit'] }}
									</td>
									<td style="width: 40%;">
										{{ $d['kapasitas_sistem'] }}
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'roll_out_plan_jartup_visat')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th style="text-align: center;">Periode</th>
							<th style="text-align: center;">Kapasitas Transponder yang disewa/disediakan (MHz/Mbps)</th>
						</tr>
					</thead>
					<tbody id="rolloutplan-lists">
						@if($mi->form_isian !== "kosong")
						<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
						?>

						@foreach($mi->form_isian as $d)
						<tr class="rolloutplan-item">
							<td style="width: 10%;">
								{{$d['periode']}}
							</td>
							<td style="width: 90%;">
								{{$d['kapasitas_transponder']}}
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				@endif
				@endforeach

				<br /><br />
				@foreach($map_izin_perubahan as $mi)
				@if ($mi->component_name == 'komitmen_kinerja_layanan_lima_tahun')
				<table class="table table-sm table-custom" style="width: 100%">
					<thead>
						<tr>
							<th class="text-center" style="vertical-align : middle;text-align:center; width:30%">Tahun</th>
							<th class="text-center">Tahun I</th>
							<th class="text-center">Tahun II</th>
							<th class="text-center">Tahun III</th>
							<th class="text-center">Tahun IV</th>
							<th class="text-center">Tahun V</th>
						</tr>
					</thead>

					@if($mi->form_isian !== "kosong")
					<?php
						$mi->form_isian = json_decode($mi->form_isian, true);
					?>

					<tbody id="komitmen-kinerja-lists">
						<tr>
							<td style="width: 40%;">
								<i>Network Availability </i> (%)
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['network_availbility']['I']}}
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['network_availbility']['II']}}
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['network_availbility']['III']}}
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['network_availbility']['IV']}}
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['network_availbility']['V']}}
							</td>
						</tr>
						<tr>
							<td style="width: 15%;">
								Pencapaian <i>Mean Time To Restore</i> (Jam)
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['mean_time_to_restore']['I']}}
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['mean_time_to_restore']['II']}}
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['mean_time_to_restore']['III']}}
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['mean_time_to_restore']['IV']}}
							</td>
							<td style="text-align: center;">
								{{$mi->form_isian['mean_time_to_restore']['V']}}
							</td>
						</tr>
					</tbody>
					@endif
				</table>
				@elseif($mi->component_name == 'rencanausaha')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th rowspan="2" style="text-align: center;">Tahun</th>
							<th colspan="2" style="text-align: center;border: none;">Pusat Pelayanan Pelanggan</th>
							<th rowspan="2" style="text-align: center;">Kapasitas Layanan dalam E1 (atau Setara)</th>
							<th rowspan="2"></th>
						</tr>
						<tr>
							<th style="border-top: none;background: #fafafa;text-align: center;">(Kota/Kab)</th>
							<th style="border-top: none;background: #fafafa;text-align: center;">Jumlah</th>
						</tr>
					</thead>
					<tbody id="rencanausaha-lists">
						@if ($mi->form_isian !== 'kosong')
							<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
							?>
							@foreach ($mi->form_isian as $key => $d)
								<tr class="rencanausaha-item">
									<td style="width: 15%;">
										{{ $d['tahun'] }}
									</td>
									<td style="width: 35%;">
										@foreach ($cities as $city)
											@if ($city->id == $d['kota'])
												{{$city->name}},
											@endif
										@endforeach
									</td>
									<td>
										{{ $d['jumlah'] }}
									</td>
									<td>
										{{ $d['kapasitas_e1'] }}
									</td>
									<td></td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'rencanausaha_v2')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th rowspan="2" style="text-align: center;">Tahun</th>
							<th colspan="2" style="text-align: center;border: none;">Pusat Pelayanan Pelanggan</th>
							<th rowspan="2" style="text-align: center;">Jumlah Perjanjian Kerjasama (PKS) dengan Penyedia Konten
								Independen</th>
						</tr>
						<tr>
							<th style="border-top: none;background: #fafafa;text-align: center;">(Kota/Kab)</th>
							<th style="border-top: none;background: #fafafa;text-align: center;">Jumlah</th>
						</tr>
					</thead>
					<tbody id="rencanausaha-lists">
						@if($mi->form_isian !== "kosong")
						<?php $mi->form_isian = json_decode($mi->form_isian, true); ?>
						@foreach($mi->form_isian as $key => $d)
						<tr class="rencanausaha-item">
							<td style="width: 15%;">
								{{ $d['tahun'] }}
							</td>
							<td style="width: 35%;">
								@foreach ($cities as $city)
									@if ($city->id == $d['kota'])
										{{$city->name}},
									@endif
								@endforeach
							</td>
							<td>
								{{ $d['jumlah'] }}
							</td>
							<td>
								{{ $d['pks'] }}
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'rencanausaha_v3')
				<table class="table table-custom table-sm">
					<thead>
						<tr>
							<th rowspan="2" style="text-align: center;width: 10%;">Tahun</th>
							<th colspan="2" style="text-align: center;border: none;width: 20%;">Pusat Pelayanan Pelanggan</th>
							<th rowspan="2" style="text-align: center;width: 20%;">Cakupan Wilayah Layanan (Kota/Kab)</th>
							<th rowspan="2" style="text-align: center;">Kapasitas Bandwidth Internasional (Mbps)</th>
						</tr>
						<tr>
							<th style="border-top: none;background: #fafafa;text-align: center;">(Kota/Kab)</th>
							<th style="border-top: none;background: #fafafa;text-align: center;">Jumlah</th>
						</tr>
					</thead>
					<tbody id="rencanausaha-lists">
						@if ($mi->form_isian !== 'kosong')
							<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
							?>
							@foreach ($mi->form_isian as $key => $d)
								<tr class="rencanausaha-item">
									<td style="width: 15%;">
										{{ $d['tahun'] }}
									</td>
									<td style="width: 20%;">
										@foreach ($cities as $city)
											@if ($city->id == $d['kota'])
												{{$city->name}},
											@endif
										@endforeach
									</td>
									<td>
										{{ $d['jumlah'] }}
									</td>
									<td style="width: 20%;">
										@foreach ($cities as $city)
											@if ($city->id == $d['kota'])
												{{$city->name}},
											@endif
										@endforeach
									</td>
									<td>
										{{ $d['kapasitas_band'] }}
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'rencanausaha_v4')
				<table class="table table-sm table-custom">
					<thead>
						<tr>
							<th rowspan="2" style="text-align: center;">Tahun</th>
							<th colspan="2" style="text-align: center;border: none;">Pusat Pelayanan Pelanggan</th>
							<th class="text-center" rowspan="2">Lokasi Ketersambungan Simpul Jasa (Node) (Kota / Kabupaten)</th>
							<th class="text-center" rowspan="2">Kapasitas Bandwidth Domestik (Mbps)</th>
							<th class="text-center" rowspan="2">Kapasitas Bandwidth Internasional (Mbps)</th>
						</tr>
						<tr>
							<th style="border-top: none;background: #fafafa;text-align: center;">(Kota/Kab)</th>
							<th style="border-top: none;background: #fafafa;text-align: center;">Jumlah</th>
						</tr>
					</thead>
					<tbody id="rencanausaha-lists">
						@if ($mi->form_isian !== 'kosong')
							<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
							?>
							@foreach ($mi->form_isian as $key => $d)
								<tr class="rencanausaha-item">
									<td style="width: 15%;">
										{{ $d['tahun'] }}
									</td>
									<td style="width: 20%;">
										@foreach ($cities as $city)
											@if ($city->id == $d['kota'])
												{{$city->name}},
											@endif
										@endforeach
									</td>
									<td>
										{{ $d['jumlah'] }}
									</td>
									<td style="width: 20%;">
										@foreach ($cities as $city)
											@if ($city->id == $d['kota'])
												{{$city->name}},
											@endif
										@endforeach
									</td>
									<td>
										{{ $d['band_domestik'] }}
									</td>
									<td>
										{{ $d['band_inter'] }}
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				@elseif($mi->component_name == 'rencanausaha_v5')
				<table class="table table-sm table-custom">
					<thead>
						<tr>
							<th class="text-center" rowspan="2" style="vertical-align : middle;text-align:center;">Tahun</th>
							<th class="text-center" colspan="2">Pusat Pelayanan Pelanggan</th>
							{{-- <th class="text-center" rowspan="2" style="vertical-align : middle;text-align:center;">Jenis Layanan
								Siskomdat</th> --}}
						</tr>
						<tr>
							<th>(Kota/Kab)</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody id="rencanausaha-lists">

						@if ($mi->form_isian !== 'kosong')
							<?php
							$mi->form_isian = json_decode($mi->form_isian, true);
							?>
							@foreach ($mi->form_isian as $key => $d)
								<tr class="rencanausaha-item">
									<td style="width: 15%;">
										{{ $d['tahun'] }}
									</td>
									<td style="width: 20%;">
										@foreach ($cities as $city)
											@if ($city->id == $d['kota'])
												{{$city->name}},
											@endif
										@endforeach
									</td>
									<td>
										{{ $d['jumlah'] }}
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				@endif
				@endforeach
			</li>
		</ol> 

	</div>
	<div style="float:right">
		Ditetapkan di Jakarta<br>
		Pada tanggal {{date('d F Y')}}<br>
		<br>
		a.n MENTERI KOMUNIKASI DAN INFORMATIKA<br>
		DIREKTUR JENDERAL<br>
		PENYELENGGARAAN POS DAN INFORMATIKA<br>
		u.b<br>
		DIREKTUR TELEKOMUNIKASI<br>
		<br>
		<br>
		<br>
		AJU WIDYA SARI
	</div>
</body>

</html>