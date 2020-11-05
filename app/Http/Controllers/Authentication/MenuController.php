<?php
namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\BaseController;
use App\Models\Menu;
use App\Models\Module;
use App\Form\MenuForm;
use Illuminate\Http\Request;

class MenuController extends BaseController {
	protected $_baseUrl = 'menu';
	protected $_title = 'Menu';
	protected $_model = Menu::class;

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
						'name'=>'name',
						'title'=>'Name',
						'visible'=>true,
					],
					[
						'name'=>'parent.name',
						'title'=>'Parent Menu',
						'visible'=>true,
					],
					[
						'name'=>'module.name',
						'title'=>'Module',
						'visible'=>true,
					],
					[
						'name'=>'action',
						'title'=>'Action',
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
		return MenuForm::class;
	}

	protected function additionalParams(Request $request) {
		$moduleName = $request->input('module');
		$action = $request->input('action');
		
		if($moduleName !='' && $action != '') {
			$checkModule = Module::where('name', $moduleName)
				->where('action', $action)
				->first();

			if (is_null($checkModule)) {
				return [
					'errors'=>["Module and action is not exists"]
				];
			}
			
			return [
				'module_id'=>$checkModule->id,
			];
		}
		return [];
	}

	protected function unsetParam() {
		return ['module'];
	}
}