<?php

require('../settings.php');

$user = 1;

// Check if designation name and department ID are set in the POST data
try {
    if (!isset($_POST['name']) || !isset($_POST['days']) || empty($_POST['name']) || empty($_POST['days'])) {
        throw new Exception('Please enter valid name and days for the category');
    }

    $name = $_POST['name'];
    $days = $_POST['days'];

    // Check if the designation with the same name already exists in this department
    $query = "SELECT id FROM leave_categories WHERE category = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $existingDesignation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingDesignation) {
        throw new Exception('Category with the same name already exists!');
    }

    // Add the new designation
    $insertQuery = "INSERT INTO `leave_categories` (`category`, `days`, `modified_by`) VALUES (:name, :days, :user)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
    $insertStmt->bindParam(':days', $days, PDO::PARAM_INT);
    $insertStmt->bindParam(':user', $user, PDO::PARAM_INT);
    $insertStmt->execute();

    // Success message
    $response = ['success' => true, 'message' => 'New Leave Category Added Successfully.'];
} catch (Exception $e) {
    // Error message
    $response = ['success' => false, 'message' => $e->getMessage()];
}

// Output the JSON response
echo json_encode($response);
?>
