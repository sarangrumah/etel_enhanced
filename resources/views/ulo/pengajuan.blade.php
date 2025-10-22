@extends('layouts.frontend.main')
@section('title', 'Pengajuan Uji Laik Operasi')
@section('js')
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
	</script>

	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
	{{-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> --}}
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
	</script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endsection
@section('content')
	{{--
<x-frm-jartup-fo-ter />
<x-frm-komittahun />
<x-frm-kinerjalayanan />
<x-frm-dataalatperangkat />
<x-frm-jar-persyaratan /> --}}
	<form id="form-ulo" action="{{ url('/ulo/submitulo') }}" method="post" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="id_izin" value="{{ $id_izin }}">
		<input type="hidden" name="nama_master_izin" value="{{ $izin['nama_master_izin'] }}">
		<input type="hidden" name="nib_user" value="{{ $izin['nib'] }}">
		<div class="card">
			<div class="card-header bg-indigo text-white header-elements-inline">
				<div class="row">
					<div class="col-lg">
						<h6 class="card-title font-weight-semibold py-3">Form Uji Laik Operasi </h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-12">
						<fieldset>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Metode Uji Laik Operasi</label>
								<label class="col-lg-8 col-form-label"><span>:
									</span>
									@if ($izin['kbli'] == '61911' || $izin['kbli'] == '61912' || $izin['kbli'] == '61914' || $izin['kbli'] == '61919')
										Penilaian Mandiri
										<input type="hidden" name="tipe_ulo" value="2">
										<input type="hidden" name="status" value="11">
										<input type="hidden" name="nama_status" value="Penilaian Mandiri">
									@else
										Uji Petik
										<input type="hidden" name="tipe_ulo" value="1">
										<input type="hidden" name="status" value="20">
										<input type="hidden" name="nama_status" value="Uji Petik">
									@endif
								</label>
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Tanggal Permohonan Pelaksanaan ULO <span
										class="text-danger">*</span></label>
								<div class="col-lg-3">
									{{-- <input type="date" name="tgl_ulo" id="tgl_ulo" class="form-control" placeholder="Pilih Tanggal"> --}}
									<input readonly type="text" name="tgl_ulo" id="datepicker" placeholder="Input Tanggal">

									{{-- <div class="form-group">
										<h3> EX 03: Disabled date from 27th aug to 30th aug 2023</h3>
										<label for="datepicker_c3">Select date</label>
										<input type="text" name="" id="datepicker_c3" class="form-control" placeholder="select date">
									</div> --}}
									{{-- <input type="text" class="form-control datepicker" placeholder="Date" name="date"> --}}
									{{-- <p class="m-0 text-danger">*Tanggal merah tidak bisa dipilih</p> --}}
								</div>
							</div>
							<div class="dropdown-divider"></div>
							@if ($izin['kbli'] == '61911' || $izin['kbli'] == '61912' || $izin['kbli'] == '61914' || $izin['kbli'] == '61919')
								<div class="text-left">
									<p class="text-danger">*Tanggal ULO
										dalam Uji Laik Operasi (ULO) Metode Penilaian Mandiri mengacu
										pada tanggal batas akhir Pemohon ULO melakukan upload Dokumen
										Hasil Pelaksanaan ULO Penilaian Mandiri di sistem.</p>
								</div>
								<div class="dropdown-divider mb-3"></div>
							@endif

							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Surat Permohonan Uji Laik Operasi <span
										class="text-danger">*</span></label>
								<div class="col-lg-3">
									<input type="file" name="sp_ulo" id="sp_ulo" accept="application/pdf">
									<span for="" class="text-danger mr-2">*Wajib Diisi Format PDF</span>
									<span for="" class="text-danger">*Maksimum File : 5Mb</span>
									{{-- <button style="display: inline-block" type="button" class="btn btn-warning btn-sm"
                                    data-toggle="tooltip" data-placement="top"
                                    title="Pastikan upload dokumen sebelum tanggal pelaksanaan ulo">
                                    Peringatan!
                                </button> --}}
								</div>
							</div>
							<div class="dropdown-divider"></div>
							<div class="form-group row">
								<div class="col-lg-12">
									<!--begin::Text-->
									<div class="fw-bold text-dark-600 text-dark my-4 text-sm">
										<p>
											Saya menyatakan adalah benar merupakan pegawai/karyawan/pemilik/pemegang kuasa
											pengurusan izin dari lembaga/institusi/perusahaan ini, yang untuk selanjutnya
											bertindak atas nama lembaga/institusi/perusahaan sebagai Pemohon Izin
											Penyelenggaraan Telekomunikasi Layanan Uji Laik Operasi (ULO).
										</p>
										<p>
											Dalam rangka mewujudkan Zona Integritas menuju Wilayah Bebas dari Korupsi (WBK)
											di
											Direktorat Telekomunikasi, dengan ini saya menyatakan bersedia untuk:
										</p>
										<ol>
											<li>Tidak melakukan komunikasi dan perbuatan yang mengarah kepada kolusi,
												korupsi
												dan nepotisme (KKN);</li>
											<li>Akan melaporkan kepada pihak yang berwajib/berwenang apabila mengetahui ada
												indikasi korupsi, kolusi dan nepotisme (KKN);</li>
											<li>Tidak menjanjikan dan/atau memberikan dan/atau akan memberikan kepada
												petugas/pejabat Layanan Uji Laik Operasi, segala bentuk
												pemberian/gratifikasi
												atas Layanan Uji Laik Operasi yang dimohonkan kepada Direktorat
												Telekomunikasi;
												dan</li>
											<li>Mematuhi Standar Operasional Prosedur (SOP) yang berlaku dalam pengurusan
												Layanan Uji Laik Operasi.</li>
										</ol>
										<p>Apabila saya melanggar hal-hal yang telah saya nyatakan dalam PAKTA INTEGRITAS
											ini,
											Saya atas nama pribadi, lembaga/ institusi/ perusahaan bersedia untuk diproses
											berdasarkan ketentuan peraturan perundang-undangan yang berlaku.</p>

									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-lg-12">
									<label class="custom-control custom-checkbox custom-control-inline">
										<input type="checkbox" class="custom-control-input" id="pakta-integritas" required>
										<span for="pakta-integritas" class="custom-control-label">PAKTA INTEGRITAS ini
											dibuat tanpa adanya paksaan
											dari pihak lain untuk dapat
											dipergunakan sebagaimana mestinya.</span>
									</label>
									<div class="text-danger">*Pastikan anda sudah check Pakta Integritas sebelum mengirim
										permohonan</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<div class="text-right">
			<a href="{{ URL::previous() }}" class="btn btn-indigo"><i class="icon-backward2 ml-2"></i> Kembali </a>
			<button type="submit" class="btn btn-secondary submit" onclick="return false;" data-toggle="modal"
				data-target="#submitModal">
				Kirim Permohonan
				<i class="icon-paperplane ml-2"></i></button>
		</div>

	</form>

	<div class="modal" id="submitModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Kirim Permohonan Uji Laik Operasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Apakah anda yakin permohonan yang akan dikirim sudah sesuai?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary notif-button" data-dismiss="modal">Batal</button>
					<button type="button" onclick="submitulo();return false;" class="btn btn-primary notif-button">Kirim</button>
					<div class="spinner-border loading text-primary" role="status" hidden>
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('custom-js')
	<script type="text/javascript">
		function submitulo() {
			$('.notif-button').attr("hidden", true);
			$('.loading').attr("hidden", false);
			$('#form-ulo').submit();
		}

		function checkValid() {
			var cbChecked = $("#pakta-integritas").is(":checked");
			var tglUlo = $("#datepicker").val().length > 0;
			var spUlo = $("#sp_ulo").val().length > 0;

			$(".submit").prop("disabled", !cbChecked || !tglUlo || !spUlo);
		}

		$(function() {
			checkValid();
			$("#pakta-integritas").on("change", checkValid);
			$("#datepicker").on("change", checkValid);
			$("#sp_ulo").on("input", checkValid);
		});

		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	<script>
		$.ajax({
			url: "../offday",
			success: function(data) {

				var data = data;

				$.ajax({

					// url	: "https://api-harilibur.vercel.app/api",
					url: "/api/offday/",
					success: function(result) {

						var newArray = result.filter(function(el) {
							return el.is_national_holiday >= true;
						});

						newArray = newArray.map(obj => obj.holiday_date);

						var holiDays = data.concat(newArray);
						// var extraHoliday = '2024-01-18'; // Example date, change this to your desired date
						// holiDays.push(extraHoliday);

						// console.log(holiDays);


						function disableHoliday(date) {
							var string = $.datepicker.formatDate('yy-mm-dd', date);

							var filterDate = new Date(string);
							var day = filterDate.getDay();
							var isHoliday = ($.inArray(string, holiDays) != -1);
							console.log(string, holiDays);
							return [day != 0 && day != 6 && !isHoliday]
						}

						$("#datepicker").datepicker({
							beforeShowDay: disableHoliday,
							minDate: '+8D',
							dateFormat: 'd MM yy'
							// dateFormat: 'yy-mm-dd'
						});
					}

				});

			}
		});
		// var disabledDates1 = ["27-05-2024"];
		// console.log("Datepicker initialized");
		// $('#datepicker').datepicker({
		// 	minDate: new Date()
		// });
		// var disabledDates1 = ["27-08-2023", "28-08-2023", "29-08-2023", "30-08-2023"];
		// $('#datepicker').datepicker({
		// 	beforeShowDay: function(date) {
		// 		var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
		// 		//var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
		// 		return [disabledDates1.indexOf(string) == -1]
		// 	}
		// });
	</script>
@endsection
