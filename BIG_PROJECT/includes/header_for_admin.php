<?php

session_start();

include "../../path.php";

?>

<body>
<div class="wrapper-2">
    <!----Header (start)---->

    <div class="container-fluid">
        <header class="container-xl">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <h1><a href="<?= MAIN_PAGE ?>">My blog</a></h1>
                    </div>
                    <nav class="col-8">
                        <?php
                        if (isset($_SESSION['login'])) { ?>
                            <ul>
                                <li>
                                    <a href="../posts/post_index.php"><i class="fa-solid fa-user"
                                                                         style="color: #511f46;"></i>
                                        <?= $_SESSION['login'] ?></a>
                                </li>
                                <li>
                                    <a class="log_out" href="../../log_form/log_out.php"><i
                                                class="fa-sharp fa-solid fa-plane" style="color: #1f5145;"></i>
                                        Log-out</a>
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