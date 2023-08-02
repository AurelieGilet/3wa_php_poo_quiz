<?php

namespace App\Models;

use App\Models\AbstractModel;

class User extends AbstractModel
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

    public function getByEmail(string $email): bool|User
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE email = ?';

        return $this->query($request, [$email], true);
    }
}
