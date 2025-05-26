<?php

require_once '../settings.php';

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Update student data
        $updateColumns = [];
        $updateValues = [];
        $studentFields = [
            'student_firstName',
            'student_lastName',
            'student_gender',
            'student_dob',
            'student_religion',
            'student_address',
            'student_country',
            'student_state',
            'student_city',
            'admission_no',
        ];

        // Check if all required fields are provided
        foreach ($studentFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required.');
            }
            $updateColumns[] = str_replace('student_', '', $field) . ' = ?';
            $updateValues[] = $_POST[$field];
        }

        // Prepare and execute the update statement for student data
        $sqlStudent = "UPDATE students SET " . implode(', ', $updateColumns) . " WHERE admission_no = ?";
        $updateValues[] = $_POST['admission_no']; // Add admission number to the update values
        $stmtStudent = $pdo->prepare($sqlStudent);
        $stmtStudent->execute($updateValues);

        // Commit the transaction
        $pdo->commit();

        // Set success message
        $response = ['success' => true, 'message' => 'Student info updated successfully.'];

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
