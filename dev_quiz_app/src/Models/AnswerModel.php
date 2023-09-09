<?php

namespace App\Models;

use App\Entities\Answer;
use Database\DBConnection;

class AnswerModel extends AbstractModel
{
    protected $table = 'answer';

    public function __construct(DBConnection $db)
    {
        parent::__construct($db, Answer::class);
    }

    public function findByQuestion(int $questionID)
    {
        $request = 'SELECT id, content, is_good_answer, question_id FROM ' . $this->table . ' WHERE question_id = ?';

        return $this->query($request, [$questionID]);
    }
}
