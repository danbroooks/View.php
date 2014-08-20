<?php

class HomePage extends Page {

	protected static function noDBGet() {
		return array(
			"Template" => "HomePage",
			"Title" => "Home",
			"Content" => "<p>Welcome.</p>"
		);
	}

}