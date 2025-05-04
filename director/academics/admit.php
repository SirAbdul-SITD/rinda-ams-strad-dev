<?php

require_once '../settings.php';

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Insert student data
        $insertColumns = [];
        $insertValues = [];
        $studentFields = [
            'student_firstName',
            'student_lastName',
            'student_gender',
            'student_dob',
            'student_religion',
            'student_email',
            'student_phoneNumber',
            'student_bloodGroup',
            'student_height',
            'student_weight',
            'student_disorder',
            'student_address',
            'student_country',
            'student_state',
            'student_city',
            'admission_no',
            'join_date',
            'session',
            'class_id',
            'term',
            '2ndJoin_date',
            '2ndSession',
            '2ndTerm',
            '2ndClass_id'
        ];

        $requiredFields = [
            'student_firstName',
            'student_lastName',
            'student_gender',
            // 'student_dob',
            // 'student_religion',
            // 'student_address',
            // 'student_country',
            // 'student_state',
            // 'student_city',
            // 'admission_no',
            // 'join_date',
            // 'session',
            'class_id',
            // 'term'
        ];



        // Check if all required fields are provided
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required.');
            }
        }


        $initC = $_POST['class_id'];

        // Check if all required fields are provided
        // foreach ($studentFields as $field) {
        //     $insertColumns[] = str_replace('student_', '', $field);
        //     $insertColumns[] = 'init_class_id';
        //     $insertValues[] = $_POST[$field];
        //     $insertValues[] = $initC;
        // }


        // Check if all required fields are provided
foreach ($studentFields as $field) {
    $insertColumns[] = str_replace('student_', '', $field);
    $insertValues[] = !empty($_POST[$field]) ? $_POST[$field] : null;
}


// Add 'init_class_id' only once
$insertColumns[] = 'init_class_id';
$insertValues[] = $initC;



        // Prepare and execute the insert statement for student data
        $placeholders = implode(', ', array_fill(0, count($insertColumns), '?'));
        $sqlStudent = "INSERT INTO students (" . implode(', ', $insertColumns) . ") VALUES (" . $placeholders . ")";
        $stmtStudent = $pdo->prepare($sqlStudent);
        $stmtStudent->execute($insertValues);

        // Get the last inserted student ID
        $studentId = $pdo->lastInsertId();

        // Insert 2nd data if provided
        if (!empty($_POST['2ndClass_id']) && !empty($_POST['2ndSession']) && !empty($_POST['2ndTerm']) && !empty($_POST['2ndJoin_date'])) {
            $updateColumns = ['2ndClass_id', '2ndSession', '2ndTerm', '2ndJoin_date'];
            $updateValues = [$_POST['2ndClass_id'], $_POST['2ndSession'], $_POST['2ndTerm'], $_POST['2ndJoin_date']];
            $updateColumns[] = 'multiClass';
            $updateValues[] = 1;

            // Prepare and execute the update statement for 2nd data
            $placeholders = implode(' = ?, ', $updateColumns) . ' = ?';
            $sqlSecond = "UPDATE students SET " . $placeholders . " WHERE id = ?";
            $stmtSecond = $pdo->prepare($sqlSecond);
            $updateValues[] = $studentId;
            $stmtSecond->execute($updateValues);
        }

        // // Check if any parent (father, mother, or guardian) is selected
        // $selectedParents = [];
        // if (isset($_POST['fatherId'])) {
        //     $selectedParents[] = $_POST['fatherId'];
        // }
        // if (isset($_POST['motherId'])) {
        //     $selectedParents[] = $_POST['motherId'];
        // }
        // if (isset($_POST['guardianId'])) {
        //     $selectedParents[] = $_POST['guardianId'];
        // }

        // // Check for duplicate parent IDs
        // if (count($selectedParents) !== count(array_unique($selectedParents))) {
        //     throw new Exception('Duplicate parent detected. Each parent type should have a unique individual.');
        // }

        // // Insert parent-student relationships into the parent_student table
        // foreach ($selectedParents as $parentId) {
        //     // Initialize parent type for the current parent
        //     $parentType = '';

        //     // Determine the parent type for the current parent
        //     if (isset($_POST['fatherId']) && $_POST['fatherId'] == $parentId) {
        //         $parentType = 'father';
        //     }
        //     if (isset($_POST['motherId']) && $_POST['motherId'] == $parentId) {
        //         $parentType = 'mother';
        //     }
        //     if (isset($_POST['guardianId']) && $_POST['guardianId'] == $parentId) {
        //         $parentType = 'guardian';
        //     }

        //     // Check if the parent-student relationship already exists
        //     $sqlCheckRelationship = "SELECT COUNT(*) FROM parent_student WHERE parent_id = ? AND student_id = ? AND relationship_type = ?";
        //     $stmtCheckRelationship = $pdo->prepare($sqlCheckRelationship);
        //     $stmtCheckRelationship->execute([$parentId, $studentId, $parentType]);
        //     $existingRelationships = $stmtCheckRelationship->fetchColumn();

        //     // If the relationship doesn't exist, insert it
        //     if ($existingRelationships == 0) {
        //         // Insert parent-student relationship into the parent_student table
        //         $sqlParentStudent = "INSERT INTO parent_student (parent_id, student_id, relationship_type) VALUES (?, ?, ?)";
        //         $stmtParentStudent = $pdo->prepare($sqlParentStudent);
        //         // Bind parameters
        //         $stmtParentStudent->bindValue(1, $parentId);
        //         $stmtParentStudent->bindValue(2, $studentId);
        //         $stmtParentStudent->bindValue(3, $parentType);
        //         // Execute the statement
        //         $stmtParentStudent->execute();
        //     }
        // }

        // Commit the transaction
        $pdo->commit();

        // Set success message
        $response = ['success' => true, 'message' => 'New student admitted successfully.'];
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
