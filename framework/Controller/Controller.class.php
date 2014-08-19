<?php

class Controller {

	protected $model;
	protected $response;

	public function handleRequest($request, $model) {
		$this->model = $model;
		$this->response = new Response;
		$this->response->body = $this->renderView();
		return $this->response;
	}

	protected function renderView() {
		$layout = new View('Layout');
		return $layout->render($this->model->toArray());
	}

}
