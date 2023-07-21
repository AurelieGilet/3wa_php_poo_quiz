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

    public function query(string $request, array $param = null, bool $single = false)
    {
        //TODO : refactor this function

        // If $param is null, it's a general query otherwise it's a prepared request
        $method = is_null($param) ? 'query' : 'prepare';

        // If the query is CRUD, we do not fetch data, we execute the request
        if (strpos($request, 'CREATE') === 0
            || strpos($request, 'UPDATE') === 0
            || strpos($request, 'DELETE') === 0
        ) {
            $pdoStatement = $this->db->getPDO()->$method($request);
            $pdoStatement->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

            return $pdoStatement->execute($param);
        }

        // If $single is true, we fetch a single row from DB
        $fetch = $single ? 'fetch' : 'fetchAll';

        $pdoStatement = $this->db->getPDO()->$method($request);
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
        $request = 'SELECT * FROM ' . $this->table . ' ORDER BY id ASC';

        return $this->query($request);
    }
    
    public function findById(int $id): AbstractModel
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

        return $this->query($request, [$id], true);
    }

    public function isUnique(string $column, string $value)
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = ?';

        return $this->query($request, [$value], true);
    }

    public function create(array $data, ?array $relations = null)
    {
        $requestArgs = '';
        $requestValues = '';
        $i = 1;

        foreach ($data as $key => $value) {
            $separator = $i === count($data) ? '' : ', ';
            $requestArgs .= $key . $separator;
            $requestValues .= ':' . $key . $separator;
            $i++;
        }

        $request = 'INSERT INTO ' . $this->table . ' (' . $requestArgs . ') VALUES(' . $requestValues . ')';

        return $this->query($request, $data);
    }

    public function update(int $id, array $data)
    {
        $requestArgs = '';
        $i = 1;

        foreach ($data as $key => $value) {
            $separator = $i === count($data) ? '' : ', ';
            $requestArgs .= $key . ' = :' . $key . $separator;
            $i++;
        }

        $data['id'] = $id;

        $request = 'UPDATE ' . $this->table . ' SET ' . $requestArgs . ' WHERE id = :id';

        return $this->query($request, $data);
    }

    public function delete(int $id): bool
    {
        $request = 'DELETE FROM ' . $this->table . ' WHERE id = ?';

        return $this->query($request, [$id]);
    }
}
