<?php
namespace App\Tools;

use Illuminate\Support\Facades\Auth;
use App\Models\Permission as modelPermission;
use App\Models\BaseTable;

class Permission {
	
	public static $_permissionKey = 'permission_';
	public static $_isRoot = false;
	protected static $_groupId;

	public static function setPermission($groupId) {
		$grants = [];

		//menus
		$datas = new \App\Models\Menu();
		$dataMenus = $datas->setMenu($groupId);

		$menus = [];
		foreach($dataMenus as $data) {
			$menus[$data->parent][$data->menu_group][] = $data->toArray();
		}
		$grants['menus'] = $menus;

		if ($groupId === 1) {
			Redis::set(self::$_permissionKey.md5($groupId), json_encode($grants));
			return true;
		}
		self::$_groupId = $groupId;

		if (is_null(self::getPermission(self::$_permissionKey.md5($groupId)))) { 
			$permissions = modelPermission::
				join(BaseTable::TBL_GROUP,BaseTable::TBL_PERMISSION.'.group_id','=',BaseTable::TBL_GROUP.'.id')
				->join(BaseTable::TBL_MODULE,BaseTable::TBL_PERMISSION.'.module_id','=',BaseTable::TBL_MODULE.'.id')
				->select('modules.*', BaseTable::TBL_GROUP.'.name AS groupName')
				->where('group_id',$groupId)
				->get();

			foreach($permissions as $permission) {
				// $grants['permission'][] = [
				// 	'name'=>$permission->name,
				// 	'initial'=>$permission->initial,
				// 	'action'=>$permission->action,
				// ];
				$grants['permission'][] = $permission->initial;
			}

			
			Redis::set(self::$_permissionKey.md5($groupId), json_encode($grants));
		}
	}

	public static function getPermission(String $key) {
		return Redis::get($key);
	}

	public static function isRoot() {
		return Auth::user()->group_id === 1;
	}

	public static function isAuthorized(String $module, String $action='index') {
		if (self::isRoot())
			return true;
		
		// $getPermission = self::getPermission(self::$_permissionKey.self::$_groupId);
		
	}
}