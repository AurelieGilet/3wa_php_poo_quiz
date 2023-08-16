<?php

namespace App\Controllers\Admin;

use App\Models\User;
use Database\DBConnection;
use App\Controllers\AbstractController;

class AdminUserController extends AbstractController
{
    protected $user;
    protected $userModel;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        if ($this->isAuth()) {
            $this->userModel = new User($this->getDB());
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $this->isAdmin($this->user);
    }

    /**
     * Route: /admin/utilisateurs
     */
    public function index()
    {
        $users = $this->userModel->getAll();

        $flashes = $this->flashMessage->getFlashMessages('user');

        return $this->render('admin/user/index', compact('users', 'flashes'));
    }

    /**
     * Route: /admin/utilisateur/modifier/:id
     */
    public function udpateUser(int $id)
    {
        $updateUser = $this->userModel->findById($id);
    }

    public function updateUserPost(int $id)
    {
    }

    /**
     * Route: /admin/utilisateur/supprimer/:id
     */
    public function deleteUser()
    {
    }
}
