<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;


class fe_register_pj extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $oss;
    public function __construct($oss)
    {
        //
        $this->oss = $oss; 
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $instansi_nbh = DB::table('tb_oss_mst_jenisperseroan')->select('id','oss_kode',
        'name')->where('is_instansi',1)->where('is_active', 1)->get();
        $instansi_npt = DB::table('tb_oss_mst_jenisperseroan')->select('id','oss_kode',
        'name')->where('is_npt',1)->where('is_active', 1)->get();
        $instansi_bh= DB::table('tb_oss_mst_jenisperseroan')->select('id','oss_kode',
        'name')->where('is_badanhukum',1)->where('is_active', 1)->get();
        $provinsi = DB::table('tb_mst_provinsi')->select('id', 'name')->get();           
        return view('components.fe_register_pj', compact(['instansi_nbh','instansi_bh','instansi_npt','provinsi']));
    }
}