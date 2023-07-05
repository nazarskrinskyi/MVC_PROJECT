<?php

$db = "db_for_blog";
$host = "localhost";
$username = 'root';
$options = [PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false];

$connection = new PDO("mysql:host=$host;dbname=$db", $username, '', $options);

if (!$connection) {
    echo "Error (Line)->" . __LINE__;
    exit("message -> connection-error to db\n");
}
