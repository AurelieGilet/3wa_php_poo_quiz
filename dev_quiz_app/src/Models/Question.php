<?php

namespace App\Models;

class Question extends AbstractModel
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

    public function findByCategory(int $categoryId)
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE category_id = ?';

        return $this->query($request, [$categoryId]);
    }
}
