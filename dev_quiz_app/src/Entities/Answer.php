<?php

namespace App\Entities;

class Answer extends AbstractEntity
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
}
