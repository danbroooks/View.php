<?php

class PageController extends Controller {

	public $model;

	public function Invoke($url) {
		$this->model = Page::get($url);
		$this->renderView();
	}

	public function renderView() {
		$layout = new View('Layout');
		echo $layout->render($this->model->toArray());
	}

}
