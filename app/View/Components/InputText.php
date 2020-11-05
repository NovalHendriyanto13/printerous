<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputText extends Component
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
        if(!isset($attr['readonly']))
            $attr['readonly'] = false;
        
        if(!isset($attr['disabled']))
            $attr['disabled'] = false;

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

        return view('components.input-text',[
            'attr'=>$this->_attr,
        ]);
    }
}
