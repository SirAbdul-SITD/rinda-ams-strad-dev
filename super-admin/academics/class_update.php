<?php

require_once '../settings.php';

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Begin transaction
        $pdo->beginTransaction();

       
            $class =  $_POST['2ndClass_id'];
            $id =  $_POST['id'];
            $section = $_POST['section'];
            
            if ($section == 1 ) {
                 // Check if all required fields are provided
        

        // Prepare and execute the update statement for student data
        $sqlStudent = "UPDATE students SET class_id = :class WHERE id = :id";
        $stmtStudent = $pdo->prepare($sqlStudent);
        $stmtStudent->bindParam(':class', $class, PDO::PARAM_INT);
        $stmtStudent->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtStudent->execute();

        // Commit the transaction
        $pdo->commit();

        // Set success message
        $response = ['success' => true, 'message' => 'Student class updated successfully.'];
        
        
            } elseif ($section == 2 ) {
                 // Check if all required fields are provided
        

        // Prepare and execute the update statement for student data
        $sqlStudent = "UPDATE students SET 2ndClass_id = :class,  multiClass = 1 WHERE id = :id";
        $stmtStudent = $pdo->prepare($sqlStudent);
        $stmtStudent->bindParam(':class', $class, PDO::PARAM_INT);
        $stmtStudent->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtStudent->execute();

        // Commit the transaction
        $pdo->commit();

        // Set success message
        $response = ['success' => true, 'message' => 'Student class updated successfully.'];
        
    }
       

       

    } catch (Exception $e) {
        // Rollback the transaction on error
        $pdo->rollBack();

        // Set error message
        $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
} else {
    // If the request method is not POST, return an error response
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
