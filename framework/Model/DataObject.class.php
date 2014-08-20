<?php

class DataObject implements DataObjectInterface {

	private $data;
	private $class;

	public function __construct($data) {
		$this->class = self::getClass();
		$this->data = $data;
	}

	public function __get($property) {
		if ($this->hasMethod($method = "get$property")) {
			return $this->$method();
		} else if ($this->hasField($property)) {
			return $this->getField($property);
		}
	}

	public function __set($property, $value) {
		if($this->hasMethod($method = "set$property")) {
			$this->$method($value);
		} else {
			$this->setField($property, $value);
		}
	}
	
	public function hasMethod($method) {
		return method_exists($this, $method);
	}
	
	public function hasField($field) {
		return property_exists($this, $field);
	}
	
	public function getField($field) {
		return $this->$field;
	}
	
	public function setField($field, $value) {
		$this->$field = $value;
	}

	public function toArray() {
		return $this->data;
	}

	protected static function getClass() {
		return get_called_class();
	}

	// static methods to simulate ORM database interaction
	public static function get($id) {
		$callerClass = static::getClass();

		if ($callerClass == get_class()) {
			throw new Exception("Well done mate. You've only gone and tried to get a generic DataObject... try again.");
		}
		
		$data = Database::active() ? Database::get($callerClass, $id) : static::noDBGet();

		return new $callerClass($data);
	}

	protected static function noDBGet() {
		return array();
	}

}

interface DataObjectInterface {

	public function toArray();

}