<?php
// Include your database connection file
require 'settings.php';

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $vidId = isset($_POST['id']) ? $_POST['id'] : null;
    $newTitle = isset($_POST['title']) ? $_POST['title'] : null;
    $newClass = isset($_POST['class']) ? $_POST['class'] : null;
    $newSubject = isset($_POST['subject']) ? $_POST['subject'] : null;

    // Validate inputs (add more validation as needed)
    if ($vidId && $newTitle && $newClass && $newSubject) {
        // Prepare and execute the SQL statement to update video information
        $query = "UPDATE files SET title = :title, class = :class, subject = :subject WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':title', $newTitle);
        $stmt->bindParam(':class', $newClass);
        $stmt->bindParam(':subject', $newSubject);
        $stmt->bindParam(':id', $vidId);
        
        if ($stmt->execute()) {
            // If the update was successful, return success message
            $response = [
                'status' => 'success',
                'message' => 'Video information updated successfully.'
            ];
            echo json_encode($response);
            exit();
        } else {
            // If the update failed, return error message
            $response = [
                'status' => 'error',
                'message' => 'Failed to update video information. Please try again.'
            ];
            echo json_encode($response);
            exit();
        }
    } else {
        // If required inputs are missing, return error message
        $response = [
            'status' => 'error',
            'message' => 'Please provide all required information.'
        ];
        echo json_encode($response);
        exit();
    }
} else {
    // If request method is not POST, return error message
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method.'
    ];
    echo json_encode($response);
    exit();
}
?>
