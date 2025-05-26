<?php
// Include your database connection file
require '../settings.php';

// Check if the ID parameter is set in the POST request
if (isset($_POST['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $id = htmlspecialchars($_POST['id']);

    try {
        // Prepare a DELETE statement
        $stmt = $pdo->prepare("DELETE FROM files WHERE id = :id");

        // Bind the ID parameter
        $stmt->bindParam(':id', $id);

        // Execute the statement
        if ($stmt->execute()) {
            // If the deletion is successful, send a success response
            echo json_encode(['status' => 'success', 'message' => 'Audio deleted successfully.']);
        } else {
            // If the deletion fails, send an error response
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete Audio.']);
        }
    } catch (PDOException $e) {
        // If an exception occurs, send an error response with the error message
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    // If the ID parameter is not set, send an error response
    echo json_encode(['status' => 'error', 'message' => 'Audio is missing.']);
}
