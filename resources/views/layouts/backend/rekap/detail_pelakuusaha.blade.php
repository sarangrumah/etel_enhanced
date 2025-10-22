@extends('layouts.backend.main')
@section('js')
	<script src="{{ url('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ url('global_assets/js/demo_pages/form_layouts.js') }}"></script>
@endsection
@section('content')
	<form action="#">
		@csrf
		<div class="form-group">
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Detail Perusahaan/Instansi </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					{{-- {{$user->id}} --}}
					<x-be-register-pt :datapt="$user_pt" />
				</div>
			</div>
			<div class="card">
				<div class="card-header bg-indigo text-white header-elements-inline">
					<div class="row">
						<div class="col-lg">
							<h6 class="card-title font-weight-semibold py-3">Detail Registrasi Penanggung Jawab </h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<x-be-register-pj :datapj="$user" />
				</div>
			</div>
			{{-- <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Hasil Evaluasi </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <select class="form-control" name="is_setuju" id="" required>
                        <option disabled selected>Silakan Pilih..</option>
                        <option value="1">Setuju</option>
                        <option value="2">Tolak</option>
                    </select>
                </div>
            </div> --}}
			{{-- <div class="card">
                <div class="card-header bg-indigo text-white header-elements-inline">
                    <div class="row">
                        <div class="col-lg">
                            <h6 class="card-title font-weight-semibold py-3">Catatan Hasil Evaluasi </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <textarea id="catatan_evaluasi" name="catatan_evaluasi" rows="3" cols="3" class="form-control"
                        placeholder="Hasil Evaluasi"></textarea>
                </div>
            </div> --}}
			<div class="form-group text-right">
				{{-- <button type="submit" class="btn btn-light">Kembali <i class="icon-backward2 ml-2"></i></button> --}}
				<a href="{{ URL::previous() }}" class="btn btn-secondary border-transparent"><i class="icon-backward2 ml-2"></i>
					Kembali </a>
				{{-- <button type="submit" class="btn btn-primary">Kirim Evaluasi Pendaftaran <i
                        class="icon-paperplane ml-2"></i></button> --}}
			</div>
		</div>
	</form>
@endsection
