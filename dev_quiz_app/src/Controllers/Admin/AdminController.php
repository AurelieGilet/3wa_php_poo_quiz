<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Controllers\AbstractController;

class AdminController extends AbstractController
{
    /**
     * Route: /espace-admin
     */
    public function adminHomepage()
    {
        if ($this->isAuth()) {
            $user = new User($this->getDB());
            $user = $user->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $this->isAdmin($user);

        return $this->render('admin/admin-homepage', compact('user'));
    }
}
