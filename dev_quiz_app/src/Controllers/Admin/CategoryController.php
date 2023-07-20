<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Controllers\AbstractController;

class CategoryController extends AbstractController
{
    public function index()
    {
        $categories = (new Category($this->getDB()))->getAll();

        return $this->render('admin/category/index', compact('categories'));
    }

    public function deleteCategory(int $id)
    {
        $category = (new Category($this->getDB()))->delete($id);

        if ($category) {
            return header('Location: /admin/categories');
        }
    }
}
