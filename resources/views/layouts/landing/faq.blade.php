@extends('layouts.landing.main')
@section('content')
<style>
    .content-inner{
        background-color: linear-gradient(0deg, #FFFFFF 44.93%, #A5A5A5 100%);
        background-image: url("/global_assets/images/landing/landing_background.svg");
        background-repeat: no-repeat;
        background-size: contain;
    }
    .card {
      flex-direction: row!important;
      background: none;
      border: none;
    }
    .card-header{
      padding: 8px;
      border-radius: 8px!important;
    }
</style>
<div style="padding: 60px 0;">
    <div class="search-bar">
        <div class="input-group input-group-lg col-4">
            <input type="text" class="form-control" id="searcher" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Pencarian">
            <div class="input-group-append">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
            </div>
        </div>
    </div>
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
    <h1 class="title-informasi">{{ $title }}</h1>
    <div class="accordion" id="accordionExample">
      @foreach ($content as $item)
      <div class="card d-flex justify-content-between">
        <div class="card-header informasi col-3">
          <h2 class="">
            <button class="btn btn-link btn-block text-left" type="button">
              {{$item}}
            </button>
          </h2>
        </div>
        <div class="card-header informasi col-8">
          <h2 class="">
            <button class="btn btn-link btn-block text-left" type="button">
            </button>
          </h2>
        </div>
      </div>
      @endforeach
    </div>
    </div>
</div>
<script>
$(document).ready(function(){
  $("#searcher").on("keypress click input", function () {
      var val = $(this).val();
      if(val.length) {
          $(".accordion .card").hide().filter(function () {
              return $('.btn-block', this).text().toLowerCase().indexOf(val.toLowerCase()) > -1;
          }).show();
      }
      else {
          $(".accordion .card").show();
      }
  });
});
</script>
@endsection