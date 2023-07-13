<?php

namespace InternetShop\app\controllers;
/**
 * Home page controller
 */
class HomeController {

    /**
     * @return bool
     */
    public function index(): bool
    {
        if (file_exists("app/views/index.php")){;
            include_once "app/views/index.php";
            return true;
        }
        else include_once "app/views/errors/404.php";
        return false;
    }
}