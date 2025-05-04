<?php
require '../settings.php';
// Check if the section value is set and not empty
if (isset($_GET['class']) && !empty($_GET['class'])) {
    // Sanitize the class value
    $class = $_GET['class'];

    // Prepare and execute a query to fetch classes based on the selected class
    $query = "SELECT * FROM students WHERE class = :class ORDER BY class ASC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class, PDO::PARAM_STR);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any students are found
    if ($students) {
        // Generate HTML options for the students
        $options = '<option value="">Select Student</option>';
        foreach ($students as $student) {
            $options .= '<option value="' . $student['id'] . '">' . $student['fullname'] . '</option>';
        }
        // Return the HTML options
        echo $options;
    } else {
        // If no classes are found, return a default message
        echo '<option value="" >No students found</option>';
    }
} else {
    // If the class value is not set or empty, return an empty option
    echo '<option value="" >Select Class First</option>';
}
?>
