<?php

namespace App\Controllers;

use App\Controllers\AbstractController;

class AppController extends AbstractController
{
    public function home()
    {
        return $this->render('app/home');
    }

    public function newGame()
    {
        // Check if session with authenticated user exists and redirect accordingly
        if ($this->isAuth()) {
            return header('Location: /espace-utilisateur');
        }

        return $this->render('app/new-game');
    }
}
