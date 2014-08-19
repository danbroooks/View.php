<?php

class Response {

	private $body;

	public function output(){
		echo $this->body;
		die;
	}

	public function setBody($body){
		$this->body = $body;
	}

	public static function make($body) {
		$res = new self;
		$res->setBody($body);
		return $res;
	}
}
