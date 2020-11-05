<?php
namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Permission;
use App\Models\Module;
use App\Models\BaseTable;

use App\Form\GroupForm;

class GroupController extends BaseController {
	protected $_baseUrl = 'group';
	protected $_title = 'Group';
	protected $_model = Group::class;

	protected function indexData() {
		return [
			'table'=>[
				'columns'=>[
					[
						'name'=>'id',
						'visible'=>false,
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

	protected function retrieveData(Request $request) {
		return $this->_model::where('id','<>',1)->get();
	}

	protected function setForm() {
		return GroupForm::class;
	}

	public function update($id) {
		$model = $this->_model::find($id);
		$form = $this->setForm();
		$permission = $this->setModule($id);
		
		$data = [
			'id'=>$id,
			'form' => new $form($model, ['mode'=>'edit']),
			'permissions'=>$permission['modules'],
			'defaultPermission'=>$permission['default']
		];

		return view('authentication.group.update')->with($data);
	}

	public function updateAction(Request $request, $id) {
		$data = $request->all();
		$additional = isset($data['additional'])?$data['additional']:'';
		$default = $data['default'];
		
		unset($data['_token']);
		unset($data['additional']);
		unset($data['default']);

		$this->transactionBegin();
		try{
			if(!Group::where('id',$id)->update($data))
				throw new \Exception("Error Processing Request", 1);
			
			// delete existing permission
			$modules = $additional != ''? explode(',', $additional):[];
			if(count($modules) > 0)
				Permission::where('group_id',$id)->delete();

			$errs = [];	
			foreach ($modules as $value) {
				$permission = Permission::firstOrCreate([
					'group_id'=>$id,
					'module_id'=>$value
				]);
				if(!$permission)
					$errs[] = 'Error on permission';
			}
			if (count($errs) > 0)
				throw new \Exception("Error Processing Request", 1);
				
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

	private function setModule($groupId='') {
		$modules = Module::leftJoin(BaseTable::TBL_PERMISSION,BaseTable::TBL_MODULE.'.id','=','module_id')
			->select(BaseTable::TBL_MODULE.'.id AS id', BaseTable::TBL_MODULE.'.name', BaseTable::TBL_MODULE.'.action', 'permission.group_id')
			->orderBy(BaseTable::TBL_MODULE.'.initial')
			->get();

		$data = [];
		$default = [];
		foreach($modules as $module) {
			$selected = $module->group_id == $groupId ? true:false;
			// set parent key
			$data[$module->name][] = [
				'id'=>$module->id,
				'action'=>$module->action,
				'selected'=>$selected
			];
			if($module->group_id == $groupId)
				$default[] = $module->id;
		}
		unset($data['']);
		return [
			'modules'=>$data,
			'default'=>$default
		];
	}
}