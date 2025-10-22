@extends('layouts.backend.main')
@section('js')

<script src="{{url('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
<script src="{{url('global_assets/js/demo_pages/form_layouts.js')}}"></script>
@endsection
@section('content')
@php
	$status = $penyesuaian->status_komitmen == 1? 'Perubahan': 'Penyesuaian';
@endphp
<style>
	.form-group .component:not(:first-child) {
    	margin-top: 60px
	}
</style>
	<div class="form-group">
		<!-- Section Detail Permohonan -->
		<h3>Evaluasi {{$status}}</h3>
		<hr />
		<div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Informasi Permohonan </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">No Permohonan </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{$izin['id_izin']}}</label>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Jenis Permohonan </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {!! $izin['jenis_layanan_html'] !!}</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Tanggal Permohonan </label>
								<div class="col-lg">
									@if($izin['updated_at'] == null)
									<label class="col-lg col-form-label">: - </label>
									@else
									<label class="col-lg col-form-label">:
										{{$date_reformat->dateday_lang_reformat_long($izin['updated_at'])}}</label>
									@endif
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Status Permohonan </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{$izin['status_bo']}}</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Section Detail Permohonan -->

		<!-- Section Detail Perusahaan -->
		<div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Informasi Perusahaan </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Perusahaan</legend>
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">NIB </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{$detailnib['nib']}}</label>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Nama </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{$detailnib['nama_perseroan']}}</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">NPWP </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{$detailnib['npwp_perseroan']}}</label>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">No Telp </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">:
										{{$detailnib['nomor_telpon_perseroan']}}</label>
								</div>
							</div>
						</div>
					</div>
					<legend class="text-uppercase font-size-sm font-weight-bold">Data Penanggung Jawab</legend>
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">NIK </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{ isset($penanggungjawab['no_ktp']) ?
										$penanggungjawab['no_ktp'] : '-' }} </label>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Nama </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{
										isset($penanggungjawab['nama_user_proses']) ?
										$penanggungjawab['nama_user_proses'] : '-' }} </label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">Email </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{
										isset($penanggungjawab['email_user_proses']) ?
										$penanggungjawab['email_user_proses'] : '-' }}</label>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<label class="col-lg-4 col-form-label">No Telp/Mobile </label>
								<div class="col-lg">
									<label class="col-lg col-form-label">: {{ isset($penanggungjawab['hp_user_proses'])
										? $penanggungjawab['hp_user_proses'] : '-' }}</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Section Detail Perusahaan -->

		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Evaluasi {{$status}}</h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="col-12">
				<p class="font-weight-semibold">Dokumen Surat {{$status}} Komitmen</p>
				<div class="input-group">
					<input type="text" class="form-control border-right-0" value="" placeholder="Dokumen {{$status}} Komitmen" disabled>
					<span class="input-group-append">
						<a target="_blank" href="/{{$penyesuaian->surat_pernyataan}}" class="btn btn-teal" type="button">Lihat Dokumen</a>
					</span>
				</div>
				</div>
				<br><br>
				<div class="row">
				<div class="col-6">
					@csrf
					<input type="hidden" name="id_izin" value="{{$izin['id_izin']}}">
					@if( count($map_izin) > 0 )
					<div class="form-group">
						@foreach($map_izin as $mi)
						@if (in_array($mi->component_name, ['komitmen_kinerja_layanan_lima_tahun', 'roll_out_plan_jarber_satelit','roll_out_plan_jarber_radio_trunking','roll_out_plan_jartaplok_packet_switched','roll_out_plan_jartaplok_bwa','roll_out_plan_jartup_skkl','roll_out_plan_jartup_fo_ter','roll_out_plan_jartup_mw_link','roll_out_plan_jartup_satelit','roll_out_plan_jartup_visat','rencanausaha', 'rencanausaha_v2', 'rencanausaha_v3', 'rencanausaha_v4', 'rencanausaha_v5']))
							<div class="component">
								<p class="font-weight-bold">{!!$mi->persyaratan_html!!}</p>
								<x-dynamic-component :component="$mi->component_name" :triger="$triger ?? 'null'"
									:datajson="$mi->form_isian ?? 'kosong'" :needcorrection="$mi->need_correction ?? ''"
									:correctionnote="$mi->correction_note ?? ''" />
							</div>
						@endif
						@endforeach
					</div>
					@endif
				</div>
				<div class="col-6">
					<div class="form-group">
						<div class="component">
						@foreach($map_izin_perubahan as $mi)
						@if (in_array($mi->component_name, ['komitmen_kinerja_layanan_lima_tahun', 'roll_out_plan_jarber_satelit','roll_out_plan_jarber_radio_trunking','roll_out_plan_jartaplok_packet_switched','roll_out_plan_jartaplok_bwa','roll_out_plan_jartup_skkl','roll_out_plan_jartup_fo_ter','roll_out_plan_jartup_mw_link','roll_out_plan_jartup_satelit','roll_out_plan_jartup_visat','rencanausaha', 'rencanausaha_v2', 'rencanausaha_v3', 'rencanausaha_v4', 'rencanausaha_v5']))
						<div class="component">
							<p class="font-weight-bold">{!!$mi->persyaratan_html!!}</p>
							<x-dynamic-component :component="$mi->component_name" :triger="$triger ?? 'null'"
								:datajson="$mi->form_isian ?? 'kosong'" :needcorrection="$mi->need_correction ?? ''"
								:correctionnote="$mi->correction_note ?? ''" />
						</div>
						@endif
						@endforeach
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
						<h6 class="card-title font-weight-semibold py-3">Catatan Disposisi </h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<form method="post" id="formDisposisi" action="{{route('admin.koordinator.disposisipenyesuaianpost',$id)}}">
					@csrf
					<div class="form-group row">
						<div class="col-lg-12">
							<fieldset>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Disposisi ke : </label>
									<div class="col-lg">
										
										<select name="id_user_disposisi" data-placeholder="Silakan Pilih" class="form-control ">
											<option>-- Silakan Pilih --</option>
											@if(count($user)  > 0)
												@foreach($user as $users)
													<option value="{{$users['id']}}">{{$users['nama']}} | {{$users['short_desc']}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="form-group row" hidden>
									<textarea name="catatan" rows="3" cols="3" class="form-control" placeholder="Catatan Disposisi"></textarea>
								</div>
							</fieldset>
						</div>
					</div>
					<input type="hidden" id="id_izin" name="id_izin" value="{{$id}}">
					<div class="text-right">
						<a href="{{route('admin.koordinator')}}" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i> Kembali </a>
						<a target="_blank" href="{{ route('admin.historyperizinan', $id) }}" class="btn btn-info">Riwayat Permohonan <i class="icon-history ml-2"></i></a>
						<button type="submit" onclick="return false;" data-toggle="modal" data-target="#submitModal" class="btn btn-indigo">Kirim Disposisi <i class="icon-paperplane ml-2"></i></button>
					</div>
				</form>
			</div>
		</div>

		<div class="modal" id="submitModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Kirim Evaluasi</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Apakah anda yakin akan mengirim evaluasi ini ?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
						<button type="button" onclick="submitdisposisi();return false;"
							class="btn btn-primary notif-button">Kirim</button>
						<div class="spinner-border loading text-primary" role="status" hidden>
							<span class="sr-only">Loading...</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="submitModalKoreksi" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Kirim Perbaikan Evaluasi</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="text-warning">Apakah anda yakin akan mengirim perbaikan evaluasi ini ?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
						<button type="button" onclick="submitdisposisi();return false;"
							class="btn btn-primary notif-button">Kirim</button>
						<div class="spinner-border loading text-primary" role="status" hidden>
							<span class="sr-only">Loading...</span>
						</div>
					</div>
				</div>
			</div>
		</div>
<script>
	function submitdisposisi(){
		$('.notif-button').attr("hidden",true);
		$('.loading').attr("hidden",false);	
        $('#formDisposisi').submit();
		$("#btnSubmit").attr("disabled", true);
		$("#btnSubmitKoreksi").attr("disabled", true);
    }
	
</script>
<script type="text/javascript">
	$(document).ready(function(){

		$("#btnSubmitModalKoreksi").hide();
		$("#btnSubmitModal").show();	

		

		function  CekChek() {
			let yourArray = []
            $("input:checkbox[class=custom-control-input]:checked").each(function(){
				yourArray.push($(this).val());
			});
			if (yourArray.length > 1 ) {
				$("#btnSubmitModalKoreksi").show();
				$("#btnSubmitModal").hide();
			} else {
				$("#btnSubmitModal").show();
				$("#btnSubmitModalKoreksi").hide();
			}
		}

		$('#formEvaluasi').on('change', ':checkbox', function () {
			CekChek();
			var id=$(this).attr('data');
			if ($(this).is(':checked')) {
				$("#label"+id).html("Tidak Sesuai")
				$("#catatan_dokumen_"+id).attr("readonly", false); 
				$("#catatan_dokumen_"+id).focus(); 
			} else {
				$("#label"+id).html("Sesuai")
				$("#catatan_dokumen_"+id).attr("readonly", true); 
				$("#catatan_dokumen_"+id).val(""); 
				setValue();
			}
		});

		function setValue() {
			const vall = [];
			var inputs = $(".koreksi-catatan");
			for(var i = 0; i < inputs.length; i++){
				if($(inputs[i]).val() !== ''){vall.push($(inputs[i]).val().replace(",", "^"))}
			}
			FsetValue(vall.toString());
		}


		$('.koreksi-catatan').on("input", function() {
			const vall = [];
			var inputs = $(".koreksi-catatan");
			for(var i = 0; i < inputs.length; i++){
				if($(inputs[i]).val() !== ''){vall.push($(inputs[i]).val().replace(",", "^"))}
			}
			FsetValue(vall.toString());

		});

		function FsetValue(val) {
			var a = val.split(",")
			var x = a.toString().replace(/,/g, "\r\n");
			$("#catatan_hasil_evaluasi").val(x.replace("^", ","));
		}

	

	});
</script>
@endsection