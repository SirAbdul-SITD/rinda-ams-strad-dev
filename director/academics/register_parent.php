<?php

// Include your database connection file (e.g., settings.php)
require('../settings.php');

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize response array
    $response = array();

    // Retrieve form data
    $role = $_POST['role'] ?? null;
    $firstName = $_POST['firstName'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $number = $_POST['number'] ?? null;
    $email = $_POST['email'] ?? null;
    $state_of_origin = $_POST['state_of_origin'] ?? null;
    $occupation = $_POST['occupation'] ?? null;
    $address = $_POST['address'] ?? null;
    $city = $_POST['city'] ?? null;
    $office_address = $_POST['office_address'] ?? null;
    $ps = $_POST['ps'] ?? null;
    $password = $_POST['number'] ?? null;
    $confirmPassword = $_POST['number'] ?? null;

    $requiredFields = [

        'firstName',
        'lastName',
        'number',
        'email',
       
    ];


    // Perform validation
    // Check if all required fields are provided
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $response['success'] = false;
            $response['message'] = "Error: " . $field . ' is required.';
            // Output JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }

    if ($password !== $confirmPassword) {
        $response['success'] = false;
        $response['message'] = "Passwords do not match.";
    } else {
        try {
            // Check if email already exists
            $query = "SELECT COUNT(*) FROM parents WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $emailExists = $stmt->fetchColumn();

            if ($emailExists) {
                $response['success'] = false;
                $response['message'] = "Email already exists. Please use a different email, ask parent to signin or reset password incase forgotten.";
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Prepare SQL statement to insert data into super_admin table
                $insertQuery = "INSERT INTO parents (firstName, lastName, email, phoneNumber, address, state, state_of_origin, occupation, role, office_address, ps, password) 
                                VALUES (:firstName, :lastName, :email, :phoneNumber, :address, :state, :state_of_origin, :occupation, :role, :office_address, :ps, :password) ";
                $insertStmt = $pdo->prepare($insertQuery);
                $insertStmt->bindParam(':email', $_POST['email']);
                $insertStmt->bindParam(':firstName', $_POST['firstName']);
                $insertStmt->bindParam(':lastName', $_POST['lastName']);
                $insertStmt->bindParam(':phoneNumber', $_POST['number']);
                $insertStmt->bindParam(':address', $_POST['address']);
                $insertStmt->bindParam(':state', $_POST['state']);
                $insertStmt->bindParam(':state_of_origin', $_POST['state_of_origin']);
                $insertStmt->bindParam(':occupation', $_POST['occupation']);
                $insertStmt->bindParam(':role', $_POST['role']);
                $insertStmt->bindParam(':office_address', $_POST['office_address']);
                $insertStmt->bindParam(':ps', $_POST['ps']);
                $insertStmt->bindParam(':password', $hashedPassword);
                $insertStmt->execute();

                // Set success response
                $response['success'] = true;
                $response['message'] = "Registration successful. Parent can now login with the email and phone number provided.";
            }
        } catch (PDOException $e) {
            // Handle database errors
            $response['success'] = false;
            $response['message'] = "Error: " . $e->getMessage();
        }
    }

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Set success response
    $response['success'] = true;
    $response['message'] = "Nothing Submitted";
    exit();
}
