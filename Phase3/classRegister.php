<?php
require 'config.php';

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

    // Get current courses and their average grades
    $query = "SELECT course.course_name AS course, AVG(CASE 
                    WHEN take.grade = 'A+' THEN 4.0
                    WHEN take.grade = 'A'  THEN 4.0
                    WHEN take.grade = 'A-' THEN 3.7
                    WHEN take.grade = 'B+' THEN 3.3
                    WHEN take.grade = 'B'  THEN 3.0
                    WHEN take.grade = 'B-' THEN 2.7
                    WHEN take.grade = 'C+' THEN 2.3
                    WHEN take.grade = 'C'  THEN 2.0
                    WHEN take.grade = 'C-' THEN 1.7
                    WHEN take.grade = 'D+' THEN 1.3
                    WHEN take.grade = 'D'  THEN 1.0
                    WHEN take.grade = 'D-' THEN 0.7
                    WHEN take.grade = 'F'  THEN 0.0
                    ELSE NULL
                END) AS grade_average,
                section.section_id AS section
            FROM section
            INNER JOIN take ON section.section_id = take.section_id
            INNER JOIN course ON section.course_id = course.course_id
            WHERE section.year = '$curYear' AND section.semester = '$curSem'
            GROUP BY course.course_id";
    $result = mysqli_query($connection, $query);

    $courses = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }

    $response['courses'] = $courses;
    echo json_encode($response);
} else {
    echo "DB connection failed";
}
?>
