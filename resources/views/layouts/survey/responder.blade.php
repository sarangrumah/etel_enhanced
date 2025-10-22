@extends('layouts.survey.main')
@section('content')
    <style>
        .content-inner {
            background-color: linear-gradient(0deg, #FFFFFF 44.93%, #A5A5A5 100%);
            background-image: url("/global_assets/images/landing/landing_background.svg");
            background-repeat: no-repeat;
            background-size: contain;
        }

        .heading {
            background: #0147B0;
            border-radius: 16px 16px 0px 0px;
            padding: 18px 30px;
            color: #fff;
        }

        .body {
            padding: 30px 40px
        }
    </style>
    <div style="padding: 60px 0;">
        <div style="background-color: #ECECEC;border-radius: 15px">
            <div class="heading">
                <h1 class="title-informasi">Kelengkapan Identitas Responden</h1>
            </div>
            <div class="body">
                <form method="POST" action="{{ route('responder-submit') }}" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <fieldset class="mb-3">
                        {{-- <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Data diri responden
                </legend> --}}

                        <div class="form-group form-group-floating row">
                            <div class="col-lg-7">
                                <div class="row">
                                    <label class="col-form-label col-lg-3">Survei Penunjukkan Responden</label>
                                    <div class="col-lg-8">
                                        <div>
                                            <input type="file" name="file_uploaded"
                                                class="form-control form-control-outline" accept="application/pdf"
                                                id="custom-file-hidden">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="row">
                                    <label class="col-form-label col-lg-3">Nama Anda</label>
                                    <div class="col-lg-8">
                                        <div>
                                            <input type="text" name="responder_name"
                                                class="form-control form-control-outline" placeholder="Masukkan Nama Anda">
                                            {{-- <label class="label-floating">Masukkan Nama Anda</label> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row">
                                    <label class="col-form-label col-lg-3">Umur Anda</label>
                                    <div class="col-lg-4">
                                        <div>
                                            <input type="number" name="responder_age"
                                                class="form-control form-control-outline text-right"
                                                placeholder="Masukkan Umur Anda">
                                            {{-- <label class="label-floating">Masukkan Umur Anda</label> --}}
                                        </div>
                                    </div>
                                    <label class="col-form-label col-lg-1">Tahun</label>
                                </div>


                            </div>

                        </div>
                        <div class="form-group form-group-floating row">
                            <div class="col-lg-7">

                                <div class="row">
                                    <label class="col-form-label col-lg-3">Jenis Kelamin</label>

                                    <div class="col-lg-8">
                                        <div class="border px-3 pt-2 pb-2 rounded ">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_gender" value="1">
                                                        <span class="custom-control-label">Laki-Laki</span>
                                                    </label>
                                                </div>

                                                <div class="col-lg-6">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_gender" value="2">
                                                        <span class="custom-control-label">Perempuan</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-floating row">
                            <div class="col-lg-7">
                                <div class="row">
                                    <label class="col-form-label col-lg-3">Pendidikan Terakhir</label>
                                    <div class="col-lg-9">
                                        <div class="border px-3 pt-2 pb-2 rounded ">
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_education" value="1">
                                                        <span class="custom-control-label">SD</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_education" value="2">
                                                        <span class="custom-control-label">SMP</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_education" value="3">
                                                        <span class="custom-control-label">SMA</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_education" value="4">
                                                        <span class="custom-control-label">S1</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_education" value="5">
                                                        <span class="custom-control-label">S2</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_education" value="6">
                                                        <span class="custom-control-label">S3</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-floating row">
                            <div class="col-lg-7">
                                <div class="row">
                                    <label class="col-form-label col-lg-3">Pekerjaan</label>
                                    <div class="col-lg-9">
                                        <div class="border px-3 pt-3 pb-3 rounded ">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_occupation" value="1">
                                                        <span class="custom-control-label">PNS</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_occupation" value="2">
                                                        <span class="custom-control-label">TNI/POLRI</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_occupation" value="3">
                                                        <span class="custom-control-label">SWASTA</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_occupation" value="4">
                                                        <span class="custom-control-label">WIRAUSAHA</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="custom-control custom-control-secondary custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="id_tb_mst_occupation" value="5">
                                                        <span class="custom-control-label">Lainnya</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row">
                                    <label class="col-form-label col-lg-3">Lainnya</label>
                                    <div class="col-lg-5">
                                        <div>
                                            <input type="text" name="occupation_other"
                                                class="form-control form-control-outline" placeholder="Masukkan Pekerjaan Anda">
                                            {{-- <label class="label-floating">Masukkan Pekerjaan Anda</label> --}}
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        {{-- <div class="form-group form-group-floating row">
                            <div class="col-lg-7">
                                <div class="row">
                                    <label class="col-form-label col-lg-3">Perusahaan/Instansi</label>
                                    <div class="col-lg-8">
                                        <div class="position-relative">
                                            <input type="text" class="form-control form-control-outline"
                                                placeholder="Placeholder">
                                            <label class="label-floating">Masukkan Nama Perusahaan / Instansi
                                                Anda</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row">
                                    <label class="col-form-label col-lg-3">Jabatan</label>
                                    <div class="col-lg-8">
                                        <div class="position-relative">
                                            <input type="text" name="responder_jabatan"
                                                class="form-control form-control-outline" placeholder="Placeholder">
                                            <label class="label-floating">Masukkan Jabatan Anda</label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="form-group form-group-floating row">
                            <div class="col-lg-7">
                                <div class="row">
                                    <label class="col-form-label col-lg-3">Jenis layanan yang diterima</label>
                                    <div class="col-lg-6">
                                        <div class="border px-3 pt-2 pb-2 rounded ">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox mb-2">
                                                            <input type="checkbox" name="id_tb_mst_izinlayanan[]"
                                                                class="custom-control-input" id="cc_ls_jastel"
                                                                value="1">
                                                            <label class="custom-control-label" for="cc_ls_jastel">Izin
                                                                Penyelenggaraan Jasa
                                                                Telekomunikasi</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox mb-2">
                                                            <input type="checkbox" name="id_tb_mst_izinlayanan[]"
                                                                class="custom-control-input" id="cc_ls_jartel"
                                                                value="2">
                                                            <label class="custom-control-label" for="cc_ls_jartel">Izin
                                                                Penyelenggaraan
                                                                Jaringan Telekomunikasi</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox mb-2">
                                                            <input type="checkbox" name="id_tb_mst_izinlayanan[]"
                                                                class="custom-control-input" id="cc_ls_telsus"
                                                                value="3">
                                                            <label class="custom-control-label" for="cc_ls_telsus">Izin
                                                                Penyelenggaraan
                                                                Telekomunikasi Khusus</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </fieldset>


                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        {{-- <a href='{{ url('/survey/form', $id_survey) }}'" class="btn btn-primary">Submit --}}
                        {{-- <i class="icon-paperplane ml-2"></i></a> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
