<?php
namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\BaseController;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends BaseController {
	protected $_baseUrl = 'permission';
	protected $_title = 'Permission';
	protected $_model = Permission::class;

	protected function indexData() {
		return [
			'table'=>[
				'columns'=>[
					[
						'title'=>'Group',
						'name'=>'group.name',
						'visible'=>true
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

	protected function retrieveData(Request $request){
		return Permission::distinct('group_id')
			->get();
	}
	
}