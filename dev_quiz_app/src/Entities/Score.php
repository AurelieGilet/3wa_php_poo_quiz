<?php

namespace App\Entities;

use App\Entities\AbstractEntity;
use DateTime;

class Score extends AbstractEntity
{
    protected $table = 'score';

    private ?int $id = null;
    private ?string $created_at = null;
    private ?int $result = null;
    private ?int $user_id = null;
    private ?int $category_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }
}
