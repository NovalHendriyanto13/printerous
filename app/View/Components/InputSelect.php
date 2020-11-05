<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputSelect extends Component
{
    /**
     * Attributes 
     *
     * @var array
     */
    public $_attr;

    private $_options = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Array $attr)
    {
        if (array_key_exists('options', $attr))
            $this->_options = $attr['options'];

        if (!array_key_exists('allowEmpty', $attr))
            $attr['allowEmpty'] = false;
        
        if(!isset($attr['disabled']))
            $attr['disabled'] = false;

        $attr['options'] = $this->getData();
        $this->_attr = $attr;
    }

    private function getData() {
        if(is_object($this->_options)){
            $options = [];
            foreach($this->_options as $option) {
                $options[$option->id] = $option->name;
            }
            return $options;
        }
        return $this->_options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input-select',[
            'attr'=>$this->_attr
        ]);
    }

}
