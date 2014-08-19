<?php

class Page extends DataObject {

	private $layout;
	private $title;
	private $content;

	public function __construct($layout, $title, $content) {
		$this->layout = $layout;
		$this->title = $title;
		$this->content = $content;
	}

	public function toArray() {
		return array(
			"Template" => $this->layout,
			"Title" => $this->title,
			"Content" => $this->content
		);
	}


	// static methods to simulate ORM database interaction
	public static function get($url) {
		switch($url) {
			case '/':
				return new Page('HomePage', 'Templating', '<p>Hello World</p>');
			default: 
				return new Page('ErrorPage', 'Page not found', '<p>404 page not found</p>');
		}
	}

}