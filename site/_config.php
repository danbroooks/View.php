<?php


// View only example

// $view = new View('Layout');

// echo $view->render(array(
// 	"Template" => "HomePage",
// 	"Title" => "Templating",
// 	"Content" => "<p>Hello</p><p>World</p>"
// ));





// View + Model

// $page = new Page('HomePage', 'Templating', '<p>Hello World</p>');
// $layout = new View('Layout');

// echo $layout->render($page->toArray());






// Controller + View + Model

Router::add_route('/contact-us', 'PageController');
Router::add_route('/', 'PageController');

