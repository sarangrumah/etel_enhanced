@extends('layouts.frontend.main')
{{-- @extends('main') --}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h3 class="card-title">Kata Pengantar</h3>
                </div>

                <div class="card-body">
                    <p><b>Bapak / Ibu yang terhormat,</b></p><br />
                    <p>Dalam rangka meningkatkan kualitas pelayanan publik Direktorat Telekomunikasi (Ditjen PPI),
                        Kementerian
                        Komunikasi dan Informatika, </p><br />
                    <p>maka Direktorat Telekomunikasi mengadakan Survei Kepuasan
                        Masyarakat
                        untuk
                        mengetahui indeks kepuasan masyarakat dan Indeks Integritas Pelayanan Publik terhadap pelayanan yang
                        selama ini diberikan oleh unit layanan publik.</p><br />
                    <p>Kami berharap, semoga Bapak/Ibu memberikan jawaban
                        yang
                        objektif dalam mengisi kuesioner ini, agar hasil survei ini dapat mencerminkan kondisi pelayanan
                        yang
                        sebenarnya. </p><br />
                    <p>Dari hasil survei ini diharapkan pelayanan yang diberikan oleh Direktorat Telekomunikasi
                        (Ditjen PPI) akan lebih baik lagi di masa-masa yang akan datang.</p><br />
                    <p>Sedangkan dasar dalam pembuatan indikator berupa pernyataan-pernyataan di dalam kuesioner mengacu
                        pada
                        Peraturan Menpan RB Nomor 14 Tahun 2017 tentang pedoman survei kepuasan masyarakat unit
                        penyelenggara
                        pelayanan publik untuk mengukur kinerja (<i>perfomance</i>) dan harapan/tingkat kepentingan
                        (<i>importance</i>).


                    </p><br />

                    <p>Salam hormat Kami,</p>
                    <p><b>Direktorat Telekomunikasi (Ditjen PPI)</b></p>
                </div>
                <div class="card-footer bg-white">

                    <button type="button" data-toggle="modal" data-target="#petunjuk_pengisian"
                        class="btn btn-primary mt-3 mt-sm-0 w-100 w-sm-auto">Ikuti Survei <i
                            class="icon-paperplane ml-2"></i></button>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6 image">
            <div class="card">
                <img class="card-img-top img-fluid" src="/global_assets/images/landing/content.svg" alt="">
            </div>
        </div> --}}
    </div>


    <!-- Primary modal -->
    <div id="petunjuk_pengisian" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title font-weight-semibold">Petunjuk Pengisian</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-1">1. </div>
                        <div class="col-lg">
                            <p>Berilah tanda <b>√</b> atau tuliskan jawaban pada kolom jawaban yang telah disediakan
                                mengenai
                                pendapat
                                Bapak/Ibu tentang hal yang dinilai terkait dengan kondisi pelayanan Direktorat
                                Telekomunikasi,
                                Ditjen
                                PPI saat ini.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1">2. </div>
                        <div class="col-lg">
                            <p>Bagian <b>TINGKAT HARAPAN (<i>EXPECTATION</i>)</b> adalah harapan atau ekspektasi Bapak/Ibu
                                terhadap kualitas
                                pelayanan Direktorat Telekomunikasi, Ditjen PPI saat ini dan masa mendatang.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1">3. </div>
                        <div class="col-lg">
                            <p>Bagian <b>KINERJA (<i>PERFOMANCE</i>)</b> adalah fakta yang Bapak/Ibu alami dalam mengurus
                                layanan di Direktorat
                                Telekomunikasi, Ditjen PPI selama ini.</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup </button>
                    <button onclick="location.href='{{ url('/responder') }}'" type="button" class="btn btn-primary">Lanjut
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /primary modal -->
@endsection
