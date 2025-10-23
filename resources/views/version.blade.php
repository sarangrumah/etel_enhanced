@extends('layouts.frontend.main')

@section('content')
<div class="container">
    <h1>Version Information</h1>
    <p>Current Version: {{ config('app.version') }}</p>

    <h2>Release Notes</h2>
    <ul>
        <li>Initial release.</li>
    </ul>
</div>
@endsection
