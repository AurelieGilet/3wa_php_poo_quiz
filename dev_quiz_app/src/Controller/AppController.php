<?php

namespace App\Controller;

class AppController {
    public function index() 
    {
        echo 'Je suis la homepage';
    }

    public function show(int $id) 
    {
        echo 'Voici l\'id n°' . $id;
    }
}