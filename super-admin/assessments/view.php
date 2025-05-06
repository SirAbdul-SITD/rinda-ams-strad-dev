<?php
require ('../settings.php');

try {
    // Prepare SQL statement to fetch assessment marks with subject information
    $stmt = $pdo->prepare("SELECT m.*, s.subject AS subject_name FROM assessment_marks m INNER JOIN subjects s ON m.subject_id = s.id WHERE m.class_id = :class_id");
    $stmt->bindValue(':class_id', 8, PDO::PARAM_INT); // Assuming class_id is fixed for this operation
    $stmt->execute();

    // Fetch all assessment marks with subject information as an associative array
    $assessmentMarks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any assessment marks
    if (empty($assessmentMarks)) {
        echo "No assessment marks found.";
    } else {
        // Build an array to store assessment marks by student ID
        $studentMarks = [];

        // Iterate through assessment marks and organize them by student ID and assessment type
        foreach ($assessmentMarks as $row) {
            $studentId = $row['student_id'];
            $subjectName = $row['subject_name'];
            $assessmentType = $row['assessment_type'];
            $mark = $row['mark'];
            $session = $row['session_id'];
            $term = $row['term'];
            $studentMarks[$studentId][$subjectName][$session][$term][$assessmentType] = $mark;
        }

        // Output HTML table header with subject names and assessment types as table headers
        echo "<table border='1'>";
        echo "<tr><th>Student ID</th><th>Subject</th><th>Session</th><th>Term</th>";
        $assessmentTypes = array_unique(array_column($assessmentMarks, 'assessment_type')); // Get unique assessment types
        foreach ($assessmentTypes as $type) {
            echo "<th>$type</th>";
        }
        echo "</tr>";

        // Iterate through student marks and output each row as a table row
        foreach ($studentMarks as $studentId => $subjects) {
            foreach ($subjects as $subjectName => $sessions) {
                foreach ($sessions as $session => $terms) {
                    foreach ($terms as $term => $marks) {
                        echo "<tr>";
                        echo "<td rowspan='" . count($subjects) . "'>$studentId</td>"; // Output student ID only for the first row of each student
                        echo "<td rowspan='" . count($sessions) . "'>$subjectName</td>"; // Output subject name only for the first row of each subject
                        echo "<td rowspan='" . count($terms) . "'>$session</td>"; // Output session only for the first row of each term
                        echo "<td rowspan='" . count($marks) . "'>$term</td>"; // Output term only for the first row of each mark set
                        foreach ($assessmentTypes as $type) {
                            echo "<td>" . ($marks[$type] ?? "") . "</td>"; // Output mark for the assessment type or empty cell if mark is not set
                        }
                        echo "</tr>";
                    }
                }
            }
        }

        // Close HTML table
        echo "</table>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("#update-result-info");
    if (form) {
        form.addEventListener("submit", function(event) {
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'update-result-info.php',
                data: $(this).serialize(), // Ensure jQuery is included in your project
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        displayPopup(response.message, true);
                        // Refresh the page after 2 seconds
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        displayPopup(response.message, false);
                    }
                },
                error: function(xhr, status, error) {
                    displayPopup('Error occurred during request. Contact Admin', false);
                }
            });
        });
    }
});
