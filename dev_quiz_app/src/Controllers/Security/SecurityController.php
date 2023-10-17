<?php

namespace App\Controllers\Security;

use App\Models\UserModel;
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
            return header('Location: /');
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

        $user = (new UserModel($this->getDB()));

        // Backend validation
        $emailExists = $user->isUnique('email', $_POST['email']);

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
        $user->create($_POST);

        $this->flashMessage->createFlashMessage(
            'registration',
            'Votre compte a bien été créé, merci de vous authentifier',
            $this->flashMessagesConstants::FLASH_SUCCESS,
        );

        return header('Location: /connexion');
    }

    /**
     * Route: /connexion
     */
    public function login()
    {
        // Check if session with authenticated user exists and redirect accordingly
        if ($this->isAuth() && $_SESSION['auth'] === 'user') {
            return header('Location: /espace-utilisateur');
        }

        if ($this->isAuth() && $_SESSION['auth'] === 'admin') {
            return header('Location: /espace-admin');
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

        $user = (new UserModel($this->getDB()))->getByEmail($_POST['email']);

        if ($user) {
            if (password_verify($_POST['password'], $user->getPassword())) {
                $_SESSION['auth'] = $user->getRole();
                $_SESSION['user'] = $user->getId();
    
                if ($user->getRole() === 'user') {
                    return header('Location: /espace-utilisateur');
                }
                
                if ($user->getRole() === 'admin') {
                    return header('Location: /espace-admin');
                }
    
                return header('Location: /');
            } else {
                $this->flashMessage->createFlashMessage(
                    'login',
                    'Identifiants incorrects',
                    $this->flashMessagesConstants::FLASH_ERROR,
                );
    
                return header('Location: /connexion');
            }
        }

        $this->flashMessage->createFlashMessage(
            'login',
            'Identifiants incorrects',
            $this->flashMessagesConstants::FLASH_ERROR,
        );

        return header('Location: /connexion');
    }

    /**
     * Route: /deconnexion
     */
    public function logout()
    {
        session_destroy();

        return header('Location: /');
    }
}
