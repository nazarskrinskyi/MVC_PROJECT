<?php

session_start();

if (str_starts_with($_SERVER['REQUEST_URI'], "/BIG_PROJECT/admin/")) {
    include "../../path.php";
} else {
    include "../db_code/db_functions.php";
}
// Registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['reg-btn'])) {
    $login = trim(strip_tags($_POST['login']));

    $email = trim(strip_tags($_POST['email']));

    $password = trim(strip_tags($_POST['password']));

    $pass_verify = trim(strip_tags($_POST['pass_verify']));

    function email_checker(string $table): bool
    {
        global $connection;
        $email = trim(strip_tags($_POST['email']));
        $sql = "SELECT * FROM $table where $table.email='$email'";
        $email_check = $connection->query($sql)->fetchAll();
        if (!empty($email_check)) {
            return true;
        } else {
            return false;
        }
    }

    if ($login === '' || $password === '' || $email === '' || $pass_verify === '') {
        $err_msg = "\nSomething is not filled\n";
    } else {
        if (mb_strlen($login, 'UTF-8') < 3) {
            $err_msg = "\nLogin is too short\n";
        } else {
            if ($pass_verify !== $password) {
                $err_msg = "\nIncorrect password in verify field\n";
            } else {
                if (email_checker('users') === true) {
                    $err_msg = "\nSuch email is already exist\n";
                } else {
                    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                    $post_data =
                        [
                            'admin' => "user",
                            'email' => $email,
                            'username' => $login,
                            'password' => $hash_pass
                        ];
                    $last_id = insert(table: 'users', params: $post_data);
                    $user = select('users', ['id' => $last_id]);

                    $_SESSION['id'] = $user[0]["id"];
                    $_SESSION['login'] = $user[0]["username"];
                    $_SESSION['admin'] = $user[0]['admin'];
                    header("location: " . MAIN_PAGE);

                }
            }
        }
    }
}
///LOGIN///
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['log-btn'])) {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    if ($login === '' || $password === '' || $email === '') {
        $err_msg = "\nSomething is not filled\n";
    } else {
        $search = select('users', ['email' => $email, 'username' => $login]);

        if (password_verify($password, $search[0]['password']) and $search) {
            $_SESSION['id'] = $search[0]['id'];
            $_SESSION['login'] = $search[0]['username'];
            $_SESSION['admin'] = $search[0]['admin'];
            header("location: " . MAIN_PAGE);
        } else {
            $err_msg = "\nIncorrect data in fields\n";
        }
    }
}