<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Database\DBConnection;
use App\Controllers\AbstractController;

class GameController extends AbstractController
{
    protected $user;
    protected $userModel;
    protected $categoryModel;
    protected $questionModel;
    protected $answerModel;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        $this->categoryModel = new Category($this->getDB());
        $this->questionModel = new Question($this->getDB());
        $this->answerModel = new Answer($this->getDB());


        if ($this->isAuth()) {
            $this->userModel = new User($this->getDB());
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $this->isUser($this->user);
    }

    /**
     * Route: /jeu/categorie/:id
     */
    public function playGame(int $id)
    {
        $category = $this->categoryModel->findById($id);
        $questions = $this->questionModel->findByCategory($id);

        $question = $questions[0];
        $answers = $this->answerModel->findByQuestion($question->getId());

        return $this->render('game/game', compact('category', 'question', 'answers'));
    }

    public function ajaxPlayGame()
    {
        //TODO: display questions and answer via Ajax call and memorize the answers
    }
}
