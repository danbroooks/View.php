<?php

require('framework/start/Bootstrapper.php');

Bootstrapper::init();

function dd($var){
	var_dump($var);
	die;
}

$view = new View('Layout');

echo $view->render(array(
	"Template" => "HomePage",
	"Title" => "Templating",
	"Content" => "<p>Hello</p><p>World</p>"
));
