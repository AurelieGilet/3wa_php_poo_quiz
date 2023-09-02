<?php

namespace App\Models;

use App\Entities\User;
use Database\DBConnection;
use App\Models\AbstractModel;

class UserModel extends AbstractModel
{
    protected $table = 'user';

    public function __construct(DBConnection $db)
    {
        parent::__construct($db, User::class);
    }

    public function getByEmail(string $email): bool|User
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE email = ?';

        return $this->query($request, [$email], true);
    }
}
