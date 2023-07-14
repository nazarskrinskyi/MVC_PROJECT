<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'internet_shop';

const APP_BASE_PATH = "test.loc/InternetShop";

function is_active($currentPath): string
{
    $currentPage = $_SERVER['REQUEST_URI'];
    if ($currentPage === $currentPath) {
        return 'active';
    }
    return '';
}

function tt($arr): void
{
    echo "DEBAG:<pre>";
    var_dump($arr);
    echo "<pre>";
}

function tte($arr): void
{
    echo "DEBAG:<pre>";
    var_dump($arr);
    echo "<pre>";
    exit();
}