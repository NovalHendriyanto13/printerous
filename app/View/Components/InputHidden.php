<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputHidden extends Component
{
    /**
     * name of input
     *
     * @var array
     */
    public $_attr;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $attr)
    {
        $this->_attr = $attr;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input-hidden',[
            'attr'=>$this->_attr,
        ]);
    }
}
