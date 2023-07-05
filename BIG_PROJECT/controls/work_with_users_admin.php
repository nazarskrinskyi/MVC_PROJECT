<?php

error_reporting(E_ALL & ~E_WARNING);
require_once "../../db_code/db_functions.php";

function email_checker(string $table, $id = null): bool
{
    global $connection;
    $email = trim(strip_tags($_POST['email']));
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['user_create'])) {
        $sql = "SELECT * FROM $table where $table.email='$email'";
        $email_check = $connection->query($sql)->fetchAll();
        if (!empty($email_check)) {
            return true;
        } else {
            return false;
        }
    } else {
        $sql = "SELECT * FROM $table where $table.email='$email' and $table.id <> '$id'";
        $email_check = $connection->query($sql)->fetchAll();
        foreach ($email_check as $value) {
            if ($value['email'] == $email) {
                $check = true;
            }
        }
        if (isset($check)) {
            return true;
        } else {
            return false;
        }
    }

}

//////////CREATE USER////////////////
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['user_create'])) {
    $username = trim($_POST['login']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $pass_verify = trim(strip_tags($_POST['pass_verify']));
    $status = $_POST['status'];

    if ($username === '' || $email === '' || $password === '' || $status === '') {
        $err_msg = "\nSomething is not filled\n";
    } else {
        if (mb_strlen($username, 'UTF-8') < 2) {
            $err_msg = "\nUsername is too short\n";
        } else {
            if (email_checker('users') === true) {
                $err_msg = "\nSuch email address is used by another user\n";
            } else {
                if ($pass_verify !== $password) {
                    $err_msg = "\nIncorrect password in verify field\n";
                } else {
                    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                    $user_data =
                        [
                            'username' => $username,
                            'email' => $email,
                            "password" => $hash_pass,
                            "admin" => $status
                        ];
                    $_SESSION['admin'] = $status;
                    $last_user = insert(table: 'users', params: $user_data);
                    $user = select('users', ['id' => $last_user]);
                    header("location: http://localhost/BIG_PROJECT/admin/users/user_index.php?res=created");
                }
            }
        }
    }
}
/////////////CREATE USER(END)////////////////


///////////////EDIT USER////////////////
if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = $user[0]['id'];
    $login = $user[0]['username'];
    $status = $user[0]['admin'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['user_edit'])) {
    $users = select_all('users');
    $username = trim($_POST['login']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $status = $_POST['status'];
    $id = $_POST['id'];


    if ($username === '' || $email === '' || $password === '' || $status === '') {
        $err_msg = "\nSomething is not filled\n";
    } else {
        for ($i = 0; $i < count($users); $i++) {
            if ($users[$i]["username"] === $username and $users[$i]['email'] === $email and $users[$i]['admin'] === $status and password_verify(
                    $password,
                    $users[$i]['password']) === true) {
                $err_msg = "\nYou didn't modify user\n";
                $check = false;
            }
        }
        if (mb_strlen($username, 'UTF-8') < 2) {
            $err_msg = "\nUsername is too short\n";
        } else {
            if (email_checker('users', $id) === true) {
                $err_msg = "\nSuch email address is used by another user\n";
            } else {
                if (!isset($check)) {
                    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                    $user_data =
                        [
                            'username' => $username,
                            'email' => $email,
                            "admin" => $status,
                            "password" => $hash_pass
                        ];
                    $_SESSION['admin'] = $status;
                    update('users', $id, $user_data);
                    header("location: http://localhost/BIG_PROJECT/admin/users/user_index.php?res=edited");
                }
            }
        }
    }
}
/*/////////////EDIT USER(END)*************/


/*//////////////DELETE USER////////////////*/
if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    delete('users', $id);
    header("location: http://localhost/test.loc/BIG_PROJECT/admin/users/user_index.php?res=deleted");
}
/*//////////////DELETE USER(END)////////////////*/