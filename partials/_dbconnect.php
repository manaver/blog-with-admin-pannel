<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "blog";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("DB not connected");
}
