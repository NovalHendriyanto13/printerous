<?php
namespace App\Http\Controllers\Masters;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Organization;
use App\Models\Person;
use App\Form\OrganizationForm;
use Lib\Upload;

class OrganizationController extends BaseController {
	protected $_baseUrl = 'organization';
	protected $_title = 'Organization';
	protected $_model = Organization::class;

	private $_view = 'masters.organization';

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
						'name'=>'account.name',
						'title'=>'Account Manager',
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
						'name'=>'phone',
						'title'=>'Phone',
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
					[
						'icon'=>'edit',
						'class'=>'btn-primary',
						'title'=>'Assign',
						'url'=>url($this->_baseUrl.'/assign')
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
		$accountId = session('user')->account_id;
		if (!is_null($accountId)) {
			return $this->_model::where('account_id',$accountId)->get();
		}
		return $this->_model::get();
	}

	protected function setForm() {
		return OrganizationForm::class;
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
			'code'=>'required',
			'name'=>'required',
			'phone'=>'required',
			'email'=>'required',
			// 'account_id'=>'required',
			'logo_image'=>'image|mimes:jpeg,png,jpg',
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
		
		$upload = new Upload($request);
		if($request->hasFile('logo_image')) {
			$file = $data['logo_image'];
			$filename = 'logo_image'.'.'.$file->getClientOriginalExtension();
			
			$upload->setParam('logo_image');
			$uploadFile = $upload->process('organization/'.$data['code'], $filename);
			$data['logo_image'] = $uploadFile['image'];
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
		if($request->hasFile('logo_image')) {
			$file = $data['logo_image'];
			$filename = 'logo_image'.'.'.$file->getClientOriginalExtension();
			
			$upload->setParam('logo_image');
			$uploadFile = $upload->process('organization/'.$data['code'], $filename);
			$data['logo_image'] = $uploadFile['image'];
		}

		$model = $this->_model::where('id',$id);
		$latestData = $model->first();
		if($model->update($data)) {
			$uploadClass = new Upload;
			$uploadClass->removeFile($latestData->logo_image);
			
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
	public function assign(Request $request, $id) {
		$model = $this->_model::find($id);
		$form = $this->setForm();
		
		$req = $request->all();
		if (count($req) > 0) {
			$data = json_decode($req['data']);
			list($action, $value) = explode(':',$req['action']);
			switch($action) {
				case 'assign':
					foreach($data as $idPerson) {
						if ($value==1){
							$update = Person::where('id',$idPerson)->update(['organization_id'=>$id]);
						}
						else {
							$update = Person::where('id',$idPerson)->update(['organization_id'=>0]);
						}
					}
				break;
			}
			return response()->json([
				'status'=>true,
				'data'=>$request->all(),
				'errors'=>null,
				'redirect'=>[
					'page'=>$this->_baseUrl.'/assign/'.$id
				],
			]);
		}
		$data = [
			'id'=>$id,
			'form' => new $form($model, ['mode'=>'assign']),
			'person'=>[
				'model'=>Person::where(['organization_id'=>0, 'status'=>1])->get(),
				'setting'=>[
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
						],
						'bulks'=>[
							'assign:0'=>'Un Assign',
							'assign:1'=>'Assign',
						],
					]
				]
			]
		];

		return view($this->_view.'.assign')->with($data);
	}
}