<?php

namespace App\Controllers;

use App\Models\User;
use App\Controllers\AbstractController;

class AppController extends AbstractController
{
    public function home()
    {
        return $this->render('app/home');
    }

    public function index()
    {
        $user = new User($this->getDB());
        $users = $user->getAll();

        foreach ($users as $user) {
            echo $user->alias;
        }

        return $this->render('app/index');
    }

    public function show(int $id)
    {
        $user = new User($this->getDB());
        $user = $user->findById($id);

        return $this->render('app/show', compact('user'));
    }
}
