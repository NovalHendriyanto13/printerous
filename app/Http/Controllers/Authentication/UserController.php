<?php
namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Form\UserForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController {

	protected $_baseUrl = 'user';
	protected $_title = 'User';
	protected $_model = User::class;

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
						'name'=>'username',
						'title'=>'Username',
						'visible'=>true,
					],
					[
						'name'=>'email',
						'title'=>'Email',
						'visible'=>true,
					],
					[
						'name'=>'group.name',
						'title'=>'Group',
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

	protected function retrieveData(Request $request) {
		return $this->_model::where('group_id','<>','1')
			->where('status',1)
			->get();
	}

	protected function setForm() {
		return UserForm::class;
	}

	protected function additionalParams(Request $request) {
		return [
			'password' => Hash::make('otobid123')
		];
	}

	public function getName(Request $request) {
		$data = $request->all();
		$user = $this->_model::where('id',$data['value'])->first();
		if ($user) {
			return response()->json([
				'status'=>true,
				'data'=>[
					'value'=>$user->name,
				],
				'errors'=>null,
				'redirect'=>false,
			]); 
		}
		return response()->json([
			'status'=>false,
			'data'=>[],
			'errors'=>[
				'messages'=> 'No Users Found',
			],
			'redirect'=>false,
		]); 
	}
}