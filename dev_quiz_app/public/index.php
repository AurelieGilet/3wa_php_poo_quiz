<?php

use Router\Router;

require '../vendor/autoload.php';

$router = new Router($_GET['url']);

// Don't forget to add the namespace so that the Route->execute() can work properly
$router->get('/', 'App\Controller\AppController@index');
$router->get('/test/:id', 'App\Controller\AppController@show');

$router->run();