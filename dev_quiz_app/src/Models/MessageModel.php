<?php

namespace App\Models;

use Database\DBConnection;
use App\Entities\Message;
use App\Models\AbstractModel;

class MessageModel extends AbstractModel
{
    protected $table = 'message';

    public function __construct(DBConnection $db)
    {
        parent::__construct($db, Message::class);
    }

    public function getPaginatedMessages(int $index, int $limit): bool|array
    {
        $request = 'SELECT id, content, email, created_at
        FROM ' . $this->table .
        ' ORDER BY created_at DESC
        LIMIT ?, ?';

        return $this->query($request, [$index, $limit]);
    }
}
