<?php
namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\BaseController;
use App\Models\Module;
use App\Form\ModuleForm;
use Illuminate\Http\Request;

class ModuleController extends BaseController {
	protected $_baseUrl = 'module';
	protected $_title = 'Module';
	protected $_model = Module::class;

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
						'name'=>'initial',
						'title'=>'Initial',
						'visible'=>true,
					],
					[
						'name'=>'action',
						'title'=>'action',
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
		return ModuleForm::class;
	}
	public function createAction(Request $request) {
		$data = $request->all();
		unset($data['_token']);

		$actions = [
			'index','create','update','delete','detail'
		];

		$this->transactionBegin();
		try {
			$errors = [];
			if($data['action'] == '') {
				foreach($actions as $action) {
					$insertEachActions = $this->_model::firstOrCreate([
						'initial'=>strtolower($data['name']).'.'.$action,
						'name'=>ucfirst($data['name']),
						'action'=>$action
					]);
					if(!$insertEachActions)
						$errors[] = 'error on '.$action;
				}
				if(count($errors) > 0) 
					throw new \Exception("Error Processing Request");
			}
			else {
				$insertEachActions = $this->_model::firstOrCreate([
					'initial'=>strtolower($data['name']).'.'.strtolower($data['action']),
					'name'=>ucfirst($data['name']),
					'action'=>strtolower($data['action'])
				]);
				if(!$insertEachActions)
					$errors[] = 'error on '.$data['action'];
				
				if(count($errors) > 0) 
					throw new \Exception("Error Processing Request");
			}

			$this->transactionCommit();

			return response()->json([
				'status'=>true,
				'data'=>$data,
				'errors'=>null,
				'redirect'=>[
					'page'=>$this->_baseUrl
				],
			]);
				
		}
		catch(\Exception $e) {
			$this->transactionRollback();

			return response()->json([
				'status'=>false,
				'data'=>[],
				'errors'=>[
					'messages'=>$e->getMessage(),
				],
				'redirect'=>false,
			]);
		}	
	}

	public function updateAction(Request $request, $id) {
		$data = $request->all();
		unset($data['_token']);

		$data['initial'] = strtolower($data['name']).'.'.strtolower($data['action']);

		if($this->_model::where('id',$id)->update($data)) {
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

	public function getAction(String $name) {
		$modules = $this->model->where('name',$name)->get();
	}
}