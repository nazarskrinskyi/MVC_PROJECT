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
    <link rel="stylesheet" href="../css/For-project.css">
    <link rel="stylesheet" href="../bootstrap5/bootstrap.css">


    <title>BLOG</title>
</head>
<?php

error_reporting(E_ALL & ~E_WARNING);
if (file_exists("../includes/header.php")) {
    require_once "../includes/header.php";
}
require_once "../controls/work_with_form_data.php"

?>

<!---------FORM(start)-------------->
<div class="wrapper-2">

    <div class="container reg-form">
        <h1>Login</h1>
        <?php
        if (isset($success)):?>
            <div class="form-success">
                <h2><i class="fa-solid fa-champagne-glasses"></i><?= $success ?><i
                            class="fa-solid fa-face-smile-wink"></i></h2>
            </div>
        <?php endif; ?>

        <?php if (!empty($err_msg)): ?>
            <div class=" form-error">
                <h2><i class="fa-solid fa-triangle-exclamation" style="color: black"></i><?= $err_msg ?><i
                            class="fa-solid fa-triangle-exclamation" style="color: black"></i></h2>
            </div>
        <?php endif; ?>

        <form class="row justify-content-center" method="post" action="../log_form/Login.php">
            <div class="mb-3 col-12 col-md-6">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input placeholder="Your email..." type="email" class="form-control" id="exampleInputEmail1"
                       aria-describedby="emailHelp" name="email">
            </div>
            <div class="w-100"></div>
            <div class="mb-3 col-12 col-md-6">
                <label for="formGroupExampleInput" class="form-label">Login</label>
                <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Your login..."
                       name="login">
            </div>
            <div class="w-100"></div>

            <div class="mb-3 col-12 col-md-6">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input placeholder="Your password..." type="password" class="form-control" id="exampleInputPassword1"
                       name="password">
            </div>
            <div class="w-100"></div>
            <button class=" btn btn-outline-danger reg-btn " name="log-btn">Login</button>
            <a href="../reg_form/Registration_big_project.php" class="btn btn-outline-success">Registry</a>

        </form>
    </div>
    <!---------FORM(end)---------------->

    <?php
    if (file_exists("../includes/footer.php")) {
        require_once "../includes/footer.php";
    }
    ?>
</div>

