<?php

namespace App\View\Components;

use Illuminate\View\Component;

class daftar_perangkat_mtd extends Component
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
        return view('components.daftar_perangkat_mtd');
    }
}
