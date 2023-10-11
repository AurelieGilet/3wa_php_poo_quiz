<?php

namespace App\Models;

use PDO;
use Database\DBConnection;
use App\Entities\Category;
use App\Models\AbstractModel;

class CategoryModel extends AbstractModel
{
    protected $table = 'category';

    public function __construct(DBConnection $db)
    {
        parent::__construct($db, Category::class);
    }

    /**
     * Method called in the AbstractModel query method that allows to associate the db request result
     * to the corresponding Entity property
     */
    protected function modelQuery($entity): void
    {
        $request = 'SELECT COUNT(q.id) AS "questions"
        FROM category c INNER JOIN question q
        ON c.id = q.category_id
        WHERE c.id = ?';

        $pdoStatement = $this->db->getPDO()->prepare($request);
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $pdoStatement->execute([$entity->getId()]);
        $result = $pdoStatement->fetch();

        if (count($result) > 0) {
            $entity->setQuestionsCount($result[0]);
        }
    }

    public function getPaginatedCategories($index)
    {
        $request = 'SELECT id, name
        FROM ' . $this->table .
        ' LIMIT ?, 10';

        return $this->query($request, [$index]);
    }
}
