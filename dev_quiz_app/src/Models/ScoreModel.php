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
}
