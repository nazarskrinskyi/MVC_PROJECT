<?php

namespace OOP_CRM\app\controllers\users;

use OOP_CRM\app\models\Check;
use OOP_CRM\app\models\roles\RoleModel;
use OOP_CRM\app\models\users\AuthUser;
use OOP_CRM\app\models\users\UserModel;

class UsersController
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
        $userModel = new UserModel();
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $all_pages = ceil(count($userModel->readAll()) / $limit);
        $users = $userModel->getAllUsersPagination($offset, $limit);
        if ($page > $all_pages || $page < 1) {
            header("Location: /" . APP_BASE_PATH . "/users/index/1");
        }
        include "app/views/users/index.php";
    }

    public function create(): void
    {
        $this->check->requirePermission();
        include "app/views/users/createUser.php";
    }

    public function store(): void
    {
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['passwordVerify'])) {
            $authModel = new AuthUser();
            $pass = trim($_POST['password']);
            $passVer = trim($_POST['passwordVerify']);
            $username = trim(htmlspecialchars($_POST['username']));
            $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
            if (strlen($username) < 4) {
                $_SESSION['err_msg'] = " Username must be > than 3 symbols ";
                header("Location: /" . APP_BASE_PATH . "/users/create");
                die();
            }
            if ($authModel->findByEmail($email) !== false) {
                $_SESSION['err_msg'] = " Such email is already exist! ";
                header("Location: /" . APP_BASE_PATH . "/users/create");
                die();
            }
            if ($pass !== $passVer) {
                $_SESSION['err_msg'] = " Incorrect password verification! ";
                header("Location: /" . APP_BASE_PATH . "/users/create");
                die();
            } else {
                $userModel = new UserModel();
                $data =
                    [
                        'username' => $username,
                        'email' => $email,
                        'password' => $pass,
                        'role' => START_ROLE
                    ];
                $userModel->createUser($data);
                header("Location: /" . APP_BASE_PATH . "/users");

            }
        }
    }

    public function delete(): void
    {
        $this->check->requirePermission();
        $userModel = new UserModel();
        $allId = $userModel->readAllId();

        foreach ($allId as $id){
            if (in_array($_GET['id'],$id)){
                $userModel->deleteUser($_GET['id']);
                header("Location: /" . APP_BASE_PATH . "/users");
                die();
            }
        }
        http_response_code(404);
        include 'app/views/errors/404.php';
    }

    public function edit(): void
    {
        $this->check->requirePermission();
        $userModel = new UserModel();
        $user = $userModel->readUser($_GET['id']);
        if (!$user) {
            http_response_code(404);
            include 'app/views/errors/404.php';
            return;
        }
        $roleClass = new  RoleModel();
        $roles = $roleClass->getAllRoles();
        include_once "app/views/users/editUser.php";
    }

    public function update(): void
    {
        $userModel = new UserModel();
        $authModel = new AuthUser();
        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
        $username = trim(htmlspecialchars($_POST['username']));
        if (strlen($username) < 4) {
            $_SESSION['err_msg'] = " Username must be > than 3 symbols! ";
            header("Location: /" . APP_BASE_PATH . "/users/edit/{$_GET['id']}");
            die();
        }
        $emails = $authModel->findByEmail($email);
        if (!empty($emails) && $emails['id'] != $_GET['id']) {
            $_SESSION['err_msg'] = " Such email is already exist! ";
            header("Location: /" . APP_BASE_PATH . "/users/edit/{$_GET['id']}");
            die();
        }
        if (isset($_POST['role'])) {
            $newRole = trim($_POST['role']);
            $user = $userModel->readUser($_GET['id']);
            if ($user['id'] == $_SESSION['user_id'] && !$this->check->isCurrentUserRole($newRole)) {
                $role = trim(filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT));
                $userModel->updateUser($_GET['id'], $email, $role, $username);
                header("Location: /" . APP_BASE_PATH . "/auth/logout");
                exit();
            }
        }
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['role'])) {
            $role = trim(filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT));
            $userModel->updateUser($_GET['id'], $email, $role, $username);
            header("Location: /" . APP_BASE_PATH . "/users");
        }
    }
}