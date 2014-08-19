<?php

class PageController extends Controller {

	public function handleRequest(Request $request) {
		$this->model = Page::get($request->url);
		return parent::handleRequest($request);
	}

}
