<?php

namespace App\Controllers\Admin;

use Database\DBConnection;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class AdminUserController extends AbstractController
{
    protected $user;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        // Check if user is auth and is admin
        if ($this->isAuth()) {
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            header('Location: /connexion');
            exit;
        }

        $this->isAdmin($this->user);
    }

    /**
     * Route: /admin/utilisateurs
     */
    public function index()
    {
        // Pagination
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $index = ($currentPage - 1) * $limit;

        $users = $this->userModel->getPaginatedUsers($index, $limit);

        $totalUsers = $this->userModel->countAll();
        $totalPages = ceil($totalUsers / $limit);

        $flashes = $this->flashMessage->getFlashMessages('user');

        return $this->render('admin/user/index', compact('users', 'currentPage', 'totalPages', 'flashes'));
    }

    /**
     * Route: /admin/utilisateur/modifier/:id
     */
    public function updateUser(mixed $id)
    {
        // Check if id is really an int and exists in DB (protect against url modifications)
        $this->redirectIfWrongId($id, 'user', 'userModel', '/admin/utilisateurs');

        $user = $this->userModel->findById($id);

        return $this->render('admin/user/update-user-form', compact('user'));
    }

    public function updateUserPost(mixed $id)
    {
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'alias' => ['required', 'min:2'],
            'email' => ['required', 'emailValidation'],
            'adminPassword' => ['required'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/utilisateur/modifier/' . $id);
            exit;
        }

        // Before doing any modifications we check if the admin entered the right password
        if (!password_verify($_POST['adminPassword'], $this->user->getPassword())) {
            $errors['adminPassword'][] = 'Ce n\'est pas le bon mot de passe';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/utilisateur/modifier/' . $id);
            exit;
        }

        // Remove useless $_POST data
        unset($_POST['adminPassword']);

        // Check if id is really an int and exists in DB (protect against form action modifications)
        $this->redirectIfWrongId($id, 'user', 'userModel', '/admin/utilisateurs');

        $user = $this->userModel->findById($id);

        // Back end Alias validation
        $aliasExists = $this->userModel->isUnique('alias', $_POST['alias']);

        if ($aliasExists && $aliasExists->getId() !== $user->getId()) {
            $errors['alias'][] = 'Ce pseudo est pris';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/utilisateur/modifier/' . $id);
            exit;
        }

        // Back end Email validation
        $emailExists = $this->userModel->isUnique('email', $_POST['email']);

        if ($emailExists && $emailExists->getId() !== $user->getId()) {
            $errors['email'][] = 'Cet email existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/utilisateur/modifier/' . $id);
            exit;
        }

        // Update User
        $user = $this->userModel->update($user->getId(), $_POST);

        if ($user) {
            $this->flashMessage->createFlashMessage(
                'user',
                'Les informations de l\'utilisateur ont bien été modifiées',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            header('Location: /admin/utilisateurs');
            exit;
        } else {
            $this->flashMessage->createFlashMessage(
                'user',
                'Les informations de l\'utilisateur n\'ont pas été modifiées, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            header('Location: /admin/utilisateur/modifier/' . $id);
            exit;
        }
    }

    /**
     * Route: /admin/utilisateur/supprimer/:id
     */
    public function deleteUser(mixed $id)
    {
        // Check if id is really an int and exists in DB (protect against url modifications)
        $this->redirectIfWrongId($id, 'user', 'userModel', '/admin/utilisateurs');
        
        $user = $this->userModel->findById($id);

        return $this->render('admin/user/delete-user-form', compact('user'));
    }

    /**
     * Route: /admin/utilisateur/supprimer/:id
     */
    public function deleteUserPost($id)
    {
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'adminPassword' => ['required'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/utilisateur/supprimer/' . $id);
            exit;
        }

        // Password check
        if (!password_verify($_POST['adminPassword'], $this->user->getPassword())) {
            $errors['adminPassword'][] = 'Ce n\'est pas le bon mot de passe';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/utilisateur/supprimer/' . $id);
            exit;
        }

        // Check if id is really an int and exists in DB (protect against form action modifications)
        $this->redirectIfWrongId($id, 'user', 'userModel', '/admin/utilisateurs');

        // Delete user
        $user = $this->userModel->delete($id);

        if ($user) {
            $this->flashMessage->createFlashMessage(
                'user',
                'Cet utilisateur et toutes les données associées ont bien été supprimés',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            header('Location: /admin/utilisateurs');
            exit;
        } else {
            $this->flashMessage->createFlashMessage(
                'user',
                'L\'utilisateur n\'a pas été supprimé, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            header('Location: /admin/utilisateur/supprimer/' . $id);
            exit;
        }
    }
}
