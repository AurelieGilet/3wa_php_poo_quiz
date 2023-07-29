<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Controllers\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * Route: /admin/categories
     */
    public function index()
    {
        $categories = (new Category($this->getDB()))->getAll();

        $flashes = $this->flashMessage->getFlashMessages('category');

        return $this->render('admin/category/index', compact('categories', 'flashes'));
    }

    /**
     * Route: /admin/categorie/ajouter
     */
    public function createCategory()
    {
        return $this->render('admin/category/form');
    }

    public function createCategoryPost()
    {
        //TODO: isUnique + length validation for create category
        
        $category = (new Category($this->getDB()));

        $categoryExists = $category->isUnique('name', $_POST['name']);

        if (!empty($categoryExists)) {
            $errors['name'][] = 'Cette catégorie existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/ajouter');
            exit;
        }

        $category->create($_POST);

        $this->flashMessage->createFlashMessage(
            'category',
            'La catégorie ' . $_POST['name'] . ' a bien été créée',
            $this->flashMessagesConstants::FLASH_SUCCESS,
        );

        // FIXME: no return value on insert ??? Why ???
        // if ($category) {
            return header('Location: /admin/categories');
        // }
    }

    /**
     * Route: /admin/categorie/modifier/:id
     */
    public function updateCategory(int $id)
    {
        $category = (new Category($this->getDB()))->findById($id);

        return $this->render('admin/category/form', compact('category'));
    }

    public function updateCategoryPost(int $id)
    {
        $category = (new Category($this->getDB()))->update($id, $_POST);

        //TODO: isUnique + length validation for update category

        if ($category) {
            $this->flashMessage->createFlashMessage(
                'category',
                'La catégorie a bien été modifiée',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            return header('Location: /admin/categories');
        } else {
            $this->flashMessage->createFlashMessage(
                'category',
                'La catégorie n\'a pas été modifiée, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            return header('Location: /admin/categories');
        }
    }

    /**
     * Route: /admin/categorie/supprimer/:id
     */
    public function deleteCategory(int $id)
    {
        // TODO: prevent delete if questions associated to category
        // TODO: add delete confirmation procedure
        $category = (new Category($this->getDB()))->delete($id);

        if ($category) {
            $this->flashMessage->createFlashMessage(
                'category',
                'La catégorie a bien été supprimée',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            return header('Location: /admin/categories');
        } else {
            $this->flashMessage->createFlashMessage(
                'category',
                'La catégorie n\'a pas été supprimée, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            return header('Location: /admin/categories');
        }
    }
}
