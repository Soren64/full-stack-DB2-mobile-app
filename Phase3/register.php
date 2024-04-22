<?php
require 'config.php';

if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    //$connection = mysqli_connect("localhost", "root","","DB2");
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($connection){
        $sql = "INSERT INTO account VALUES('$email','$password','student')";
        if (mysqli_query($connection, $sql)) {
            echo "success";
        }
        else {
            echo "Registration Failed";
        }
    }
    else {
        echo "DB connection failed";
    }
}
else {
    echo "All fields are required";
}
