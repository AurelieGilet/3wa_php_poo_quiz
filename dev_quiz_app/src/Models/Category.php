<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;

class Category extends AbstractModel
{
    protected $table = 'category';

    private ?int $id = null;
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getQuestions(): int
    {
        $request = 'SELECT COUNT(q.id) AS "questions"
        FROM category c INNER JOIN question q
        ON c.id = q.category_id
        WHERE c.id = ?';

        $pdoStatement = $this->db->getPDO()->prepare($request);
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $pdoStatement->execute([$this->id]);
        $result = $pdoStatement->fetch();

        if (count($result) > 0) {
            return $result[0];
        }

        return 0;
    }
}
