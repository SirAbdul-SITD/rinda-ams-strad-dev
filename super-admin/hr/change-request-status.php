<?php
require '../settings.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are present in the POST data
    if (isset($_POST['id']) && isset($_POST['status'])) {
        // Sanitize and validate the input
        $Id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT); // Change 'Id' to 'id'
        $status = $_POST['status'];

        // Update the student status in the database
        $sql = "UPDATE leave_applications SET status = :status WHERE id = :Id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':Id', $Id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Return success response
            echo json_encode(['success' => true, 'message' => 'Request status updated successfully']);
            exit();
        } else {
            // Return error response if the query fails
            echo json_encode(['success' => false, 'message' => 'Failed to update request status']);
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
