<?php

require('../settings.php');

$user = 1;

if (isset($_POST['id']) && isset($_POST['newName'])) {
    $classId = $_POST['id'];
    $newName = $_POST['newName'];

    // Fetch the class's section
    $query = "SELECT section_id FROM classes WHERE id = :classId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':classId', $classId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $classSection = $result['section_id'];

        // Check if a class with the new name exists in the same section
        $query = "SELECT id FROM classes WHERE class = :newName AND section_id = :classSection";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':newName', $newName, PDO::PARAM_STR);
        $stmt->bindParam(':classSection', $classSection, PDO::PARAM_INT);
        $stmt->execute();
        $existingClass = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingClass) {
            $response = ['success' => false, 'message' => 'A class with the same name already exists in this section.'];
        } else {
            // Update the class's name
            $updateQuery = "UPDATE classes SET class = :newName, modified_by = :user WHERE id = :classId";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(':newName', $newName, PDO::PARAM_STR);
            $updateStmt->bindParam(':user', $user, PDO::PARAM_INT);
            $updateStmt->bindParam(':classId', $classId, PDO::PARAM_INT);
            $updateStmt->execute();

            $response = ['success' => true, 'message' => 'Class name updated successfully.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Class not found.'];
    }

    echo json_encode($response);
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
    echo json_encode($response);
}
?>
