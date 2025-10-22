@extends('layouts.backend.main')
@section('content')
<style>
  .content-inner{
    background-color: linear-gradient(0deg, #FFFFFF 44.93%, #A5A5A5 100%);
    background-image: url("/global_assets/images/landing/landing_background.svg");
    background-repeat: no-repeat;
    background-size: cover;
  }
  .inline .custom-radio{
    text-align: center;
  }
  .pertanyaan {
    margin-top: 8px;
    margin-bottom: 8px;
    width: 30%
  }
  .pertanyaan-terbuka:has(input) + div.pertanyaan {
    display: none;
  }

  .pertanyaan-terbuka:has(input:checked) + div.pertanyaan {
    display: block;
  }
</style>
<div style="padding: 60px 0 0 0;">
    <div style="background-color: #001432;color:#fff;border-radius: 30px;padding: 40px 60px;z-index: 1;position: relative;">
        <div style="display: flex;">
            <img src="/global_assets/images/landing/logo_alt.svg" alt="footer logo">
            <h1 style="font-weight: 700;font-size: 50px;line-height: 70px;margin-left:15px">Survey Kepuasan<br>Pelanggan IKM dan IPP</h1>
        </div>
        <p>Sistem Perizinan Telekomunikasi telah melayani berbagai permohonan untuk mendukung Perizinan Berusaha Berbasis Risiko yaitu Perizinan Jaringan Telekomunikasi, Jasa Telekomunikasi, Telekomunikasi Khusus, Penetapan Penomoran dan Uji Laik Operasi.</p>
    </div>
    <div style="width: 100vw;margin-left: calc(50% - 50vw);background: #E5E5E5;padding: 150px 140px;margin-top: -100px;min-height: 100vh;">
        <form class="form-horizontal" method="GET" action="{{ route('admin.responder.view-responder', [Request::segment(4), Request::segment(5),Request::segment(6) + 1]) }}">
        @csrf
        @foreach ($question as $q)
            @if ($loop->first)
                <h1>{{$q->survey_desc}}</h1>
                <br>
            @endif
            @if ($q['cat']==2)
            <div class="row">
                @if ($loop->first)
                <div class="col-6 offset-md-6 row">
                    <div class="col-3">
                        <h3 class="text-center">Sangat Penting</h3>
                    </div>
                    <div class="col-3">
                        <h3 class="text-center">Penting</h3>
                    </div>
                    <div class="col-3">
                        <h3 class="text-center">Tidak Penting</h3>
                    </div>
                    <div class="col-3">
                        <h3 class="text-center">Sangat Tidak Penting</h3>
                    </div>
                </div>
                @endif
                <div class="col-6">
                    <h3>{{ $loop->iteration }}. {{$q['question_name']}}</h3>
                </div>
                <div class="col-6 row inline">
                    <div class="col-3">
                        <label class="custom-control custom-radio">
                            <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="1" {{$q['survey_result']=='1'?"checked":''}}>
                            <span class="custom-control-label"></span>
                        </label>
                    </div>
                    <div class="col-3">
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="2" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label"></span>
                    </label>
                    </div>
                    <div class="col-3">
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="3" {{$q['survey_result']=='3'?"checked":''}}>
                        <span class="custom-control-label"></span>
                    </label>
                    </div>
                    <div class="col-3">
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="4" {{$q['survey_result']=='4'?"checked":''}}>
                        <span class="custom-control-label"></span>
                    </label>
                    </div>
                </div>
            </div>
            @elseif($q['cat']==4)
                <h3>{{ $loop->iteration }}. {{$q['question_name']}}</h3>
                {{-- @if($q['id_tb_mst_question_type']==1 || $q['id_tb_mst_question_type']==2) --}}
                    <div class="pertanyaan-terbuka">
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="1" {{$q['survey_result']=='1'?"checked":''}}>
                        <span class="custom-control-label">PERSYARATAN</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="2" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">PROSEDUR</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="3" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">WAKTU PENYELESAIAN</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="4" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">BIAYA/TARIF</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="5" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">PRODUK SPESIFIKASI JENIS PELAYANAN</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="6" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">KOMPETENSI PELAKSANA</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="7" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">PERILAKU PELAKSANA</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="8" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">PENANGANAN PENGADUAN, SARAN DAN MASUKAN</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="9" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">SARANA DAN PRASARANA</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="10" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">UMUM</span>
                    </label>
                    </div>
                    <div class="pertanyaan">
                        <textarea name="pertanyaan[{{$q['id_map']}}]" disabled class="form-control" placeholder="Note">{{$q['survey_answer']}}</textarea>
                    </div>
                {{-- @endif --}}
            @else
                <h3>{{ $loop->iteration }}. {{$q['question_name']}}</h3>
                @if($q['id_tb_mst_question_type']==1 || $q['id_tb_mst_question_type']==2)
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="1" {{$q['survey_result']=='1'?"checked":''}}>
                        <span class="custom-control-label">{{$q['question_text_1']}}</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="2" {{$q['survey_result']=='2'?"checked":''}}>
                        <span class="custom-control-label">{{$q['question_text_2']}}</span>
                    </label>
                    @if($q['id_tb_mst_question_type']==2)
                        <label class="custom-control custom-radio">
                            <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="3" {{$q['survey_result']=='3'?"checked":''}}>
                            <span class="custom-control-label">{{$q['question_text_3']}}</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input type="radio" disabled class="custom-control-input" name="q[{{$q['id_map']}}]" value="4" {{$q['survey_result']=='4'?"checked":''}}>
                            <span class="custom-control-label">{{$q['question_text_4']}}</span>
                        </label>
                    @endif
                    @else
                    <label class="custom-control">
                        <textarea class="form-control" disabled name="q[{{$q['id_map']}}]"></textarea>
                    </label>
                @endif
            @endif
            <br><br>
        @endforeach
        <div class="text-center">
            @if ($id_survey!=5)
                {{-- <a href='{{ url('/survey/form', $id_survey) }}'" class="btn btn-primary">Next</a>  --}}
                <button type="submit" class="btn btn-primary"> Next</button>
            @else
                {{-- <a href='{{ url('/survey/greet', $id_survey) }}'" class="btn btn-primary">Submit</a>  --}}
                <button type="submit" class="btn btn-primary"> Next</button>
            @endif
        </div>
        </form>
    </div>
</div>
@endsection