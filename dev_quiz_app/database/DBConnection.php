<?php

namespace Database;

use PDO;

class DBConnection
{
    private $dbname;
    private $host;
    private $username;
    private $password;
    private $pdo;

    public function __construct(string $dbname, string $host, string $username, string $password)
    {
        $this->dbname = $dbname;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Instantiate PDO if it doesn't already exists
     */
    public function getPDO(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                'mysql:dbname=' . $this->dbname .';host=' . $this->host,
                $this->username,
                $this->password,
                array(
                    // Allows PDO to throw exceptions
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Allows to return data as object and not associative array
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    // Avoid special characters and accents encoding errors
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET UTF8',
                )
            );
        }

        return $this->pdo;
    }
}
