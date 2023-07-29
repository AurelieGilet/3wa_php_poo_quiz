<?php

namespace App\Models;

use App\Models\AbstractModel;

class User extends AbstractModel
{
    protected $table = 'user';

    public function getByEmail(string $email): bool|User
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE email = ?';

        return $this->query($request, [$email], true);
    }
}
