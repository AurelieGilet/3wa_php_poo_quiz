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
}
