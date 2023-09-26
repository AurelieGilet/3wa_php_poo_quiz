<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception
{
    public function __construct($message = '', $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function error404()
    {
        http_response_code(404);

        $view = 'errors/404';

        ob_start();

        $view = str_replace('/', DIRECTORY_SEPARATOR, $view);

        require VIEWS . $view . '.php';

        $content = ob_get_clean();

        require VIEWS . 'base.php';
    }
}
