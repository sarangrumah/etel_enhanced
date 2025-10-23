<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index()
    {
        $versions = \App\Models\Version::orderBy('release_date', 'desc')->get();
        return view('version', ['versions' => $versions]);
    }
}
