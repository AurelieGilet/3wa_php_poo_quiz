<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use Database\DBConnection;
use App\Models\MessageModel;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class MessageController extends AbstractController
{
    protected $user;
    protected $userModel;
    protected $messageModel;


    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        $this->messageModel = new MessageModel($this->getDB());

        if ($this->isAuth()) {
            $this->userModel = new UserModel($this->getDB());
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $this->isAdmin($this->user);
    }

    /**
     * Route: /admin/messagerie
     */
    public function index()
    {
        // Pagination
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $index = ($currentPage - 1) * $limit;

        $messages = $this->messageModel->getPaginatedMessages($index, $limit);

        $totalMessages = $this->messageModel->countAll();
        $totalPages = ceil($totalMessages / $limit);

        $flashes = $this->flashMessage->getFlashMessages('message');

        return $this->render('admin/message/index', compact('messages', 'currentPage', 'totalPages', 'flashes'));
    }

    /**
     * Route: /admin/message/supprimer/:id
     */
    public function deleteMessage(int $id)
    {
        $message = $this->messageModel->findById($id);

        return $this->render('admin/message/delete-message-form', compact('message'));
    }

    public function deleteMessagePost(int $id)
    {
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'adminPassword' => ['required'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/message/supprimer/' . $id);
            exit;
        }

        // Password check
        if (!password_verify($_POST['adminPassword'], $this->user->getPassword())) {
            $errors['adminPassword'][] = 'Ce n\'est pas le bon mot de passe';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/message/supprimer/' . $id);
            exit;
        }

        // Delete Message
        $message = $this->messageModel->delete($id);

        if ($message) {
            $this->flashMessage->createFlashMessage(
                'message',
                'Le message a bien été supprimé',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            return header('Location: /admin/messagerie');
        } else {
            $this->flashMessage->createFlashMessage(
                'message',
                'Le message n\'a pas été supprimé, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            return header('Location: /admin/messagerie');
        }
    }
}
