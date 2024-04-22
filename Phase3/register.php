<?php
require 'config.php';

if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    //$connection = mysqli_connect("localhost", "root","","DB2");
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($connection) {
        $sql = "INSERT INTO account VALUES('$email','$password','student')";
        if (mysqli_query($connection, $sql)) {
            $sqlStudent = "INSERT INTO student VALUES(99999, '$name', '$email', 'Miner School of Computer & Information Sciences')";
            if (mysqli_query($connection, $sqlStudent)) {
                $sqlUndergrad = "INSERT INTO undergraduate VALUES(99999, 0, 'Freshman')";
                if (mysqli_query($connection, $sqlUndergrad)) {
                    echo "success";
                }
            }
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
