<?php
namespace App\Form;

use Lib\Form;
use App\View\Components\InputText;
use App\View\Components\InputSelect;
use App\View\Components\TextArea;
use App\View\Components\InputImage;

use App\Models\Account;
use App\Models\BaseTable;

class OrganizationForm extends Form {
	
	protected function initialize($entity=null, array $options) {
		$mode = '';
		if (isset($options['mode']) && $options['mode'] == 'edit')
			$mode = 'edit';
		
		if (isset($options['mode']) && $options['mode'] == 'assign')
			$mode = 'assign';
		
		$readOnly = $mode=='assign'?true:false;
		$code = new InputText([
			'name'=>'code',
			'class'=>'code',
			'type'=>'text',
			'required'=>true,
			'disabled'=>$readOnly,
		]);
		$this->addCollection($code);
		
		$name = new InputText([
			'name'=>'name',
			'class'=>'name',
			'type'=>'text',
			'required'=>true,
			'disabled'=>$readOnly,
		]);
		$this->addCollection($name);

		$account = new InputSelect([
			'name'=>'account_id',
			'class'=>'account_id',
			'allowEmpty'=>true,
			'required'=>true,
			'options'=>$this->getAccount(),
			'disabled'=>$readOnly,
		]);
		$this->addCollection($account);

		$zipcode = new InputText([
			'name'=>'zipcode',
			'class'=>'zipcode',
			'type'=>'text',
			'disabled'=>$readOnly,
		]);
		$this->addCollection($zipcode);

		$phone = new InputText([
			'name'=>'phone',
			'class'=>'phone',
			'type'=>'text',
			'required'=>true,
			'disabled'=>$readOnly,
		]);
		$this->addCollection($phone);

		$email = new InputText([
			'name'=>'email',
			'class'=>'email',
			'type'=>'email',
			'required'=>true,
			'disabled'=>$readOnly,
		]);
		$this->addCollection($email);

		$website = new InputText([
			'name'=>'website',
			'class'=>'website',
			'type'=>'text',
			'disabled'=>$readOnly,
		]);
		$this->addCollection($website);

		$logo = new InputImage([
			'name'=>'logo_image',
			'class'=>'logo-image',
			'disabled'=>$readOnly
		]);
		$this->addCollection($logo);

		$status = new InputSelect([
			'name'=>'status',
			'class'=>'status',
			'options'=>[
				1=>'Active',
				0=>'In Active'
			],
			'disabled'=>$readOnly
		]);
		$this->addCollection($status);

		$address = new TextArea([
			'name'=>'address',
			'class'=>'address',
			'disabled'=>$readOnly,
		]);
		$this->addCollection($address);

		parent::initialize($entity, $options);
	}

	private function getAccount() {
		$tbl = BaseTable::TBL_ACCOUNT;
		$accounts = Account::select($tbl.'.id',$tbl.'.name')
			->Join(BaseTable::TBL_OCCUPATION.' AS b', $tbl.'.occupation_id','=','b.id')
			->where('b.code','account-manager')
			->orderBy($tbl.'.name')
			->get();

		return $accounts;
	}
}