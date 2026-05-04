<?php

$host = "127.0.0.1";
$user = "root";
$password = "";
$database = "coffee_talk";

$con = mysqli_connect($host, $user, $password, $database);

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
