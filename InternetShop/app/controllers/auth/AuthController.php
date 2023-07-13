<?php

namespace InternetShop\app\controllers\auth;
/**
 * login\logout\register page controller
 */
class AuthController {

    public function login():void
    {
            include_once "app/views/auth/login.php";
    }

    public function register():void
    {
        include_once "app/views/auth/register.php";
    }

    public function store(): void
    {

        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['passwordVerify'])) {
            $authModel = new AuthUser();
            $pass = trim($_POST['password']);
            $passVer = trim($_POST['passwordVerify']);
            $username = trim(htmlspecialchars($_POST['username']));
            $email = trim(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL));

            if (strlen($username) < 4) {
                $_SESSION['err_msg'] = " Username must be > than 3 symbols ";
                header("Location: /" . APP_BASE_PATH . "/auth/register");
                die();
            }
            if ($authModel->findByEmail($email) !== false){
                $_SESSION['err_msg'] = " Such email is already exist! ";
                header("Location: /" . APP_BASE_PATH . "/auth/register");
                die();
            }
            if ($pass !== $passVer) {
                $_SESSION['err_msg'] = " Incorrect password verification ";
                header("Location: /" . APP_BASE_PATH . "/auth/register");
                die();
            } else {
                $userModel = new AuthUser();
                $data =
                    [
                        'username' => $username,
                        'email' => $email,
                        'password' => $pass,
                        'role' => START_ROLE
                    ];
                $userModel->register($data['username'], $data['email'], $data["password"], $data['role']);
                header("Location: /" . APP_BASE_PATH . "/auth/login");
            }
        }
    }

}