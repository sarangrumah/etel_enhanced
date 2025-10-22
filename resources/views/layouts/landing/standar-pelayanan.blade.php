@extends('layouts.landing.main')
@section('content')
<style>
    .content-inner{
        background-color: linear-gradient(0deg, #FFFFFF 44.93%, #A5A5A5 100%);
        background-image: url("/global_assets/images/landing/landing_background.svg");
        background-repeat: no-repeat;
        background-size: contain;
    }
</style>
<div style="padding: 60px 0;">
    <div style="background-color: #ECECEC; padding: 30px 40px; border-radius: 15px">
    <div class="header-elements-lg-inline">
        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            <div class="breadcrumb">
                <h4><a href="{{ url('/') }}" class="breadcrumb-item">
                        <i class="icon-home4 mr-2"></i> 
                        <span class="font-weight-semibold">BERANDA</span>
                    </a>
                    <span class="breadcrumb-item active">INFORMASI</span>
                    <span class="breadcrumb-item active">{{ $title }}</span>
                </h4>
            </div>
        </div>
    </div>
    <h1 style="font-weight: 600;font-size: 25px;line-height: 40px;text-align: center;">Maklumat Pelayanan<br>Perizinan Telekomunikasi</h1>
    <br><br>
    <p style="font-weight: 400;font-size: 20px;line-height: 40px;">Dengan ini, Direktorat Telekomunikasi menyatakan:</p>
    <ol style="font-weight: 400;font-size: 20px;line-height: 30px;">
      <li>Sanggup menyelenggarakan pelayanan perizinan telekomunikasi sesuai standar pelayanan.</li>
      <li>Memberikan pelayanan sesuai dengan kewajiban dan akan melakukan perbaikan secara terus menerus.</li>
      <li>Bersedia menerima sanksi, dan/atau memberikan kompensasi apabila pelayanan yang diberikan tidak sesuai standar.</li>
    </ol>
    <p style="text-align: right;font-weight: 400;font-size: 20px;line-height: 23px;">
      Jakarta, 24 Maret 2022
      <br><br><br>
      Direktur Telekomunikasi
      <br><br>
      ttd
      <br><br>
      Aju Widya Sari
    </p>
    <br><br><br><br>
    <a href="/document/standar-pelayanan.docx" class="btn btn-primary btn-lg" style="width: 100%;padding: 18px;">Download Standar Pelayanan</a>
    </div>
</div>
@endsection