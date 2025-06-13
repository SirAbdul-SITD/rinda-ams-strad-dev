<?php

require 'db.php';

// Get the email from the AJAX request
$email = $_POST['email'];

// Generate the application reference number using the current time
$ref = 'GHA_' . time();
$_SESSION['ref'] = $ref;

// Save the email and reference number to the database
$application_status = 'Initiated';
$query = 'INSERT INTO applications (email, ref, status) VALUES (:email, :ref, :status)';
$insertQuery = $pdo->prepare($query);
$insertQuery->bindParam(':ref', $ref, PDO::PARAM_STR);
$insertQuery->bindParam(':email', $email, PDO::PARAM_STR);
$insertQuery->bindParam(':status', $application_status, PDO::PARAM_STR);
$insertQuery->execute();

if ($insertQuery) {


  $subject = "Student Application";

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
        <h2>Grithall Academy Student Application</h2>
      </div>
      <div class='content'>
        <p>
          We are delighted to confirm the successful initialisation of your
          child's application into Grithall Academy.
        </p>
        <p>Your application reference number is: <b>$ref</b></p>

        <p>
          Please keep this reference number safe for future communication
          regarding this application status.
        </p>
      </div>
      <div class='footer'>
        <p>Thank you for choosing Grithal Academy,</p>
        <p>The GHA Rinda AMS Team</p>
        <p>This is an automated message. Please do not reply to this email.</p>
      </div>
    </div>
  </body>
</html>
";

  // Additional headers
  $headers .= 'From: Grithall Academy <noreply@strad.africa>' . "\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";


  // Send email
  mail($email, $subject, $message, $headers);

  $response = array(
    'success' => true,
    'ref' => $ref
  );
  echo json_encode($response);
} else {
  // Return an error response if the insertion fails
  $response = array(
    'success' => false,
    'message' => 'Failed to save application'
  );
  echo json_encode($response);
}
