<?php

session_start();

error_reporting(E_ALL &~ E_WARNING);
ini_set("display_errors",1);


use OOP_CRM\app\Router;

require "config.php";
require "../composer/vendor/autoload.php";

$router = new Router();
$router->run();




