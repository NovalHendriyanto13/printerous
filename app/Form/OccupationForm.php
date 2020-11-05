<?php
namespace App\Form;

use Lib\Form;
use App\View\Components\InputText;
use App\View\Components\InputSelect;
use App\Models\Occupation;

class OccupationForm extends Form {
	
	protected function initialize($entity=null, array $options) {
		$mode = '';
		if (isset($options['mode']) && $options['mode'] == 'edit')
			$mode = 'edit';

		if ($mode == 'edit') {
			$code = new InputText([
				'name'=>'code',
				'class'=>'code',
				'type'=>'text',
				'readonly'=>true,
			]);
			$this->addCollection($code);
		}

		$name = new InputText([
			'name'=>'name',
			'class'=>'tes',
			'type'=>'text',
			'required'=>true,
		]);
		$this->addCollection($name);

		parent::initialize($entity, $options);
	}
}