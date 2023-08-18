<?php

namespace App\Models;

class Answer extends AbstractModel
{
    protected $table = 'answer';

    private ?int $id = null;
    private ?string $content = null;
    private ?bool $is_good_answer = null;
    private ?int $question_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getIsGoodAnswer(): ?bool
    {
        return $this->is_good_answer;
    }

    public function getQuestion(): ?int
    {
        return $this->question_id;
    }

    public function findByQuestion(int $questionID)
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE question_id = ?';

        return $this->query($request, [$questionID]);
    }
}
