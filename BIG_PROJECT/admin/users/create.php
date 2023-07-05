<?php include "../../controls/work_with_users_admin.php" ?>


<!doctype html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/66d450dc17.js" crossorigin="anonymous"></script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/For-admin.css">
    <link rel="stylesheet" href="../../bootstrap5/bootstrap.css">

    <title>BLOG</title>
</head>
<?php


include "../../includes/header_for_admin.php";

?>
<?php
if (isset($_SESSION['admin']) and $_SESSION['admin'] == 'admin') {

    ?>
    <main>
        <div class="container">
            <div class="row">
                <?php
                if (file_exists("../../includes/sidebar_admin.php")) include "../../includes/sidebar_admin.php" ?>

                <div class="topics col-9">
                    <?php if (!empty($err_msg)): ?>
                        <div class="form-error">
                            <h4><i class="fa-solid fa-triangle-exclamation" style="color: black"></i><?= $err_msg ?><i
                                        class="fa-solid fa-triangle-exclamation" style="color: black"></i></h4>
                        </div>
                    <?php endif; ?>
                    <hr>
                    <h1>Actions With Users</h1>
                    <hr>
                    <div class="button row col-13 justify-content-center">
                        <a href="create.php" class="btn btn-success col-4">Add User</a>
                        <span class="col-1"></span>
                        <a href="user_index.php" class="btn btn-warning col-4">Manage User</a>
                    </div>
                    <hr>
                    <h1>Create User</h1>
                    <hr>
                    <div class="row add-post">
                        <form action="create.php" method="post">
                            <div class="col">
                                <label for="formGroupExampleInput" class="form-label">Login</label>
                                <input type="text" class="form-control" id="formGroupExampleInput"
                                       placeholder="Your login..."
                                       name="login">
                            </div>

                            <div class="col">
                                <label for="formGroupExampleInput" class="form-label">Email</label>
                                <input type="email" class="form-control" id="formGroupExampleInput"
                                       placeholder="Your email..."
                                       name="email">
                            </div>

                            <div class="col">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input placeholder="Your password..." type="password" class="form-control"
                                       id="exampleInputPassword1"
                                       name="password">
                            </div>

                            <div class="col">
                                <label for="exampleInputPassword1" class="form-label">Password Verify</label>
                                <input placeholder="password verify..." type="password" class="form-control"
                                       id="exampleInputPassword1"
                                       name="pass_verify">
                            </div>
                            <h6>Status</h6>
                            <select class="form-select col w-100" aria-label="Default select example" name="status">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>

                            <div class="col">
                                <button type="submit" class="btn btn-primary" name="user_create">Create User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    require "../../includes/footer_for_admin.php";
} else {
    header("Location: " . MAIN_PAGE);

}
?>

