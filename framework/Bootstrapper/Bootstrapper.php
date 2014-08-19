<?php

class Bootstrapper {

	private static $instance;

	public static function init(){

		self::inst()
			->enableErrors()
			->configureAutoloader();
	}

	public static function inst() {
		if (!self::$instance) {
			self::$instance = new Bootstrapper();
		}

		return self::$instance;
	}

	private function enableErrors() {
		ini_set('display_startup_errors',1);
		ini_set('display_errors',1);
		error_reporting(-1);
		return $this;
	}

	private function configureAutoloader() {
		spl_autoload_register(array($this, 'loadClass'));
		return $this;
	}

	private function loadClass($class) {
		if ($path = $this->getClassPath($class)) {
			require_once $path;
		}
		return $path;
	}

	private function getClassPath($class) {
		require_once(__DIR__."/../FileSystem/Glob.class.php");
		require_once(Glob::find($class.'.class.php')->first());
	}

}

