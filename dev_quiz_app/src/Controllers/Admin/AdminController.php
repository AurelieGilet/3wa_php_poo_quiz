<?php

namespace App\Controllers\Admin;

use Database\DBConnection;
use App\Controllers\AbstractController;

class AdminController extends AbstractController
{
    protected $user;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        if ($this->isAuth()) {
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            header('Location: /connexion');
            exit;
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
