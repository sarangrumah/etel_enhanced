@extends('layouts.survey.main')
@section('content')
<style>
  .content-inner{
    background-color: linear-gradient(0deg, #FFFFFF 44.93%, #A5A5A5 100%);
    background-image: url("/global_assets/images/landing/landing_background.svg");
    background-repeat: no-repeat;
    background-size: cover;
  }
</style>
<div style="padding: 60px 0 60px 0;">
    <div style="background-color: #001432;color:#fff;border-radius: 30px;padding: 40px 60px;z-index: 1;position: relative;">
        <div style="text-align: center;">
            <img src="/global_assets/images/landing/logo_alt.svg" alt="footer logo">
            <h1 style="font-weight: 700;font-size: 50px;line-height: 70px;margin-left:15px">Terima Kasih</h1>
            <h3 style="font-weight: 700;font-size: 30px;line-height: 70px;margin-left:15px">Telah Mengisi Survey Kepuasan Pelanggan IKM & IIPP</h3>
        </div>
    </div>
</div>
@endsection