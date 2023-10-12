<?php

namespace App\Controllers\User;

use App\Models\UserModel;
use Database\DBConnection;
use App\Models\CategoryModel;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;
use App\Models\ScoreModel;

class UserController extends AbstractController
{
    protected $user;
    protected $userModel;
    protected $categoryModel;
    protected $scoreModel;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        $this->categoryModel = new CategoryModel($this->getDB());
        $this->scoreModel = new ScoreModel($this->getDB());

        if ($this->isAuth()) {
            $this->userModel = new UserModel($this->getDB());
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }
    }

    /**
     * Route: /espace-utilisateur
     */
    public function userHomepage()
    {
        $user = $this->user;

        $this->isUser($this->user);

        return $this->render('user/user-homepage', compact('user'));
    }

    
    /**
     * Route: /espace-utilisateur/scores
     */
    public function userScores()
    {
        $user = $this->user;

        $this->isUser($this->user);

        $categories = $this->categoryModel->getAll();

        // Filter categories to display only those that are payable = with at least 10 questions
        foreach ($categories as $key => $category) {
            if ($category->getQuestionsCount() < 10) {
                unset($categories[$key]);
            }
        }

        $activeCategory = $categories[0]->getId();

        // Pagination
        $currentPage = 1;

        $limit = 10;
        $index = 0;

        $scores = $this->scoreModel->findUserScoreByCategory($this->user->getId(), $activeCategory, $index, $limit);

        $totalScores = $this->scoreModel->countUserScoreByCategory($this->user->getId(), $activeCategory);
        $totalPages = ceil($totalScores / $limit);

        return $this->render('user/user-scores', compact(
            'categories',
            'activeCategory',
            'scores',
            'currentPage',
            'totalPages'
        ));
    }

    /**
     * Route: /espace-utilisateur/scores/:id
     */
    public function ajaxUserScores(string $categoryId)
    {
        /**
         * This is used to secure the url against any direct modifications,
         * adding parameters to it would break the Ajax calls
         */
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            header('Location: /espace-utilisateur/scores');
            exit;
        }

        $currentPage = isset($_GET['page']) ? $_GET['page'] : false;

        $limit = 10;
        $index = ($currentPage - 1) * $limit;
        
        // User Ajax call (user-score-ajax.js) to render the scores filtered by category
        $scores = $this->scoreModel->findUserScoreByCategory($this->user->getId(), $categoryId, $index, $limit);
        
        $totalScores = $this->scoreModel->countUserScoreByCategory($this->user->getId(), $categoryId);
        $totalPages = ceil($totalScores / $limit);

        return $this->renderFragment('user/_category-scores', compact('scores', 'currentPage', 'totalPages'));
    }

    /**
     * Route: profil-utilisateur
     */
    public function userProfile()
    {
        $user = $this->user;

        $flashes = $this->flashMessage->getFlashMessages('updateUser');

        return $this->render('user/user-profil', compact('user', 'flashes'));
    }

    /**
     * Route: /profil-utilisateur/modifier
     */
    public function updateUser()
    {
        $user = $this->user;

        return $this->render('user/update-user-form', compact('user'));
    }

    public function updateUserPost()
    {
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
        if (!password_verify($_POST['passwordOld'], $this->user->getPassword())) {
            $errors['passwordOld'][] = 'Votre mot de passe actuel ne correspond pas à celui enregistré';
            $_SESSION['errors'][] = $errors;
            header('Location: /profil-utilisateur/modifier');
            exit;
        }

        // Back end Alias validation
        $aliasExists = $this->userModel->isUnique('alias', $_POST['alias']);

        if ($aliasExists && $aliasExists->getId() !== $this->user->getId()) {
            $errors['alias'][] = 'Ce pseudo est pris';
            $_SESSION['errors'][] = $errors;
            header('Location: /profil-utilisateur/modifier');
            exit;
        }

        // Back end Email validation
        $emailExists = $this->userModel->isUnique('email', $_POST['email']);

        if ($emailExists && $emailExists->getId() !== $this->user->getId()) {
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
        $user = $this->userModel->update($this->user->getId(), $_POST);

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

            return header('Location: /profil-utilisateur/modifier');
        }
    }

    /**
     * Route: /profil-utilisateur/supprimer
     */
    public function deleteUser()
    {
        $user = $this->user;

        return $this->render('user/delete-user-form', compact('user'));
    }

    public function deleteUserPost()
    {
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
        if (!password_verify($_POST['password'], $this->user->getPassword())) {
            $errors['password'][] = 'Vous n\'avez pas indiqué le bon mot de passe';
            $_SESSION['errors'][] = $errors;
            header('Location: /profil-utilisateur/supprimer');
            exit;
        }

        $user = $this->userModel->delete($this->user->getId());

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
