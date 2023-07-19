<?php

namespace App\Controllers;

use Database\DBConnection;

abstract class AbstractController
{
    protected $db;

    /**
     * Instantiate the DB connection so that it is available in all controllers
     */
    public function __construct(DBConnection $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
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

    protected function isAuth(): bool
    {
        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
            return true;
        }
        
        return false;
    }

    protected function isAdmin($user): bool|string
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === 'admin' && $_SESSION['user'] === $user->id) {
            return true;
        } else {
            return header('Location: /');
        }
    }

    protected function isUser($user): bool|string
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === 'user' && $_SESSION['user'] === $user->id) {
            return true;
        } else {
            return header('Location: /');
        }
    }
}
