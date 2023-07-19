<?php

namespace App\Controllers\User;

use App\Models\User;
use App\Controllers\AbstractController;

class UserController extends AbstractController
{
    public function userHomepage()
    {
        if ($this->isAuth()) {
            $user = new User($this->getDB());
            $user = $user->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $this->isUser($user);
        
        return $this->render('user/user-homepage', compact('user'));
    }
}
