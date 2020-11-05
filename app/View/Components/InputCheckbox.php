<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputCheckbox extends Component
{
    /**
     * Attributes 
     *
     * @var array
     */
    public $_attr;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Array $attr)
    {
        if(!isset($attr['options']))
            $attr['options'] = [];

        $this->_attr = $attr;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if(!isset($this->_attr['value']))
            $this->_attr['value'] = '';

        return view('components.input-checkbox',[
            'attr'=>$this->_attr,
        ]);
    }
}
