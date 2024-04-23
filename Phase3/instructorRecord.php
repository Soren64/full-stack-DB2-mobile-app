<?php
require 'config.php';

if (!empty($_POST['id'])) {
    $id = $_POST['id'];

    if ($connection) {
        // Get current semester and year
        $sql = "SELECT MAX(year) AS max_year, semester
            FROM section
            GROUP BY year
            ORDER BY year DESC, FIELD(semester, 'Spring', 'Summer', 'Fall', 'Winter')
            LIMIT 1";
        $result = mysqli_query($connection, $sql);
        $currRow = $result->fetch_assoc();
        $curSem = $currRow["semester"];
        $curYear = $currRow["max_year"];

        // Get student name
        $getName = mysqli_query($connection, "SELECT * FROM instructor WHERE instructor_id = '$id'");
        $nRow = mysqli_fetch_assoc($getName);
        $name = $nRow["instructor_name"];

        // Get current courses
        $getCurCourses = mysqli_query($connection,
            "SELECT * FROM section
            WHERE instructor_id = '$id'
            AND semester = '$curSem'
            AND year = '$curYear'"
        );
        $curCoursesArr = array();

        // Get past courses
        $getPastCourses = mysqli_query($connection,
            "SELECT * FROM section
            WHERE instructor_id = '$id'
            AND semester != '$curSem'
            AND year <= '$curYear'"
        );
        $pastCoursesArr = array();

        // Populate current courses array
        while ($rslt = mysqli_fetch_array($getCurCourses)){
            array_push($curCoursesArr, $rslt["course_id"]);
        }
        // Populate past courses array
        while ($rslt = mysqli_fetch_array($getPastCourses)){
            array_push($pastCoursesArr, $rslt["course_id"]);
        }

        // Convert arrays to strings
        $curCoursesStr = implode(" ", $curCoursesArr);
        $pastCoursesStr = implode(" ", $pastCoursesArr);

        $response['cur-courses'] = $curCoursesStr;
        $response['past-courses'] = $pastCoursesStr;
        $response['name'] = $name;
        $response['id'] = $id;
        $response['status'] = "true";

        echo json_encode($response);
    }
}
