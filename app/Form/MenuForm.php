<?php
namespace App\Form;

use Lib\Form;
use App\View\Components\InputText;
use App\View\Components\InputSelect;
use App\Models\Menu;
use App\Models\Module;

class MenuForm extends Form {
	
	protected function initialize($entity=null, array $options) {
		$mode = '';
		if (isset($options['mode']) && $options['mode'] == 'edit')
			$mode = 'edit';

		$name = new InputText([
			'name'=>'name',
			'class'=>'tes',
			'type'=>'text',
			'required'=>true,
		]);
		$this->addCollection($name);

		$parent = new InputSelect([
			'label'=>'Parent Menu',
			'name'=>'parent_id',
			'class'=>'parent-menu',
			'allowEmpty'=>true,
			'options'=>Menu::select('id','name')
				->whereNull('parent_id')
				->get(),
		]);
		$this->addCollection($parent);

		$attrModule = [
			'name'=>'module',
			'allowEmpty'=>true,
			'options'=>$this->loadModule(),
		];
		
		if ($mode === 'edit') {
			$moduleValue = $entity->module;
			$attrModule['value'] = $entity->module->name;
		}

		$module = new InputSelect($attrModule);
		$this->addCollection($module);

		$action = new InputText([
			'name'=>'action',
			'type'=>'text',
			'default'=>'index',
		]);
		$this->addCollection($action);
		
		$icon = new InputText([
			'name'=>'icon',
			'type'=>'text',
			'label'=>'Icon Class'
		]);
		$this->addCollection($icon);

		$menuGrup = new InputText([
			'name'=>'menu_group',
			'type'=>'text',
		]);
		$this->addCollection($menuGrup);

		$sort = new InputText([
			'name'=>'sort_number',
			'type'=>'number',
		]);
		$this->addCollection($sort);

		$status = new InputSelect([
			'label'=>'Visible',
			'name'=>'status',
			'required'=>true,
			'options'=>[
				1=>'Yes',
				0=>'No'
			]
		]);
		$this->addCollection($status);

		parent::initialize($entity, $options);
	}

	private function loadModule() {
		$module = Module::select('name')
				->orderBy('name')
				->get();

		$modules = [];
		foreach ($module as $m) {
			$modules[$m->name] = $m->name;
		}

		return $modules;
	}
}