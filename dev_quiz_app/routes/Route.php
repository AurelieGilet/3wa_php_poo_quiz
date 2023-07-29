<?php

namespace Router;

use Database\DBConnection;
use Database\DBConstants;

class Route
{
    public $path;
    public $action;
    public $matches;

    public function __construct($path, $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    public function matches(string $url)
    {
        // pattern : we seek to replace anything that starts with ":"
        // and is followed by one or several alphanumerical characters
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";

        if (preg_match($pathToMatch, $url, $matches)) {
            $this->matches = $matches;

            return true;
        } else {
            return false;
        }
    }

    public function execute()
    {
        // create an array with the controller name in first index,
        // and the action (function) called in the second
        $params = explode('@', $this->action);
        // create a new object of the controller class and init db connection
        $controller = new $params[0](new DBConnection(
            DBConstants::DB_NAME,
            DBConstants::DB_HOST,
            DBConstants::DB_USER,
            DBConstants::DB_PWD
        ));
        // stock the function name (action)
        $method = $params[1];

        if (isset($this->matches[1])) {
            // If there is a param in the url, we call the controller's method and pass it the param
            return $controller->$method($this->matches[1]);
        } else {
            // otherwise, we just call the controller's method
            return $controller->$method();
        }
    }
}
