<?php

namespace App\Models;

use PDO;
use App\Entities\Score;
use Database\DBConnection;

class ScoreModel extends AbstractModel
{
    protected $table = 'score';

    public function __construct(DBConnection $db)
    {
        parent::__construct($db, Score::class);
    }

    public function findUserScoreByCategory(int $userId, int $categoryId, int $index)
    {
        $request = 'SELECT created_at, result, category_id
        FROM score s INNER JOIN user u
        ON s.user_id = u.id
        WHERE u.id = ? AND s.category_id = ?
        LIMIT ?, 10';

        return $this->query($request, [$userId, $categoryId, $index]);
    }

    public function countUserScoreByCategory(int $userId, int $categoryId)
    {
        $request = 'SELECT COUNT(s.id)
        FROM score s INNER JOIN user u
        ON s.user_id = u.id
        WHERE u.id = ? AND s.category_id = ?';

        $pdoStatement = $this->db->getPDO()->prepare($request);
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $pdoStatement->execute([$userId, $categoryId]);

        $result = $pdoStatement->fetch();

        return $result[0];
    }
}
