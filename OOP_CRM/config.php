<?php

function tt($arr): void
{
    echo "<pre>";
        var_dump($arr);
    echo "<pre>";
}
function tte($arr): void
{
    echo "<pre>";
        var_dump($arr);
    echo "<pre>";
    exit();
}

function is_active($currentPath): string
{
    $currentPage = $_SERVER['REQUEST_URI'];
    if ($currentPage === $currentPath) {
        return 'active';
    }
    return '';
}

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'crm_for_telegram';
const START_ROLE = 1;
const APP_BASE_PATH = 'test.loc/OOP_CRM';