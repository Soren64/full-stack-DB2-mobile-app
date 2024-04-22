<?php
require 'config.php';

if (!empty($_POST['id'])){
    $id = $_POST['id'];

    if ($connection){
        //get current semester and year
        $sql = "SELECT MAX(year) AS max_year, semester
        FROM section
        GROUP BY year
        ORDER BY year DESC, FIELD(semester, 'Spring', 'Summer', 'Fall', 'Winter')
        LIMIT 1";
        $result = mysqli_query($connection, $sql);
        $currRow = $result->fetch_assoc();
        $curSem = $currRow["semester"];
        $curYear = $currRow["max_year"];

        //get student name
        $getName = mysqli_query($connection, "SELECT * FROM student WHERE student_id = '".$id."'");
        $nRow = mysqli_fetch_assoc($getName);
        $name = $nRow["name"];

        //get current courses
        $getCurCourses = mysqli_query($connection, "SELECT * FROM take WHERE student_id = '".$id."' AND semester = '".$curSem."' AND year = '".$curYear."'");
        $curCoursesArr = array();

        //get past courses
        $getPastCourses = mysqli_query($connection, "SELECT * FROM take WHERE student_id = '".$id."' AND semester != '".$curSem."' AND year <= '".$curYear."'");
        $pastCoursesArr = array();

        //populate current courses array
        while ($rslt = mysqli_fetch_array($getCurCourses)){
            array_push($curCoursesArr, $rslt["course_id"]);
        }
        //populate past courses array
        while ($rslt = mysqli_fetch_array($getPastCourses)){
            array_push($pastCoursesArr, $rslt["course_id"]);
        }

        //convert arrays to strings
        $curCoursesStr = implode(" ", $curCoursesArr);
        $pastCoursesStr = implode(" ", $pastCoursesArr);

        $response['cur-courses'] = $curCoursesStr;
        $response['past-courses'] = $pastCoursesStr;
        $response['id'] = $id;
        $response['status'] = "true";
        $response['name'] = $name;

        echo json_encode($response);
    }
}
