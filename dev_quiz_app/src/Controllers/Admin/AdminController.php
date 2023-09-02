<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use Database\DBConnection;
use App\Controllers\AbstractController;

class AdminController extends AbstractController
{
    protected $user;
    protected $userModel;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        if ($this->isAuth()) {
            $this->userModel = new UserModel($this->getDB());
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $this->isAdmin($this->user);
    }

    /**
     * Route: /espace-admin
     */
    public function adminHomepage()
    {
        $user = $this->user;
        
        return $this->render('admin/admin-homepage', compact('user'));
    }
}
