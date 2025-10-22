@extends('layouts.frontend.main')
@section('js')
	<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="/global_assets/js/demo_pages/form_layouts.js"></script>
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
			@if (session()->has('error'))
				<div class="alert alert-danger alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{{ session()->get('error') }}</strong>
				</div>
			@endif
			@if (session()->has('success'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{{ session()->get('success') }}</strong>
				</div>
			@endif
			<div class="card-body">
				<div class="alert alert-info alert-styled-left alert-dismissible">
					<span class="font-weight-semibold">Seluruh Dokumen dalam format PDF dan maksimal 5 MB.</span>
				</div>
				<x-fe_register_pj :oss="$oss" />
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$("input:file").on('change', function() {
			let input = this.files[0];
			const fileSize = input.size / 1048576;

			var fileExt = $(this).val().split(".");
			fileExt = fileExt[fileExt.length - 1].toLowerCase();
			var arrayExtensions = "pdf";

			if (arrayExtensions != fileExt) {
				alert("Format file yang diunggah tidak sesuai. Hanya format PDF yang diperbolehkan");
				$(this).val('');
			}
			if (fileSize > 5) {
				alert(
					'Ukuran file yang diunggah terlalu besar dari ketentuan. Ukuran file yang diunggah maksimal 5 Mb'
				);
				$(this).val('');
			}
		});
		$('document').ready(function() {
			$('#vKotaKabupaten-loading').hide();
			$('#vKecamatan-loading').hide();
			$('#vKelurahan-loading').hide();

			$("#chekCheklis").change(function() {
				if ($('#chekCheklis').is(":checked")) {
					$("#btnSubmitRegisPt").removeClass("disabled");
				} else {
					$("#btnSubmitRegisPt").addClass("disabled");
				}
			});


			$("#vProvinsi").change(function() {
				var provinsi = $("#vProvinsi").val();
				$.ajax({
					type: "POST",
					url: "{{ url('/ip/getKabupaten') }}",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: JSON.stringify({
						provinsi: provinsi
					}),
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					beforeSend: function() {
						$('#vKotaKabupaten-loading').show();
					},
					success: function(e) {
						if (e.pesan == 'Suksess') {
							var tempoption = "";
							var tempoption = "<option>-- Pilih kabupaten --</option>";
							$.each(e.data, function(key, value) {
								tempoption += "<option value='" + value.id + "'>" +
									value.name + "</option>";
							});
						} else {
							alert("Terjadi Kesalahan Silahkan Coba Lagi nanti!");
						}

						$("#vKotaKabupaten").html(tempoption);
						$("#vKotaKabupaten").removeAttr("disabled");
						$('#vKotaKabupaten-loading').hide();
					},
					failure: function(errMsg) {
						alert(errMsg);
					}
				});
			});
			$("#vKotaKabupaten").change(function() {
				var kabupaten = $("#vKotaKabupaten").val();
				$.ajax({
					type: "POST",
					url: "{{ url('/ip/getKecamatan') }}",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: JSON.stringify({
						kabupaten: kabupaten
					}),
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					beforeSend: function() {
						$('#vKecamatan-loading').show();
					},
					success: function(e) {
						if (e.pesan == 'Suksess') {
							var tempoption = "";
							var tempoption = "<option>-- Pilih kecamatan --</option>";
							$.each(e.data, function(key, value) {
								tempoption += "<option value='" + value.id + "'>" +
									value.name + "</option>";
							});
						} else {
							alert("Terjadi Kesalahan Silahkan Coba Lagi nanti!");
						}

						$("#vKecamatan").html(tempoption);
						$("#vKecamatan").removeAttr("disabled");
						$('#vKecamatan-loading').hide();
					},
					failure: function(errMsg) {
						alert(errMsg);
					}
				});
			});
			$("#vKecamatan").change(function() {
				var kecamatan = $("#vKecamatan").val();
				$.ajax({
					type: "POST",
					url: "{{ url('/ip/getKelurahan') }}",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: JSON.stringify({
						kecamatan: kecamatan
					}),
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					beforeSend: function() {
						$('#vKelurahan-loading').show();
					},
					success: function(e) {
						if (e.pesan == 'Suksess') {
							var tempoption = "";
							var tempoption = "<option>-- Pilih Kelurahan --</option>";
							$.each(e.data, function(key, value) {
								tempoption += "<option value='" + value.id + "'>" +
									value.name + "</option>";
							});
						} else {
							alert("Terjadi Kesalahan Silahkan Coba Lagi nanti!");
						}

						$("#vKelurahan").html(tempoption);
						$("#vKelurahan").removeAttr("disabled");
						$('#vKelurahan-loading').hide();
					},
					failure: function(errMsg) {
						alert(errMsg);
					}
				});
			});
		});
	</script>
@endsection
