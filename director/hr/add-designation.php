<?php

require('../settings.php');

$user = 1;

// Check if designation name and department ID are set in the POST data
try {
    if (!isset($_POST['name']) || !isset($_POST['id']) || empty($_POST['name']) || empty($_POST['id'])) {
        throw new Exception('Please enter a valid name and select a department for the designation!');
    }

    $name = $_POST['name'];
    $id = $_POST['id'];
    $salary = !empty($_POST['salary']) ? $_POST['salary'] : null;

    // Check if the designation with the same name already exists in this department
    $query = "SELECT ds.*, dp.id FROM designations ds INNER JOIN departments dp ON ds.department_id = dp.id WHERE ds.department_id = :id AND ds.designation = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $existingDesignation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingDesignation) {
        throw new Exception('Designation with the same name already exists in this department!');
    }

    // Add the new designation
    $insertQuery = "INSERT INTO `designations` (`designation`, `department_id`, `salary`, `modified_by`) VALUES (:name, :id, :salary, :user)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
    $insertStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $insertStmt->bindParam(':salary', $salary, PDO::PARAM_INT); // Assuming salary is an integer
    $insertStmt->bindParam(':user', $user, PDO::PARAM_INT);
    $insertStmt->execute();

    // Success message
    $response = ['success' => true, 'message' => 'New Designation Added Successfully.'];
} catch (Exception $e) {
    // Error message
    $response = ['success' => false, 'message' => $e->getMessage()];
}

// Output the JSON response
echo json_encode($response);
?>
