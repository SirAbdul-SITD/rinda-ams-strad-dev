<?php
require('../settings.php');

// Escape user inputs to prevent SQL injection


$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Begin transaction
        $pdo->beginTransaction();


        if (isset($_POST['admission_no'])) {
            $admission_no = $_POST['admission_no'];
        } else {
            throw new Exception("Unknown Student");
        }

        // Check if admission number already exists
        $sqlCheckAdmission = "SELECT COUNT(*) FROM students WHERE admission_no = :admission_no";
        $stmtCheckAdmission = $pdo->prepare($sqlCheckAdmission);
        $stmtCheckAdmission->bindParam(':admission_no', $admission_no, PDO::PARAM_STR);
        $stmtCheckAdmission->execute();
        $existingAdmission = $stmtCheckAdmission->fetchColumn();
        if ($existingAdmission != 1) {
            throw new Exception('Students Not Found.');
        }


        $Fields = [
            'firstName',
            'lastName',
            'class_id',
            'state',
            'address',
            'likes',
            'dislikes',
            'allergies',
            'disorder',
            'health_info',
            'pickup_name1',
            'pickup_relationship1',
            'pickup_number1',
            'pickup_name2',
            'pickup_relationship2',
            'pickup_number2',
            'pickup_name3',
            'pickup_relationship3',
            'pickup_number3',
        ];

        // Initialize an array to store the values to be updated
        $updateValues = [];

        // Construct the SET part of the SQL query dynamically
        $setValues = [];
        foreach ($Fields as $field) {
            $setValues[] = $field . ' = :' . $field;
            $updateValues[':' . $field] = $_POST[$field];
        }

        // Construct the SQL query
        $sqlStudent = "UPDATE students SET " . implode(', ', $setValues) . " WHERE admission_no = :admission_no";
        $stmtStudent = $pdo->prepare($sqlStudent);

        // Bind the parameters and execute the query
        $updateValues[':admission_no'] = $admission_no;
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
