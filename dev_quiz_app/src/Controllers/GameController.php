<?php

namespace App\Controllers;

use Database\DBConnection;
use App\Controllers\AbstractController;

class GameController extends AbstractController
{
    protected $user;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        if ($this->isAuth()) {
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            header('Location: /connexion');
            exit;
        }

        $this->isUser($this->user);
    }

    /**
     * Route: /jeu/categorie/:id
     */
    public function playGame(mixed $id)
    {
        // Check if id is an int
        if (!$this->isParameterInt($id)) {
            header('Location: /choisir-sujet');
            exit;
        }

        $category = $this->categoryModel->findById($id);

        // Check if category exists and has at least 10 questions
        if (!$category || $category->getQuestionsCount() < 10) {
            header('Location: /choisir-sujet');
            exit;
        }

        $questions = $this->questionModel->getRandomQuestions($id, 10);

        $_SESSION['gameCategory'] = $id;
        $_SESSION['gameQuestions'] = $questions;
        $_SESSION['gameAnswers'] = array();
        $_SESSION['questionIndex'] = 0;
        $_SESSION['scoreSaved'] = false;

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
    public function gameResult()
    {
        $score = $this->calculateScore();

        return $this->render('game/game-score', compact('score'));
    }
    
    private function calculateScore()
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

        // Save score in DB
        if (!$_SESSION['scoreSaved']) {
            $scoreData['result'] = $score['percentage'];
            $scoreData['user_id'] = $this->user->getId();
            $scoreData['category_id'] = $_SESSION['gameCategory'];

            $this->scoreModel->create($scoreData);
            $_SESSION['scoreSaved'] = true;
        }
        
        return $score;
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
