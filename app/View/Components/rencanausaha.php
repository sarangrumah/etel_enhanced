<?php

namespace App\View\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;


class rencanausaha extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $datajson;
    public $needcorrection;
    public $penyesuaian;
    public $ulo;

    public function __construct($datajson, $needcorrection = false, $penyesuaian = false, $ulo = [])
    {
        //
        $this->datajson = $datajson;
        $this->needcorrection = $needcorrection;
        $this->penyesuaian = $penyesuaian;
        $this->ulo = $ulo;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();

        return view('components.rencanausaha', compact('cities'));
    }
}
