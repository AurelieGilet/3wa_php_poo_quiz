<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Category;
use Database\DBConnection;
use App\Controllers\AbstractController;

class AppController extends AbstractController
{
    protected $categoryModel;
    protected $user;
    protected $userModel;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        $this->categoryModel = new Category($this->getDB());
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
        if ($this->isAuth()) {
            return header('Location: /espace-utilisateur');
        }

        return $this->render('app/new-game');
    }

    /**
     * Route: /choisir-sujet
     */
    public function chooseGameSubject()
    {
        if ($this->isAuth()) {
            $this->userModel = new User($this->getDB());
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $this->isUser($this->user);

        $categories = $this->categoryModel->getAll();

        return $this->render('app/choose-game-subject', compact('categories'));
    }
}
