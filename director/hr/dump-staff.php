<?php

// Include your database connection file (e.g., settings.php)
require('../settings.php');

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize response array
    $response = array();

    // Retrieve form data
    $designation = $_POST['designation'] ?? null;
    $employmentDate = $_POST['employment-date'] ?? null;
    $firstName = $_POST['firstName'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $dob = $_POST['dob'] ?? null;
    $maritalStatus = $_POST['marital-status'] ?? null;
    $email = $_POST['email'] ?? null;
    $mobileNumber = $_POST['mobileNumber'] ?? null;
    $emergencyContact = $_POST['emergencyContact'] ?? null;
    $currentAddress = $_POST['currentAddress'] ?? null;
    $permanentAddress = $_POST['permanentAddress'] ?? null;
    $qualifications = $_POST['qualifications'] ?? null;
    $experience = $_POST['experience'] ?? null;
    $salary = $_POST['salary'] ?? null;
    $contractType = $_POST['contract-status'] ?? null;
    $bankName = $_POST['bankName'] ?? null;
    $accountName = $_POST['accountName'] ?? null;
    $accountNumber = $_POST['accountNumber'] ?? null;

    try {
        // Check if mobile number exists in staffs table
        $query = "SELECT COUNT(*) FROM staffs WHERE mobile_number = :mobileNumber";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':mobileNumber', $mobileNumber);
        $stmt->execute();
        $mobileNumberExists = $stmt->fetchColumn();

        // Check if email exists in staffs table
        if (!empty($email)) {
            $query = "SELECT COUNT(*) FROM staffs WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $emailExists = $stmt->fetchColumn();
        } else {
            $emailExists = false; // Assume email does not exist if not provided
        }

        // Insert record if mobile number and email do not exist
        if (!$mobileNumberExists && !$emailExists) {

             // Use email as password
             $password = $email;

             // Hash the password (optional, but recommended)
             $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare SQL statement to insert data into staffs table
            $query = "INSERT INTO staffs (designation_id, employment_date, first_name, last_name, gender, dob, marital_status, email, mobile_number, emergency_contact, current_address, permanent_address, qualifications, experience, salary, contract_type, bank_name, account_name, account_number, password) 
                  VALUES (:designation, :employmentDate, :firstName, :lastName, :gender, :dob, :maritalStatus, :email, :mobileNumber, :emergencyContact, :currentAddress, :permanentAddress, :qualifications, :experience, :salary, :contractType, :bankName, :accountName, :accountNumber, :password)";
            $stmt = $pdo->prepare($query);

            // Bind parameters
            $stmt->bindParam(':designation', $designation);
            $stmt->bindParam(':employmentDate', $employmentDate);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':maritalStatus', $maritalStatus);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mobileNumber', $mobileNumber);
            $stmt->bindParam(':emergencyContact', $emergencyContact);
            $stmt->bindParam(':currentAddress', $currentAddress);
            $stmt->bindParam(':permanentAddress', $permanentAddress);
            $stmt->bindParam(':qualifications', $qualifications);
            $stmt->bindParam(':experience', $experience);
            $stmt->bindParam(':salary', $salary);
            $stmt->bindParam(':contractType', $contractType);
            $stmt->bindParam(':bankName', $bankName);
            $stmt->bindParam(':accountName', $accountName);
            $stmt->bindParam(':accountNumber', $accountNumber);
            $stmt->bindParam(':password', $hashedPassword);

            // Execute the statement
            $stmt->execute();

            // Set success response
            $response['success'] = true;
            $response['message'] = "Staff added successfully.";

        } else {
            // Set error response
            $response['success'] = false;
            $response['message'] = "Mobile number or email already exists.";
        }
    } catch (PDOException $e) {
        // Handle database errors
        $response['success'] = false;
        $response['message'] = "Error: " . $e->getMessage();
    }

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If form data is not submitted, redirect to the form page
    header("Location: form.php");
    exit();
}
?>
