
@extends('layouts.backend.main')
<!-- @section('title', 'Dashboard') -->
@section('content')
<!-- Quick stats boxes -->
<div class="row">
    
    <div class="col-lg">
	
	</div>    

	
</div>
<!-- /quick stats boxes -->	
<div>
    <!-- Latest orders -->
<div class="card">
    <div class="card-header d-flex py-0">
        <h6 class="card-title font-weight-semibold py-3">Users</h6>
    
        <div class="d-inline-flex align-items-center ml-auto">
            <div class="dropdown ml-2">
                <a href="{{route('admin.adduser')}}" class="dropdown-item"><i class="icon-user"></i> Tambah User</a>
                
            </div>
        </div>  
    </div>

    @if (session()->has('flash_notification.message'))
    <div class="container">
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    </div>
    @endif
    
    <div class="card-body">
        <div class="table-responsive border-top-0">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Username</th>
                        
                        <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users['data']) > 0)
                        @foreach ($users['data'] as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <a href="#" class="text-body font-weight-semibold">{{ $user['nama'] }}</a>
                                            
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $user['email'] }}</td>
                                
                                <td class="text-center">{{ $user['username'] }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-outline-light btn-icon btn-sm text-body border-transparent rounded-pill" data-toggle="dropdown">
                                            <i class="icon-menu7"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('admin.edituser',$user['id']) }}" class="dropdown-item"><i class="icon-pencil"></i> Ubah</a>
                                            @if(Auth::guard('admin')->user()->id != $user['id'])
                                                <a onclick="return false;" href="{{ route('admin.deleteuser',$user['id']) }}" class="dropdown-item deletebutton"><i class="icon-trash"></i> Hapus</a>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    

                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="text-right pagination-flat" style="float:right;">
    @if( $paginate != null && $paginate->count() > 0)
        {{ $paginate->links() }}
    @endif
</div>

<!-- /latest orders -->
</div>
<script>
    $(document).ready(function(){
        $('.deletebutton').click(function(){
            // console.log($(this).attr('href'));
            if (confirm('Apakah anda yakin akan menghapus user ini ?')) {
                location.href = $(this).attr('href');
            } else {
                return false;
            }
        })
    });  
</script>
@endsection