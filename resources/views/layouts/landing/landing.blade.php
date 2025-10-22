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
	{{-- <section id="slider" class="slider-element slider-parallax min-vh-60 min-vh-md-100 include-header"> --}}
	<section id="slider" class="slider-element slider-parallax revslider-wrap min-vh-0">
		{{-- <div class="slider-inner"
			style="background: #FFF url('/assets/kominfo/images/1450840.png') center center no-repeat; background-size: cover;">
			<div class="vertical-middle slider-element-fade">
				<div class="container py-5">
					<div class="row pt-5">
						<div class="col-lg-8 col-md-8">
							<div class="slider-title">
								<div class="badge rounded-pill badge-default">e-Telekomunikasi</div>
								<h2>Kami siap melayani Anda.</h2>
								<h3 class="text-rotater mb-2" data-separator="," data-rotate="fadeIn" data-speed="3500">
									Ajukan Perizinan <span class="t-rotate">Jasa
										Telekomunikasi,Jaringan Telekomunikasi,Telekomunikasi Khusus,Penomoran
										Telekomunikasi</span>.</h3>
								<p>Direktorat Telekomunikasi mempunyai tugas melaksanakan perumusan dan pelaksanaan
									kebijakan, penyusunan norma, standar, prosedur, dan kriteria, dan pemberian
									bimbingan teknis dan supervisi, serta pemantauan, evaluasi, dan pelaporan di
									bidang standardisasi teknis dan keamanan penyelenggaraan penomoran
									telekomunikasi dan informatika, serta pelayanan perizinan, peningkatan
									aksesibilitas dan konektivitas penyelenggaraan telekomunikasi dan telekomunikasi
									khusus.</p>
								<a href="{{ route('register') }}" class="button button-rounded button-large nott ls0 side-panel-trigger">Ajukan
									Perizinan</a>
								<a href="demo-seo-contact.html"
                                    class="button button-rounded button-large button-light text-dark bg-white border nott ls0">Hubungi
                                    Kami</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="video-wrap h-100 d-block d-lg-none">
				<div class="video-overlay" style="background: rgba(255,255,255,0.85);"></div>
			</div>
		</div> --}}
		<div class="slider-inner">

			<div id="rev_slider_k_fullwidth_wrapper" class="rev_slider_wrapper fullwidth-container" style="padding:0px;">

				<div id="rev_slider_k_fullwidth" class="rev_slider fullwidthbanner" style="display:none;" data-version="5.1.4">
					<ul>

						<li data-transition="fade" data-slotamount="1" data-masterspeed="1500"
							data-thumb="images/slider/rev/ken-2-thumb.jpg" data-delay="15000" data-saveperformance="off"
							data-title="Unlimited Possibilities">

							<img src="/assets/kominfo/images/1450840.png" alt="kenburns6" data-bgposition="center bottom"
								data-bgpositionend="center top" data-kenburns="on" data-duration="25000" data-ease="Linear.easeNone"
								data-scalestart="100" data-scaleend="140" data-rotatestart="0" data-rotateend="0" data-blurstart="0"
								data-blurend="0" data-offsetstart="0 0" data-offsetend="0 0" class="rev-slidebg" data-no-retina>

							{{-- <div class="tp-caption ltl tp-resizeme revo-slider-caps-text text-uppercase" data-x="middle" data-hoffset="0"
								data-y="top" data-voffset="170"
								data-transform_in="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
								data-speed="800" data-start="1000" data-easing="easeOutQuad" data-splitin="none" data-splitout="none"
								data-elementdelay="0.01" data-endelementdelay="0.1" data-endspeed="1000" data-endeasing="Power4.easeIn"
								style="z-index: 3; color: #333; white-space: nowrap;">Why Choose Canvas?</div>
							<div class="tp-caption ltl tp-resizeme revo-slider-emphasis-text p-0 border-0" data-x="middle" data-hoffset="0"
								data-y="top" data-voffset="185" data-fontsize="['60','50','50','40']"
								data-transform_in="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
								data-speed="800" data-start="1200" data-easing="easeOutQuad" data-splitin="none" data-splitout="none"
								data-elementdelay="0.01" data-endelementdelay="0.1" data-endspeed="1000" data-endeasing="Power4.easeIn"
								style="z-index: 3; color: #333; white-space: nowrap;">Unlimited Possibilities</div>
							<div class="tp-caption ltl tp-resizeme revo-slider-desc-text" data-x="middle" data-hoffset="0" data-y="top"
								data-voffset="295"
								data-transform_in="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
								data-speed="800" data-lineheight="['30','30','34','26']" data-width="['750','750','480','360']" data-start="1400"
								data-easing="easeOutQuad" data-splitin="none" data-splitout="none" data-elementdelay="0.01"
								data-endelementdelay="0.1" data-endspeed="1000" data-textAlign="center" data-endeasing="Power4.easeIn"
								style="z-index: 3; color: #333; max-width: 650px; white-space: normal;">Create
								whatever you require for your Business to bloom with Tons of Customization
								Possibilities.</div>
							<div class="tp-caption ltl tp-resizeme" data-x="middle" data-hoffset="0" data-y="top" data-voffset="405"
								data-transform_in="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
								data-speed="800" data-start="1550" data-easing="easeOutQuad" data-splitin="none" data-splitout="none"
								data-elementdelay="0.01" data-endelementdelay="0.1" data-endspeed="1000" data-endeasing="Power4.easeIn"
								style="z-index: 3;"><a href="#"
									class="button button-border button-large button-rounded text-end m-0"><span>Browse</span><i
										class="icon-angle-right"></i></a></div> --}}
						</li>
						{{-- <li class="dark" data-transition="zoomout" data-slotamount="1" data-masterspeed="1500"
								data-thumb="images/slider/rev/bg1-thumb.jpg" data-saveperformance="off"
								data-title="Fixed-Size Video">

								<img src="images/slider/rev/bg1.jpg" alt="citybg"
									data-lazyload="images/slider/rev/bg1.jpg" data-bgposition="center top"
									data-scale="cover" data-bgrepeat="no-repeat">


								<div class="tp-caption ltl tp-resizeme" data-x="['left','left','left','left']"
									data-hoffset="['670','670','100','0']" data-y="['top','top','bottom','bottom']"
									data-voffset="['45','45','0','0']"
									data-transform_in="x:250;y:0;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:400;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
									data-speed="400" data-start="1000" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-endeasing="Power4.easeIn"><img
										src="images/services/imac2.png" alt="imac"></div>
								<div class="tp-caption ltl tp-resizeme" data-x="['left','left','right','right']"
									data-hoffset="['1000','1000','180','0']" data-y="['top','top','bottom','bottom']"
									data-voffset="['320','320','0','0']"
									data-transform_in="x:0;y:100;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:400;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
									data-speed="400" data-start="1200" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-endeasing="Power4.easeIn"><img
										src="images/services/iphone3.png" alt="iphone"></div>
								<div class="tp-caption ltl tp-resizeme revo-slider-caps-text text-uppercase"
									data-x="['left','left','left','left']" data-hoffset="['20','20','20','20']"
									data-y="['top','top','top','top']" data-voffset="['165','165','165','40']"
									data-transform_in="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
									data-speed="800" data-start="1000" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-endeasing="Power4.easeIn" style="white-space: nowrap;">
									Have Multiple Devices? No Worries!</div>
								<div class="tp-caption ltl tp-resizeme revo-slider-emphasis-text p-0 border-0"
									data-x="['left','left','left','left']" data-hoffset="['17','17','17','17']"
									data-y="['top','top','top','top']" data-voffset="['180','180','180','65']"
									data-transform_in="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
									data-fontsize="['56','56','50','40']" data-speed="800" data-start="1200"
									data-easing="easeOutQuad" data-splitin="none" data-splitout="none"
									data-elementdelay="0.01" data-endelementdelay="0.1" data-endspeed="1000"
									data-endeasing="Power4.easeIn" style="font-size: 56px; white-space: nowrap;">
									Responsive Retina Ready</div>
								<div class="tp-caption ltl tp-resizeme revo-slider-desc-text text-start"
									data-x="['left','left','left','left']" data-hoffset="['20','20','20','20']"
									data-y="['top','top','top','top']" data-voffset="['280','280','280','165']"
									data-width="['550','550','480','400']"
									data-transform_in="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
									data-speed="800" data-start="1400" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-endeasing="Power4.easeIn"
									style="max-width: 550px; white-space: normal;">Canvas has Mobile Ready Design &amp;
									Retina Graphics Support for seamless experience on all types of Devices.</div>
								<div class="tp-caption ltl tp-resizeme" data-x="['left','left','left','left']"
									data-hoffset="['20','20','20','20']" data-y="['top','top','top','top']"
									data-voffset="['385','385','385','270']"
									data-transform_in="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
									data-speed="800" data-start="1550" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-endeasing="Power4.easeIn"><a href="#"
										class="button button-border button-white button-light button-large button-rounded text-end m-0"><span>Start
											Tour</span> <i class="icon-angle-right"></i></a></div>
							</li>
							<li class="dark" data-transition="zoomout" data-slotamount="1" data-masterspeed="1500"
								data-thumb="images/slider/rev/bg2-thumb.jpg" data-saveperformance="off"
								data-title="Fixed-Size Video">

								<img src="images/slider/rev/bg2.jpg" alt="kenburns6" data-bgposition="left bottom"
									data-bgpositionend="right top" data-kenburns="on" data-duration="20000"
									data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="120"
									data-rotatestart="0" data-rotateend="0" data-blurstart="0" data-blurend="0"
									data-offsetstart="0 0" data-offsetend="0 0" class="rev-slidebg" data-no-retina>

								<div class="tp-caption" data-x="['left','left','left','left']"
									data-hoffset="['20','20','30','30']" data-y="['top','top','top','top']"
									data-voffset="['130','130','130','130']"
									data-transform_in="x:0;y:0;z:0;rotationZ:0;scaleX:0.6;scaleY:0.6;skewX:0;skewY:0;s:850;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
									data-speed="850" data-start="1200" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-videowidth="['600','500','650','420']"
									data-videoheight="['340','283','368','238']" data-endeasing="Power4.easeIn"><iframe
										src='https://player.vimeo.com/video/102501580?title=0&amp;byline=0&amp;portrait=0;api=1'
										width='600' height='340'
										style='width:600px;height:340px;border: none !important;'></iframe></div>
								<div class="tp-caption ltl tp-resizeme revo-slider-caps-text text-uppercase"
									data-x="['left','left','left','left']" data-hoffset="['675','575','30','30']"
									data-y="['top','top','top','top']" data-voffset="['165','165','530','430']"
									data-transform_in="x:140;y:0;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
									data-speed="800" data-start="1000" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-endeasing="Power4.easeIn" style="white-space: nowrap;">
									Need to show Videos?</div>
								<div class="tp-caption ltl tp-resizeme revo-slider-emphasis-text p-0 border-0"
									data-x="['left','left','left','left']" data-hoffset="['672','572','30','30']"
									data-y="['top','top','top','top']" data-voffset="['180','180','555','455']"
									data-fontsize="['56','50','40','30']"
									data-transform_in="x:140;y:0;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
									data-speed="800" data-start="1200" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-endeasing="Power4.easeIn"
									style="font-size: 56px; white-space: nowrap;">Embedded Videos</div>
								<div class="tp-caption ltl tp-resizeme revo-slider-desc-text text-start"
									data-x="['left','left','left','left']" data-hoffset="['675','575','30','30']"
									data-y="['top','top','top','top']" data-voffset="['280','280','655','555']"
									data-transform_in="x:140;y:0;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
									data-speed="800" data-start="1400" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-endeasing="Power4.easeIn"
									style="max-width: 450px; white-space: normal;">Show off your Youtube or Vimeo Videos
									in Style with an Autoplay Option.</div>
								<div class="tp-caption ltl tp-resizeme" data-x="['left','left','left','left']"
									data-hoffset="['675','575','30','30']" data-y="['top','top','top','top']"
									data-voffset="['385','385','760','630']"
									data-transform_in="x:140;y:0;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;s:800;e:Power4.easeOutQuad;"
									data-speed="800" data-start="1550" data-easing="easeOutQuad" data-splitin="none"
									data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.1"
									data-endspeed="1000" data-endeasing="Power4.easeIn"><a href="#"
										class="button button-border button-white button-light button-large button-rounded text-end m-0"><span>Embed
											Now</span> <i class="icon-angle-right"></i></a></div>
							</li> --}}
					</ul>
				</div>
			</div>
		</div>
	</section>
@endsection
@section('content')
	<div class="section m-0 bg-transparent pb-0" style="padding-top: 100px;">
		<div class="container clearfix">
			<div class="heading-block border-bottom-0 center mx-auto mb-0" style="max-width: 550px">
				<div class="badge rounded-pill badge-default">Tentang Kami</div>
				<h3 class="nott ls0 mb-3">DIREKTORAT TELEKOMUNIKASI</h3>
				<p>Fungsi, Tugas dan Tanggung Jawab</p>
				{{-- <p>Direktorat Telekomunikasi mempunyai tugas melaksanakan perumusan dan pelaksanaan kebijakan, penyusunan
                    norma, standar, prosedur, dan kriteria, dan pemberian bimbingan teknis dan supervisi, serta pemantauan,
                    evaluasi, dan pelaporan di bidang standardisasi teknis dan keamanan penyelenggaraan penomoran
                    telekomunikasi dan informatika, serta pelayanan perizinan, peningkatan aksesibilitas dan konektivitas
                    penyelenggaraan telekomunikasi dan telekomunikasi khusus.</p> --}}
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-md-12">
							<div class="feature-box fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-line2-screen-desktop text-primary"></i></a>
								</div>
								<div class="fbox-content">
									<h3>Penyiapan Perumusan Kebijakan</h3>
									<p>Penyiapan perumusan kebijakan di bidang standardisasi teknis dan keamanan
										penyelenggaraan
										penomoran telekomunikasi dan informatika, pelayanan perizinan telekomunikasi dan
										telekomunikasi khusus, peningkatan aksesibilitas dan konektivitas telekomunikasi dan
										telekomunikasi khusus, serta tarif, interkoneksi, dan iklim usaha penyelenggaraan
										telekomunikasi dan telekomunikasi khusus.</p>
								</div>
							</div>
							<div class="line line-sm"></div>
						</div>
						<div class="col-md-12">
							<div class="feature-box fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-line2-bulb text-warning"></i></a>
								</div>
								<div class="fbox-content">
									<h3>Penyusunan Pelaksanaan Kebijakan</h3>
									<p>Penyiapan pelaksanaan kebijakan di bidang standardisasi teknis dan keamanan
										penyelenggaraan
										penomoran telekomunikasi dan informatika, pelayanan perizinan telekomunikasi dan
										telekomunikasi khusus, peningkatan aksesibilitas dan konektivitas telekomunikasi dan
										telekomunikasi khusus, serta tarif, interkoneksi, dan iklim usaha penyelenggaraan
										telekomunikasi dan telekomunikasi khusus.</p>
								</div>
							</div>
							<div class="line line-sm"></div>
						</div>
						<div class="col-md-12">
							<div class="feature-box fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-line2-bulb text-danger"></i></a>
								</div>
								<div class="fbox-content">
									<h3>Penyusunan Norma, Standar, Prosedur, dan Kriteria</h3>
									<p>Penyusunan norma, standar, prosedur, dan kriteria di bidang standardisasi teknis dan
										keamanan
										penyelenggaraan penomoran telekomunikasi dan informatika, pelayanan perizinan
										telekomunikasi
										dan telekomunikasi khusus, peningkatan aksesibilitas dan konektivitas telekomunikasi
										dan
										telekomunikasi khusus, serta tarif, interkoneksi, dan iklim usaha penyelenggaraan
										telekomunikasi dan telekomunikasi khusus.</p>
								</div>
							</div>
							<div class="line line-sm"></div>
						</div>
						<div class="col-md-12">
							<div class="feature-box fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-line2-support text-danger"></i></a>
								</div>
								<div class="fbox-content">
									<h3>Bimbingan Teknis</h3>
									<p>Penyiapan pemberian bimbingan teknis dan supervisi di bidang standardisasi teknis dan
										keamanan penyelenggaraan penomoran telekomunikasi dan informatika, pelayanan
										perizinan
										telekomunikasi dan telekomunikasi khusus, peningkatan aksesibilitas dan konektivitas
										telekomunikasi dan telekomunikasi khusus, serta tarif, interkoneksi, dan iklim usaha
										penyelenggaraan telekomunikasi dan telekomunikasi khusus.</p>
								</div>
							</div>
							<div class="line line-sm"></div>
						</div>
						<div class="col-md-12">
							<div class="feature-box fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-eye-open text-success"></i></a>
								</div>
								<div class="fbox-content">
									<h3>Pemantauan, Evaluasi, dan Pelaporan</h3>
									<p>Pemantauan, evaluasi, dan pelaporan di bidang standardisasi kualitas layanan dan
										teknis,
										serta keamanan penyelenggaraan penomoran telekomunikasi dan informatika, pelayanan
										perizinan
										telekomunikasi dan telekomunikasi khusus, peningkatan aksesibilitas dan konektivitas
										telekomunikasi dan telekomunikasi khusus, serta tarif, interkoneksi, dan iklim usaha
										penyelenggaraan telekomunikasi dan telekomunikasi khusus.</p>
								</div>
							</div>
							<div class="line line-sm"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
					<li class="col-sm-3 col-lg-1-7 active">
						<a href="#" class="i-bordered i-circled mx-auto icon-check1"></a>
						<h5>Permohonan Izin Penyelenggaraan</h5>
						<h5>Pemenuhan Persyaratan</h5>
						<h5>Verifikasi Persyaratan</h5>
					</li>
					<li class="col-sm-3 col-lg-1-7 active">
						<a href="#" class="i-bordered i-circled mx-auto icon-tachometer-alt"></a>
						<h5>Pengajuan Uji Laik Operasi</h5>
						<h5>Uji Laik Operasi</h5>
						<h5>Evaluasi Uji Laik Operasi</h5>
					</li>
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
						{{-- <div class="toggle faq pb-3 mb-4 faq-jasa faq-jaringan faq-telsus faq-nomor faq-lainnya">
							<div class="toggle-header">
								<div class="toggle-icon color">
									<i class="toggle-closed icon-question-sign"></i>
									<i class="toggle-open icon-question-sign"></i>
								</div>
								<div class="toggle-title fw-semibold ps-1">
									Dokumen apa yang perlu disiapkan untuk membuat akun baru di E-Telekomunikasi?
								</div>
								<div class="toggle-icon color">
									<i class="toggle-closed icon-chevron-down text-black-50"></i>
									<i class="toggle-open icon-chevron-up color"></i>
								</div>
							</div>
							<div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
								adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
								excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
								enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
								Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
						</div>
						<div class="toggle faq pb-3 mb-4 faq-jasa faq-jaringan faq-telsus faq-nomor faq-lainnya">
							<div class="toggle-header">
								<div class="toggle-icon color">
									<i class="toggle-closed icon-question-sign"></i>
									<i class="toggle-open icon-question-sign"></i>
								</div>
								<div class="toggle-title fw-semibold ps-1">
									Bagaimana alur perizinan penyelenggaraan telekomunikasi?
								</div>
								<div class="toggle-icon color">
									<i class="toggle-closed icon-chevron-down text-black-50"></i>
									<i class="toggle-open icon-chevron-up color"></i>
								</div>
							</div>
							<div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
								adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
								excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
								enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
								Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
						</div>
						<div class="toggle faq pb-3 mb-4 faq-authors faq-jasa faq-jaringan faq-telsus faq-nomor faq-lainnya">
							<div class="toggle-header">
								<div class="toggle-icon color">
									<i class="toggle-closed icon-comments-alt"></i>
									<i class="toggle-open icon-comments-alt"></i>
								</div>
								<div class="toggle-title fw-semibold ps-1">
									Apakah pelaku usaha masih perlu melakukan tahapan di OSS RBA?
								</div>
								<div class="toggle-icon color">
									<i class="toggle-closed icon-chevron-down text-black-50"></i>
									<i class="toggle-open icon-chevron-up color"></i>
								</div>
							</div>
							<div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
								adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
								excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
								enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
								Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
						</div>
						<div class="toggle faq pb-3 mb-4 faq-authors faq-jasa faq-jaringan faq-telsus faq-nomor faq-lainnya">
							<div class="toggle-header">
								<div class="toggle-icon color">
									<i class="toggle-closed icon-comments-alt"></i>
									<i class="toggle-open icon-comments-alt"></i>
								</div>
								<div class="toggle-title fw-semibold ps-1">
									Apa yang perlu dilakukan calon penyelenggara untuk dapat mengajukan permohonan perizinan
									baru melalui E-Telekomunikasi?
								</div>
								<div class="toggle-icon color">
									<i class="toggle-closed icon-chevron-down text-black-50"></i>
									<i class="toggle-open icon-chevron-up color"></i>
								</div>
							</div>
							<div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
								adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
								excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
								enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
								Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
						</div>
						<div class="toggle faq pb-3 mb-4 faq-jasa">
							<div class="toggle-header">
								<div class="toggle-icon color">
									<i class="toggle-closed icon-lock3"></i>
									<i class="toggle-open icon-lock3"></i>
								</div>
								<div class="toggle-title fw-semibold ps-1">
									Bagaimana mengajukan perizinan Jasa?
								</div>
								<div class="toggle-icon color">
									<i class="toggle-closed icon-chevron-down text-black-50"></i>
									<i class="toggle-open icon-chevron-up color"></i>
								</div>
							</div>
							<div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
								adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
								excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
								enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
								Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
						</div>
						<div class="toggle faq pb-3 mb-4 faq-jasa">
							<div class="toggle-header">
								<div class="toggle-icon color">
									<i class="toggle-closed icon-download-alt"></i>
									<i class="toggle-open icon-download-alt"></i>
								</div>
								<div class="toggle-title fw-semibold ps-1">
									Bagaimana mengajukan perizinan Jasa Call Center?
								</div>
								<div class="toggle-icon color">
									<i class="toggle-closed icon-chevron-down text-black-50"></i>
									<i class="toggle-open icon-chevron-up color"></i>
								</div>
							</div>
							<div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
								adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
								excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
								enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
								Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
						</div>
						<div class="toggle faq pb-3 mb-4 faq-jaringan">
							<div class="toggle-header">
								<div class="toggle-icon color">
									<i class="toggle-closed icon-ok"></i>
									<i class="toggle-open icon-ok"></i>
								</div>
								<div class="toggle-title fw-semibold ps-1">
									Bagaimana mengajukan perizinan Jaringan Bergerak Satelit?
								</div>
								<div class="toggle-icon color">
									<i class="toggle-closed icon-chevron-down text-black-50"></i>
									<i class="toggle-open icon-chevron-up color"></i>
								</div>
							</div>
							<div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
								adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
								excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
								enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
								Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
						</div>
						<div class="toggle faq pb-3 mb-4 faq-jasa faq-nomor">
							<div class="toggle-header">
								<div class="toggle-icon color">
									<i class="toggle-closed icon-money"></i>
									<i class="toggle-open icon-money"></i>
								</div>
								<div class="toggle-title fw-semibold ps-1">
									Bagaimana mengajukan Penomoran untuk Call Center?
								</div>
								<div class="toggle-icon color">
									<i class="toggle-closed icon-chevron-down text-black-50"></i>
									<i class="toggle-open icon-chevron-up color"></i>
								</div>
							</div>
							<div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
								adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
								excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
								enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
								Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
						</div>
						<div class="toggle faq pb-3 mb-4  faq-lainnya">
							<div class="toggle-header">
								<div class="toggle-icon color">
									<i class="toggle-closed icon-picture"></i>
									<i class="toggle-open icon-picture"></i>
								</div>
								<div class="toggle-title fw-semibold ps-1">
									Apa itu proses verifikasi pendaftaran?
								</div>
								<div class="toggle-icon color">
									<i class="toggle-closed icon-chevron-down text-black-50"></i>
									<i class="toggle-open icon-chevron-up color"></i>
								</div>
							</div>
							<div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
								adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
								excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
								enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
								Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
						</div> --}}
						{{-- <div class="toggle faq pb-3 mb-4 faq-legal faq-authors faq-itemdiscussion">
                            <div class="toggle-header">
                                <div class="toggle-icon color">
                                    <i class="toggle-closed icon-file3"></i>
                                    <i class="toggle-open icon-file3"></i>
                                </div>
                                <div class="toggle-title fw-semibold ps-1">
                                    Can I use trademarked names in my items?
                                </div>
                                <div class="toggle-icon color">
                                    <i class="toggle-closed icon-chevron-down text-black-50"></i>
                                    <i class="toggle-open icon-chevron-up color"></i>
                                </div>
                            </div>
                            <div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
                                excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
                                enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
                                Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
                        </div>
                        <div class="toggle faq pb-3 mb-4 faq-affiliates">
                            <div class="toggle-header">
                                <div class="toggle-icon color">
                                    <i class="toggle-closed icon-bar-chart"></i>
                                    <i class="toggle-open icon-bar-chart"></i>
                                </div>
                                <div class="toggle-title fw-semibold ps-1">
                                    Tips for Increasing Your Referral Income
                                </div>
                                <div class="toggle-icon color">
                                    <i class="toggle-closed icon-chevron-down text-black-50"></i>
                                    <i class="toggle-open icon-chevron-up color"></i>
                                </div>
                            </div>
                            <div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
                                excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
                                enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
                                Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
                        </div>
                        <div class="toggle faq pb-3 mb-4 faq-authors faq-itemdiscussion">
                            <div class="toggle-header">
                                <div class="toggle-icon color">
                                    <i class="toggle-closed icon-phone3"></i>
                                    <i class="toggle-open icon-phone3"></i>
                                </div>
                                <div class="toggle-title fw-semibold ps-1">
                                    How can I get support for an item which isn't working correctly?
                                </div>
                                <div class="toggle-icon color">
                                    <i class="toggle-closed icon-chevron-down text-black-50"></i>
                                    <i class="toggle-open icon-chevron-up color"></i>
                                </div>
                            </div>
                            <div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
                                excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
                                enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
                                Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
                        </div>
                        <div class="toggle faq pb-3 mb-4 faq-marketplace faq-itemdiscussion">
                            <div class="toggle-header">
                                <div class="toggle-icon color">
                                    <i class="toggle-closed icon-credit"></i>
                                    <i class="toggle-open icon-credit"></i>
                                </div>
                                <div class="toggle-title fw-semibold ps-1">
                                    How do I pay for items on the Marketplaces?
                                </div>
                                <div class="toggle-icon color">
                                    <i class="toggle-closed icon-chevron-down text-black-50"></i>
                                    <i class="toggle-open icon-chevron-up color"></i>
                                </div>
                            </div>
                            <div class="toggle-content text-black-50 ps-4">Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum
                                excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus
                                enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis?
                                Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
                        </div> --}}
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
