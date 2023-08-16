<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use Database\DBConnection;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class CategoryController extends AbstractController
{
    protected $user;
    protected $userModel;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        if ($this->isAuth()) {
            $this->userModel = new User($this->getDB());
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            return header('Location: /connexion');
        }

        $this->isAdmin($this->user);
    }
    
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
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'name' => ['required', 'min:2'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/ajouter');
            exit;
        }
        
        $categoryModel = (new Category($this->getDB()));

        // Back end validation
        $categoryExists = $categoryModel->isUnique('name', $_POST['name']);

        if ($categoryExists) {
            $errors['name'][] = 'Cette catégorie existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/ajouter');
            exit;
        }

        // Category create
        $categoryModel->create($_POST);

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
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'name' => ['required', 'min:2'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/ajouter');
            exit;
        }

        $categoryModel = (new Category($this->getDB()));

        // Back end validation
        $categoryExists = $categoryModel->isUnique('name', $_POST['name']);

        if ($categoryExists) {
            $errors['name'][] = 'Cette catégorie existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/modifier/' . $id);
            exit;
        }

        // TODO: add warning if category has associated questions as it will change the category of the questions too

        // Category update
        $category = $categoryModel->update($id, $_POST);

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
