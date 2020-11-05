<?php

if (! function_exists('variable_get')) {
	function variable_get($k) {
		$variable = new \App\Tools\Variable;
		if ($variable->get($k) == '' ) 
			return null;

		return $variable::get($k);
	}
}

if (! function_exists('variable_all')) {
	function variable_all() {
		return \App\Tools\Variable::all();
	}
}

if (! function_exists('is_root')) {
	function is_root() {
		return \App\Tools\Permission::isRoot();
	}
}

if (! function_exists('set_menu')) {
	function set_menu(Int $groupId) {
		$redisKey = \App\Tools\Permission::$_permissionKey.md5($groupId);

		$getRedis = \App\Tools\Redis::get($redisKey);
		if(is_null($getRedis)) {
			// set permission
			\App\Tools\Permission::setPermission($groupId);

			$getRedis = \App\Tools\Redis::get($redisKey);
		}
		$permission = json_decode($getRedis);

		return (Object) $permission->menus;
	}
}

if (! function_exists('image_url')) {
	function image_url($source, $type = 'original') {
		if ($type == 'original') {
			return asset(config('app.image_path.original').$source);
		}
		return asset(config('app.image_path.thumbnail').$source);
	}
}

if (! function_exists('convert_date')) {
	function convert_date($date, $format='Y-m-d') {
		return date($format, strtotime($date));
	}
}