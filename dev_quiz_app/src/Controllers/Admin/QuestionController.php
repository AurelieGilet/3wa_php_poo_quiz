<?php

namespace App\Controllers\Admin;

use App\Models\Question;
use App\Controllers\AbstractController;

class QuestionController extends AbstractController
{
    /**
     * Route: /admin/questions
     */
    public function index()
    {
        $questions = (new Question($this->getDB()))->getAll();

        $flashes = $this->flashMessage->getFlashMessages('question');

        return $this->render('admin/question/index', compact('questions', 'flashes'));
    }

    /**
     * Route: /admin/question/ajouter
     */
    public function createQuestion()
    {
    }

    public function createQuestionPost()
    {
    }

    /**
     * Route: /admin/question/modifier/:id
     */
    public function updateQuestion()
    {
    }

    public function updateQuestionPost()
    {
    }

    /**
     * Route: /admin/question/modifier/:id
     */
    public function deleteQuestion()
    {
    }
}
