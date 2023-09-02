<?php

namespace App\Entities;

use App\Entities\AbstractEntity;

class Question extends AbstractEntity
{
    protected $table = 'question';

    private ?int $id = null;
    private ?string $title = null;
    private ?int $category_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }
}
