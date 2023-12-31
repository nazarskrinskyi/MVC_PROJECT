<?php
$user_name = $_SESSION['username'] ?? 'login';
$user_role = $_SESSION['user_role'] ?? false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/<?= APP_BASE_PATH ?>/app/css/style.css">
    <script src="https://kit.fontawesome.com/6e56039614.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
</head>
<body>
<div class="row">
    <div class="sidebar col-md-3">
        <div class=" d-flex flex-column text-white bg-dark" style="min-height: 950px;">
            <a href="/<?= APP_BASE_PATH ?>" class="header-title text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="20">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <h1 class="text-center">Mini CRM</h1>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <?php if ($user_role == 5): ?>
                <li class="nav-item">
                    <a href="/<?= APP_BASE_PATH ?>/"
                       class="nav-link text-white<?= is_active('/' . APP_BASE_PATH . "/") ?>" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="/<?= APP_BASE_PATH ?>/"></use>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <a href="/<?= APP_BASE_PATH ?>/users/index"
                       class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/users/index') ?>">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="/<?= APP_BASE_PATH ?>/users/index"></use>
                        </svg>
                        Users
                    </a>
                </li>
                <li>
                    <a href="/<?= APP_BASE_PATH ?>/roles"
                       class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/roles') ?>">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="/<?= APP_BASE_PATH ?>/roles"></use>
                        </svg>
                        Roles
                    </a>
                </li>
                <li>
                    <a href="/<?= APP_BASE_PATH ?>/pages/index"
                       class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/pages/index') ?>">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="/<?= APP_BASE_PATH ?>/pages/index"></use>
                        </svg>
                        Pages
                    </a>
                </li>
                <hr>
                <?php endif ?>

                <h4 class="text-center text-danger font-monospace">Todo List</h4>
                <hr>
                <li>
                    <a href="/<?= APP_BASE_PATH ?>/todo/category"
                       class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/todo/category') ?>">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="/<?= APP_BASE_PATH ?>/todo/category"></use>
                        </svg>
                        Categories
                    </a>
                </li>
                <li>
                    <a href="/<?= APP_BASE_PATH ?>/todo/tasks/completed"
                       class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/todo/tasks/completed') ?>">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="/<?= APP_BASE_PATH ?>/todo/tasks/completed"></use>
                        </svg>
                        Tasks-(completed)
                    </a>
                </li>
                <li>
                    <a href="/<?= APP_BASE_PATH ?>/todo/tasks"
                       class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/todo/tasks') ?>">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="/<?= APP_BASE_PATH ?>/todo/tasks"></use>
                        </svg>
                        Tasks-(opened)
                    </a>
                </li>
                <li>
                    <a href="/<?= APP_BASE_PATH ?>/todo/tasks/expired"
                       class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/todo/tasks/expired') ?>">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="/<?= APP_BASE_PATH ?>/todo/tasks/expired"></use>
                        </svg>
                        Tasks-(expired)
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown p-2">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                   id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong><?=$user_name?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="/<?= APP_BASE_PATH ?>/auth/logout">Sign out</a></li>
                    <li><a class="dropdown-item" href="/<?= APP_BASE_PATH ?>/auth/login">Sign in</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="article col-md-9">
        <div class="container mt-4">
            <?php echo $content; ?>
        </div>
    </div>
</div>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>