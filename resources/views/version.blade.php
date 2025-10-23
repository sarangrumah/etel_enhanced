@extends('layouts.frontend.main')

@section('content')
<div class="container">
    <h1>Version Information</h1>

    @foreach ($versions as $version)
        <h2>Version {{ $version->version }}</h2>
        <p><strong>Release Date:</strong> {{ $version->release_date }}</p>
        <div>
            {!! $version->notes !!}
        </div>
        <hr>
    @endforeach
</div>
@endsection
