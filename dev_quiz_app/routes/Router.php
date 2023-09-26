<?php

namespace Router;

use App\Exceptions\NotFoundException;

class Router
{
    public $url;
    public $routes = array();

    public function __construct($url)
    {
        $this->url = trim($url, '/');
    }

    public function get(string $path, string $action)
    {
        $this->routes['GET'][] = new Route($path, $action);
    }

    public function post(string $path, string $action)
    {
        $this->routes['POST'][] = new Route($path, $action);
    }
    
    public function run()
    {
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches($this->url)) {
                $this->requestPath();
                return $route->execute();
            }
        }

        throw new NotFoundException("La page demandée est introuvable");
    }

    public function requestPath(): void
    {
        $requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $scriptName = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));

        $parts = array_diff_assoc($requestUri, $scriptName);

        $path = implode('/', $parts);

        if (($position = strpos($path, '?')) !== false) {
            $path = substr($path, 0, $position);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['path'] = $path;
    }
}
