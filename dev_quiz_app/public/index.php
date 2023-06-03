<?php

use Router\Router;

require '../vendor/autoload.php';

define('TEMPLATES', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);

$router = new Router($_GET['url']);

// Don't forget to add the namespace of the controller so that the Route->execute() can work properly
$router->get('/', 'App\Controller\AppController@index');
$router->get('/test/:id', 'App\Controller\AppController@show');

$router->run();