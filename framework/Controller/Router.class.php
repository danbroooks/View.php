<?php

class Router {

	private static $routes;

	public static function add_route($url, $controller) {
		if (!is_array(self::$routes)) {
			self::$routes = array();
		}
		self::$routes[$url] = $controller;
	}

	public static function route() {
		$url = $_SERVER['REQUEST_URI'];
		$routes = self::$routes;

		if (array_key_exists($url, $routes)) {
			$controllerClass = $routes[$url];
			$controller = new $controllerClass();
			$controller->invoke($url);
		} else {
			echo 404;
			die;
		}
	}

}


