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
    include "../../controls/work_with_posts_admin.php";

    ?>
    <main>
        <div class="container">
            <div class="row">
                <?php
                if (file_exists("../../includes/sidebar_admin.php"))
                    include "../../includes/sidebar_admin.php" ?>

                <div class="posts col-8">
                    <?php
                    if (isset($err_msg)) { ?>
                        <div class="form-error">
                            <h4><i class="fa-solid fa-triangle-exclamation" style="color: black"></i><?= $err_msg ?><i
                                        class="fa-solid fa-triangle-exclamation" style="color: black"></i></h4>
                        </div>
                        <?php
                    } ?>
                    <hr>
                    <h1>Actions With Posts</h1>
                    <hr>
                    <div class="button row  col-13 justify-content-center">
                        <a href="create.php" class="btn btn-success col-4">Add Post</a>
                        <span class="col-1"></span>
                        <a href="post_index.php" class="btn btn-warning col-4">Manage Posts</a>
                    </div>
                    <hr>
                    <h1>Add Post</h1>
                    <hr>
                    <div class="row add-post">
                        <form action="create.php" method="post" enctype="multipart/form-data">
                            <div class="col">
                                <input type="text" name="title" class="form-control" placeholder="Title Name"
                                       aria-label="Title name">
                            </div>
                            <div class="col">
                                <label for="editor"></label>
                                <textarea name="content" placeholder="Post value" class="form-control textarea-post"
                                          id="editor"
                                          rows="5"></textarea>
                            </div>
                            <div class="input-group col">
                                <input type="file" name="img" class="form-control" id="InputGroupFile02">
                                <label class="input-group-text" for="InputGroupFile02">Upload</label>
                            </div>
                            <select class="form-select mb-3" aria-label="Default select example" name="topics">
                                <option selected>Choose category</option>
                                <?php
                                $topics = select_all('topics');
                                foreach ($topics as $key => $topic):?>
                                    <option value="<?= $topic['id'] ?>"><?= $topic['name'] ?></option>
                                <?php
                                endforeach; ?>
                            </select>
                            <label>
                                <input type="checkbox" class="form-check-input" name="publish" value="published"
                                       style="cursor: pointer" checked> Publish
                            </label>
                            <div class="col-12">
                                <button type="submit" name="post_create" class="btn btn-primary">Add Post</button>
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
    header("Location: ../pages/main.php");
}
?>
