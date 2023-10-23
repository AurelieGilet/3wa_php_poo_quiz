<?php

namespace App\Controllers\Admin;

use Database\DBConnection;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class MessageController extends AbstractController
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
    public function deleteMessage(mixed $id)
    {
        // Check if id is really an int and exists in DB (protect against url modifications)
        $this->redirectIfWrongId($id, 'message', 'messageModel', '/admin/messagerie');

        $message = $this->messageModel->findById($id);

        return $this->render('admin/message/delete-message-form', compact('message'));
    }

    public function deleteMessagePost(mixed $id)
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

        // Check if id is really an int and exists in DB (protect against form action modifications)
        $this->redirectIfWrongId($id, 'message', 'messageModel', '/admin/messagerie');

        // Delete Message
        $message = $this->messageModel->delete($id);

        if ($message) {
            $this->flashMessage->createFlashMessage(
                'message',
                'Le message a bien été supprimé',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            header('Location: /admin/messagerie');
            exit;
        } else {
            $this->flashMessage->createFlashMessage(
                'message',
                'Le message n\'a pas été supprimé, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            header('Location: /admin/messagerie');
            exit;
        }
    }
}
