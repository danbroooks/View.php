<?php

class PageController extends Controller {

	public function handleRequest(Request $request) {
		Database::build();
		$this->model = Page::get($request->url);
		return parent::handleRequest($request);
	}

}
