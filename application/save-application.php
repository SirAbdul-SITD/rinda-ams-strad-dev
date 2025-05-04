<?php
require('db.php');

// Escape user inputs to prevent SQL injection


$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    // Begin transaction
    $pdo->beginTransaction();


    if (isset($_SESSION['ref'])) {
      $ref = $_SESSION['ref'];
    } else {
      throw new Exception("Please go back and input your applicatione reference number or start a new application");
    }

    // Check if admission number already exists
    $application_status = 'Initiated';
    $sqlCheckAdmission = "SELECT COUNT(*) FROM applications WHERE ref = :ref AND status = :status";
    $stmtCheckAdmission = $pdo->prepare($sqlCheckAdmission);
    $stmtCheckAdmission->bindParam(':ref', $ref, PDO::PARAM_STR);
    $stmtCheckAdmission->bindParam(':status', $application_status, PDO::PARAM_STR);
    $stmtCheckAdmission->execute();
    $existingAdmission = $stmtCheckAdmission->fetchColumn();
    if ($existingAdmission != 1) {
      throw new Exception('This Application Have Already Been Submitted.');
    }


    $Fields = [
      'student_firstName',
      'student_lastName',
      'student_gender',
      'student_dob',
      'student_country',
      'student_state',
      'student_origin',
      'student_address',
      'student_pos_in_family',
      'student_prev_school',
      'class_id',
      'student_juz_memorised',
      'student_kyh',
      'student_quran',
      'student_languages',
      'referrer',
      'rfj',
      'student_genotype',
      'student_bloodGroup',
      'student_likes',
      'student_dislikes',
      'student_allergies',
      'student_learning_disorder',
      'student_health_info',
      'father_firstName',
      'father_lastName',
      'father_number',
      'father_email',
      'father_state',
      'father_job',
      'father_office',
      'father_ps',
      'mother_firstName',
      'mother_lastName',
      'mother_number',
      'mother_email',
      'mother_state',
      'mother_job',
      'mother_office',
      'mother_ps',
      'emergency_name',
      'emergency_number',
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


    $requiredFields = [
      'student_firstName',
      'student_lastName',
      'student_gender',
      'student_dob',
      'student_country',
      'student_state',
      'student_origin',
      'student_address',
      'student_pos_in_family',
      'class_id',
      'student_juz_memorised',
      'student_kyh',
      'student_quran',
      'student_languages',
      'referrer',
      'rfj',
      'student_genotype',
      'student_bloodGroup',
      'student_likes',
      'student_dislikes',
      'student_allergies',
      'student_learning_disorder',
      'student_health_info',
      'father_firstName',
      'father_lastName',
      'father_number',
      'father_email',
      'father_state',
      'father_job',
      'father_office',
      'father_ps',
      'mother_firstName',
      'mother_lastName',
      'mother_number',
      'mother_email',
      'mother_state',
      'mother_job',
      'mother_office',
      'mother_ps',
      'emergency_name',
      'emergency_number',
      'pickup_name1',
      'pickup_relationship1',
      'pickup_number1'
    ];


    // Check if all required fields are provided
    foreach ($requiredFields as $field) {
      if (empty($_POST[$field])) {
        throw new Exception(ucfirst($field) . ' is required.');
      }
    }



    // Initialize an array to store the values to be updated
    $updateValues = [];

    // Construct the SET part of the SQL query dynamically
    $setValues = [];
    foreach ($Fields as $field) {
      $setValues[] = $field . ' = :' . $field;
      $updateValues[':' . $field] = $_POST[$field];
    }

    // Update the status field in the fields to be updated
    $setValues[] = 'status = :status';
    $updateValues[':status'] = 'Submitted';

    // Construct the SQL query
    $sqlStudent = "UPDATE applications SET " . implode(', ', $setValues) . " WHERE ref = :ref";
    $stmtStudent = $pdo->prepare($sqlStudent);

    // Bind the parameters and execute the query
    $updateValues[':ref'] = $ref;
    $stmtStudent->execute($updateValues);





    $class_id = $_POST['class_id'];

    $secQuery = "SELECT section_id, class FROM classes WHERE id = ?";
    $sec = $pdo->prepare($secQuery);
    $sec->execute([$class_id]);
    $section = $sec->fetch(PDO::FETCH_ASSOC);
    $section_id = $section['section_id'];
    $class_name = $section['class'];
    // Commit the transaction
    $pdo->commit();


    $student_fullName = $_POST['student_firstName'] . ' ' . $_POST['student_lastName'];
    $father_fullName = $_POST['father_firstName'] . ' ' . $_POST['father_lastName'];
    $mother_fullName = $_POST['mother_firstName'] . ' ' . $_POST['mother_lastName'];


    $subject = "New Student Application";

    $message = "<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
      }
      .container {
        background-color: #ffffff;
        padding: 20px;
        margin: 20px auto;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
      }
      .header {
        text-align: center;
        padding-bottom: 20px;
        border-bottom: 1px solid #dddddd;
      }
      .content {
        margin-top: 20px;
      }
      .content p {
        line-height: 1.6;
      }
      .footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #dddddd;
        text-align: center;
        font-size: 0.9em;
        color: #666666;
      }
    </style>
  </head>
  <body>
   <div class='container'>
      <div class='header'>
        <h2>New Student Application</h2>
      </div>
     <div class='content'>
    <p>
        A new student application has just been submitted through the Grithall Academy Portal.
    </p>
    <p>Application reference number: <b>$ref</b></p>
    <p>Student's Name: <b>$student_fullName</b></p>
    <p>Father's Name: <b>$father_fullName</b></p>
    <p>Mother's Name: <b>$mother_fullName</b></p>
    <p>Applied Class: <b>$class_name</b></p>
    <p>
        You can log in to view the full application details and update the application status.
    </p>
</div>

      <div class='footer'>
        <p>Thank you,</p>
        <p>The GHA Rinda AMS Team</p>
        <p>This is an automated message. Please do not reply to this email.</p>
      </div>
    </div>
  </body>
</html>
";

    // Additional headers
    $headers .= 'From: Grithall Academy <noreply@grithallacademy.com.ng>' . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";


    $amnin_emails = 'admin@grithallacademy.com.ng, grithallacademy@gmail.com, abdulkarimhussain7gmail.com, noreply@grithallacademy.com.ng';
    // Send email
    mail($amnin_emails, $subject, $message, $headers);


    // Set success message
    $response = ['success' => true, 'message' => 'Student application submitted successfully.', 'section' => $section_id];
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
