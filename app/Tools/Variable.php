<?php
namespace App\Tools;

use Illuminate\Support\Facades\Auth;

class Variable {
	public static $_var = [];
	
	public function __construct() {
		if (!array_key_exists('user', self::$_var)) {
			self::$_var['user'] = Auth::user();
		}
	}

	public static function set(Array $var) {
		self::$_var = array_merge(self::$_var, $var);
		if (!array_key_exists('user', self::$_var)) {
			self::$_var['user'] = Auth::user();
		}
	}

	public static function get(String $key) {
		return self::$_var[$key];
	}

	public static function all() {
		return self::$_var;
	}
}