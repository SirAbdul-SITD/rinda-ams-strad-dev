<?php
require '../settings.php';

// Check if the class ID is provided and not empty
if (isset($_POST['class_id']) && !empty($_POST['class_id'])) {
    // Sanitize the class ID value
    $class_id = $_POST['class_id'];

    // Prepare and execute a query to fetch students based on the selected class_id
    $query = "SELECT * FROM students WHERE class_id = :class_id AND status = 1 ORDER BY firstName ASC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any students are found
    if ($students) {
        // Generate JSON response with the retrieved students
        $response = ['success' => true, 'students' => $students];
    } else {
        // If no students are found, return a default message
        $response = ['success' => false, 'message' => 'No students found for the selected class.'];
    }
} else {
    // If the class ID is not provided or empty, return an error response
    $response = ['success' => false, 'message' => 'Invalid or missing class ID.'];
}

// Output the JSON response
echo json_encode($response);
?>
