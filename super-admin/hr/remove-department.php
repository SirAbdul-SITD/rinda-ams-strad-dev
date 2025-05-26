<?php

require('../settings.php');

$user = 1;

// Check if department ID and name are set in the POST data
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Remove the department
    $query = "DELETE FROM departments WHERE `id` = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if any rows were affected (i.e., if the department was successfully removed)
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
        // Success message
        $response = ['success' => true, 'message' => 'Department removed successfully.'];
    } else {
        // No department found with the provided ID
        $response = ['success' => false, 'message' => 'Department not found.'];
    }
} else {
    // Invalid request: Department ID is not provided
    $response = ['success' => false, 'message' => 'Invalid request. Please provide department ID.'];
}

// Output the JSON response
echo json_encode($response);
?>
