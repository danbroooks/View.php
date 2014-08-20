<?php

class Bootstrapper {

	private static $instance;

	public static function init(){

		return self::inst()
			->configureAutoloader()
			->enableErrors()
		;
	}

	public static function inst() {
		if (!self::$instance) {
			self::$instance = new Bootstrapper();
		}

		return self::$instance;
	}

	public function run() {
		require('../site/_site.conf.php');
		Router::route();
	}

	private function enableErrors() {
		ini_set('display_startup_errors',1);
		ini_set('display_errors',1);
		error_reporting(-1);

		$errorHandler = new ErrorHandler;
		// register_shutdown_function(array($errorHandler, "handleFatalError"));
		set_error_handler(array($errorHandler, "handleError"));
		set_exception_handler(array($errorHandler, "handleException"));
		
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
		return Glob::find($class.'.class.php')->first();
	}

	public static function configureFromEnv() {
		require('./../_env.conf.php');

		Database::configure(array(
			'host' => DATABASE_SERVER,
			'user' => DATABASE_USERNAME,
			'password' => DATABASE_PASSWORD,
			'dbname' => DATABASE_NAME
		));
	}

}
