<?php
require('../settings.php');

$user = 1;

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $subjectId = $_POST['id'];
    $status = 3;

    try {
        $updateQuery = "UPDATE subjects SET status = :status, modified_by = :user WHERE id = :subjectId";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':user', $user, PDO::PARAM_INT);
        $stmt->bindParam(':subjectId', $subjectId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response = ['success' => true, 'message' => 'Subject removed successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Subject not found or already removed.'];
        }
    } catch (PDOException $e) {
        $response = ['success' => false, 'message' => 'Error updating removing subject: ' . $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid subject.'];
}

echo json_encode($response);
?>
