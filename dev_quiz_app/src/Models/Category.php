<?php

namespace App\Models;

use App\Models\AbstractModel;

class Category extends AbstractModel
{
    protected $table = 'category';

    private ?int $id = null;
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
