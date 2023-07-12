<?php

namespace InternetShop\app\controllers;
/**
 * Home page controller
 */
class HomeController {

    /**
     * @return void
     */
    public function index(): void
    {
        if (file_exists("../app/views/index.php")){;
            include_once "../app/views/index.php";
        }
        else include_once "../app/views/errors/404.php";

    }
}