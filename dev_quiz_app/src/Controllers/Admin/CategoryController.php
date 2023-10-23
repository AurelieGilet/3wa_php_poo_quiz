<?php

namespace App\Controllers\Admin;

use Database\DBConnection;
use App\Services\Validation\Validator;
use App\Controllers\AbstractController;

class CategoryController extends AbstractController
{
    protected $user;

    public function __construct(DBConnection $db)
    {
        parent::__construct($db);

        if ($this->isAuth()) {
            $this->user = $this->userModel->findById($_SESSION['user']);
        } else {
            header('Location: /connexion');
            exit;
        }

        $this->isAdmin($this->user);
    }
    
    /**
     * Route: /admin/categories
     */
    public function index()
    {
        // Pagination
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $index = ($currentPage - 1) * $limit;

        $categories = $this->categoryModel->getPaginatedCategories($index, $limit);

        $totalCategories = $this->categoryModel->countAll();
        $totalPages = ceil($totalCategories / $limit);

        $flashes = $this->flashMessage->getFlashMessages('category');

        return $this->render('admin/category/index', compact('categories', 'currentPage', 'totalPages', 'flashes'));
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
        
        // Back end validation
        $categoryExists = $this->categoryModel->isUnique('name', $_POST['name']);

        if ($categoryExists) {
            $errors['name'][] = 'Cette catégorie existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/ajouter');
            exit;
        }

        // Category create
        $this->categoryModel->create($_POST);

        $this->flashMessage->createFlashMessage(
            'category',
            'La catégorie ' . $_POST['name'] . ' a bien été créée',
            $this->flashMessagesConstants::FLASH_SUCCESS,
        );

        header('Location: /admin/categories');
        exit;
    }

    /**
     * Route: /admin/categorie/modifier/:id
     */
    public function updateCategory(mixed $id)
    {
        // Check if id is really an int and exists in DB (protect against url modifications)
        $this->redirectIfWrongId($id, 'category', 'categoryModel', '/admin/categories');

        $category = $this->categoryModel->findById($id);

        return $this->render('admin/category/form', compact('category'));
    }

    public function updateCategoryPost(mixed $id)
    {
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'name' => ['required', 'min:2'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/modifier/' . $id);
            exit;
        }

        // Check if id is really an int and exists in DB (protect against form action modifications)
        $this->redirectIfWrongId($id, 'category', 'categoryModel', '/admin/categories');

        // Back end validation
        $categoryExists = $this->categoryModel->isUnique('name', $_POST['name']);

        if ($categoryExists && $categoryExists->getId() !== $id) {
            $errors['name'][] = 'Cette catégorie existe déjà';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/modifier/' . $id);
            exit;
        }

        // Category update
        $category = $this->categoryModel->update($id, $_POST);

        if ($category) {
            $this->flashMessage->createFlashMessage(
                'category',
                'La catégorie a bien été modifiée',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            header('Location: /admin/categories');
            exit;
        } else {
            $this->flashMessage->createFlashMessage(
                'category',
                'La catégorie n\'a pas été modifiée, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            header('Location: /admin/categories');
            exit;
        }
    }

    /**
     * Route: /admin/categorie/supprimer/:id
     */
    public function deleteCategory(mixed $id)
    {
        // Check if id is really an int and exists in DB (protect against url modifications)
        $this->redirectIfWrongId($id, 'category', 'categoryModel', '/admin/categories');

        $category = $this->categoryModel->findById($id);

        $questions = $this->questionModel->findByCategory($id);

        return $this->render('admin/category/delete-category-form', compact('category', 'questions'));
    }

    public function deleteCategoryPost(mixed $id)
    {
        $validator = new Validator($_POST);

        // Front end validation
        $errors = $validator->validate([
            'adminPassword' => ['required'],
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/supprimer/' . $id);
            exit;
        }

        // Password check
        if (!password_verify($_POST['adminPassword'], $this->user->getPassword())) {
            $errors['adminPassword'][] = 'Ce n\'est pas le bon mot de passe';
            $_SESSION['errors'][] = $errors;
            header('Location: /admin/categorie/supprimer/' . $id);
            exit;
        }

        // Check if id is really an int and exists in DB (protect against form action modifications)
        $this->redirectIfWrongId($id, 'category', 'categoryModel', '/admin/categories');

        // Delete category (delete associated questions and answers by cascade)
        $category = $this->categoryModel->delete($id);

        if ($category) {
            $this->flashMessage->createFlashMessage(
                'category',
                'La catégorie a bien été supprimée',
                $this->flashMessagesConstants::FLASH_SUCCESS,
            );

            header('Location: /admin/categories');
            exit;
        } else {
            $this->flashMessage->createFlashMessage(
                'category',
                'La catégorie n\'a pas été supprimée, une erreur s\'est produite',
                $this->flashMessagesConstants::FLASH_ERROR,
            );

            header('Location: /admin/categories');
            exit;
        }
    }
}
