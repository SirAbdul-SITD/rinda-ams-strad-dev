<?php
require '../settings.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are present in the POST data
    if (isset($_POST['studentId']) && isset($_POST['status'])) {
        // Sanitize and validate the input
        $studentId = filter_var($_POST['studentId'], FILTER_SANITIZE_NUMBER_INT);
        $status = filter_var($_POST['status'], FILTER_VALIDATE_INT);

        // Update the student status in the database
        $sql = "UPDATE students SET status = :status WHERE id = :studentId";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Return success response
            echo json_encode(['success' => true, 'message' => 'Student status updated successfully']);
            exit();
        } else {
            // Return error response if the query fails
            echo json_encode(['success' => false, 'message' => 'Failed to update student status']);
            exit();
        }
    } else {
        // Return error response if required parameters are missing
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        exit();
    }
} else {
    // Return error response if the request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}
?>
