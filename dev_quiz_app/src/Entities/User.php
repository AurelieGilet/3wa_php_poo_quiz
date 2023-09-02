<?php

namespace App\Entities;

class User extends AbstractEntity
{
    protected $table = 'user';

    private ?int $id = null;
    private ?string $email = null;
    private ?string $password = null;
    private ?string $alias = null;
    private ?string $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }
}
