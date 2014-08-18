<?php

class Bootstrapper {

	public static function init(){
		ini_set('display_startup_errors',1);
		ini_set('display_errors',1);
		error_reporting(-1);

		spl_autoload_register(function ($class) {
			include 'framework/' . $class . '.class.php';
		});

	}

}

