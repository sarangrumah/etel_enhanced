<?php

namespace App\View\Components;

use Illuminate\View\Component;

class be_register_pj extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $datapj;

    public function __construct($datapj)
    {
        $this->datapj = $datapj;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.be-register-pj');
    }
}
