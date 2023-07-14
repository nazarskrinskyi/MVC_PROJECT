<?php

namespace OOP_CRM\app\controllers\todo\category;

use OOP_CRM\app\models\Check;
use OOP_CRM\app\models\todo\category\CategoryModel;

class CategoryController
{
    private Check $check;
    public function __construct()
    {
        $userRole    = filter_var($_SESSION['user_role'], FILTER_SANITIZE_NUMBER_INT) ?? null;
        $this->check = new Check($userRole);
    }
    public function index(): void
    {
        $this->check->requirePermission();
        $categoryModel = new CategoryModel();
        $categories    = $categoryModel->getAllCategories();
        include_once "app/views/todo/category/index.php";
    }

    public function create(): void
    {
        $this->check->requirePermission();
        include_once "app/views/todo/category/createCategory.php";
    }

    public function store(): void
    {
        if (isset($_POST['title']) && isset($_POST['description'])) {

            $title = trim(htmlspecialchars($_POST['title']));
            $desc  = trim(htmlspecialchars($_POST['description']));
            $user  = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT) ?? 0;
            $categoryModel = new CategoryModel();
            $categoryModel->createCategory($title, $desc, $user);
            header("Location: /" . APP_BASE_PATH . "/todo/category");
        }
    }

    public function delete(): void
    {
        $this->check->requirePermission();
        $categoryModel = new CategoryModel();
        $allId = $categoryModel->readAllId();
        foreach ($allId as $id){
            if (in_array($_GET['id'],$id)){
                $categoryModel->deleteCategory((int)$_GET['id']);
                header("Location: /" . APP_BASE_PATH . "/todo/category");
                die();
            }
        }
        http_response_code(404);
        include 'app/views/errors/404.php';
    }

    public function edit(): void
    {
        $this->check->requirePermission();
        $categoryModel = new CategoryModel();
        $category = $categoryModel->getCategoryById($_GET['id']);
        if (!$category){
            http_response_code(404);
            include 'app/views/errors/404.php';
            return;
        }
        include_once "app/views/todo/category/editCategory.php";
    }

    public function update(): void
    {
        if (isset($_POST['title']) && isset($_POST['description'])) {
            $title = trim(htmlspecialchars($_POST['title']));
            $desc  = trim(htmlspecialchars($_POST['description']));
            $usability = (int) filter_var($_POST['usability'], FILTER_SANITIZE_NUMBER_INT) ?? 0;
            $categoryModel = new CategoryModel();
            $check = $categoryModel->getCategoryByTitle($title, $_GET['id']);
            if (!empty($check)){
                $_SESSION['err_msg'] = " Such category title is already exist! ";
                header("Location: /" . APP_BASE_PATH . "/todo/category/edit/{$_GET['id']}" );
                die();
            }
            $categoryModel->updateCategory($title, $desc, $usability, $_GET['id']);
            header("Location: /" . APP_BASE_PATH . "/todo/category");
        }
    }

}