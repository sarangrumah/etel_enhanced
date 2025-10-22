<?php

namespace App\View\Components;

use Illuminate\View\Component;

class pemenuhanpersyaratan extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $datajson;
    public function __construct($datajson)
    {
        //
        $this->datajson = $datajson;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pemenuhanpersyaratan');
    }
}
