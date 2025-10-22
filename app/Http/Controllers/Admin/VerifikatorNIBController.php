<?php

namespace App\Http\Controllers\Admin;

class KoordinatorController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
        // $this->middleware('auth');
    }

    public function index(){
    $date_reformat = new DateHelper();

    }
}