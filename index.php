<?php


include_once 'Request.php';
include_once 'Route.php';

$route = new Route(new Request);

$route->get('/', function() {

	return <<<HTML
		<h1>Hello World</h1>
HTML;
});


$route->get('/profile', function($request) {
	return <<<HTML
<h1>Profile</h1>
HTML;
});


$route->post('/data', function($request) {
	return json_encode($request->getBody());
});
