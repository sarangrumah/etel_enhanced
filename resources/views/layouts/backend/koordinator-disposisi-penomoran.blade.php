@extends('layouts.backend.main')
@section('js')
    <script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>

    <script src="{{ url('global_assets/js/plugins/buttons/spin.min.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/buttons/ladda.min.js') }}"></script>

    <script src="{{ url('global_assets/js/demo_pages/components_buttons.js') }}"></script>
@endsection
@section('content')
    <div class="form-group">
        <x-be-detail-perusahaan />
        <x-be-detail-permohonan-penomoran />

        <div class="card">
            <div class="card-header bg-indigo text-white header-elements-inline">
                <div class="row">
                    <div class="col-lg">
                        <h6 class="card-title font-weight-semibold py-3">Catatan Disposisi </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="#">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <fieldset>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Disposisi ke : </label>
                                    <div class="col-lg">
                                        <select data-placeholder="Select your state"
                                            class="form-control form-control-select2" data-fouc>
                                            <option></option>
                                            <option value="AK">Alaska</option>
                                            <option value="HI">Hawaii</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <textarea rows="3" cols="3" class="form-control" placeholder="Catatan Disposisi"></textarea>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="text-right">
                        {{-- <button type="button" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i> Kembali </button> --}}
                        <a href="{{ URL::previous() }}" class="btn btn-secondary border-transparent"><i
                                class="icon-backward2 ml-2"></i> Kembali </a>
                        <button type="button" class="btn btn-info">Riwayat Permohonan <i
                                class="icon-history ml-2"></i></button>
                        <button type="submit" class="btn btn-indigo">Kirim Disposisi <i
                                class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
