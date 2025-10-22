<?php

namespace App\View\Components\jaringan;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class roll_out_plan_jartaplok_cs extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $datajson;
    public $needcorrection;

    public function __construct($datajson, $needcorrection = false)
    {
        //
        $this->datajson = $datajson;
        $this->needcorrection = $needcorrection;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        return view('components.jaringan.roll_out_plan_jartaplok_cs', compact('cities'));
    }
}