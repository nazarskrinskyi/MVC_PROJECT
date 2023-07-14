<!doctype html>
<html lang="en">
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/<?= APP_BASE_PATH ?>/css/style.css">
    <script src="https://kit.fontawesome.com/66d450dc17.js" crossorigin="anonymous"></script>
</head>
<body>

<?php if ($_SESSION['is_admin'] != 1): ?>

    <header>
        <nav id="header" class="header row p-2">
            <div class="custom-menu d-flex align-items-stretch">
                <button type="button" onclick="openNav()" id="sidebarCollapse" class="open-btn btn btn-dark icon">
                    <i class=" fas fa-bars" style="color: white;font-size: 35px"></i>
                </button>
                <a href="/<?= APP_BASE_PATH ?>"><i class="icon fa-sharp fa-solid fa-shop"
                                                   style="color: white;font-size: 35px;"></i></a>
                <h1 class="header-title text-white " style="font-family: American Typewriter, cursive">MY SHOP</h1>
                <div class="icon input-group mb-3">
                    <input type="text" class="form-control" placeholder="I am searching..."
                           aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary pb-2 text-white" type="button">Button</button>
                    </div>
                </div>

                <a href="/<?= APP_BASE_PATH ?>/auth/login/">
                    <i class="icon fa-solid fa-user" style="color: white;font-size: 35px;"></i>
                </a>
                <a href="#"><i class="icon fas fa-shopping-cart" style="color: white;font-size: 35px;"></i></a>
            </div>
        </nav>
    </header>

    <main class="body">
        <div class="wrapper">
            <div id="sidebar" class="sidebar">
                <a href="/<?= APP_BASE_PATH ?>" class="home-link"><i class="icon fa-sharp fa-solid fa-house"
                                                                     style="color: white;font-size: 40px;"></i></a>
                <h1 class="p-4 text-danger">MENU</h1>
                <ul>
                    <li></li>
                </ul>
                <a href="javascript:void(0)" class="close-btn text-white" id="closeSidebar" onclick="closeNav()">×</a>
            </div>

            <div id="main" class="main-content">
                <?= $content ?>
            </div>
        </div>
    </main>

<?php else: ?>

    <div class="row">
        <div class="sidebar col-md-3">
            <div class=" d-flex flex-column text-white bg-dark" style="min-height: 950px;">
                <a href="/<?= APP_BASE_PATH ?>/" class="header-title text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="20">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <h1 class="text-center">ADMIN</h1>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li>
                        <a href="/<?= APP_BASE_PATH ?>/users/index/"
                           class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/users/index/') ?>">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="/<?= APP_BASE_PATH ?>/users/index/"></use>
                            </svg>
                            Users
                        </a>
                    </li>

                    <li>
                        <a href="/<?= APP_BASE_PATH ?>/roles/"
                           class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/roles/') ?>">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="/<?= APP_BASE_PATH ?>/roles/"></use>
                            </svg>
                            Roles
                        </a>
                    </li>

                    <li>
                        <a href="/<?= APP_BASE_PATH ?>/pages/index/"
                           class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/pages/index/') ?>">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="/<?= APP_BASE_PATH ?>/pages/index/"></use>
                            </svg>
                            Pages
                        </a>
                    </li>

                    <li>
                        <a href="/<?= APP_BASE_PATH ?>/categories/"
                           class="nav-link text-white <?= is_active('/' . APP_BASE_PATH . '/categories/') ?>">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="/<?= APP_BASE_PATH ?>/categories/"></use>
                            </svg>
                            Categories
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown p-2">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                       id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong><?= $_SESSION['username'] ?></strong>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/<?= APP_BASE_PATH ?>/auth/logout/">Sign out</a></li>
                        <li><a class="dropdown-item" href="/<?= APP_BASE_PATH ?>/auth/login/">Sign in</a></li>
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

<?php endif; ?>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
