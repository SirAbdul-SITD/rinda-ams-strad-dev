<?php

require_once '../settings.php';

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Begin transaction
        $pdo->beginTransaction();

        $studentId = $_POST['id'];

        // Check if any parent (father, mother, or guardian) is selected
        $selectedParents = [];
        if (isset($_POST['fatherId'])) {
            $selectedParents[] = $_POST['fatherId'];
        }
        if (isset($_POST['motherId'])) {
            $selectedParents[] = $_POST['motherId'];
        }
        if (isset($_POST['guardianId'])) {
            $selectedParents[] = $_POST['guardianId'];
        }

        // Check for duplicate parent IDs
        if (count($selectedParents) !== count(array_unique($selectedParents))) {
            throw new Exception('Duplicate parent detected. Each parent type should have a unique individual.');
        }

        // Insert parent-student relationships into the parent_student table
        foreach ($selectedParents as $parentId) {
            // Initialize parent type for the current parent
            $parentType = '';

            // Determine the parent type for the current parent
            if (isset($_POST['fatherId']) && $_POST['fatherId'] == $parentId) {
                $parentType = 'father';
            }
            if (isset($_POST['motherId']) && $_POST['motherId'] == $parentId) {
                $parentType = 'mother';
            }
            if (isset($_POST['guardianId']) && $_POST['guardianId'] == $parentId) {
                $parentType = 'guardian';
            }

            // Check if the parent-student relationship already exists
            $sqlCheckRelationship = "SELECT COUNT(*) FROM parent_student WHERE parent_id = ? AND student_id = ? AND relationship_type = ?";
            $stmtCheckRelationship = $pdo->prepare($sqlCheckRelationship);
            $stmtCheckRelationship->execute([$parentId, $studentId, $parentType]);
            $existingRelationships = $stmtCheckRelationship->fetchColumn();

            // If the relationship doesn't exist, insert it
            if ($existingRelationships == 0) {
                // Insert parent-student relationship into the parent_student table
                $sqlParentStudent = "INSERT INTO parent_student (parent_id, student_id, relationship_type) VALUES (?, ?, ?)";
                $stmtParentStudent = $pdo->prepare($sqlParentStudent);
                // Bind parameters
                $stmtParentStudent->bindValue(1, $parentId);
                $stmtParentStudent->bindValue(2, $studentId);
                $stmtParentStudent->bindValue(3, $parentType);
                // Execute the statement
                $stmtParentStudent->execute();
            }
        }

        // Commit the transaction
        $pdo->commit();

        // Set success message
        $response = ['success' => true, 'message' => 'Parent info updated successfully.'];

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
