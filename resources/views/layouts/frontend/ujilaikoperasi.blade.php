@extends('layouts.frontend.main')
<!-- @section('title', 'Uji Laik Operasi') -->
@section('js')
    <script src="global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script src="global_assets/js/plugins/pickers/daterangepicker.js"></script>
    <script src="global_assets/js/plugins/pickers/pickadate/picker.js"></script>
    <script src="global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script src="global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script src="global_assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script src="global_assets/js/plugins/notifications/jgrowl.min.js"></script>
    <script src="global_assets/js/demo_pages/picker_date.js"></script>
@endsection
@section('content')
    <!-- <x-perizinan /> -->
    <div class="card">
        <div class="card-header bg-indigo text-white header-elements-inline">
            <div class="row">
                <div class="col-lg">
                    <h6 class="card-title font-weight-semibold py-3">Pengajuan Tanggal Uji Laik Operasi</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="#">
                <div class="row">
                    <div class="col-lg-12">
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Tanggal Uji Laik Operasi</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar52"></i></span>
                                        </span>
                                        <input type="text" class="form-control pickadate-disable rounded-right"
                                            placeholder="Pilih Tanggal">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Metode Uji Laik Operasi</label>
                                <label class="col-lg-8 col-form-label">Metode Uji Laik Operasi</label>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <!--begin::Text-->
                                    <div class="fw-bold text-dark-600 text-dark my-4 text-sm">
                                        <p>
                                            Saya menyatakan adalah benar merupakan pegawai/karyawan/pemilik/pemegang kuasa
                                            pengurusan izin dari lembaga/institusi/perusahaan ini, yang untuk selanjutnya
                                            bertindak atas nama lembaga/institusi/perusahaan sebagai Pemohon Izin
                                            Penyelenggaraan Telekomunikasi Layanan Uji Laik Operasi (ULO).
                                        </p>
                                        <p>
                                            Dalam rangka mewujudkan Zona Integritas menuju Wilayah Bebas dari Korupsi (WBK)
                                            di
                                            Direktorat Telekomunikasi, dengan ini saya menyatakan bersedia untuk:
                                        </p>
                                        <ol>
                                            <li>Tidak melakukan komunikasi dan perbuatan yang mengarah kepada kolusi,
                                                korupsi
                                                dan nepotisme (KKN);</li>
                                            <li>Akan melaporkan kepada pihak yang berwajib/berwenang apabila mengetahui ada
                                                indikasi korupsi, kolusi dan nepotisme (KKN);</li>
                                            <li>Tidak menjanjikan dan/atau memberikan dan/atau akan memberikan kepada
                                                petugas/pejabat Layanan Uji Laik Operasi, segala bentuk
                                                pemberian/gratifikasi
                                                atas Layanan Uji Laik Operasi yang dimohonkan kepada Direktorat
                                                Telekomunikasi;
                                                dan</li>
                                            <li>Mematuhi Standar Operasional Prosedur (SOP) yang berlaku dalam pengurusan
                                                Layanan Uji Laik Operasi.</li>
                                        </ol>
                                        <p>Apabila saya melanggar hal-hal yang telah saya nyatakan dalam PAKTA INTEGRITAS
                                            ini,
                                            Saya atas nama pribadi, lembaga/ institusi/ perusahaan bersedia untuk diproses
                                            berdasarkan ketentuan peraturan perundang-undangan yang berlaku.</p>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" checked>
                                        <span class="custom-control-label">PAKTA INTEGRITAS ini dibuat tanpa adanya paksaan
                                            dari pihak lain untuk dapat
                                            dipergunakan sebagaimana mestinya.</span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('/') }}" class="btn btn-secondary border-transparent"><i
                            class="icon-backward2 ml-2"></i> Kembali </a>
                    <button type="submit" class="btn btn-primary">Kirim Permohonan <i
                            class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
