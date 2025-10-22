@extends('layouts.landing.main_rev')
@section('section')
	<div id="side-panel" class="dark">
		<div id="side-panel-trigger-close" class="side-panel-trigger"><a href="#"><i class="icon-line-cross"></i></a>
		</div>
		<div class="side-panel-wrap">
			<div class="widget">
				<h4>Belum memiliki akun? Daftar Sekarang.</h4>
				<button onclick="location.href='{{ route('register') }}'" class="button button-small button-3d m-0">Daftar</button>
				{{-- <nav class="nav-tree mb-0">
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
				</nav> --}}
			</div>
			<div class="widget quick-contact-widget form-widget clearfix">
				<h4>Sudah Memiliki Akun?</h4>
				<button onclick="location.href='{{ route('login') }}'" class="button button-small button-3d m-0">Masuk</button>
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
								<h2>Frequently Asked Questions.</h2>
								<!-- <h3 class="text-rotater mb-2" data-separator="," data-rotate="fadeIn" data-speed="3500">
									Ajukan Perizinan <span class="t-rotate">Jasa
										Telekomunikasi,Jaringan Telekomunikasi,Telekomunikasi Khusus,Penomoran
										Telekomunikasi</span>.</h3> -->
								<p>Berikut merupakan daftar pertanyaan yang sering diajukan. Terima Kasih.</p>
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
	<div id="section-faqs" class="section m-0 bg-transparent pb-0" style="padding-top: 100px;">
		<div class="container bottommargin">
			<div class="row justify-content-center">
				<div class="col-xl-6 col-lg-8 text-center">
					<div class="heading-block border-bottom-0 center mx-auto">
						<div class="badge rounded-pill badge-default">Bagaimana Kami dapat membantu Anda?</div>
						<h3 class="nott ls0 mb-3">Frequently Asked Questions</h3>
						<p>Berikut merupakan daftar pertanyaan yang sering diajukan. Terima Kasih.</p>
					</div>
				</div>

				<div class="col-lg-10">
					<div class="grid-filter-wrap justify-content-center">
						<ul class="grid-filter style-4 customjs">
							<li class="activeFilter"><a href="#" class="fw-semibold" data-filter="all">Umum</a>
							</li>
							<li><a href="#" class="fw-semibold" data-filter=".Jasa">Perizinan Jasa
									Telekomunikasi</a></li>
							<li><a href="#" class="fw-semibold" data-filter=".Jaringan">Perizinan Jaringan
									Telekomunikasi</a></li>
							<li><a href="#" class="fw-semibold" data-filter=".Telsus">Perizinan Telekomunikasi
									Khusus</a></li>
							<li><a href="#" class="fw-semibold" data-filter=".Nomor">Penomoran
									Telekomunikasi</a>
							</li>
							<li><a href="#" class="fw-semibold" data-filter=".Lainnya">Lainnya</a></li>
						</ul>
					</div>
					<div class="clear"></div>
					<div id="faqs" class="faqs">
						@foreach ($list_faq as $faq)
							<div class="toggle faq pb-3 mb-4 {{ $faq->category }}">
								<div class="toggle-header">
									<div class="toggle-icon color">
										<i class="toggle-closed icon-question-sign"></i>
										<i class="toggle-open icon-question-sign"></i>
									</div>
									<div class="toggle-title fw-semibold ps-1">
										{!! $faq->question !!}
									</div>
									<div class="toggle-icon color">
										<i class="toggle-closed icon-chevron-down text-black-50"></i>
										<i class="toggle-open icon-chevron-up color"></i>
									</div>
								</div>
								<div class="toggle-content text-black-50 ps-4">{!! $faq->answer !!}</div>
								@if (isset($faq->download_link) && $faq->download_link != '')
									<div class="toggle-content text-black-50 ps-4">Unduh Dokumen <a target="_blank"
											href="{{ $faq->download_link }}">Disini</a></div>
								@else
								@endif
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
