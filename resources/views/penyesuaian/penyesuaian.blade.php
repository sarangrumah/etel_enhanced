@extends('layouts.frontend.main')
@section('title', 'Penyesuaian / Komitmen')
@section('js')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_extension_buttons_init.js"></script>

    <script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="/global_assets/js/kominfo/form_option_kominfo.js"></script>
    <script src="/global_assets/js/demo_pages/form_select2.js"></script>

@endsection
@section('content')
    <!-- Quick stats boxes -->
    @error('message')
        <div class="alert alert-danger alert-styled-left alert-dismissible">
            <span class="font-weight-semibold">{{ $message }}.</span>
        </div>
    @endError

    


    <div class="card">
        <div class="card-header bg-indigo text-white header-elements-inline">
            <div class="row">
                <div class="col-lg-12">
                    <h6 class="card-title font-weight-semibold py-3"> Penyesuaian Komitmen </h6>
                </div>
            </div>
        </div>
        @if (session('message'))
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="card-body">
				<div>
                    <form id="form-persyaratan" action="{{ url('/komitmen/penyesuaian', $id) }}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="id_izin" value="{{$izin['id_izin']}}">
                    <div class="form-group">
                        <label for="">Surat Pernyataan Penyesuaian Komitmen</label>
                        <input type="file" accept="application/pdf" class="form-control"
                        name="surat_pernyataan" required />
                    </div>
					@if( count($map_izin) > 0 )
                    @foreach($map_izin as $mi)
                            @if (Illuminate\Support\Str::is('roll_out_plan_jartup_fo_ter',
                                $mi->component_name))
                                <input type="hidden" name="id_maplist_roll_out_plan"
                                    value="{{ $mi->id_map_listpersyaratan }}">
                            @endif
                            @if (Illuminate\Support\Str::is('komitmen_kinerja_layanan_lima_tahun',
                                $mi->component_name))
                                <input type="hidden" name="id_komitmen_kinerja_layanan_lima_tahun"
                                    value="{{ $mi->id_map_listpersyaratan }}">
                            @endif
                            @if($mi->file_type == 'pdf')
                            @elseif($mi->file_type == 'table' && $mi->component_name != null)
                                @if(isset($mi->form_isian))
                                        @if ($mi->component_name == 'komitmen_kinerja_layanan_lima_tahun' || $mi->component_name == 'roll_out_plan_jartup_fo_ter' || $mi->component_name=='rencanausaha_v3')
                                            <p class="font-weight-bold">{!!$mi->persyaratan_html!!}</p>
                                                <x-dynamic-component :component="$mi->component_name" :triger="$triger ?? 'null'"
                                                :datajson="$mi->form_isian ?? 'kosong'" :needcorrection="$mi->need_correction ?? ''"
                                                :correctionnote="$mi->correction_note ?? ''" />
                                            <br/><br/>
                                            @php
                                                $datajson = 'kosong';
                                            @endphp
                                            <x-dynamic-component :triger="null" :component="$mi->component_name" :datajson="$datajson" :needcorrection="false" />
                                        @endif
                                @endif
                                <br/><br/>
                            @endif
						@endforeach
                    @endif
                    <br>
                    <button class="btn btn-success">Submit</button>
                    </form>
				</div>
			</div>
    </div>
@endsection

@section('custom-js')

@endsection
