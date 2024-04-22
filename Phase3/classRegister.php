<?php
require 'config.php';

if (!empty($_POST['id']) && !empty($_POST['courseId']) && !empty($_POST['sectionId'])) {
    $id = $_POST['id'];
    $courseId = $_POST['courseId'];
    $sectionId = $_POST['sectionId'];

    if ($connection) {
        //Check if section is full (has 15 students)
        $roster_query = "SELECT COUNT(*) AS roster_size FROM take WHERE section_id = '$sectionId'";
        $roster_result = mysqli_query($connection, $roster_query);
        $roster_row = mysqli_fetch_assoc($roster_result);
        $roster_size = (int)$roster_row['roster_size'];

        if ($roster_size < 15) {
            //Section is not full, proceed with enrollment

            //Fetch current semester and year
            $sql = "SELECT MAX(year) AS max_year, semester
                FROM section
                GROUP BY year
                ORDER BY year DESC, FIELD(semester, 'Spring', 'Summer', 'Fall', 'Winter')
                LIMIT 1";
            $result = mysqli_query($connection, $sql);
            $currRow = $result->fetch_assoc();
            $curSem = $currRow["semester"];
            $curYear = $currRow["max_year"];

            //Calculate grade average
            $query = "SELECT AVG(CASE 
                            WHEN grade = 'A+' THEN 4.0
                            WHEN grade = 'A'  THEN 4.0
                            WHEN grade = 'A-' THEN 3.7
                            WHEN grade = 'B+' THEN 3.3
                            WHEN grade = 'B'  THEN 3.0
                            WHEN grade = 'B-' THEN 2.7
                            WHEN grade = 'C+' THEN 2.3
                            WHEN grade = 'C'  THEN 2.0
                            WHEN grade = 'C-' THEN 1.7
                            WHEN grade = 'D+' THEN 1.3
                            WHEN grade = 'D'  THEN 1.0
                            WHEN grade = 'D-' THEN 0.7
                            WHEN grade = 'F'  THEN 0.0
                            ELSE NULL
                        END) AS grade_avg
              FROM take
              WHERE course_id = '$courseId' AND grade IS NOT NULL";

            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $gradeAverage = $row["grade_avg"];

                
                $signup = mysqli_query($connection, "INSERT INTO take (student_id, course_id, section_id, semester, year, grade) VALUES ('$id', '$courseId', '$sectionId', '$curSem', '$curYear', NULL)");
                echo "Enrollment Successful";

                $response['cur-courses'] = $curCoursesStr;
                $response['id'] = $id;
                $response['status'] = "true";

                echo json_encode($response);
            } else {
                echo json_encode(["error" => "No grades found for the course"]);
            }

        } else {
            echo "Unable to enroll: Section is full (max=15)";
        }

    } else {
        echo "DB connection failed";
    }
} else {
    echo "All fields are required";
}
?>


