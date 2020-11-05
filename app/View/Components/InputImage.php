<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputImage extends Component
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
        $this->_attr = $attr;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if(!isset($this->_attr['value']) && isset($this->_attr['default']))
            $this->_attr['value'] = $this->_attr['default'];
        
        return view('components.input-image',[
            'attr'=>$this->_attr,
        ]);
    }
}
