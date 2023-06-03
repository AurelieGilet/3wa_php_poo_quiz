<?php 

namespace App\Controller;

class AbstractController {
    public function render(string $view, array $params = null)
    {
        ob_start();

        $view = str_replace('/', DIRECTORY_SEPARATOR, $view);

        require TEMPLATES . $view . '.php';

        if ($params) {
            $params = extract($params);
        }

        $content = ob_get_clean();

        require TEMPLATES . 'base.php';
    }
}