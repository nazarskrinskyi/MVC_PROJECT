<?php

namespace OOP_CRM\app\controllers\pages;

use OOP_CRM\app\models\Check;
use OOP_CRM\app\models\pages\PageModel;
use OOP_CRM\app\models\roles\RoleModel;

class PageController
{
    private Check $check;

    public function __construct()
    {
        $userRole = $_SESSION['user_role'] ?? null;
        $this->check = new Check($userRole);
    }

    public function index(): void
    {
        $this->check->requirePermission();
        $pageModel = new PageModel();
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        if ($page == 1) $offset = 5;
        else $offset = $limit * $page;
        $all_pages = ceil(count($pageModel->getAllPages()) / $limit) - 1;
        $pages = $pageModel->getAllPagesPagination($offset, $limit);
        if ($page > $all_pages || $page < 1) {
            header("Location: /" . APP_BASE_PATH . "/pages/index/1");
        }
        else include_once "app/views/pages/index.php";
    }


    public function create(): void
    {
        $this->check->requirePermission();
        $roleModel = new RoleModel();
        $roles = $roleModel->getAllRoles();
        include_once "app/views/pages/createPage.php";
    }

    public function store(): void
    {
        if (isset($_POST['title']) && isset($_POST['slug']) && count($_POST['roles']) > 0) {
            $title = trim(htmlspecialchars($_POST['title']));
            $slug = trim(htmlspecialchars($_POST['slug']));
            if (count($_POST['roles']) > 1) {
                $roles = implode(',', $_POST['roles']);
            } else {
                $roles = implode('', $_POST['roles']);
            }
            $pageModel = new PageModel();
            $pageModel->createPage($title, $slug, $roles);
            header("Location: /" . APP_BASE_PATH . "/pages/index");
        }
    }

    public function delete(): void
    {
        $this->check->requirePermission();
        $pageModel = new PageModel();
        $allId = $pageModel->readAllId();
        foreach ($allId as $id) {
            if (in_array($_GET['id'], $id)) {
                $pageModel->deletePage((int)$_GET['id']);
                header("Location: /" . APP_BASE_PATH . "/pages/index");
                die();
            }
        }
        http_response_code(404);
        include 'app/views/errors/404.php';
    }

    public function edit(): void
    {
        $this->check->requirePermission();
        $pageModel = new PageModel();
        $page = $pageModel->getPageById((int)$_GET['id']);
        if (!$page) {
            http_response_code(404);
            include 'app/views/errors/404.php';
            die();
        }
        $roleModel = new RoleModel();
        $roles = $roleModel->getAllRoles();
        include_once "app/views/pages/editPage.php";
    }

    public function update(): void
    {
        $title = trim(htmlspecialchars($_POST['title']));
        $slug = trim(htmlspecialchars($_POST['slug']));

        if (count($_POST['roles']) > 1) {
            $roles = implode(',', $_POST['roles']);
        } else {
            $roles = implode('', $_POST['roles']);
        }
        $pageModel = new PageModel();
        $check = $pageModel->getPageBySlugCheck($slug, $_GET['id']);
        if (!empty($check)) {
            $_SESSION['err_msg'] = " Such slug is already exist! ";
            header("Location: /" . APP_BASE_PATH . "/pages/edit/{$_GET['id']}");
            die();
        }
        $pageModel->updatePage($title, $slug, $roles, $_GET['id']);

        header("Location: /" . APP_BASE_PATH . "/pages/index");
    }
}