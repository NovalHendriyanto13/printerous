<?php
namespace App\Tools;

use Illuminate\Support\Facades\Redis as RedisCore;
use Illuminate\Support\Facades\Cache as CacheCore;

class Redis {

	protected $_type = ['database','cache'];
	protected static $_default = 'database';

	public static function setDefault(String $type) {
		self::$_default = $type;
	}
	public static function set(String $key, $value, $timeout = 1*60*60) {
		switch (self::$_default) {
			case 'database':
				return RedisCore::set($key, $value);
				break;
			case 'cache':
				return CacheCore::store('redis')->put($key, $value, $timeout);
				break;
			default:
				return 'Invalid Default Setting';
				break;
		}
	}

	public static function get(String $key) {
		switch (self::$_default) {
			case 'database':
				return RedisCore::get($key);
				break;
			case 'cache':
				return CacheCore::store('redis')->get($key);
				break;
			default:
				return 'Invalid Default Setting';
				break;
		}
	}

	public static function delete(String $key) {
		switch (self::$_default) {
			case 'database':
				return RedisCore::del($key, $value);
				break;
			case 'cache':
				return CacheCore::store('redis')->forget($key, $value, $timeout);
				break;
			default:
				return 'Invalid Default Setting';
				break;
		}
	}

	public static function cacheFlush() {
		if (self::$_default == 'database')
			return 'This method is not available in Database Default';

		return CacheCore::flush();
	}

	public static function cacheRetrieveDelete(String $key) {
		if (self::$_default == 'database')
			return 'This method is not available in Database Default';

		return CacheCore::pull($key);
	}
}