<?php

require('../settings.php');

$user = 1;

// Check if designation ID, name, salary, and department ID are set in the POST data
if (isset($_POST['id'], $_POST['name'], $_POST['salary'], $_POST['department_id'])) {
    $designationId = $_POST['id'];
    $name = $_POST['name'];
    $salary = $_POST['salary'];
    $departmentId = $_POST['department_id'];

    // Check if any designation already has the new name
    $query = "SELECT * FROM designations WHERE `designation` = :name AND `department_id` = :departmentId AND `id` != :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':id', $designationId, PDO::PARAM_INT);
    $stmt->bindParam(':departmentId', $designationId, PDO::PARAM_INT);
    $stmt->execute();
    $existingDesignation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingDesignation) {
        // designation with the same name already exists
        $response = ['success' => false, 'message' => 'Designation with the same name already exists!'];
    } else {
        // Update the designation
        $query = "UPDATE designations SET `designation` = :name, `salary` = :salary, `department_id` = :departmentId, `modified_by` = :user WHERE `id` = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':salary', $salary, PDO::PARAM_INT);
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindParam(':user', $user, PDO::PARAM_INT);
        $stmt->bindParam(':id', $designationId, PDO::PARAM_INT);
        $stmt->execute();

        // Success message
        $response = ['success' => true, 'message' => 'Designation updated successfully.'];
    }
} else {
    // Invalid request: designation ID, name, salary, or department ID is not provided
    $response = ['success' => false, 'message' => 'Invalid request. Please provide designation ID, name, salary, and department ID.'];
}

// Output the JSON response
echo json_encode($response);
?>