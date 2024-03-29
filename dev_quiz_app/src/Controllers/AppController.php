<?php

namespace App\Controllers;

use Database\DBConnection;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class AppController extends AbstractController
{
    protected $user;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);
    }

    /**
     * Route: /
     */
    public function home()
    {
        return $this->render('app/home');
    }

    /**
     * Route: /nouveau-jeu
     */
    public function newGame()
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

        return $this->render('app/new-game');
    }

    /**
     * Route: /choisir-sujet
     */
    public function chooseGameSubject()
    {
        if ($this->isAuth()) {
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            header('Location: /connexion');
            exit;
        }

        $this->isUser($this->user);

        $categories = $this->categoryModel->getAll();

        // Filter categories to display only those that are payable = with at least 10 questions
        foreach ($categories as $key => $category) {
            if ($category->getQuestionsCount() < 10) {
                unset($categories[$key]);
            }
        }

        return $this->render('app/choose-game-subject', compact('categories'));
    }

    /**
     * Route: /rgpd
     */
    public function rgpd()
    {
        return $this->render('app/rgpd');
    }

    /**
     * Route: /contact
     */
    public function contact()
    {
        $flashes = $this->flashMessage->getFlashMessages('contact');

        return $this->render('app/contact', compact('flashes'));
    }

    public function contactPost()
    {
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'content' => ['required', 'min:10'],
        ]);

        // We check if the email has a valide format only if it is not empty
        if (strlen(trim($_POST['email'])) > 0) {
            $errors = $validator->validate([
                'email' => ['emailValidation'],
            ]);
        }

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            $_SESSION['post'] = $_POST;
            header('Location: /contact');
            exit;
        }
        
        // Register message
        $this->messageModel->create($_POST);
        unset($_SESSION['post']);

        $this->flashMessage->createFlashMessage(
            'contact',
            'Votre message a bien été enregistré',
            $this->flashMessagesConstants::FLASH_SUCCESS,
        );

        header('Location: /contact');
        exit;
    }
}
