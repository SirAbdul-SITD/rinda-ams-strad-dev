<?php
require('../settings.php');


if (isset($_POST['id']) && is_numeric($_POST['parent_id'])) {
    $id = $_POST['id'];
    $parent_id = $_POST['parent_id'];
    $status = 0;

    try {
        $updateQuery = "UPDATE `parent_student` SET `status` = :status, `modified_by` = :user_id WHERE parent_id = :parent_id AND student_id = :id";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt) {
            $response = ['success' => true, 'message' => 'Dependants Unlinked Successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Student not found or already removed.'];
        }
    } catch (PDOException $e) {
        $response = ['success' => false, 'message' => 'Error updating removing dependant: ' . $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
}


echo json_encode($response);
?>
