<?php
namespace App\Http\Controllers\Masters;

use App\Http\Controllers\BaseController;
use App\Models\Person;
use App\Form\PersonForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lib\Upload;

class PersonController extends BaseController {
	protected $_baseUrl = 'person';
	protected $_title = 'Person';
	protected $_model = Person::class;

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
					[
						'name'=>'email',
						'title'=>'Email',
						'visible'=>true,
					],
					[
						'name'=>'organization.name',
						'title'=>'Organization',
						'visible'=>true,
					],
					[
						'name'=>'status',
						'title'=>'Status',
						'visible'=>true,
						'transform'=>['Inactive', 'Active'],
					],
				],
				'bulks'=>[
					'active:0'=>'Deactive',
					'active:1'=>'Active'
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
		return PersonForm::class;
	}

	protected function validation() {
		return [
			'code'=>'required',
			'name'=>'required',
			'phone_no'=>'required',
			'avatar_image'=>'image|mimes:jpeg,png,jpg',
		];
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
		
		$upload = new Upload($request);
		if($request->hasFile('avatar_image')) {
			$file = $data['avatar_image'];
			$filename = 'avatar_image'.'.'.$file->getClientOriginalExtension();
			
			$upload->setParam('avatar_image');
			$uploadFile = $upload->process('person/'.$data['code'], $filename);
			$data['avatar_image'] = $uploadFile['image'];
		}

		if($this->_model::create($data)) {
			
			$request->session()->flash('status', 'Insert was successful!');
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

		$upload = new Upload($request);
		if($request->hasFile('avatar_image')) {
			$file = $data['avatar_image'];
			$filename = 'avatar_image'.'.'.$file->getClientOriginalExtension();
			
			$upload->setParam('avatar_image');
			$uploadFile = $upload->process('Person/'.$data['code'], $filename);
			$data['avatar_image'] = $uploadFile['image'];
		}

		$model = $this->_model::where('id',$id);
		$latestData = $model->first();
		if($model->update($data)) {
			$uploadClass = new Upload;
			$uploadClass->removeFile($latestData->avatar_image);
			
			$request->session()->flash('status', 'Update was successful!');
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