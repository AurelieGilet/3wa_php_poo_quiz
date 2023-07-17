<?php

namespace App\Models;

use Database\DBConnection;
use PDO;

abstract class AbstractModel
{
    protected $db;
    protected $table;

    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }

    public function query(string $sql, $param = null, bool $single = false)
    {
        // If $param is null, it's a general query otherwise it's a prepared request
        $method = is_null($param) ? 'query' : 'prepare';
        // If $single is true, we fetch a single row from DB
        $fetch = $single ? 'fetch' : 'fetchAll';

        $pdoStatement = $this->db->getPDO()->$method($sql);
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

        if ($method === 'query') {
            return $pdoStatement->$fetch();
        } else {
            $pdoStatement->execute([$param]);

            return $pdoStatement->$fetch();
        }
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";

        return $this->query($sql);
    }
    
    public function findById(int $id): AbstractModel
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";

        return $this->query($sql, $id, true);
    }
}
