<?php

error_reporting(E_ALL);
ini_set("display_errors",1);

use InternetShop\www\Router;

include_once "../config/paths.php";
include "../../composer/vendor/autoload.php";


/**
 * @function run is the start point in shopSite
 * from this point we includes others views by url
 */
$Router = new Router();

$Router->run();