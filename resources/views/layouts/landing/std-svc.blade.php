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
								<h2>Direktorat Telekomunikasi.</h2>
								<h3>
									Tentang Kami.</h3>
								<p>Direktorat Telekomunikasi adalah unit kerja yang berada di bawah dan bertanggung jawab kepada Direktur
									Jenderal Penyelenggaraan Pos dan Informatika. Direktorat Telekomunikasi dikepalai oleh Direktur Telekomunikasi
									yang membawahi 6 Tim Kerja.
									Reformasi Birokrasi di lingkungan Direktorat telekomunikasi khususnya dalam peningkatan kualitas pelayanan
									publik serta pengembangan budaya kerja anti korupsi dilaksanakan melalui pencanangan Zona Integritasi menuju
									Wilayah Bebas Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM) yang dituangkan dalam Pernyataan
									Deklarasi Zona Integritas Direktorat Telekomunikasi.
									Dalam pernyataan deklarasi, seluruh Aparatur Sipil Negara di lingkungan Direktorat Telekomunikasi berkomitmen
									untuk mewujudkan Zona Integritas menuju Wilayah Bebas Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani
									(WBBM), menjauhkan diri dari praktek korupsi, kolusi, dan nepotisme dalam pelaksanaan tugas, serta meningkatkan
									kualitas pelayanan kepada masyarakat.</p>
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
			<div class="container center clearfix">
				<h3>Maklumat Pelayanan</h3>
				<embed src="{{ asset('/storage/lampiran/MaklumatPelayananDittel2023.pdf') }}" type="application/pdf" width="100%"
					height="600px" />

				{{-- <div class="entry-image bottommargin">
					<a href="#"><img src="/assets/kominfo/images/maklumat.png" alt="Blog Single"></a>
				</div> --}}
				<a href="/storage/lampiran/MaklumatPelayananDittel2023.pdf" class="button button-desc" target="_blank">
					<div>Unduh Maklumat</div>
				</a>
				<div class="divider"><i class="icon-circle"></i></div>
				<h3>Standard Pelayanan</h3>
				<embed src="{{ asset('/storage/lampiran/StandardPelayanan.pdf') }}" type="application/pdf" width="100%"
					height="600px" />

				{{-- <div class="entry-image bottommargin">
					<a href="#"><img src="/assets/kominfo/images/maklumat.png" alt="Blog Single"></a>
				</div> --}}
				<a href="/storage/KEPUTUSAN DIREKTUR NO 36 TAHUN 2023 - STANDAR PELAYANAN PERIZINAN TELEKOMUNIKASI.pdf"
					class="button button-desc" target="_blank">
					<div>Unduh Standar Pelayanan</div>
				</a>
			</div>
		</div>
	</section>
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
