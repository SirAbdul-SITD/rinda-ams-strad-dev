<?php
require('../settings.php');

$user = 1;

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $classId = $_POST['id'];
    $status = 3;

    try {
        $updateQuery = "UPDATE classes SET status = :status, modified_by = :user WHERE id = :classId";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':user', $user, PDO::PARAM_INT);
        $stmt->bindParam(':classId', $classId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response = ['success' => true, 'message' => 'Class removed successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Class not found or already removed.'];
        }
    } catch (PDOException $e) {
        $response = ['success' => false, 'message' => 'Error updating removing Class: ' . $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid Class.'];
}

echo json_encode($response);
?>
