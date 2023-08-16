<?php

namespace App\Models;

class Answer extends AbstractModel
{
    protected $table = 'answer';

    private ?int $id = null;
    private ?string $content = null;
    private ?bool $isGoodAnswer = null;
    private ?Question $question = null;

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
        return $this->isGoodAnswer;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }
}
