<?php require "../path.php" ?>
<body>
<div class="wrapper">
    <!----Header (start)---->

    <div class="container-fluid">
        <header class="container-xl">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <h1><a href="<?= MAIN_PAGE . '?page=1' ?>">My blog</a></h1>
                    </div>
                    <nav class="col-8">
                        <ul>
                            <li>
                                <a href="<?= MAIN_PAGE . '?page=1' ?>" class="header-links"><i class="fa-solid fa-house"
                                                                                               style="color: #1f3251;"></i>Main</a>
                            </li>
                            <?php
                            if (isset($_SESSION['login'])){ ?>
                            <li>
                                <a href="../admin/posts/post_index.php"><i class="fa-solid fa-user"
                                                                           style="color: #511f46;"></i>
                                    <?= $_SESSION['login'] ?></a>
                                <ul>
                                    <li>
                                        <a href="../admin/posts/post_index.php"><i class="fa-sharp fa-solid fa-person"
                                                                                   style="color: black;"></i>
                                            Change-data</a>
                                    </li>
                                    <li>

                                        <a href="../log_form/log_out.php" class="header-links"><i
                                                    class="fa-sharp fa-solid fa-plane"
                                                    style="color: #1f5145;"></i>
                                            Log-out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <?php
                        }
                        else { ?>
                            <ul>
                                <li>
                                    <a href="../log_form/Login.php" class="header-links"><i
                                                class="fa-sharp fa-solid fa-plane"
                                                style="color: #1f5145;"></i>Log-in</a>
                                </li>
                                <li>
                                    <a href="../reg_form/Registration_big_project.php" class="header-links"><i
                                                class="fa-sharp fa-solid fa-plane"
                                                style="color: #1f5145;font-size: 10px"></i>Sign-up</a>
                                </li>
                            </ul>
                            <?php
                        } ?>
                    </nav>
                </div>
            </div>
        </header>
    </div>
    <!----Header (end)---->