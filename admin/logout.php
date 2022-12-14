<?php
include "../partials/_dbconnect.php";
session_start();
session_unset();
session_destroy();
header("location:http://localhost/blog/login.php");
exit();
