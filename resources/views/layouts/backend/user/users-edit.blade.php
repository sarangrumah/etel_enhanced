
@extends('layouts.backend.main')

@section('content')
<form action="#" method="post">
@csrf
<div class="form-group">
    

    <div class="card">
        <div class="card-header bg-indigo text-white header-elements-inline">
            <div class="row">
                <div class="col-lg">
                    <h6 class="card-title font-weight-semibold py-3">Edit User</h6>
                </div>
            </div>
        </div>
        
        <div class="card-body">         
            <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
            <script src="global_assets/js/demo_pages/form_layouts.js"></script>
            <div>
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>    
                            <strong>{{ $error }}</strong>
                        </div>
                    @endforeach
                @endif

                @if (session()->has('flash_notification.message'))
                <div class="">
                    <div class="alert alert-{{ session()->get('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session()->get('flash_notification.message') !!}
                    </div>
                </div>
                @endif

                <fieldset>
                    <div class="form-group">
                        <div class="col-lg">
                            <div class="row">
                                <div class="col-lg-6">
                                    <p class="font-weight-semibold">Nama</p>
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" value="{{$user['nama']}}">
                                </div>
                                
                                <div class="col-6">
                                    <p class="font-weight-semibold">Email</p>
                                    <input type="text" name="email" class="form-control" required placeholder="Email" value="{{$user['email']}}">
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-lg">
                            <div class="row">
                                <div class="col-6">
                                    <p class="font-weight-semibold">Job Position</p>
                                    <select name="jobposition" class="form-control">
                                        @foreach ($jobposition as $jobposition)
                                            <option value="{{$jobposition['id']}}" @if($user['id_mst_jobposition'] == $jobposition['id']) selected="selected" @endif >{{$jobposition['name']}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                
                                <div class="col-6">
                                    <p class="font-weight-semibold">Username</p>
                                    <input type="text" name="username" class="form-control" required placeholder="Username" value="{{$user['username']}}">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg">
                            <div class="row">
                                <div class="col-6">
                                    <p class="font-weight-semibold">Password</p>
                                    <input type="password" name="password" class="form-control"  placeholder="Password">
                                </div>
                                
                                <div class="col-6">
                                    <p class="font-weight-semibold">Konfirmasi Password</p>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                                </div>

                            </div>
                        </div>
                    </div>

                </fieldset>
            </div>
        </div>
    </div>
    
    <div class="form-group text-right">
        <a href="{{route('admin.user')}}" class="btn btn-light"><i class="icon-backward2 ml-2"></i> Kembali </a>
        <button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
    </div>
</div>
</form>



@endsection