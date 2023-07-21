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
        // TODO : length validation
        
        $category = (new Category($this->getDB()));

        $categoryExists = $category->isUnique('name', $_POST['name']);

        if (!empty($categoryExists)) {
            $errors['name'][] = 'Cette catégorie existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/ajouter');
            exit;
        }

        $category->create($_POST);

        // TODO: no return value on insert ??? Why ???
        // if ($category) {
            return header('Location: /admin/categories');
        // }
    }

    public function updateCategory(int $id)
    {
        $category = (new Category($this->getDB()))->findById($id);

        return $this->render('admin/category/form', compact('category'));
    }

    public function updateCategoryPost(int $id)
    {
        $category = (new Category($this->getDB()))->update($id, $_POST);

        //TODO : isUnique + length validation for update category

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
