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

    public function createCategory()
    {
        return $this->render('admin/category/form');
    }

    public function createCategoryPost()
    {
        $category = (new Category($this->getDB()))->create($_POST);

        // TODO: find a way to get a return value on insert

        if ($category) {
            return header('Location: /admin/categories');
        }
    }

    public function updateCategory(int $id)
    {
        $category = (new Category($this->getDB()))->findById($id);

        return $this->render('admin/category/form', compact('category'));
    }

    public function updateCategoryPost(int $id)
    {
        $category = (new Category($this->getDB()))->update($id, $_POST);

        if ($category) {
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
