<?php

class Request {

	public $url;

	public $urlParams;

	public $postVars;

	public function __construct() {
		$this->url = $_SERVER['REQUEST_URI'];
		$this->urlParams = $_GET;
		$this->postVars = $_POST;
	}
}
