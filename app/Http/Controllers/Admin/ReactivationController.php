<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReactivationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ReactivationController extends Controller
{
    public function index()
    {
        $requests = ReactivationRequest::where('status', 'pending')->with('user')->get();
        return view('admin.reactivations.index', compact('requests'));
    }

    public function approve(ReactivationRequest $reactivationRequest)
    {
        $reactivationRequest->update(['status' => 'approved']);
        $reactivationRequest->user->update(['status' => true]);

        $reactivationRequest->user->notify(new \App\Notifications\ReactivationStatusChanged($reactivationRequest));

        return redirect()->route('admin.reactivations.index')->with('success', 'User reactivated successfully.');
    }

    public function reject(Request $request, ReactivationRequest $reactivationRequest)
    {
        $reactivationRequest->update([
            'status' => 'rejected',
            'notes' => $request->notes,
        ]);

        $reactivationRequest->user->notify(new \App\Notifications\ReactivationStatusChanged($reactivationRequest));

        return redirect()->route('admin.reactivations.index')->with('success', 'Reactivation request rejected.');
    }
}
