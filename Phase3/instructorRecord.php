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

        // Get current courses and the names of attending students
        $getCurCourses = mysqli_query($connection,
            "SELECT take.course_id AS course,
                take.section_id AS section,
                student.name AS name
            FROM take
            INNER JOIN student ON take.student_id = student.student_id
            INNER JOIN section ON take.course_id = section.course_id
                AND take.section_id = section.section_id
            WHERE take.semester = '$curSem'
            AND take.year = $curYear
            AND section.instructor_id = $id"
        );
        $curCoursesArr = array();

        // Get past courses and their attending student names and grades
        $getPastCourses = mysqli_query($connection, 
            "SELECT take.course_id AS course,
                take.section_id AS section,
                student.name AS name,
                take.grade AS grade
            FROM take
            INNER JOIN student ON take.student_id = student.student_id
            INNER JOIN section ON take.course_id = section.course_id
                AND take.section_id = section.section_id
            WHERE take.semester != '$curSem'
            AND take.year <= $curYear
            AND section.instructor_id = $id"
        );
        $pastCoursesArr = array();

        // Populate current courses array
        while ($rslt = mysqli_fetch_array($getCurCourses, MYSQLI_ASSOC)) {
            $rsltRow = implode(" ", $rslt);
            array_push($curCoursesArr, $rsltRow);
        }

        // Populate past courses array
        while ($rslt = mysqli_fetch_array($getPastCourses, MYSQLI_ASSOC)) {
            $rsltRow = implode(" ", $rslt);
            array_push($pastCoursesArr, $rsltRow);
        }

        // Convert arrays to strings
        $curCoursesStr = implode(", ", $curCoursesArr);
        $pastCoursesStr = implode(", ", $pastCoursesArr);

        $response['cur-courses'] = $curCoursesStr;
        $response['past-courses'] = $pastCoursesStr;
        $response['name'] = $name;
        $response['id'] = $id;
        $response['status'] = "true";

        echo json_encode($response);
    }
}
