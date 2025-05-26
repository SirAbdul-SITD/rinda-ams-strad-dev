<?php
require('../settings.php');


if (isset($_POST['id']) && is_numeric($_POST['parent_id'])) {
    $id = $_POST['id'];
    $parent_id = $_POST['parent_id'];
    $status = 0;

    try {
        $updateQuery = "DELETE FROM parent_student WHERE student_id = :id AND parent_id = :parent_id";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
      
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
