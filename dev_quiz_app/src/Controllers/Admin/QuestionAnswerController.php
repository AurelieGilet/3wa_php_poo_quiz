<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Database\DBConnection;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class QuestionAnswerController extends AbstractController
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

        $this->isAdmin($this->user);
    }
    
    /**
     * Route: /admin/questions
     */
    public function index()
    {
        // We erase any previous form data that had been stored in the session
        unset($_SESSION['post']);

        $categories = $this->categoryModel->getAll();

        //When arriving on the page, we display the questions of the first category by default
        $activeCategory = $categories[0]->getId();

        $questions = $this->questionModel->findByCategory($activeCategory);
    
        $flashes = $this->flashMessage->getFlashMessages('question');

        return $this->render('admin/question/index', compact('categories', 'activeCategory', 'questions', 'flashes'));
    }

    /**
     * Route: /admin/questions/:id
     */
    public function ajaxIndex(int $categoryId)
    {
        // Use Ajax call (question-ajax.js) to render the questions filtered by category
        $questions = $this->questionModel->findByCategory($categoryId);

        return $this->renderFragment('admin/question/_category-questions', compact('questions'));
    }

    /**
     * Route: /admin/question/ajouter
     */
    public function createQuestion()
    {
        $categories = $this->categoryModel->getAll();

        return $this->render('admin/question/create-question-form', compact('categories'));
    }

    public function createQuestionPost()
    {
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'category' => ['required'],
            'title' => ['required'],
            'answer' => ['answersMin', 'isGoodAnswer'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            $_SESSION['post'] = $_POST;
            header('Location: /admin/question/ajouter');
            exit;
        }

        // Back end validation
        $categoryExists = $this->categoryModel->findById($_POST['category']);

        if (!$categoryExists) {
            $errors['category'][] = 'Merci de choisir une catégorie';
            $_SESSION['errors'][] = $errors;
            $_SESSION['post'] = $_POST;
            header('Location: /admin/question/ajouter');
            exit;
        }

        $questionExists = $this->questionModel->isUnique('title', $_POST['title']);

        if ($questionExists) {
            $errors['title'][] = 'Cette question existe déjà';
            $_SESSION['errors'][] = $errors;
            $_SESSION['post'] = $_POST;
            header('Location: /admin/question/ajouter');
            exit;
        }

        // Create Question
        $questionData['title'] = $_POST['title'];
        $questionData['category_id'] = $_POST['category'];

        $this->questionModel->create($questionData);

        $question = $this->questionModel->getLastEntry();

        // Create Answers
        foreach ($_POST['answer'] as $answer) {
            if (trim($answer['content'] !== '')) {
                $answerData['content'] = trim($answer['content']);

                $answerData['is_good_answer'] = isset($answer['goodAnswer'])
                && $answer['goodAnswer'] === 'on'
                ? true
                : false;
                
                $answerData['question_id'] = $question->getId();

                $this->answerModel->create($answerData);
            }
        }

        $this->flashMessage->createFlashMessage(
            'question',
            'La question a bien été créée',
            $this->flashMessagesConstants::FLASH_SUCCESS,
        );

        return header('Location: /admin/questions');
    }

    /**
     * Route: /admin/question/modifier/:id
     */
    public function updateQuestion(int $id)
    {
        $categories = $this->categoryModel->getAll();

        $question = $this->questionModel->findById($id);

        $answers = $this->answerModel->findByQuestion($id);

        return $this->render('admin/question/update-question-form', compact('categories', 'question', 'answers'));
    }

    public function updateQuestionPost(int $id)
    {
        echo'<pre>';var_dump($_POST);echo'</pre>';

        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'category' => ['required'],
            'title' => ['required'],
            'answer' => ['answersMin'],
            'goodAnswer' => ['isGoodAnswer'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            $_SESSION['post'] = $_POST;
            header('Location: /admin/question/modifier/' . $id);
            exit;
        }

        die();
    }

    /**
     * Route: /admin/question/supprimer/:id
     */
    public function deleteQuestion(int $id)
    {
        $question = $this->questionModel->findById($id);
        $answers = $this->answerModel->findByQuestion($id);

        return $this->render('admin/question/delete-question-form', compact('question', 'answers'));
    }

    public function deleteQuestionPost(int $id)
    {
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'adminPassword' => ['required'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/question/supprimer/' . $id);
            exit;
        }

        // Password check
        if (!password_verify($_POST['adminPassword'], $this->user->getPassword())) {
            $errors['adminPassword'][] = 'Ce n\'est pas le bon mot de passe';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/question/supprimer/' . $id);
            exit;
        }

        // Delete question (delete answers by cascade)
        $question = $this->questionModel->delete($id);

        if ($question) {
            $this->flashMessage->createFlashMessage(
                'deleteQuestion',
                'Cette question et toutes les réponses associées ont bien été supprimées',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            return header('Location: /admin/questions');
        } else {
            $this->flashMessage->createFlashMessage(
                'deleteQuestion',
                'Cette question n\'a pas été supprimée, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            return header('Location: /admin/question/supprimer/' . $id);
        }
    }
}
