<?php
namespace App\Http\Controllers\Masters;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Tools\Variable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Account;
use App\Models\User;
use App\Models\Occupation;
use App\Models\Group;

use App\Form\AccountForm;

class AccountController extends BaseController {
	protected $_baseUrl = 'account';
	protected $_title = 'Account';
	protected $_model = Account::class;

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
						'name'=>'account_code',
						'title'=>'Code',
						'visible'=>true,
					],
					[
						'name'=>'name',
						'title'=>'Name',
						'visible'=>true,
					],
					[
						'name'=>'occupation.name',
						'title'=>'name',
						'visible'=>true,
					],
					[
						'name'=>'status',
						'title'=>'Status',
						'visible'=>true,
						'transform'=>['InActive', 'Active'],
					],
				],
				'bulks'=>[
					'active:0'=>'Inactive',
					'active:1'=>'Active',
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
		return AccountForm::class;
	}

	protected function bulkActions(Request $request) {
		$req = $request->all();
		$data = json_decode($req['data']);

		list($action, $value) = explode(':',$req['action']);
		switch($action) {
			case 'active':
				foreach($data as $id) {
					$update = $this->_model::where('id',$id)->update(['status'=>$value]);
				}
			break;
		}
	}

	protected function validation() {
		return [
			'name'=>'required',
			'occupation_id'=>'required',
			'account_code'=>'required',
			'email'=>'required',
		];
	}

	public function createAction(Request $request) {
		$data = $request->all();

		// validation
		$validate = Validator::make($data, $this->validation());
		if ($validate->fails()) {
			return response()->json([
				'status'=>false,
				'data'=>[],
				'errors'=>[
					'messages'=>$validate->messages()->getMessages(),
				],
				'redirect'=>false,
			]);
		}

		if($create = $this->_model::create($data)) {
			$request->session()->flash('status', 'Update was successful!');
			// save to user
			$occupation = Occupation::where('id', $data['occupation_id'])->first();
			if ($occupation->code == 'account-manager') {
				// group
				$group = Group::where('name','account_manager')->first();

				$user = User::where('account_id', $create->id)->first();
				$dataUser = [
					'name'=>$data['name'],
					'username'=>$data['email'],
					'password'=>Hash::make($data['email']),
					'email'=>$data['email'],
					'account_id'=>$create->id,
					'group_id'=>$group->id
				];
				if ($user) {
					$updateUser = User::where('id',$user->id)->update($dataUser);
				}
				else {
					$addUser = User::create($dataUser);					
				}
			}
			return response()->json([
				'status'=>true,
				'data'=>$data,
				'errors'=>null,
				'redirect'=>[
					'page'=>$this->_baseUrl
				],
			]);
		}
		
		return response()->json([
			'status'=>false,
			'data'=>[],
			'errors'=>[
				'messages'=>'Invalid Input',
			],
			'redirect'=>false,
		]);
	}

	public function updateAction(Request $request, $id) {
		$data = $request->all();

		// validation
		$validate = Validator::make($data, $this->validation());
		if ($validate->fails()) {
			return response()->json([
				'status'=>false,
				'data'=>[],
				'errors'=>[
					'messages'=>$validate->messages()->getMessages(),
				],
				'redirect'=>false,
			]);
		}

		if($update = $this->_model::where('id',$id)->update($data)) {
			$request->session()->flash('status', 'Update was successful!');
			// save to user
			$occupation = Occupation::where('id', $data['occupation_id'])->first();
			if ($occupation->code == 'account-manager') {
				// group
				$group = Group::where('name','account_manager')->first();

				$user = User::where('account_id', $id)->first();
				$dataUser = [
					'name'=>$data['name'],
					'username'=>$data['email'],
					'password'=>Hash::make($data['email']),
					'email'=>$data['email'],
					'account_id'=>$id,
					'group_id'=>$group->id
				];
				if ($user) {
					$updateUser = User::where('id',$user->id)->update($dataUser);
				}
				else {
					$addUser = User::create($dataUser);					
				}
			}
			return response()->json([
				'status'=>true,
				'data'=>$data,
				'errors'=>null,
				'redirect'=>[
					'page'=>$this->_baseUrl
				],
			]);
		}
		
		return response()->json([
			'status'=>false,
			'data'=>[],
			'errors'=>[
				'messages'=>'Invalid Input',
			],
			'redirect'=>false,
		]);
	}
}