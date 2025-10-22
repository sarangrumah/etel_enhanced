<?php

namespace App\View\Components;

use Illuminate\View\Component;

class be_register_pt extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $datapt;
    public function __construct($datapt)
    {
        $this->datapt = $datapt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.be-register-pt');
    }
}
