<?php
namespace App\Http\Controllers\Masters;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Occupation;
use App\Form\OccupationForm;

use Illuminate\Support\Str;

class OccupationController extends BaseController {
	protected $_baseUrl = 'occupation';
	protected $_title = 'Occupation';
	protected $_model = Occupation::class;

	protected function indexData() {
		return [
			'table'=>[
				'columns'=>[
					[
						'name'=>'id',
						'title'=>'ID',
						'visible'=>false,
					],
					[
						'name'=>'code',
						'title'=>'Code',
						'visible'=>true,
					],
					[
						'name'=>'name',
						'title'=>'Name',
						'visible'=>true,
					],
				],
				'grid_actions'=>[
					[
						'icon'=>'edit',
						'class'=>'btn-primary',
						'title'=>'Update',
						'url'=>url($this->_baseUrl.'/update')
					],
				],
			],
			'action_buttons'=>[
				[
					'icon'=>'plus-circle',
					'class'=>'btn-primary',
					'title'=>'Add New',
					'url'=>url($this->_baseUrl.'/create'),
					'type'=>'link',
				],
			],
		];
	}

	protected function setForm() {
		return OccupationForm::class;
	}

	protected function validation() {
		return [
			'name'=>'required',
		];
	}

	protected function additionalParams(Request $request) {
		$data = $request->all();
		$return = [];
		if(!isset($data['code'])) {
			$return['code'] = Str::slug($data['name'],'-');
		}
		else {
			if (is_null($data['code'])) {
				$return['code'] = Str::slug($data['name'],'-');
			}
		}
		return $return;
	}
}