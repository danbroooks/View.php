<?php

class Page extends DataObject {

	public static $fields = array(
		"Title" => null,
		"Content" => null
	);

	protected static function noDBGet() {
		return array(
			"Template" => "Page",
			"Title" => "Contact us",
			"Content" => "<p>Contact us!</p>"
		);
	}

}