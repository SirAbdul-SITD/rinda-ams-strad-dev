<?php
require('../settings.php');

$user = $user_id;

if (isset($_POST['relationship']) || isset($_POST['id']) && is_numeric($_POST['parent_id'])) {
    $id = $_POST['id'];
    $parent_id = $_POST['parent_id'];
    $relationship_type = $_POST['relationship'];

    try {

        $sql = "SELECT * FROM parent_student WHERE status = 1 AND parent_id = :parent_id AND student_id = :student_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':student_id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($students) {

            if ($students['relationship'] != $relationship_type) {

                $updateQuery = "UPDATE parent_student SET relationship_type = :relationship_type, modified_by = :modified_by WHERE parent_student_id = :student_id";
                $insertstmt = $pdo->prepare($updateQuery);
                $insertstmt->bindParam(':student_id', $id, PDO::PARAM_INT);
                $insertstmt->bindParam(':relationship_type', $relationship_type, PDO::PARAM_STR);
                $insertstmt->bindParam(':modified_by', $user, PDO::PARAM_INT);
                $insertstmt->execute();
            
            }

        } else {

            $updateQuery = "INSERT INTO `parent_student` (`parent_id`, `student_id`, `relationship_type`, `modified_by`) VALUES (:parent_id, :student_id, :relationship_type, :modified_by) ";
            $insertstmt = $pdo->prepare($updateQuery);
            $insertstmt->bindParam(':student_id', $id, PDO::PARAM_INT);
            $insertstmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
            $insertstmt->bindParam(':relationship_type', $relationship_type, PDO::PARAM_STR);
            $insertstmt->bindParam(':modified_by', $user, PDO::PARAM_INT);
            $insertstmt->execute();
            
            
        }

        if ($insertstmt) {
            $response = ['success' => true, 'message' => 'Dependants Linked Successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Student not found or already linked.'];
        }
        
    } catch (PDOException $e) {
        $response = ['success' => false, 'message' => 'Error updating removing dependant: ' . $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
}

echo json_encode($response);
?>
