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

    public function query(string $sql, array $param = null, bool $single = false)
    {
        //TODO : refactor this function

        // If $param is null, it's a general query otherwise it's a prepared request
        $method = is_null($param) ? 'query' : 'prepare';

        // If the query is CRUD, we do not fetch data, we execute the request
        if (strpos($sql, 'CREATE') === 0
            || strpos($sql, 'UPDATE') === 0
            || strpos($sql, 'DELETE') === 0
        ) {
            $pdoStatement = $this->db->getPDO()->$method($sql);
            $pdoStatement->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

            return $pdoStatement->execute($param);
        }

        // If $single is true, we fetch a single row from DB
        $fetch = $single ? 'fetch' : 'fetchAll';

        $pdoStatement = $this->db->getPDO()->$method($sql);
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

        if ($method === 'query') {
            return $pdoStatement->$fetch();
        } else {
            $pdoStatement->execute($param);

            return $pdoStatement->$fetch();
        }
    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY id ASC';

        return $this->query($sql);
    }
    
    public function findById(int $id): AbstractModel
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

        return $this->query($sql, [$id], true);
    }

    public function update(int $id, array $data)
    {
        $sqlArgs = '';
        $i = 1;

        foreach ($data as $key => $value) {
            $separator = $i === count($data) ? ' ' : ', ';
            $sqlArgs .= $key . ' = :' . $key . $separator;
            $i++;
        }

        $data['id'] = $id;

        $sql = 'UPDATE ' . $this->table . ' SET ' . $sqlArgs . ' WHERE id = :id';

        return $this->query($sql, $data);
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = ?';

        return $this->query($sql, [$id]);
    }
}
