<?php
require 'config.php';
$_SESSION = [];
session_unset();
session_destroy();
/*
if (!empty($_POST['email'])){
    $email = $_POST['email'];
    //$connection = mysqli_connect("localhost","root","","DB2");
}
*/