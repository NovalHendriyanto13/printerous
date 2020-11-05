<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextArea extends Component
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
        return view('components.text-area',[
            'attributes'=>$this->_attr,
        ]);
    }
}
