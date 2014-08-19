<?php

class Database {

	private static $instance;
	private static $conf = array();

	private $conn;

	public function __construct() {
		if ($conf = $this->config()) {
			$this->conn = @new MySQLi($conf['host'], $conf['user'], $conf['password']);

			if ($this->conn->connect_error) {
				$this->dbError($this->conn->connect_errno . ': ' . $this->conn->connect_error);
			}
		}

	}

	public static function inst() {
		if (!self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public static function active() {
		return (bool)self::inst()->conn;
	}

	public static function setConfig($conf) {
		self::$conf = $conf;
	}

	public static function getConfig() {
		return self::$conf;
	}

	public static function configure($conf) {
		self::setConfig($conf);
	}

	public function config() {
		return self::getConfig();
	}

	private function dbError($err) {
		die($err);
	}

}