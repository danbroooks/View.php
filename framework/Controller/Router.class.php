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
		$routes = self::$routes;
		$request = new Request;
		$url = $request->url;

		if (self::hasRoute($url)) {
			$controllerClass = $routes[$url];
			$controller = new $controllerClass;

			$response = $controller->handleRequest($request);
		} else {
			$response = Response::make("No route found");
		}

		$response->output();
	}

	private static function hasRoute($route) {
		return array_key_exists($route, self::$routes);
	}
}


