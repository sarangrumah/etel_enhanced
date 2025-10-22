@extends('layouts.landing.main')
@section('content')
    <style>
        .content-inner {
            background-color: linear-gradient(0deg, #FFFFFF 44.93%, #A5A5A5 100%);
            background-image: url("/global_assets/images/landing/landing_background.svg");
            background-repeat: no-repeat;
            background-size: contain;
        }
    </style>
    <div style="padding: 60px 0;">
        <div class="search-bar">
            <div class="input-group input-group-lg col-4">
                <input type="text" class="form-control" id="searcher" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-lg" placeholder="Pencarian">
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
                    <div class="card">
                        <div class="card-header informasi" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-order">A</button>
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                    data-target="#item{{ $loop->iteration }}" aria-expanded="true"
                                    aria-controls="{{ $loop->iteration }}">
                                    {{ $item }}
                                </button>
                            </h2>
                        </div>

                        <div id="item{{ $loop->iteration }}" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <b>61912 - Jasa Konten SMS Premium</b> <br />
                                Kelompok ini mencakup usaha jasa untuk menyediakan konten melalui jaringan bergerak seluler
                                yang pembebanan biayanya melalui pengurangan deposit prabayar atau tagihan telepon
                                pascabayar pelanggan jaringan bergerak seluler. Konten yang disediakan adalah semua bentuk
                                informasi yang dapat berupa tulisan, gambar, suara, animasi, atau kombinasi dari semuanya
                                dalam bentuk digital, termasuk software aplikasi untuk diunduh dan SMS premium.<br /><br />
                                <b>61911 - Jasa Panggilan Premium (Premium Call)</b><br />
                                Kelompok ini mencakup usaha jasa panggilan atau percakapan ke nomor tertentu yang mempunyai
                                awalan 0809, dan diberlakukan tarif premium. Sifat akses "Premium Call " adalah "normally
                                closed" yaitu dibuka apabila ada permintaan dari pelanggan.<br /><br />
                                <b>61923 - Jasa Televisi Protokol Internet (IPTV)</b><br />
                                Kelompok ini mencakup usaha jasa untuk menyediakan layanan konvergen radio dan televisi,
                                video, audio, teks, grafik dan data yang disalurkan melalui jaringan protokol internet yang
                                dijamin kualitas layanannya, keamanannya, kehandalannya, dan mampu memberikan layanan
                                komunikasi dengan pelanggan secara dua arah (interaktif).
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#searcher").on("keypress click input", function() {
                var val = $(this).val();
                if (val.length) {
                    $(".accordion .card").hide().filter(function() {
                        return $('.btn-block', this).text().toLowerCase().indexOf(val
                            .toLowerCase()) > -1;
                    }).show();
                } else {
                    $(".accordion .card").show();
                }
            });
        });
    </script>
@endsection
