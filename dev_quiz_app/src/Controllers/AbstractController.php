<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ScoreModel;
use Database\DBConnection;
use App\Models\AnswerModel;
use App\Models\MessageModel;
use App\Models\CategoryModel;
use App\Models\QuestionModel;
use App\Services\FlashMessages\FlashMessage;
use App\Services\FlashMessages\FlashMessagesConstants;

abstract class AbstractController
{
    protected $db;
    protected $flashMessage;
    protected $flashMessagesConstants;
    protected $userModel;
    protected $categoryModel;
    protected $questionModel;
    protected $answerModel;
    protected $scoreModel;
    protected $messageModel;

    /**
     * Instantiate the DB connection so that it is available in all controllers
     */
    public function __construct(DBConnection $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
        $this->flashMessage = new FlashMessage();
        $this->flashMessagesConstants = new FlashMessagesConstants();
        $this->userModel = new UserModel($this->getDB());
        $this->categoryModel = new CategoryModel($this->getDB());
        $this->questionModel = new QuestionModel($this->getDB());
        $this->answerModel = new AnswerModel($this->getDB());
        $this->scoreModel = new ScoreModel($this->getDB());
        $this->messageModel = new MessageModel($this->getDB());
    }

    protected function getDB()
    {
        return $this->db;
    }

    protected function render(string $view, array $params = null)
    {
        ob_start();

        $view = str_replace('/', DIRECTORY_SEPARATOR, $view);

        require VIEWS . $view . '.php';

        $content = ob_get_clean();

        require VIEWS . 'base.php';
    }

    protected function renderFragment(string $view, array $params = null)
    {
        ob_start();

        $view = str_replace('/', DIRECTORY_SEPARATOR, $view);

        require VIEWS . $view . '.php';

        $content = ob_get_clean();

        echo $content;
    }

    /**
     * Verify is the user is correctly authenticated
     */
    protected function isAuth(): bool
    {
        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
            return true;
        }
        
        return false;
    }

    /**
     * Verify is the connected user has the role admin
     */
    protected function isAdmin($user): bool|string
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === 'admin' && $_SESSION['user'] === $user->getId()) {
            return true;
        } else {
            header('Location: /');
            exit;
        }
    }

    /**
     * Verify is the connected user has the role user
     */
    protected function isUser($user): bool|string
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === 'user' && $_SESSION['user'] === $user->getId()) {
            return true;
        } else {
            header('Location: /');
            exit;
        }
    }

    /**
     * Check if the parameters send through url is an int
     */
    protected function isParameterInt($param): bool
    {
        if (ctype_digit($param)) {
            return true;
        }

        return false;
    }

    // Check if the ids passed in urls or forms action attribute exists and redirect if not
    protected function redirectIfWrongId($id, $class, $classModel, $path)
    {
        $error = true;
        $data = false;

        // Check if id is integer
        if (ctype_digit($id)) {
            $error = false;
        }

        // Check if id exists in DB
        if (!$error) {
            $data = $this->$classModel->findById($id);
        }

        if ($data) {
            return;
        }

        $this->flashMessage->createFlashMessage(
            $class,
            'L\'id communiqué est incorrect',
            $this->flashMessagesConstants::FLASH_ERROR,
        );

        header('Location: ' . $path);
        exit;
    }
}
