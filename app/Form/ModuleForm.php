<?php
namespace App\Form;

use Lib\Form;
use App\View\Components\InputText;

class ModuleForm extends Form {
	
	protected function initialize($entity=null, array $options) {
		$mode = '';
		if (isset($options['mode']) && $options['mode'] == 'edit')
			$mode = 'edit';
		
		$name = new InputText([
			'name'=>'name',
			'class'=>'text-name',
			'type'=>'text',
			'required'=>true,
		]);
		$this->addCollection($name);

		$action = new InputText([
			'name'=>'action',
			'class'=>'text-action',
			'type'=>'text',
		]);
		$this->addCollection($action);

		parent::initialize($entity, $options);
	}
}