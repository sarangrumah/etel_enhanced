@extends('layouts.landing.main')
@section('content')
<div class="landing">
    <div class="row d-flex justify-content-between">
        <div class="col">
            <h1 class="mt-5">Sistem Perizinan Telekomunikasi<br>(e-Telekomunikasi)</h1>
            <p class="mt-4">Sistem Perizinan Telekomunikasi melayani berbagai permohonan untuk mendukung Perizinan Berusaha Berbasis Risiko yaitu Perizinan Jaringan Telekomunikasi, Jasa Telekomunikasi, Telekomunikasi Khusus, Penetapan Penomoran dan Uji Laik Operasi.</p>
            <div class="mt-5 d-flex justify-content-end">
                {{-- <span class="btn info">More Info</span> --}}
            </div>
        </div>
        <div class="col image">
            <img src="/global_assets/images/landing/content.svg" alt="">
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
    <div class="col-3 mx-4 box">
        <a href="/pb/permohonan/telsus">
        <div class="thumbnail">
        <img src="/global_assets/images/landing/icon_khusus.svg" alt="Telekomunikasi Khusus">
        <div class="caption">
            <p>Telekomunikasi Khusus</p>
        </div>
        </div>
        </a>
    </div>
    <div class="col-3 mx-4 box">
        <a href="/pb/permohonan/jasa">
        <div class="thumbnail">
        <img src="/global_assets/images/landing/icon_jastel.svg" alt="Jasa Telekomunikasi">
        <div class="caption">
            <p>Jasa Telekomunikasi</p>
        </div>
        </div>
        </a>
    </div>
    <div class="col-3 mx-4 box">
        <a href="/pb/permohonan/jaringan">
        <div class="thumbnail">
        <img src="/global_assets/images/landing/icon_jartel.svg" alt="Jaringan Telekomunikasi">
        <div class="caption">
            <p>Jaringan Telekomunikasi</p>
        </div>
        </div>
        </a>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-3 mx-4 box">
        <a href="/">
        <div class="thumbnail">
        <img src="/global_assets/images/landing/icon_penomoran.svg" alt="Penomoran">
        <div class="caption">
            <p>Penomoran</p>
        </div>
        </div>
        </a>
    </div>
    <div class="col-3 mx-4 box">
        <a href="/">
        <div class="thumbnail">
        <img src="/global_assets/images/landing/icon_spectrum.svg" alt="Izin Spektrum Frekuensi">
        <div class="caption">
            <p>Izin Spektrum Frekuensi</p>
        </div>
        </div>
        </a>
    </div>
    <div class="col-3 mx-4 box">
        <a href="https://www.postel.go.id/artikel-hak-labuh-tata-cara-dan-persyaratan-70-2217" target="_blank">
        <div class="thumbnail">
        <img src="/global_assets/images/landing/icon_satelite.svg" alt="Hak Labuh Satelit">
        <div class="caption">
            <p>Hak Labuh Satelit</p>
        </div>
        </div>
        </a>
    </div>
</div>
<div class="row mx-1 d-flex justify-content-center">
    <div class="col-5 mr-3 box">
        <div class="thumbnail d-flex flex-row">
        <img src="/global_assets/images/landing/icon_konsul.svg" alt="Konsultasi Perizinan" width="75" height="75" class="p-2">
        <div class="caption p-2">
            <p>Konsultasi Perizinan</p>
        </div>
        </div>
    </div>
    <div class="col-5 ml-3 box">
        <div class="thumbnail d-flex flex-row">
        <img src="/global_assets/images/landing/icon_phone.svg" alt="Izin Spektrum Frekuensi" width="75" height="75" class="p-2">
        <div class="caption p-2">
            <p>Pengaduan Masyarakat</p>
        </div>
        </div>
    </div>
</div>

<div class="accordion attribute mx-4 mb-4 d-flex justify-content-center" id="accordionExample">
  <div class="card col-11">
    <div class="card-header" id="headingOne">
      <h2 class="d-flex">
        <img src="/global_assets/images/landing/icon_video.svg" alt="">
        <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#video" aria-expanded="true" aria-controls="collapseOne">
          Video
        </button>
      </h2>
    </div>

    <div id="video" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <div class="row d-flex justify-content-center">
            <div class="col">
                <img src="/global_assets/images/landing/content_video.svg" class="card-img-top" alt="...">
                <div>
                    <h5>Sosialisasi Sertifikat Perizinan Telekomunikasi KOMINFO</h5>
                </div>
            </div>
            <div class="col">
                <img src="/global_assets/images/landing/content_video.svg" class="card-img-top" alt="...">
                <div>
                    <h5>Sosialisasi Sertifikat Jasa Telekomunikasi Sistem Perizinan Telekomunikasi</h5>
                </div>
            </div>
            <div class="col">
                <img src="/global_assets/images/landing/content_video.svg" class="card-img-top" alt="...">
                <div>
                    <h5>Sosialisasi Sertifikat Jasa Telekomunikasi Sistem Perizinan Telekomunikasi</h5>
                </div>
            </div>
        </div>        
      </div>
    </div>
  </div>
</div>

<div class="accordion attribute mx-4 mb-4 d-flex justify-content-center" id="accordionExample">
  <div class="card col-11">
    <div class="card-header" id="headingOne">
      <h2 class="d-flex">
        <img src="/global_assets/images/landing/icon_tautan.svg" alt="">
        <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Tautan Terkait
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <div class="row d-flex justify-content-center">
            <a href="https://www.kominfo.go.id/" target="_blank" rel="noopener noreferrer">
                <div class="col"><img src="/global_assets/images/landing/logo_tautan_kominfo.svg" alt="Instagram"></div>
            </a>
            <a href="https://ditjenppi.kominfo.go.id/" target="_blank" rel="noopener noreferrer">
                <div class="col"><img src="/global_assets/images/landing/logo_tautan_djppi.svg" alt="Facebook"></div>
            </a>
            <a href="https://dittel.kominfo.go.id/" target="_blank" rel="noopener noreferrer">
                <div class="col"><img src="/global_assets/images/landing/logo_tautan_dittel.svg" alt="Twitter"></div>
            </a>
        </div>        
      </div>
    </div>
  </div>
</div>
@endsection