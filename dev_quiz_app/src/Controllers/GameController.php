<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AnswerModel;
use App\Models\CategoryModel;
use App\Models\QuestionModel;
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

        $this->categoryModel = new CategoryModel($this->getDB());
        $this->questionModel = new QuestionModel($this->getDB());
        $this->answerModel = new AnswerModel($this->getDB());


        if ($this->isAuth()) {
            $this->userModel = new UserModel($this->getDB());
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
        $questions = $this->questionModel->getRandomQuestions($id, 10);

        $_SESSION['gameQuestions'] = $questions;
        $_SESSION['gameAnswers'] = array();
        $_SESSION['questionIndex'] = 0;

        $question = $questions[0];
        $answers = $this->answerModel->findByQuestion($question->getId());

        return $this->render('game/game', compact('category', 'question', 'answers'));
    }

    /**
     * Route: /jeu/categorie/reponse/:id
     */
    public function ajaxNextQuestion(int $id)
    {
        array_push($_SESSION['gameAnswers'], $id);

        $_SESSION['questionIndex']++;

        if ($_SESSION['questionIndex'] <= 9) {
            $question = $_SESSION['gameQuestions'][$_SESSION['questionIndex']];

            $answers = $this->answerModel->findByQuestion($question->getId());
        } else {
            header('Location: /jeu/score');
            exit;
        }
        
        return $this->renderFragment('game/_game-question', compact('question', 'answers'));
    }

    /**
     * Route: /jeu/score
     */
    public function calculateScore()
    {
        $answers = $_SESSION['gameAnswers'];

        $score = array();
        $score['total'] = 0;

        foreach ($answers as $answer) {
            $answer = $this->answerModel->findById($answer);

            if ($answer->getIsGoodAnswer()) {
                $score['total']++;
            }
        }

        $score['percentage'] = $score['total'] / 10 * 100;

        $score['mention'] = $this->getScoreMention($score['percentage']);

        //TODO: save score in db;

        return $this->render('game/score', compact('score'));
    }

    private function getScoreMention(int $percentage): string
    {
        
        switch ($percentage) {
            case ($percentage === 100):
                $mention = "Parfait !";
                break;
            case ($percentage < 100 && $percentage >= 75):
                $mention = "Tu y es presque !";
                break;
            case ($percentage < 75 && $percentage >= 50):
                $mention = "Encore un peu de travail !";
                break;
            case ($percentage < 50 && $percentage >= 25):
                $mention = "On s'accroche !";
                break;
            case ($percentage < 25):
                $mention = "Il va falloir réviser !";
                break;
            default:
                $mention = "Quel est ce score ?";
                break;
        }

        return $mention;
    }
}
