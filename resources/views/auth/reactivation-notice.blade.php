@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Account Deactivated') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('Your account has been deactivated due to inactivity.') }}</p>
                    <p>{{ __('To reactivate your account, please submit a request to the administrator.') }}</p>

                    <form method="POST" action="{{ route('reactivation.request') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('Request Reactivation') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
