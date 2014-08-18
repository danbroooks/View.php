<?php

require('framework/Bootstrapper/Start.php');

Bootstrapper::init();


$view = new View('Layout');

echo $view->render(array(
	"Template" => "HomePage",
	"Title" => "Templating",
	"Content" => "<p>Hello</p><p>World</p>"
));
