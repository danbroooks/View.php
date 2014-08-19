<?php

class Controller {

	public $model;

	public function __construct() {
		$this->response = new Response;
	}

	public function handleRequest(Request $request) {
		if ($this->model) {
			$this->response->setBody($this->renderView());
			return $this->response;
		} else {
			return Response::make("Error: no model");
		}
	}

	protected function renderView() {
		$layout = new View('Layout');
		return $layout->render($this->model->toArray());
	}

}
