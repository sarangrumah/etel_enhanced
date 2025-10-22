<?php

namespace App\Http\Controllers;

use App\Models\JenisPenomoran;
use Illuminate\Http\Request;

class JenisPenomoranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $lsjnslayanan = JenisPenomoran::select('kode_izin', 'name', 'nama_layanan')
        //     ->groupBy('kode_izin', 'name', 'nama_layanan')
        //     ->get();
        // $data = [
        //     'lsjnslayanan' => $lsjnslayanan,
        //     'lspermohonan' => $lsjnslayanan
        // ];
        // $lspermohonan = nu
        // return ($data); 
        // $data = null;
        // $data = JenisPenomoran::
        return view('layouts.frontend.penomoran.main_penomoran', $data);
        // return view('layouts.frontend.penomoran.main-penomor, $data);
    }

    public function jnsnomor($jenisnomor_id)
    {
        // $ambilnomors['datano'] = DB::select("CALL p_cekavail_nomor(" . $jenisnomor_id . ")");
        // return response()->json($ambilnomors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisPenomoran  $jenisPenomoran
     * @return \Illuminate\Http\Response
     */
    public function show(JenisPenomoran $jenisPenomoran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisPenomoran  $jenisPenomoran
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisPenomoran $jenisPenomoran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JenisPenomoran  $jenisPenomoran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JenisPenomoran $jenisPenomoran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisPenomoran  $jenisPenomoran
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisPenomoran $jenisPenomoran)
    {
        //
    }
}
