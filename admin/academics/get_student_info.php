<?php
// Include your database connection code or any necessary dependencies
require('../settings.php');

// Check if the student ID is provided and is a valid integer
if (isset($_POST['student']) && is_numeric($_POST['student'])) {
    // Sanitize the input to prevent SQL injection
    $student_id = $_POST['student'];

    try {
        // Prepare and execute the query to fetch student information
        $query = "SELECT s.*, c.class FROM students s INNER JOIN classes c ON s.class_id = c.id  WHERE s.id = :student_id AND s.status = 1";
        // $query = "SELECT * FROM students WHERE id = :student_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            // If student information is found, return it as JSON response
            $response = [
                'success' => true,
                'student' => $student
            ];
        } else {
            // If no student is found with the provided ID, return an error message
            $response = [
                'success' => false,
                'message' => 'Student not found.'
            ];
        }
    } catch (PDOException $e) {
        // If an exception occurred during execution, return an error message
        $response = [
            'success' => false,
            'message' => 'Error occurred while fetching student information.'
        ];
    }
} else {
    // If student ID is not provided or invalid, return an error message
    $response = [
        'success' => false,
        'message' => 'Invalid student ID.'
    ];
}

// Output the JSON response
echo json_encode($response);
?>
