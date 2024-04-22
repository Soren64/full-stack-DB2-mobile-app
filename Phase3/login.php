<?php
//session_start();
//$connection = mysqli_connect("localhost", "root","","DB2");
require 'config.php';


if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = array();

    if ($connection) {
        //$sql = "SELECT * FROM account WHERE email = '".$email."'";
        //$res = mysqli_query($connection, $sql);
        $getEmail = mysqli_query($connection, "SELECT * FROM account WHERE email = '$email'");
        $checkTypeRow = mysqli_fetch_assoc($getEmail);

        if (mysqli_num_rows($getEmail) != 0) {
            if ($email == $checkTypeRow['email'] && $password == $checkTypeRow['password'] && $checkTypeRow['type'] == 'student') {
                $sQuery = mysqli_query($connection, "SELECT * FROM student WHERE email = '$email'");
                $sRow = mysqli_fetch_assoc($sQuery);
                
                $response['email'] = $checkTypeRow['email'];
                $response['password'] = $checkTypeRow['password'];
                $response['name'] = $sRow['name'];
                $response['status'] = "true";

                $_SESSION["email"] = $response['email'];
                $_SESSION["id"] = $sRow['student_id'];

                echo json_encode($response);
            }
            else if ($email == $checkTypeRow['email'] && $password == $checkTypeRow['password'] && $checkTypeRow['type'] == 'instructor') {
                $iQuery = mysqli_query($connection, "SELECT * FROM instructor WHERE email = '$email'");
                $iRow = mysqli_fetch_assoc($iQuery);

                $response['email'] = $checkTypeRow['email'];
                $response['password'] = $checkTypeRow['password'];
                $response['name'] = $iRow['instructor_name'];
                $response['status'] = "true";

                $_SESSION["email"] = $response['email'];
                $_SESSION["id"] = $iRow['instructor_id'];

                echo json_encode($response);
            }
        }
        /*
        if ($checkTypeRow['type'] == 'student'){
            $query = mysqli_query($connection, "SELECT * FROM student WHERE email = '".$email."'");
            if (mysqli_num_rows($getEmail) != 0){
                $row = mysqli_fetch_assoc($getEmail);
                $sRow = mysqli_fetch_assoc($query);
                if ($email == $row['email'] && $password == $row['password']){
                    $response['email'] = $row['email'];
                    $response['password'] = $row['password'];
                    $response['name'] = $sRow['name'];
                    
                    $response['status'] = "true";
                    echo json_encode($response);
                }
            }
        } 
        else{
            $query = mysqli_query($connection, "SELECT * FROM instructor WHERE email = '".$email."'");
            if (mysqli_num_rows($res) != 0){
                $row = mysqli_fetch_assoc($getEmail);
                $sRow = mysqli_fetch_assoc($query);
                if ($email == $row['email'] && $password == $row['password']){
                    $response['email'] = $row['email'];
                    $response['password'] = $row['password'];
                    $response['name'] = $sRow['instructor_name'];
                    
                    $response['status'] = "true";
                    echo json_encode($response);
                }
            }
        }
        */
	    //$query = mysqli_query($connection, "SELECT * FROM student WHERE email = '".$email."'");
        
        /*
        if (mysqli_num_rows($res) != 0){
            $row = mysqli_fetch_assoc($res);
            $sRow = mysqli_fetch_assoc($query);
            if ($email == $row['email'] && $password == $row['password']){
                $response['email'] = $row['email'];
                $response['password'] = $row['password'];
                $response['name'] = $sRow['name'];
                
                $response['status'] = "true";
                echo json_encode($response);
            }
        }
        */
    }
}