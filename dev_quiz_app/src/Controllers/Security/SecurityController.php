<?php

namespace App\Controllers\Security;

use App\Models\User;
use App\Controllers\AbstractController;

class SecurityController extends AbstractController
{
    public function register()
    {
        if ($this->isAuth()) {
            return header('Location : /');
        }

        // hash password : password_hash('password', PASSWORD_BCRYPT)
        return $this->render('security/register');
    }

    public function login()
    {
        if ($this->isAuth()) {
            return header('Location : /');
        }

        return $this->render('security/login');
    }

    public function loginPost()
    {
        $user = (new User($this->getDB()))->getByEmail($_POST['email']);

        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['auth'] = $user->role;
            $_SESSION['user'] = $user->id;

            if ($user->role === 'user') {
                return header("Location: /espace-utilisateur");
            }
            
            if ($user->role === 'admin') {
                return header("Location: /espace-admin");
            }

            return header("Location: /");
        } else {
            return header('Location: /connexion');
        }
    }

    public function logout()
    {
        session_destroy();

        return header('Location: /');
    }
}
