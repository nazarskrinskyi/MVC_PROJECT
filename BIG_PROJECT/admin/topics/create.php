<?php include "../../controls/work_with_categories_admin.php" ?>
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
                <?php if (file_exists("../../includes/sidebar_admin.php")) include "../../includes/sidebar_admin.php" ?>
                <div class="topics col-9">
                    <?php if (!empty($err_msg)): ?>
                        <div class="form-error">
                            <h4><i class="fa-solid fa-triangle-exclamation" style="color: black"></i><?= $err_msg ?><i
                                        class="fa-solid fa-triangle-exclamation" style="color: black"></i></h4>
                        </div>
                    <?php endif; ?>

                    <hr>
                    <h1>Actions With Category</h1>
                    <hr>
                    <div class="button row col-13 justify-content-center">
                        <a href="create.php" class="btn btn-success col-5">Add Category</a>
                        <span class="col-1"></span>
                        <a href="topic_index.php" class="btn btn-warning col-5">Manage Category</a>
                    </div>
                    <hr>
                    <h1>Add Category</h1>
                    <hr>
                    <div class="row add-post">
                        <form action="create.php" method="post">
                            <div class="col">
                                <input name="name" type="text" class="form-control" placeholder="Category Name"
                                       aria-label="Category name">
                            </div>
                            <div class="col textarea-category">
                                <label for="content" class="form-label"></label>
                                <textarea name="description" class="form-control" rows="3"
                                          placeholder="Category description"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="topic_create">Add Category</button>
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
