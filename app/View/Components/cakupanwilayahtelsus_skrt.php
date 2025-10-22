<?php

namespace App\View\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;


class cakupanwilayahtelsus_skrt extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $datajson;
    public $needcorrection;
    public $correctionnote;
    public $triger;
    public function __construct($triger, $datajson, $needcorrection = null, $correctionnote = null)
    {
        //
        $this->datajson = $datajson;
        $this->triger = $triger;
        $this->needcorrection = $needcorrection;
        $this->correctionnote = $correctionnote;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();

        return view('components.cakupanwilayahtelsus_skrt', compact('cities'));
    }
}
