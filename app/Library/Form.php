<?php
namespace Lib;

class Form {
	protected $_collection = [];
	protected static $_collections = [];
	protected $_entity;
	
	public function __construct($model=null, $options = []) {
		$this->_entity = $model;
		$this->initialize($model, $options);
	}

	protected function initialize($model=null, array $options) {
		self::$_collections = $this->_collection;		
	}

	protected function addCollection($arr, $name = 'Main') {
		if(!isset($this->_collection[$name]))
			$this->_collection[$name] = [];

		if($this->_entity != null) {
			$attrName = $arr->_attr['name'];
			//set default edit
			if (!isset($arr->_attr['value']))
				$arr->_attr['value'] = $this->_entity->$attrName;
		}
		
		$this->_collection[$name][] = $arr;
	}

	public static function getCollection() {
		return self::$_collections;
	}

	public static function render($el) {
		return $el->render();
	}
}