<?php

namespace App\Controllers;

use App\Models\User;

class SecurityController extends AbstractController
{
    public function register()
    {
        // hash password : password_hash('password', PASSWORD_BCRYPT)
        return $this->render('security/register');
    }

    public function login()
    {
        return $this->render('security/login');
    }

    public function loginPost()
    {
        $user = (new User($this->getDB()))->getByEmail($_POST['email']);

        if (password_verify($_POST['password'], $user->password)) {
            //TODO : connect user
        } else {
            return header('Location: /connexion');
        }
    }
}
