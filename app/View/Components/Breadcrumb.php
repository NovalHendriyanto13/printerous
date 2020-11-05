<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * mode
     *
     * @var string
     */
    public $mode;
    /**
     * Create a new component instance.
     *
     * @param String $mode
     * @return void
     */
    public function __construct($type='')
    {
        $this->mode = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
