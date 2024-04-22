<?php
require 'config.php';

if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    //$connection = mysqli_connect("localhost", "root","","DB2");
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($connection) {
        // Insertion into account table
        $sql = "INSERT INTO account VALUES('$email','$password','student')";
        if (mysqli_query($connection, $sql)) {
            // New student's ID will be 1 + the highest ID already in the table.
            $sqlID = "SELECT MAX(student_id) AS max_id FROM student";
            $result = mysqli_query($connection, $sqlID);
            $idRow = $result->fetch_assoc();
            $newID = $idRow["max_id"] + 1;
            // Insertion into student table
            $sqlStudent = "INSERT INTO student VALUES($newID, '$name', '$email', 'Miner School of Computer & Information Sciences')";
            if (mysqli_query($connection, $sqlStudent)) {
                // We are assuming a newly registered student is a freshman with no course credits
                // Insertion into undergraduate table
                $sqlUndergrad = "INSERT INTO undergraduate VALUES($newID, 0, 'Freshman')";
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
