<?php

namespace App\Entities;

class Message extends AbstractEntity
{
    private ?int $id = null;
    private ?string $email = null;
    private ?string $content = null;
    private ?string $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
}
