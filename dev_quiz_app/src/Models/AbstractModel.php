<?php

namespace App\Models;

use Database\DBConnection;
use stdClass;

abstract class AbstractModel
{
    protected $db;
    protected $table;

    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $pdoStatement = $this->db->getPDO()->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $pdoStatement->fetchAll();
    }
    
    public function findById(int $id): stdClass
    {
        $pdoStatement = $this->db->getPDO()->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $pdoStatement->execute([$id]);

        return $pdoStatement->fetch();
    }
}
