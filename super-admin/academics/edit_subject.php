<?php

require('../settings.php');

$user = 1;

if (isset($_POST['id']) && isset($_POST['newName'])) {
    $subjectId = $_POST['id'];
    $newName = $_POST['newName'];

    // Fetch the subject's class
    $query = "SELECT class_id FROM subjects WHERE id = :subjectId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':subjectId', $subjectId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $classId = $result['class_id'];

        // Check if a subject with the new name exists in the same class
        $query = "SELECT id FROM subjects WHERE subject = :newName AND class_id = :classId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':newName', $newName, PDO::PARAM_STR);
        $stmt->bindParam(':classId', $classId, PDO::PARAM_INT);
        $stmt->execute();
        $existingSubject = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($existingSubject) > 0) {
            $response = ['success' => false, 'message' => 'A subject with the same name already exists in this class.'];
        } else {
            // Update the subject's name
            $updateQuery = "UPDATE subjects SET subject = :newName, modified_by = :user WHERE id = :subjectId";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(':newName', $newName, PDO::PARAM_STR);
            $updateStmt->bindParam(':user', $user, PDO::PARAM_INT);
            $updateStmt->bindParam(':subjectId', $subjectId, PDO::PARAM_INT);
            $updateStmt->execute();

            $response = ['success' => true, 'message' => 'Subject name updated successfully.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Subject not found.'];
    }

    echo json_encode($response);
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
    echo json_encode($response);
}
?>
