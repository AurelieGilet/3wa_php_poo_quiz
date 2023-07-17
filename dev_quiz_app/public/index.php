<?php

use Router\Router;

require '../vendor/autoload.php';

define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);


$router = new Router($_GET['url']);

// URLs
// Don't forget to add the namespace of the controller so that the Route->execute() can work properly
$router->get('/', 'App\Controllers\AppController@home');
$router->get('/jeu', 'App\Controllers\AppController@newGame');
$router->get('/show/:id', 'App\Controllers\AppController@show');
$router->get('/inscription', 'App\Controllers\SecurityController@register');
$router->get('/connexion', 'App\Controllers\SecurityController@login');
$router->post('/connexion', 'App\Controllers\SecurityController@loginPost');

$router->run();
