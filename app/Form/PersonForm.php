<?php
namespace App\Form;

use Lib\Form;
use App\View\Components\InputText;
use App\View\Components\InputSelect;
use App\View\Components\TextArea;
use App\View\Components\InputImage;

use App\Models\Organization;

class PersonForm extends Form {
	
	protected function initialize($entity=null, array $options) {
		$mode = '';
		if (isset($options['mode']) && $options['mode'] == 'edit')
			$mode = 'edit';
		
		$code = new InputText([
			'name'=>'code',
			'class'=>'code',
			'type'=>'text',
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
		
		$organization = new InputSelect([
			'name'=>'organization_id',
			'class'=>'organization-id',
			'allowEmpty'=>true,
			'options'=>Organization::select('id','name')
				->where('status',1)
				->get()
		]);
		$this->addCollection($organization);
		
		$avatar = new InputImage([
			'name'=>'avatar_image',
			'class'=>'avatar-image',
		]);
		$this->addCollection($avatar);

		$email = new InputText([
			'name'=>'email',
			'class'=>'email',
			'type'=>'email',
		]);
		$this->addCollection($email);

		$phone = new InputText([
			'name'=>'phone_no',
			'class'=>'phone-no',
			'type'=>'text',
			'required'=>true,
		]);
		$this->addCollection($phone);

		parent::initialize($entity, $options);
	}
}