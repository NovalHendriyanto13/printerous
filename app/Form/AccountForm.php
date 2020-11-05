<?php
namespace App\Form;

use Lib\Form;
use App\View\Components\InputText;
use App\View\Components\InputSelect;
use App\View\Components\TextArea;

use App\Models\Occupation;
use App\Models\BaseTable;

class AccountForm extends Form {
	
	protected function initialize($entity=null, array $options) {
		$mode = '';
		if (isset($options['mode'])) {
			if ($options['mode'] == 'edit')
				$mode = 'edit';
			elseif ($options['mode'] == 'detail')
				$mode = 'detail';
		}
		
		$defaultCode = date('Ym').str_pad(rand(0,100000),6,"0",STR_PAD_LEFT);
		if ($mode == 'edit')
			$defaultCode = $entity->account_code;

		$code = new InputText([
			'name'=>'account_code',
			'class'=>'account-code',
			'type'=>'text',
			'readonly'=>true,
			'value'=>$defaultCode,
			'required'=>true,
		]);
		$this->addCollection($code);
		
		$name = new InputText([
			'name'=>'name',
			'class'=>'name',
			'type'=>'text',
			'required'=>true,
		]);
		$this->addCollection($name);

		$occupation = new InputSelect([
			'name'=>'occupation_id',
			'class'=>'occupation',
			'required'=>true,
			'allowEmpty'=>true,
			'options'=>Occupation::select('id','name')->get(),
		]);
		$this->addCollection($occupation);

		$email = new InputText([
			'name'=>'email',
			'class'=>'email',
			'type'=>'email',
			'required'=>true,
		]);
		$this->addCollection($email);

		$phone = new InputText([
			'name'=>'phone',
			'class'=>'phone',
			'type'=>'text',
		]);
		$this->addCollection($phone);

		$status = new InputSelect([
			'name'=>'status',
			'class'=>'status',
			'options'=>[
				1=>'Active',
				0=>'Inactive',
			],
		]);
		$this->addCollection($status);

		parent::initialize($entity, $options);
	}

}