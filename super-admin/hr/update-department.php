<?php

require('../settings.php');

$user = 1;

// Check if department ID and name are set in the POST data
if (isset($_POST['id'], $_POST['name'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Check if any department already has the new name
    $query = "SELECT * FROM departments WHERE `department` = :name AND `id` != :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $existingDepartment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingDepartment) {
        // Department with the same name already exists
        $response = ['success' => false, 'message' => 'Department with the same name already exists!'];
    } else {
        // Update the department
        $query = "UPDATE departments SET `department` = :name, `modified_by` = :user WHERE `id` = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Success message
        $response = ['success' => true, 'message' => 'Department updated successfully.'];
    }
} else {
    // Invalid request: Department ID or name is not provided
    $response = ['success' => false, 'message' => 'Invalid request. Please provide department ID and name.'];
}

// Output the JSON response
echo json_encode($response);
?>
