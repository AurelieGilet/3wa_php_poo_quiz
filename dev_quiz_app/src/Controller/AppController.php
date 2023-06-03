<?php

namespace App\Controller;

use App\Controller\AbstractController;

class AppController extends AbstractController {
    public function index() 
    {
        return $this->render('app/index');
    }

    public function show(int $id) 
    {
        return $this->render('app/show', compact('id'));
    }
}