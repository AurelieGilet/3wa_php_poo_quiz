<?php

namespace App\Models;

use App\Entities\Score;
use Database\DBConnection;

class ScoreModel extends AbstractModel
{
    protected $table = 'score';

    public function __construct(DBConnection $db)
    {
        parent::__construct($db, Score::class);
    }

    public function findUserScoreByCategory(int $userId, int $categoryId)
    {
        $request = 'SELECT created_at, result, category_id
        FROM score s INNER JOIN user u
        ON s.user_id = u.id
        WHERE u.id = ? AND s.category_id = ?';

        return $this->query($request, [$userId, $categoryId]);
    }
}
