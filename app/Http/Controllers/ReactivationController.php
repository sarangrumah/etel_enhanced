<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\ReactivationRequested;
use Illuminate\Support\Facades\Notification;

class ReactivationController extends Controller
{
    /**
     * Show the reactivation notice page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showNotice()
    {
        return view('auth.reactivation-notice');
    }

    /**
     * Handle the reactivation request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function requestReactivation(Request $request)
    {
        $user = Auth::user();

        // Create a new reactivation request
        \App\Models\ReactivationRequest::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('reactivation.notice')->with('status', 'Your reactivation request has been sent to the administrator.');
    }
}
