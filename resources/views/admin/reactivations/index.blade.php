@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Reactivation Requests</h1>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Request Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->user->email }}</td>
                    <td>{{ $request->created_at->format('Y-m-d') }}</td>
                    <td>
                        <form action="{{ route('admin.reactivations.approve', $request) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form action="{{ route('admin.reactivations.reject', $request) }}" method="POST" style="display:inline;">
                            @csrf
                            <textarea name="notes" placeholder="Rejection reason"></textarea>
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
