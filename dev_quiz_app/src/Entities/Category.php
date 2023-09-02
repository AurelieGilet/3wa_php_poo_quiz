<?php

namespace App\Entities;

class Category extends AbstractEntity
{
    private ?int $id = null;
    private ?string $name = null;
    private ?int $questionsCount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getQuestionsCount(): ?int
    {
        return $this->questionsCount;
    }

    public function setQuestionsCount(int $questionsCount): self
    {
        $this->questionsCount = $questionsCount;

        return $this;
    }
}
