<?php

namespace App\Controllers\User;

use App\Models\User;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class UserController extends AbstractController
{
    /**
     * Route: /espace-utilisateur
     */
    public function userHomepage()
    {
        // TODO: extract the auth check in outside function in new class Validation/Authentification
        if ($this->isAuth()) {
            $userModel = new User($this->getDB());
            $user = $userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $this->isUser($user);
        
        return $this->render('user/user-homepage', compact('user'));
    }

    /**
     * Route: profil-utilisateur
     */
    public function userProfile()
    {
        if ($this->isAuth()) {
            $userModel = new User($this->getDB());
            $user = $userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $flashes = $this->flashMessage->getFlashMessages('updateUser');

        return $this->render('user/user-profil', compact('user', 'flashes'));
    }

    /**
     * Route: /profil-utilisateur/modifier
     */
    public function updateUser()
    {
        if ($this->isAuth()) {
            $userModel = new User($this->getDB());
            $user = $userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }


        return $this->render('user/update-user-form', compact('user'));
    }

    public function updateUserPost()
    {
        if ($this->isAuth()) {
            $userModel = new User($this->getDB());
            $user = $userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'alias' => ['required', 'min:2'],
            'email' => ['required', 'emailValidation'],
            'password' => ['updatePassword'],
            'passwordOld' => ['required'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /profil-utilisateur/modifier');
            exit;
        }

        // Before doing any modifications we check if the user entered the right password
        if (!password_verify($_POST['passwordOld'], $user->getPassword())) {
            $errors['passwordOld'][] = 'Votre mot de passe actuel ne correspond pas à celui enregistré';
            $_SESSION['errors'][] = $errors;
            header('Location: /profil-utilisateur/modifier');
            exit;
        }

        // Back end Alias validation
        $aliasExists = $userModel->isUnique('alias', $_POST['alias']);

        if ($aliasExists && $aliasExists->getId() !== $user->getId()) {
            $errors['alias'][] = 'Ce pseudo est pris';
            $_SESSION['errors'][] = $errors;
            header('Location: /profil-utilisateur/modifier');
            exit;
        }

        // Back end Email validation
        $emailExists = $user->isUnique('email', $_POST['email']);

        if ($emailExists && $emailExists->getId() !== $user->getId()) {
            $errors['email'][] = 'Cet email existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /profil-utilisateur/modifier');
            exit;
        }

        // Hash new password
        if ($_POST['password']) {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $_POST['password'] = $hashedPassword;
        }

        // Delete useless $_POST data
        unset($_POST['passwordOld'], $_POST['passwordRepeat']);

        if (empty($_POST['password'])) {
            unset($_POST['password']);
        }
        
        // Update User
        $user = $userModel->update($user->getId(), $_POST);

        if ($user) {
            $this->flashMessage->createFlashMessage(
                'updateUser',
                'Vos informations ont bien été modifiées',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            return header('Location: /profil-utilisateur');
        } else {
            $this->flashMessage->createFlashMessage(
                'updateUser',
                'Vos informations n\'ont pas été modifiées, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            return header('Location: /profil-utilisateur');
        }
    }

    /**
     * Route: /profil-utilisateur/supprimer
     */
    public function deleteUser()
    {
        if ($this->isAuth()) {
            $userModel = new User($this->getDB());
            $user = $userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }


        return $this->render('user/delete-user-form', compact('user'));
    }

    public function deleteUserPost()
    {
        if ($this->isAuth()) {
            $userModel = new User($this->getDB());
            $user = $userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'password' => ['required'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /profil-utilisateur/supprimer');
            exit;
        }

        // Password check
        if (!password_verify($_POST['password'], $user->getPassword())) {
            $errors['password'][] = 'Vous n\'avez pas indiqué le bon mot de passe';
            $_SESSION['errors'][] = $errors;
            header('Location: /profil-utilisateur/supprimer');
            exit;
        }

        $user = $userModel->delete($user->getId());

        if ($user) {
            $this->flashMessage->createFlashMessage(
                'deleteUser',
                'Votre compte et toutes les données associées ont bien été supprimés',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            unset($_SESSION['auth'], $_SESSION['user']);

            return header('Location: /connexion');
        } else {
            $this->flashMessage->createFlashMessage(
                'deleteUser',
                'Votre compte n\'a pas été supprimé, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            return header('Location: /profil-utilisateur/supprimer');
        }
    }
}
