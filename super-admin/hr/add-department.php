<?php

require('../settings.php');

$user = 1;

try {
    // Check if class name is set in the POST data
    if (!isset($_POST['name'])) {
        throw new Exception('Please enter a valid name for the department!');
    }

    $name = $_POST['name'];

    // Check if the department with the same name already exists
    $query = "SELECT * FROM departments WHERE `department` = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $existingDepartment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingDepartment) {
        throw new Exception('Department with the same name already exists!');
    }

    // Add the new department
    $insertQuery = "INSERT INTO `departments` (`department`, `modified_by`) VALUES (:name, :user)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
    $insertStmt->bindParam(':user', $user, PDO::PARAM_INT);
    $insertStmt->execute();

    // Success message
    $response = ['success' => true, 'message' => 'New Department Added Successfully.'];
} catch (Exception $e) {
    // Error message
    $response = ['success' => false, 'message' => $e->getMessage()];
}

// Output the JSON response
echo json_encode($response);
?>
