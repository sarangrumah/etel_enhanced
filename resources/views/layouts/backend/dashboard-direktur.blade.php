@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
<!-- Quick stats boxes -->
<div class="row">
    <div class="col-lg">
        <!-- Members online -->
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Penetapan Penomoran</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
        <!-- /members online -->
    </div>

    <div class="col-lg">
        <!-- Members online -->
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Penetapan Perizinan</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
        <!-- /members online -->
    </div>
    <div class="col-lg">
        <!-- Members online -->
        <div class="card bg-pink text-white">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">10</h3>
                    <a href="#" class="badge badge-dark badge-pill align-self-center ml-auto">baru</a>
                </div>

                <div>
                    Permohonan
                    <div class="font-size-sm opacity-75">Pencabutan Surat Penetapan</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
        <!-- /members online -->
    </div>
</div>
<!-- /quick stats boxes -->
<x-be-list-perizinan />
@endsection