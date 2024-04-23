<?php
require 'config.php';

// Check if all required POST parameters are present
if (!empty($_POST['studentId']) && !empty($_POST['courseId']) && !empty($_POST['sectionId'])) {
    $studentId = $_POST['studentId'];
    $courseId = $_POST['courseId'];
    $sectionId = $_POST['sectionId'];

    // Get current semester and year
    $currentSemesterQuery = "SELECT semester, year FROM current_semester LIMIT 1";
    $currentSemesterResult = $connection->query($currentSemesterQuery);

    if ($currentSemesterResult->num_rows > 0) {
        $currentSemesterRow = $currentSemesterResult->fetch_assoc();
        $curSem = $currentSemesterRow['semester'];
        $curYear = $currentSemesterRow['year'];

        // Check if the course ID is valid
        $courseQuery = "SELECT * FROM course WHERE course_id = '$courseId'";
        $courseResult = $connection->query($courseQuery);

        if ($courseResult->num_rows > 0) {
            // Course ID is valid, now check if the section ID is valid for the current semester
            $sectionQuery = "SELECT * FROM section WHERE section_id = '$sectionId' AND course_id = '$courseId' AND year = '$curYear' AND semester = '$curSem'";
            $sectionResult = $connection->query($sectionQuery);

            if ($sectionResult->num_rows > 0) {
                // Section ID is valid for the current semester, check for available space (<15 students)
                $rosterQuery = "SELECT COUNT(*) AS roster_size FROM take WHERE section_id = '$sectionId'";
                $rosterResult = mysqli_query($connection, $rosterQuery);
                $rosterRow = mysqli_fetch_assoc($rosterResult);
                $rosterSize = (int)$rosterRow['roster_size'];

                if ($rosterSize < 15) {
                    // Enroll the student
                    $signupQuery = "INSERT INTO take (student_id, course_id, section_id, semester, year, grade) VALUES ('$studentId', '$courseId', '$sectionId', '$curSem', '$curYear', NULL)";
                    $signup = mysqli_query($connection, $signupQuery);

                    if ($signup) {
                        echo "Enrollment successful";
                    } else {
                        echo "Error enrolling student: " . mysqli_error($connection);
                    }
                } else {
                    echo "Section is full";
                }
            } else {
                echo "Invalid section ID for the current semester";
            }
        } else {
            echo "Invalid course ID";
        }
    } else {
        echo "Current semester information not found";
    }
} else {
    echo "Missing POST parameters";
}
?>
