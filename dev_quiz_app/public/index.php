<?php

use App\Exceptions\NotFoundException;
use Router\Router;

require '../vendor/autoload.php';

define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);


$router = new Router($_GET['url']);

// URLs
// Don't forget to add the namespace of the controller so that the Route->execute() can work properly
$router->get('/', 'App\Controllers\AppController@home');
$router->get('/nouveau-jeu', 'App\Controllers\AppController@newGame');

$router->get('/inscription', 'App\Controllers\Security\SecurityController@register');
$router->get('/connexion', 'App\Controllers\Security\SecurityController@login');
$router->post('/connexion', 'App\Controllers\Security\SecurityController@loginPost');
$router->get('/deconnexion', 'App\Controllers\Security\SecurityController@logout');

$router->get('/espace-utilisateur', 'App\Controllers\User\UserController@userHomepage');

$router->get('/espace-admin', 'App\Controllers\Admin\AdminController@adminHomepage');

$router->get('/admin/categories', 'App\Controllers\Admin\CategoryController@index');
$router->get('/admin/categorie/modifier/:id', 'App\Controllers\Admin\CategoryController@editCategory');
$router->post('/admin/categorie/modifier/:id', 'App\Controllers\Admin\CategoryController@updateCategory');
$router->post('/admin/categorie/supprimer/:id', 'App\Controllers\Admin\CategoryController@deleteCategory');


try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}
