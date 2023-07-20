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

    public function editCategory(int $id)
    {
        $category = (new Category($this->getDB()))->findById($id);

        return $this->render('admin/category/edit', compact('category'));
    }

    public function updateCategory(int $id)
    {
        $category = new Category($this->getDB());
        $result = $category->update($id, $_POST);

        if ($result) {
            return header('Location: /admin/categories');
        }
    }

    public function deleteCategory(int $id)
    {
        // TODO: prevent delete if questions associated to category
        $category = (new Category($this->getDB()))->delete($id);

        if ($category) {
            return header('Location: /admin/categories');
        }
    }
}
