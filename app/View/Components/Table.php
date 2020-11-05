<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Model
     *
     * @var object
     */
    public $model;
    /**
     * Setting
     *
     * @var array
     */
    public $setting;

    private $exception = ['created_at','created_by','modified_at','modified_by'];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $setting=[])
    {
        if(!array_key_exists('bulks', $setting))
            $setting['bulks'] = [];  

        $this->model = $model;
        $this->setting = $setting;
    }

    private function getSetting() {
        if (count($this->setting) > 0) {
            return $this->setting;
        }
        $data = count($this->model) > 0 ? $this->model[0]->toArray() : [];
        $setting = [];
        foreach($data as $k=>$v) {
            if(!in_array($k,$this->exception)) {
                $setting[] = [
                    'name'=>$k,
                    'title'=>\Str::title($k),
                    'visible'=>$k=='id'?false:true,
                ];
            }
        }
        
        $this->setting['columns'] = $setting;
        return $this->setting;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.table',[
            'setting'=>$this->getSetting(),
            'data'=>$this->model,
        ]);
    }
}
