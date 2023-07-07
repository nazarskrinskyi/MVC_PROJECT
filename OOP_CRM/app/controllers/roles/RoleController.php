<?php

namespace OOP_CRM\app\controllers\roles;

use OOP_CRM\app\models\Check;
use OOP_CRM\app\models\roles\RoleModel;

class RoleController
{
    private $check;
    public function __construct()
    {
        $userRole = $_SESSION['user_role'] ?? null;
        $this->check = new Check($userRole);
    }
    public function index(): void
    {
        $this->check->requirePermission();
        $roleModel = new RoleModel();
        $roles = $roleModel->getAllRoles();
        include_once "app/views/roles/index.php";
    }

    public function create(): void
    {
        $this->check->requirePermission();
        include_once "app/views/roles/createRole.php";
    }

    public function store(): void
    {
        if (isset($_POST['roleName']) && isset($_POST['roleDescription'])) {
            $roleName = trim(htmlspecialchars($_POST['roleName']));
            $roleDesc = trim(htmlspecialchars($_POST['roleDescription']));
            $roleModel = new RoleModel();
            $roleModel->createRole($roleName, $roleDesc);
            header("Location: /" . APP_BASE_PATH . "/roles");

        }
    }

    public function delete(): void
    {
        $this->check->requirePermission();
        $roleModel = new RoleModel();
        $allId = $roleModel->readAllId();
        foreach ($allId as $id){
            if (in_array($_GET['id'],$id)){
                $roleModel->deleteRole((int)$_GET['id']);
                header("Location: /" . APP_BASE_PATH . "/roles");
                die();
            }
        }
        http_response_code(404);
        include 'app/views/errors/404.php';
    }

    public function edit(): void
    {
        $this->check->requirePermission();
        $roleModel = new RoleModel();
        $role = $roleModel->getRoleById((int)$_GET['id']);
        if (!$role){
            http_response_code(404);
            include 'app/views/errors/404.php';
            return;
        }
        include_once "app/views/roles/editRole.php";
    }

    public function update(): void
    {
        if (isset($_POST['roleName']) && isset($_POST['roleDescription'])) {
            $roleName = trim(htmlspecialchars($_POST['roleName']));
            $roleDesc = trim(htmlspecialchars($_POST['roleDescription']));
            $roleModel = new RoleModel();
            $check = $roleModel->getAllRolesByName($roleName, $_GET['id']);
            if (!empty($check)){
                $_SESSION['err_msg'] = " Such role is already exist! ";
                header("Location: /" . APP_BASE_PATH . "/roles/edit/{$_GET['id']}" );
                die();
            }
            $roleModel->updateRole($roleName,$roleDesc,$_GET['id']);
            header("Location: /" . APP_BASE_PATH . "/roles");
        }
    }

}