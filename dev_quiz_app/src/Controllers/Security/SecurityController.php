<?php

namespace App\Controllers\Security;

use App\Models\User;
use App\Validation\Validator;
use App\Controllers\AbstractController;

class SecurityController extends AbstractController
{
    public function register()
    {
        if ($this->isAuth()) {
            return header('Location: /');
        }

        // hash password : password_hash('password', PASSWORD_BCRYPT)
        return $this->render('security/register');
    }

    public function registerPost()
    {
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'email' => ['required', 'emailValidation'],
            'password' => ['required', 'passwordValidation'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /inscription');
            exit;
        }

        $user = (new User($this->getDB()));

        // Backend validation
        $emailExists = $user->isUnique('email', $_POST['email']);

        if (!empty($emailExists)) {
            $errors['email'][] = 'Cet email existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /inscription');
            exit;
        }

        $user->create($_POST);

        // TODO : validation message when redirect to login page

        return header('Location: /connexion');
        
    }

    public function login()
    {
        if ($this->isAuth()) {
            return header('Location: /');
        }

        return $this->render('security/login');
    }

    public function loginPost()
    {
        $validator = new Validator($_POST);

        $errors = $validator->validate([
            'email' => ['required', 'emailValidation'],
            'password' => ['required'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /connexion');
            exit;
        }

        $user = (new User($this->getDB()))->getByEmail($_POST['email']);

        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['auth'] = $user->role;
            $_SESSION['user'] = $user->id;

            if ($user->role === 'user') {
                return header('Location: /espace-utilisateur');
            }
            
            if ($user->role === 'admin') {
                return header('Location: /espace-admin');
            }

            return header('Location: /');
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
