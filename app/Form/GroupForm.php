<?php
namespace App\Form;

use Lib\Form;
use App\View\Components\InputText;
use App\View\Components\InputSelect;

class GroupForm extends Form {
	
	protected function initialize($entity=null, array $options) {
		$mode = '';
		if (isset($options['mode']) && $options['mode'] == 'edit')
			$mode = 'edit';
		
		$name = new InputText([
			'name'=>'name',
			'class'=>'name',
			'type'=>'text',
			'required'=>true,
		]);
		$this->addCollection($name);

		$initial = new InputSelect([
			'name'=>'status',
			'class'=>'status',
			'options'=>[
				1=>'Active',
				0=>'In Active'
			],
		]);
		$this->addCollection($initial);

		parent::initialize($entity, $options);
	}
}