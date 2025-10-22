@extends('layouts.landing.main_rev')
@section('js')
@endsection
@section('section')
	<div id="side-panel" class="dark">
		<div id="side-panel-trigger-close" class="side-panel-trigger"><a href="#"><i class="icon-line-cross"></i></a>
		</div>
		<div class="side-panel-wrap">
			<div class="widget">
				<h4>Belum memiliki akun? Daftar Sekarang.</h4>
				<nav class="nav-tree mb-0">
					<ul>
						<li><a href="#"><i class="icon-bolt2"></i>Penyelenggara Telekomunikasi</a>
							<ul>
								<li><a href="#">Jasa Telekomunikasi</a></li>
								<li><a href="#">Jaringan Telekomunikasi</a></li>
								<li><a href="#">Telekomunikasi Khusus Badan Hukum</a></li>
								<li><a href="#">Penomoran Telekomunikasi</a></li>
							</ul>
						</li>
						<li><a href="#"><i class="icon-briefcase"></i>Non-Penyelenggara Telekomunikasi</a>
							<ul>
								<li><a href="#">Penomoran Telekomunikasi</a>
								</li>
								<li><a href="#">Telekomunikasi Instansi Pemerintah</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
			<div class="widget quick-contact-widget form-widget clearfix">
				<h4>Sudah Memiliki Akun?</h4>
				<button type="submit" id="quick-contact-form-submit" name="quick-contact-form-submit"
					class="button button-small button-3d m-0" value="submit">Login</button>
			</div>
		</div>
	</div>
	<section id="slider" class="slider-element slider-parallax min-vh-60 min-vh-md-100 include-header">
		<div class="slider-inner"
			style="background: #FFF url('/assets/kominfo/images/1450840.png') center center no-repeat; background-size: cover;">
			<div class="vertical-middle slider-element-fade">
				<div class="container py-5">
					<div class="row pt-5">
						<div class="col-lg-8 col-md-8">
							<div class="slider-title">
								<div class="badge rounded-pill badge-default">e-Telekomunikasi</div>
								<h2>{{ $header->name_landing }}.</h2>
								{{-- <h3 class="text-rotater mb-2" data-separator="," data-rotate="fadeIn" data-speed="3500">
									Ajukan Perizinan <span class="t-rotate">Jasa
										Telekomunikasi,Jaringan Telekomunikasi,Telekomunikasi Khusus,Penomoran
										Telekomunikasi</span>.</h3> --}}
								<p>{{ $header->desc_landing }}</p>
								{{-- <a href="side-panel-right-overlay.html"
									class="button button-rounded button-large nott ls0 side-panel-trigger">Ajukan
									Perizinan</a>
								<a href="demo-seo-contact.html"
									class="button button-rounded button-large button-light text-dark bg-white border nott ls0">Hubungi
									Kami</a> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="video-wrap h-100 d-block d-lg-none">
				<div class="video-overlay" style="background: rgba(255,255,255,0.85);"></div>
			</div>
		</div>
	</section>
@endsection
@section('content')
	<section id="content">
		<div class="content-wrap">
			<div class="container">
				<div class="heading-block border-bottom-0 center mx-auto" style="max-width: 550px">
					<h3 class="nott ls0 mb-3">Alur Perizinan Telekomunikasi</h3>
					<p>Berikut merupakan alur perizinan e-Telekomunikasi</p>
					{{-- <p>Direktorat Telekomunikasi mempunyai tugas melaksanakan perumusan dan pelaksanaan kebijakan, penyusunan
                    norma, standar, prosedur, dan kriteria, dan pemberian bimbingan teknis dan supervisi, serta pemantauan,
                    evaluasi, dan pelaporan di bidang standardisasi teknis dan keamanan penyelenggaraan penomoran
                    telekomunikasi dan informatika, serta pelayanan perizinan, peningkatan aksesibilitas dan konektivitas
                    penyelenggaraan telekomunikasi dan telekomunikasi khusus.</p> --}}
				</div>
				<div class="line d-block d-md-none"></div>
				<ul class="process-steps process-7 row col-mb-30 justify-content-center mb-4">
					<li class="col-sm-3 col-lg-1-7 active">
						<a href="#" class="i-bordered i-circled mx-auto icon-edit"></a>
						<h5>Daftar Akun e-Telekomunikasi</h5>
						<h5>Pemenuhan Kelengkapan Data</h5>
						<h5>Verifikasi Akun</h5>
					</li>

					@if ($header->id == 4)
						<li class="col-sm-3 col-lg-1-7 active">
							<a href="#" class="i-bordered i-circled mx-auto icon-check1"></a>
							<h5>Permohonan Penomoran Telekomunikasi</h5>
							<h5>Pemilihan Kode Akses</h5>
							<h5>Pemenuhan Persyaratan</h5>
							<h5>Verifikasi Persyaratan</h5>
						</li>
					@elseif ($header->id == 6)
						<li class="col-sm-3 col-lg-1-7 active">
							<a href="#" class="i-bordered i-circled mx-auto icon-check1"></a>
							<h5>Permohonan Penomoran Telekomunikasi</h5>
							<h5>Pemilihan Kode Akses</h5>
							<h5>Pemenuhan Persyaratan</h5>
							<h5>Verifikasi Persyaratan</h5>
						</li>
					@elseif ($header->id == 5)
						<li class="col-sm-3 col-lg-1-7 active">
							<a href="#" class="i-bordered i-circled mx-auto icon-check1"></a>
							<h5>Permohonan Izin Prinsip</h5>
							<h5>Pemenuhan Persyaratan</h5>
							<h5>Verifikasi Persyaratan</h5>
						</li>
					@else
						<li class="col-sm-3 col-lg-1-7 active">
							<a href="#" class="i-bordered i-circled mx-auto icon-check1"></a>
							<h5>Permohonan Izin Penyelenggaraan</h5>
							<h5>Pemenuhan Persyaratan</h5>
							<h5>Verifikasi Persyaratan</h5>
						</li>
					@endif
					@if ($header->id !== 4 && $header->id !== 6)
						<li class="col-sm-3 col-lg-1-7 active">
							<a href="#" class="i-bordered i-circled mx-auto icon-tachometer-alt"></a>
							<h5>Pengajuan Uji Laik Operasi</h5>
							<h5>Uji Laik Operasi</h5>
							<h5>Evaluasi Uji Laik Operasi</h5>
						</li>
					@endif
					<li class="col-sm-3 col-lg-1-7 active">
						<a href="#" class="i-bordered i-circled mx-auto icon-thumbs-up"></a>
						<h5>Penerbitan Surat Ketetapan</h5>
					</li>
				</ul>
			</div>
		</div>
	</section>
	<div id="section-faqs" class="section m-0 bg-transparent pb-0" style="padding-top: 100px;">
		<div class="container bottommargin">
			<div class="row justify-content-center">
				<div class="col-xl-12 col-lg-12 text-center">
					<div class="heading-block border-bottom-0 center mx-auto">
						<div class="badge rounded-pill badge-default">Dokumen apa yang perlu disiapkan untuk mengajukan
							{{ $header->name_landing }}
							E-Telekomunikasi?</div>
						<h3 class="nott ls0 mb-3">Daftar layanan {{ $header->name_landing }} & Pemenuhan Persyaratan</h3>
						{{-- <p>Berikut merupakan daftar pertanyaan yang sering diajukan. Terima Kasih.</p> --}}
					</div>
				</div>

				<div class="col-lg-10">
					{{-- <div class="grid-filter-wrap justify-content-center">
						<ul class="grid-filter style-4 customjs">
							<li class="activeFilter"><a href="#" class="fw-semibold" data-filter="all">Umum</a>
							</li>
							<li><a href="#" class="fw-semibold" data-filter=".faq-jasa">Perizinan Jasa
									Telekomunikasi</a></li>
							<li><a href="#" class="fw-semibold" data-filter=".faq-jaringan">Perizinan Jaringan
									Telekomunikasi</a></li>
							<li><a href="#" class="fw-semibold" data-filter=".faq-telsus">Perizinan Telekomunikasi
									Khusus</a></li>
							<li><a href="#" class="fw-semibold" data-filter=".faq-nomor">Penomoran
									Telekomunikasi</a>
							</li>
							<li><a href="#" class="fw-semibold" data-filter=".faq-lainnya">Lainnya</a></li>
						</ul>
					</div>
					<div class="clear"></div> --}}
					<div id="faqs" class="faqs">

						@foreach ($izinlayanan as $keys => $listlayanan)
							<div class="toggle faq pb-3 mb-4">
								<div class="toggle-header">
									<div class="toggle-icon color">
										<i class="toggle-closed icon-file3"></i>
										<i class="toggle-open icon-file3"></i>
									</div>
									<div class="toggle-title fw-semibold ps-1">
										{!! $listlayanan->name_html !!}
									</div>
									<div class="toggle-icon color">
										<i class="toggle-closed icon-chevron-down text-black-50"></i>
										<i class="toggle-open icon-chevron-up color"></i>
									</div>
								</div>
								<div class="toggle-content text-black-50 ps-4">
									<table class="table">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Persyaratan</th>
												<th class="text-center">Template</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($izinlayanan_persyaratan as $keys => $layanan_persyaratan)
												@if ($layanan_persyaratan->id == $listlayanan->id)
													<tr>
														<td>
															<div class="d-flex align-items-center">
																{{ $layanan_persyaratan->order_no }}
															</div>
														</td>
														<td>
															<div>
																{!! $layanan_persyaratan->persyaratan_html !!}
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																@if ($layanan_persyaratan->download_link != null && $layanan_persyaratan->download_link != '')
																	<a target="_blank" href="{{ $layanan_persyaratan->download_link }}">Unduh</a>
																@endif
															</div>
														</td>
													</tr>
												@endif
											@endforeach
										</tbody>
									</table>

								</div>
							</div>
						@endforeach
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
	<script src="/assets/kominfo/js/functions.js"></script>
	<script>
		jQuery(document).ready(function($) {
			var $faqItems = $('#faqs .faq');
			if (window.location.hash != '') {
				var getFaqFilterHash = window.location.hash;
				var hashFaqFilter = getFaqFilterHash.split('#');
				if ($faqItems.hasClass(hashFaqFilter[1])) {
					$('.grid-filter li').removeClass('activeFilter');
					$('[data-filter=".' + hashFaqFilter[1] + '"]').parent('li').addClass('activeFilter');
					var hashFaqSelector = '.' + hashFaqFilter[1];
					$faqItems.css('display', 'none');
					if (hashFaqSelector != 'all') {
						$(hashFaqSelector).fadeIn(500);
					} else {
						$faqItems.fadeIn(500);
					}
				}
			}

			$('.grid-filter a').on('click', function() {
				$('.grid-filter li').removeClass('activeFilter');
				$(this).parent('li').addClass('activeFilter');
				var faqSelector = $(this).attr('data-filter');
				$faqItems.css('display', 'none');
				if (faqSelector != 'all') {
					$(faqSelector).fadeIn(500);
				} else {
					$faqItems.fadeIn(500);
				}
				return false;
			});
		});
	</script>
@endsection
