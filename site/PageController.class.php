<?php

class PageController extends Controller {

	public function handleRequest(Request $request) {
		Database::inst()->test();
		
		$this->model = Page::get($request->url);
		return parent::handleRequest($request);
	}

}
