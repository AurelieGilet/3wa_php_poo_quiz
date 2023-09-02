<?php

namespace App\Models;

use App\Entities\Question;
use Database\DBConnection;

class QuestionModel extends AbstractModel
{
    protected $table = 'question';

    public function __construct(DBConnection $db)
    {
        parent::__construct($db, Question::class);
    }

    //TODO: replace all SELECT * functions
    public function findByCategory(int $categoryId)
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE category_id = ?';

        return $this->query($request, [$categoryId]);
    }

    public function getRandomQuestions(int $id, int $limit)
    {
        $request = 'SELECT id, title FROM ' . $this->table . ' WHERE category_id = ? ORDER BY RAND() LIMIT ?';

        return $this->query($request, [$id, $limit]);
    }
}
