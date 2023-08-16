<?php

namespace App\Models;

class Question extends AbstractModel
{
    protected $table = 'question';

    private ?int $id = null;
    private ?string $title = null;
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getByCategory(int $categoryId)
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE category_id = ?';

        return $this->query($request, [$categoryId]);
    }
}
