<?php

namespace App\Controllers\Admin;

use Database\DBConnection;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class QuestionAnswerController extends AbstractController
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

        $limit = 5;
        $index = 0;

        $questions = $this->questionModel->filterByCategory($activeCategory, $index, $limit);

        $totalQuestions = $this->questionModel->countQuestionsByCategory($activeCategory);
        $totalPages = ceil($totalQuestions / $limit);
        $currentPage = 1;
    
        $flashes = $this->flashMessage->getFlashMessages('question');

        return $this->render('admin/question/index', compact(
            'categories',
            'activeCategory',
            'questions',
            'currentPage',
            'totalPages',
            'flashes'
        ));
    }

    /**
     * Route: /admin/questions/:id
     */
    public function ajaxIndex(string $categoryId)
    {
        /**
         * This is used to secure the url against any direct modifications
         * adding parameters to it would break the Ajax calls
         */
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            header('Location: /admin/questions');
            exit;
        }

        $currentPage = isset($_GET['page']) ? $_GET['page'] : false;

        $limit = 5;
        $index = ($currentPage - 1) * $limit;

        // Use Ajax call (question-ajax.js) to render the questions filtered by category
        $questions = $this->questionModel->filterByCategory($categoryId, $index, $limit);

        $totalQuestions = $this->questionModel->countQuestionsByCategory($categoryId);
        $totalPages = ceil($totalQuestions / $limit);

        return $this->renderFragment('admin/question/_category-questions', compact(
            'questions',
            'currentPage',
            'totalPages',
            'limit',
        ));
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
        $categoryExists = false;

        if (ctype_digit($_POST['category'])) {
            $categoryExists = $this->categoryModel->findById($_POST['category']);
        }

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

        header('Location: /admin/questions');
        exit;
    }

    /**
     * Route: /admin/question/modifier/:id
     */
    public function updateQuestion(mixed $id)
    {
        // Check if id is really an int and exists in DB (protect against url modifications)
        $this->redirectIfWrongId($id, 'question', 'questionModel', '/admin/questions');

        $categories = $this->categoryModel->getAll();

        $question = $this->questionModel->findById($id);

        $answers = $this->answerModel->findByQuestion($id);

        return $this->render('admin/question/update-question-form', compact('categories', 'question', 'answers'));
    }

    public function updateQuestionPost(mixed $id)
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
            header('Location: /admin/question/modifier/' . $id);
            exit;
        }

        // Check if id is really an int and exists in DB (protect against form action modifications)
        $this->redirectIfWrongId($id, 'question', 'questionModel', '/admin/questions');

        // Back end validation
        $categoryExists = false;

        if (ctype_digit($_POST['category'])) {
            $categoryExists = $this->categoryModel->findById($_POST['category']);
        }

        if (!$categoryExists) {
            $errors['category'][] = 'Merci de choisir une catégorie';
            $_SESSION['errors'][] = $errors;
            $_SESSION['post'] = $_POST;
            header('Location: /admin/question/modifier/' . $id);
            exit;
        }

        $questionExists = $this->questionModel->isUnique('title', $_POST['title']);

        if ($questionExists && $questionExists->getId() !== $id) {
            $errors['title'][] = 'Cette question existe déjà';
            $_SESSION['errors'][] = $errors;
            $_SESSION['post'] = $_POST;
            header('Location: /admin/question/modifier/' . $id);
            exit;
        }

        // Update Question
        $questionData['title'] = $_POST['title'];
        $questionData['category_id'] = $_POST['category'];

        $question = $this->questionModel->update($id, $questionData);

        if (!$question) {
            $this->flashMessage->createFlashMessage(
                'question',
                'La question n\'a pas été modifiée, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            header('Location: /admin/question/modifier/' . $id);
            exit;
        }

        // Update Answers
        foreach ($_POST['answer'] as $key => $answer) {
            $currentAnswers = $this->answerModel->findByQuestion($id);
            $currentAnswersId = array();
        
            foreach ($currentAnswers as $currentAnswer) {
                $currentAnswersId[] = $currentAnswer->getId();
            }

            /**
             * If the array key is an int, the answer already exists, it's an update
             * We check if the key (id) match with one of the question current answers,
             * as it could have been modified in the form by the user
             * If not, we don't update that answer
             */
            if (is_int($key) && array_search($key, $currentAnswersId, true) !== false) {
                // If there is no content then we delete the answer
                if (trim($answer['content'] === '')) {
                    $this->answerModel->delete($key);

                // Otherwise, we update the answer
                } else {
                    $answerData['content'] = trim($answer['content']);

                    $answerData['is_good_answer'] = isset($answer['goodAnswer'])
                    && $answer['goodAnswer'] === 'on'
                    ? true
                    : false;
                    
                    $answerData['question_id'] = $id;

                    $this->answerModel->update($key, $answerData);
                }

            /**
             * If the array key is a string, the answer is new, it's a create
             * We check if the question has currently less than 4 answers which is the maximum
             * If not, we don't create the new answer, and inform the user of the error
             */
            } elseif (is_string($key) && count($currentAnswersId) < 4) {
                if (trim($answer['content'] !== '')) {
                    $answerData['content'] = trim($answer['content']);

                    $answerData['is_good_answer'] = isset($answer['goodAnswer'])
                    && $answer['goodAnswer'] === 'on'
                    ? true
                    : false;
                    
                    $answerData['question_id'] = $id;

                    $this->answerModel->create($answerData);
                }
            } else {
                $errors['answer'][] = 'Une erreur s\'est produite et au moins une des questions n\'a pû être modifiée.
                Assurez-vous de soumettre le formulaire sans modifier les paramètres des champs';
                $_SESSION['errors'][] = $errors;

                header('Location: /admin/question/modifier/' . $id);
                exit;
            }
        }

        $this->flashMessage->createFlashMessage(
            'question',
            'La question a bien été modifiée',
            $this->flashMessagesConstants::FLASH_SUCCESS,
        );

        header('Location: /admin/questions');
        exit;
    }

    /**
     * Route: /admin/question/supprimer/:id
     */
    public function deleteQuestion(mixed $id)
    {
        // Check if id is really an int and exists in DB (protect against url modifications)
        $this->redirectIfWrongId($id, 'question', 'questionModel', '/admin/questions');

        $question = $this->questionModel->findById($id);
        $answers = $this->answerModel->findByQuestion($id);

        return $this->render('admin/question/delete-question-form', compact('question', 'answers'));
    }

    public function deleteQuestionPost(mixed $id)
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

        // Check if id is really an int and exists in DB (protect against form action modifications)
        $this->redirectIfWrongId($id, 'question', 'questionModel', '/admin/questions');

        // Delete question (delete answers by cascade)
        $question = $this->questionModel->delete($id);

        if ($question) {
            $this->flashMessage->createFlashMessage(
                'deleteQuestion',
                'Cette question et toutes les réponses associées ont bien été supprimées',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            header('Location: /admin/questions');
            exit;
        } else {
            $this->flashMessage->createFlashMessage(
                'deleteQuestion',
                'Cette question n\'a pas été supprimée, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            header('Location: /admin/question/supprimer/' . $id);
            exit;
        }
    }
}
