<?php

namespace App\Controllers\Security;

use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * Route: /inscription
     */
    public function register()
    {
        if ($this->isAuth()) {
            header('Location: /');
            exit;
        }

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

        // Backend validation
        $emailExists = $this->userModel->isUnique('email', $_POST['email']);

        if ($emailExists) {
            $errors['email'][] = 'Cet email existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /inscription');
            exit;
        }

        // Hash password
        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $_POST['password'] = $hashedPassword;

        // Assign default alias
        $randomNumber = rand(0, 9999);
        $userAlias = 'User' . $randomNumber;
        $_POST['alias'] = $userAlias;

        // Register User
        $this->userModel->create($_POST);

        $this->flashMessage->createFlashMessage(
            'registration',
            'Votre compte a bien été créé, merci de vous authentifier',
            $this->flashMessagesConstants::FLASH_SUCCESS,
        );

        header('Location: /connexion');
        exit;
    }

    /**
     * Route: /connexion
     */
    public function login()
    {
        // Check if session with authenticated user exists and redirect accordingly
        if ($this->isAuth() && $_SESSION['auth'] === 'user') {
            header('Location: /espace-utilisateur');
            exit;
        }

        if ($this->isAuth() && $_SESSION['auth'] === 'admin') {
            header('Location: /espace-admin');
            exit;
        }

        $flashes = $this->flashMessage->getFlashMessages('registration');

        return $this->render('security/login', compact('flashes'));
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

        $user = $this->userModel->getByEmail($_POST['email']);

        if ($user) {
            if (password_verify($_POST['password'], $user->getPassword())) {
                $_SESSION['auth'] = $user->getRole();
                $_SESSION['user'] = $user->getId();
    
                if ($user->getRole() === 'user') {
                    header('Location: /espace-utilisateur');
                    exit;
                }
                
                if ($user->getRole() === 'admin') {
                    header('Location: /espace-admin');
                    exit;
                }
    
                header('Location: /');
                exit;
            } else {
                $this->flashMessage->createFlashMessage(
                    'login',
                    'Identifiants incorrects',
                    $this->flashMessagesConstants::FLASH_ERROR,
                );
    
                header('Location: /connexion');
                exit;
            }
        }

        $this->flashMessage->createFlashMessage(
            'login',
            'Identifiants incorrects',
            $this->flashMessagesConstants::FLASH_ERROR,
        );

        header('Location: /connexion');
        exit;
    }

    /**
     * Route: /deconnexion
     */
    public function logout()
    {
        session_destroy();

        header('Location: /');
        exit;
    }
}
