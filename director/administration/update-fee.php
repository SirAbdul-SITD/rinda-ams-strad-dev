<?php

require('../settings.php');


if (isset($_POST['edit-fee-id']) && isset($_POST['edit-fee-type'])) {

    $id = $_POST['edit-fee-id'];
    $type = $_POST['edit-fee-type'];
    $first_term = $_POST['edit-fee-first_term'] ?? 0;
    $second_term = $_POST['edit-fee-second_term'] ?? 0;
    $third_term = $_POST['edit-fee-third_term'] ?? 0;

    // Fetch the class's section
    $query = "SELECT id FROM compulsory_fees WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {

        $updateQuery = "UPDATE compulsory_fees SET type = :type, first_term = :first_term, second_term = :second_term, third_term = :third_term, updated_by = :user_id WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_STR);
        $updateStmt->bindParam(':type', $type, PDO::PARAM_STR);
        $updateStmt->bindParam(':first_term', $first_term, PDO::PARAM_STR);
        $updateStmt->bindParam(':second_term', $second_term, PDO::PARAM_INT);
        $updateStmt->bindParam(':third_term', $third_term, PDO::PARAM_INT);
        $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $updateStmt->execute();

        $response = ['success' => true, 'message' => 'Information updated successfully.'];
    } else {
        $response = ['success' => false, 'message' => 'Fee Not Found.'];
    }

    
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
    
}

// Output the JSON response
echo json_encode($response);
?>