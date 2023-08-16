<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use Database\DBConnection;
use App\Controllers\AbstractController;

class QuestionAnswerController extends AbstractController
{
    protected $user;
    protected $userModel;
    protected $categoryModel;
    protected $questionModel;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        $this->categoryModel = new Category($this->getDB());
        $this->questionModel = new Question($this->getDB());

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
        $categories = $this->categoryModel->getAll();

        //When arriving on the page, we display the questions of the first category by default
        $activeCategory = $categories[0]->getId();

        $questions = $this->questionModel->getByCategory($activeCategory);
    
        $flashes = $this->flashMessage->getFlashMessages('question');

        return $this->render('admin/question/index', compact('categories', 'activeCategory', 'questions', 'flashes'));
    }

    /**
     * Route: /admin/questions/:id
     */
    public function ajaxIndex(int $categoryId)
    {
        $questions = $this->questionModel->getByCategory($categoryId);

        return $this->renderFragment('admin/question/_category-questions', compact('questions'));
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
