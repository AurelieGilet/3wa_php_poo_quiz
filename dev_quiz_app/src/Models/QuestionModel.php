<?php

namespace App\Models;

use PDO;
use App\Entities\Question;
use Database\DBConnection;

class QuestionModel extends AbstractModel
{
    protected $table = 'question';

    public function __construct(DBConnection $db)
    {
        parent::__construct($db, Question::class);
    }

    
    public function findByCategory(int $categoryId)
    {
        $request = 'SELECT id, title, category_id FROM ' . $this->table . ' WHERE category_id = ?';

        return $this->query($request, [$categoryId]);
    }

    public function filterByCategory(int $categoryId, int $index)
    {
        $request = 'SELECT id, title, category_id 
        FROM ' . $this->table .
        ' WHERE category_id = ? 
        LIMIT ?, 10';

        return $this->query($request, [$categoryId, $index]);
    }

    public function countQuestionsByCategory(int $categoryId)
    {
        $request = 'SELECT COUNT(id) FROM ' . $this->table . ' WHERE category_id = ?';

        $pdoStatement = $this->db->getPDO()->prepare($request);
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $pdoStatement->execute([$categoryId]);

        $result = $pdoStatement->fetch();

        return $result[0];
    }

    public function getRandomQuestions(int $id, int $limit)
    {
        $request = 'SELECT id, title FROM ' . $this->table . ' WHERE category_id = ? ORDER BY RAND() LIMIT ?';

        return $this->query($request, [$id, $limit]);
    }
}
