<?php

require('../settings.php');


if (isset($_POST['edit-breakfast-id']) && isset($_POST['edit-breakfast-category']) && isset($_POST['edit-breakfast-duration'])) {

    $id = $_POST['edit-breakfast-id'];
    $category = $_POST['edit-breakfast-category'];
    $amount = $_POST['edit-breakfast-amount'] ?? 0;
    $duration = $_POST['edit-breakfast-duration'] ?? null;

    // Fetch the class's section
    $query = "SELECT id FROM breakfast_fees WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {

        $updateQuery = "UPDATE breakfast_fees SET category = :category, amount = :amount, duration = :duration, updated_by = :user_id WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->bindParam(':category', $category, PDO::PARAM_STR);
        $updateStmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $updateStmt->bindParam(':duration', $duration, PDO::PARAM_STR);
        $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $updateStmt->execute();

        $response = ['success' => true, 'message' => 'Information updated successfully.'];
    } 
    else {
        $response = ['success' => false, 'message' => 'breakfast Not Found.'];
    }

    
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
    
}

// Output the JSON response
echo json_encode($response);
?>