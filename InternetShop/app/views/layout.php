<!doctype html>
<html lang="en">
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/<?= APP_BASE_PATH ?>/css/style.css">
    <script src="https://kit.fontawesome.com/66d450dc17.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
    <nav id="header" class="header row p-2">
        <div class="custom-menu d-flex align-items-stretch">
            <button type="button" onclick="openNav()" id="sidebarCollapse" class="open-btn btn btn-dark icon">
                <i class=" fas fa-bars" style="color: white;font-size: 35px"></i>
            </button>
            <a href="/<?= APP_BASE_PATH ?>/www/"><i class="icon fa-sharp fa-solid fa-shop"
                                                    style="color: white;font-size: 35px;"></i></a>
            <h1 class="header-title text-white ">MY SHOP</h1>
            <div class="icon input-group mb-3">
                <input type="text" class="form-control" placeholder="I am searching..."
                       aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary pb-2 text-white" type="button">Button</button>
                </div>
            </div>

            <a href="#"><i class="icon fa-solid fa-user" style="color: white;font-size: 35px;"></i></a>
            <a href="#"><i class="icon fas fa-shopping-cart" style="color: white;font-size: 35px;"></i></a>
        </div>
    </nav>
</header>

<main>
    <div class="wrapper">
        <div id="sidebar" class="sidebar">
            <a href="/<?= APP_BASE_PATH ?>/www/" class="home-link"><h3
                        style="font-family: American Typewriter, cursive">
                    <i class="icon fa-sharp fa-solid fa-house" style="color: white;font-size: 25px;"></i> MY SHOP</h3>
            </a>
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

<script type="text/javascript" src="../js/sidebarCollapse.js"></script>

</body>
</html>
