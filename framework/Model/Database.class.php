<?php

class Database {

	private static $instance;
	private static $conf = array();

	private $conn;

	public $classGraph;

	public function __construct() {
		$this->classGraph = new ClassGraph;

		if ($conf = $this->config()) {

			$this->conn = @new MySQLi($conf['host'], $conf['user'], $conf['password']);

			if ($this->conn->connect_error) {
				$this->dbError($this->conn->connect_errno . ': ' . $this->conn->connect_error);
			}
		}
	}

	public static function build() {
		DatabaseBuilder::build(self::inst());
	}

	// @temp
	public function query($str) {
		$q = $this->conn->query($str);
		if (!$q) dd($this->conn->error);
		return $q;
	}

	public static function inst() {
		if (!self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public static function get($class, $id) {
		return array();
	}

	public static function active() {
		return (bool)self::inst()->conn;
	}

	public static function setConfig($conf) {
		self::$conf = $conf;
	}

	public static function getConfig($get = null) {
		$conf = self::$conf;
		if (isset($get)) {
			return array_key_exists($get, $conf) ? $conf[$get] : null;
		} else {
			return $conf;
		}
	}

	public static function configure($conf) {
		self::setConfig($conf);
	}

	public function config($get = null) {
		return self::getConfig($get);
	}

	private function dbError($err) {
		die($err);
	}

}