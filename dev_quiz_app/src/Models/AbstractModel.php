<?php

namespace App\Models;

use App\Entities\AbstractEntity;
use Database\DBConnection;
use PDO;

abstract class AbstractModel
{
    protected $db;
    protected $table;
    protected $entityClass;

    public function __construct(DBConnection $db, string $entityClass)
    {
        $this->db = $db;

        $this->entityClass = $entityClass;
    }

    protected function modelQuery($entity)
    {
        // Virtual function replaced by equivalent in model Classes
    }

    public function query(string $request, array $param = null, bool $single = false): bool|array|AbstractEntity
    {
        //TODO: refactor this function ?

        // If $param is null, it's a general query otherwise it's a prepared request
        $method = is_null($param) ? 'query' : 'prepare';

        // If the query is CRUD, we do not fetch data, we execute the request
        if (strpos($request, 'CREATE') === 0
            || strpos($request, 'UPDATE') === 0
            || strpos($request, 'DELETE') === 0
        ) {
            $pdoStatement = $this->db->getPDO()->$method($request);
            $pdoStatement->setFetchMode(PDO::FETCH_CLASS, $this->entityClass);
            var_dump('coucou');
            return $pdoStatement->execute($param);
        }

        // If $single is true, we fetch a single row from DB
        $fetch = $single ? 'fetch' : 'fetchAll';

        $pdoStatement = $this->db->getPDO()->$method($request);
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS, $this->entityClass);

        if ($method === 'prepare') {
            $pdoStatement->execute($param);
        }

        $results = $pdoStatement->$fetch();

        if (is_bool($results)) {
            return $results;
        } elseif (is_array($results)) {
            foreach ($results as $result) {
                $this->modelQuery($result);
            }
        } else {
            $this->modelQuery($results);
        }


        return $results;
    }

    public function getLastEntry()
    {
        $requestId = 'SELECT LAST_INSERT_ID()';

        $pdoStatement = $this->db->getPDO()->query($requestId);
        $resultId = $pdoStatement->fetch(PDO::FETCH_NUM);

        $requestEntry = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

        return $this->query($requestEntry, [$resultId[0]], true);
    }

    //TODO: replace all SELECT * requests
    public function getAll(): array
    {
        $request = 'SELECT * FROM ' . $this->table . ' ORDER BY id ASC';

        return $this->query($request);
    }

    public function countAll()
    {
        $request = 'SELECT COUNT(id) FROM ' . $this->table;
        
        $pdoStatement = $this->db->getPDO()->prepare($request);
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $pdoStatement->execute();

        $result = $pdoStatement->fetch();

        return $result[0];
    }
    
    public function findById(int $id): bool|AbstractEntity
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

        return $this->query($request, [$id], true);
    }

    public function isUnique(string $column, string $value): bool|AbstractEntity
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = ?';

        return $this->query($request, [$value], true);
    }

    public function create(array $data)
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

    public function update(int $id, array $data): bool
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
