@extends('layouts.backend.main')

@section('title', 'User Activities')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">User Activities</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Activity Log</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.user-activities.index') }}" class="form-inline mb-4">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by user or activity" value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary ml-2">Search</button>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Activity</th>
                            <th>IP Address</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $activity)
                            <tr>
                                <td>{{ $activity->user->name ?? 'N/A' }}</td>
                                <td>{{ $activity->activity }}</td>
                                <td>{{ $activity->ip_address }}</td>
                                <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No activities found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
