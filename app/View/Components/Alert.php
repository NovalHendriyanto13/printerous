<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * alert type.
     *
     * @var string
     */
    public $type = 'danger';
    /**
     * alert type.
     *
     * @var string
     */
    public $class;
    /**
     * alert type.
     *
     * @var string
     */
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(String $type='danger', $class='', $id='')
    {
        $this->type = $type;
        $this->class= $class;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
