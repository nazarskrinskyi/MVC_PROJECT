<?php
session_start();
include "../path.php";
unset($_SESSION['id']);
unset($_SESSION['login']);

header("Location: http://localhost/test.loc/BIG_PROJECT/log_form/Login.php");
