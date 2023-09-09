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
$router->get('/choisir-sujet', 'App\Controllers\AppController@chooseGameSubject');
$router->get('/jeu/categorie/:id', 'App\Controllers\GameController@playGame');
$router->get('/jeu/categorie/reponse/:id', 'App\Controllers\GameController@ajaxNextQuestion');
$router->get('/jeu/score', 'App\Controllers\GameController@gameResult');

$router->get('/inscription', 'App\Controllers\Security\SecurityController@register');
$router->post('/inscription', 'App\Controllers\Security\SecurityController@registerPost');
$router->get('/connexion', 'App\Controllers\Security\SecurityController@login');
$router->post('/connexion', 'App\Controllers\Security\SecurityController@loginPost');
$router->get('/deconnexion', 'App\Controllers\Security\SecurityController@logout');

$router->get('/espace-utilisateur', 'App\Controllers\User\UserController@userHomepage');
$router->get('/profil-utilisateur', 'App\Controllers\User\UserController@userProfile');
$router->get('/profil-utilisateur/modifier', 'App\Controllers\User\UserController@updateUser');
$router->post('/profil-utilisateur/modifier', 'App\Controllers\User\UserController@updateUserPost');
$router->get('/profil-utilisateur/supprimer', 'App\Controllers\User\UserController@deleteUser');
$router->post('/profil-utilisateur/supprimer', 'App\Controllers\User\UserController@deleteUserPost');

$router->get('/espace-admin', 'App\Controllers\Admin\AdminController@adminHomepage');

$router->get('/admin/utilisateurs', 'App\Controllers\Admin\AdminUserController@index');
$router->get('/admin/utilisateur/modifier/:id', 'App\Controllers\Admin\AdminUserController@updateUser');
$router->post('/admin/utilisateur/modifier/:id', 'App\Controllers\Admin\AdminUserController@updateUserPost');
$router->get('/admin/utilisateur/supprimer/:id', 'App\Controllers\Admin\AdminUserController@deleteUser');
$router->post('/admin/utilisateur/supprimer/:id', 'App\Controllers\Admin\AdminUserController@deleteUserPost');

$router->get('/admin/categories', 'App\Controllers\Admin\CategoryController@index');
$router->get('/admin/categorie/ajouter', 'App\Controllers\Admin\CategoryController@createCategory');
$router->post('/admin/categorie/ajouter', 'App\Controllers\Admin\CategoryController@createCategoryPost');
$router->get('/admin/categorie/modifier/:id', 'App\Controllers\Admin\CategoryController@updateCategory');
$router->post('/admin/categorie/modifier/:id', 'App\Controllers\Admin\CategoryController@updateCategoryPost');
$router->get('/admin/categorie/supprimer/:id', 'App\Controllers\Admin\CategoryController@deleteCategory');
$router->post('/admin/categorie/supprimer/:id', 'App\Controllers\Admin\CategoryController@deleteCategoryPost');

$router->get('/admin/questions', 'App\Controllers\Admin\QuestionAnswerController@index');
$router->get('/admin/questions/:id', 'App\Controllers\Admin\QuestionAnswerController@ajaxIndex');
$router->get('/admin/question/ajouter', 'App\Controllers\Admin\QuestionAnswerController@createQuestion');
$router->post('/admin/question/ajouter', 'App\Controllers\Admin\QuestionAnswerController@createQuestionPost');
$router->get('/admin/question/modifier/:id', 'App\Controllers\Admin\QuestionAnswerController@updateQuestion');
$router->post('/admin/question/modifier/:id', 'App\Controllers\Admin\QuestionAnswerController@updateQuestionPost');
$router->get('/admin/question/supprimer/:id', 'App\Controllers\Admin\QuestionAnswerController@deleteQuestion');
$router->post('/admin/question/supprimer/:id', 'App\Controllers\Admin\QuestionAnswerController@deleteQuestionPost');

try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}
